<?php
namespace Acme\Models;
use Acme\Models\Album;
class Picture extends \Eloquent
{
    protected $table = 'pictures';

	protected $guarded = array();

    const SLIDER_WIDTH  = 1600;
    const SLIDER_HEIGHT = 500;

    const ImageDefault = 'default-image.png';

	public static $rules = array(
		'caption' => 'required',
		'album_id' => 'required',
//		'path' => 'required',
//		'type_picture' => 'required'
	);

    public function album()
    {
        return $this->belongsTo('Acme\\Models\\Album', 'id');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('caption', 'LIKE', "%$search%");
    }

    public function scopeOrderDescending($query)
    {
        return $query->orderBy('order_picture','DESC');
    }

    public function scopeOrderAscending($query)
    {
        return $query->orderBy('order_picture','ASC');
    }

    public function scopePictures($query, $search)
    {
        return $query->where('album_id', '=', $search);
    }

    public function AlbumName()
    {
        $album = Album::findOrFail($this->album_id);
        return $album->caption;
//        return $this->albums()->where('id', $this->album_id)->get();
//        return $this->albums()->where('id', $this->album_id)->first()->caption;
    }

    public function AlbumFolder()
    {
        if( !is_null($this->album_id) ):
            $album = Album::findOrFail($this->album_id);
            if($album instanceof Album)
                return $album->folder;
        endif;

        return '';
    }

    public static function makeOrder($album_id)
    {
        $order_picture  = 1;
//        $pictures       = Picture::where('album_id','=', $album_id)->orderBy('order_picture')->get();
        $pictures       = Picture::where('album_id','=', $album_id)->max('order_picture');
        if( !is_null( $pictures ) )
            $order_picture  = $pictures;

        return $order_picture;
    }

    /**
    * @param Album $album
    * @param file $file
    * @param integer $idObject
    * @return string
    */
    public function factoryFileName($album, $file = null, $idEntity = null)
    {
        $id         = '';
        $extension  = '.' . $this->type_picture;

        if( !is_null($idEntity) ):
            $id = '_'.$idEntity;

            if( !is_null($file) )
                $extension = '.' . strtolower($file->getClientOriginalExtension());

            $filename = $album->folder . '_'. $this->id . $id . $extension;
        else:
            if( !is_null($file) )
                $extension = '.' . strtolower($file->getClientOriginalExtension());

            $filename = $album->folder . '_'. $this->id . $extension;
        endif;

        return $filename;
    }

    /**
    * @return string
    */
    public function getPathPicture()
    {
       $path         = 'http://';
       $path        .= $_SERVER['SERVER_NAME'];

       $pathSlider  = Album::findOrFail($this->album_id);

       $pictureName = $path . $pathSlider->getPath() . '/' .$this->factoryFileName($pathSlider);

        return $pictureName;
    }

    protected function GetImageWithPath()
    {
        $pathSlider     = public_path('pictures').'/'.$this->AlbumFolder();
        $pictureName    = $pathSlider.'/'.$this->path;

//        $type_image = $this->type_picture;

        if( !\File::exists($pictureName) )
        {
            $pictureName  = public_path('pictures') .'/'.self::ImageDefault;
            $this->type_picture = 'png';
        }

        return $pictureName;
    }

    /*********  THUMBNAILS */

    public function getThumb()
    {
        $pictureName = $this->GetImageWithPath();

        // create instance
        $response       = \Image::make($pictureName);

        // resize image to fixed size
        $response->resize(240, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        return \Response::make($response->encode($this->type_picture), 200, ['Content-Type' => 'image/'.$this->type_picture]);
    }

    /**
     * 300x200
     * @return mixed
     */
    public function getThumbCacheGray()
    {
        // pass calls to image cache
        $response = \Image::cache(function($image) {
            $pathSlider     = public_path('pictures').'/'.$this->AlbumFolder();
            $prefix         = $this->AlbumFolder().'_';
//            $pictureName    = $pathSlider.'/'.$prefix.$this->id.'.'.$this->type_picture;
            $pictureName    = $pathSlider.'/'.$this->path; // prefix: slider_

            $image->make($pictureName)->crop(300, 100)
                ->greyscale();
        });

        return \Response::make($response, 200, ['Content-Type' => 'image/'.$this->type_picture]);
    }

    /**
     * 350x117
     * @return mixed
     */
    public function getThumbCache()
    {
        $pictureName = $this->GetImageWithPath();

        // pass calls to image cache
        $response = \Image::cache(function($image) use($pictureName)  {
            $image->make($pictureName)
                ->crop(350, 117);
//                  ->resize(350, null, function ($constraint) {
//                $constraint->aspectRatio();
//            });
        });

        return \Response::make($response, 200, ['Content-Type' => 'image/'.$this->type_picture]);
    }

    /**
     * 240x90
     * @return mixed
     */
    public function getSmallest()
    {
        $pictureName = $this->GetImageWithPath();

        // pass calls to image cache
        $response = \Image::cache(function($image) use($pictureName)  {
//            $image->make($pictureName)->crop(240, 110);
            $image->make($pictureName)->fit(240, 120, function ($constraint) {
                $constraint->upsize();
            });
        });

        return \Response::make($response, 200, ['Content-Type' => 'image/'.$this->type_picture]);
    }

    /**
     * 1600x500
     * @return mixed
     */
    public function getCarousel()
    {
        $pictureName = $this->GetImageWithPath();

        // pass calls to image cache
        $response = \Image::cache(function($image) use($pictureName) {
            $image->make($pictureName)
                ->fit(Picture::SLIDER_WIDTH, Picture::SLIDER_HEIGHT);
        });

        return \Response::make($response, 200, ['Content-Type' => 'image/'.$this->type_picture]);
    }

    /**
     * 650x270
     * @return mixed
     */
    public function getMiniCarousel()
    {
        $pictureName = $this->GetImageWithPath();

        // pass calls to image cache
        $response = \Image::cache(function($image) use($pictureName) {
            $image->make($pictureName)->crop(650, 270);
        });

        return \Response::make($response, 200, ['Content-Type' => 'image/' . $this->type_picture]);
    }

    /**
     * 500x500
     *
     * @return mixed
     * */
    public function getSmall()
    {
        $pictureName = $this->GetImageWithPath();

        // pass calls to image cache
        $response = \Image::cache(function($image) use($pictureName) {
            $image->make($pictureName)->fit(500, 500);
        });

        return \Response::make($response, 200, ['Content-Type' => 'image/'.$this->type_picture]);
    }

    /**
     * 474x252
     *
     * @return mixed
     * */
    public function getMedium()
    {
        $pictureName = $this->GetImageWithPath();

        // pass calls to image cache
        $response = \Image::cache(function($image) use($pictureName) {
            $image->make($pictureName)
                ->fit(474, 252);
        });

        return \Response::make($response, 200, ['Content-Type' => 'image/'.$this->type_picture]);
    }

    /**
     * 650x270
     *
     * @return mixed
     * */
    public function getBigMedium()
    {
        $pictureName = $this->GetImageWithPath();

        // pass calls to image cache
        $response = \Image::cache(function($image) use($pictureName) {
            $image->make($pictureName)
                ->fit(650, 270);
//                ->crop(474, 252);
        });

        return \Response::make($response, 200, ['Content-Type' => 'image/'.$this->type_picture]);
    }

    public function getSimple()
    {
        $pictureName = $this->GetImageWithPath();

        // create instance
        /*$response       = \Image::make($pictureName);

        // resize image to fixed size
        $response->resize(Performedwork::IMAGE_SIZE_SINGLE, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        return \Response::make($response->encode($this->type_picture), 200, ['Content-Type' => 'image/'.$this->type_picture]);*/
		
		$response = \Image::cache(function($image) use($pictureName) {
            $image->make($pictureName)->resize(Performedwork::IMAGE_SIZE_SINGLE, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        });

        return \Response::make($response, 200, ['Content-Type' => 'image/'.$this->type_picture]);
    }

    public function getHighlight()
    {
        $pictureName = $this->GetImageWithPath();

        // create instance
        /*$response       = \Image::make($pictureName);

        // resize image to fixed size
        $response->resize(Performedwork::IMAGE_SIZE_HIGHLIGHTED, null, function ($constraint) {
            $constraint->aspectRatio();
        });
				
        return \Response::make($response->encode($this->type_picture), 200, ['Content-Type' => 'image/'.$this->type_picture]);*/
		
		$response = \Image::cache(function($image) use($pictureName) {
            $image->make($pictureName)->resize(Performedwork::IMAGE_SIZE_HIGHLIGHTED, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        });

        return \Response::make($response, 200, ['Content-Type' => 'image/'.$this->type_picture]);
		
    }
}
