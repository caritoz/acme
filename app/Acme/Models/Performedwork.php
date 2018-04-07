<?php
namespace Acme\Models;
use Acme\Models\Picture;

class Performedwork extends \Eloquent
{
	protected $guarded = array();

	public static $rules = array(
		'caption' => 'required',
//		'summary' => 'required',
//		'description' => 'required',
//		'work_date' => 'required',
//		'active' => 'required',
//		'published' => 'required'
	);

    public function album()
    {
        return $this->hasOne('Acme\\Models\\Album');
    }

    public function featured()
    {
        return $this->hasOne('Acme\\Models\\PerformedworkFeatured', 'performedwork_id');
    }

    public function pictures()
    {
        return $this->belongsToMany('Acme\\Models\\Picture', 'performedwork_picture', 'performedwork_id', 'picture_id');

        //Attach an extra column to the pivot table
        //$customer->drinks()->attach($drink_id, array('customer_got_drink', 1)); //this executes the insert-query with customer_got_drink = 1
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('caption', 'LIKE', "%$search%");
    }

    public function scopeLast($query)
    {
        return $query->where('published', true)->orderBy('created_at', 'desc')->first();
    }

    public function scopesearchPublished($query)
    {
        return $query->where('published', true)->orderBy('created_at', 'desc');
    }

    public function isPublish()
    {
        if( $this->published )
            return '<span class="label label-success">Publicado</span>';

        return '<span class="label label-warning">Pendiente</span>';
    }

    public function isPublishHTML()
    {
        $url = \URL::to('admin/performedworks/publish/' . $this->id );

        if($this->published)
            return '<span class="label label-success" onclick="updatePublish(\''.$url.'\', false);" style="cursor:pointer;">Publicado</span>';

        return '<span class="label label-warning" onclick="updatePublish(\''.$url.'\', true);" style="cursor:pointer;">Pendiente</span>';
    }

    /**
     * @param Picture $picture
     * @param integer $id
     */
    public static function mediaStore($picture, $id)
    {
        $performedwork = Performedwork::find($id);
        $performedwork->pictures()->attach($picture->id);
    }

    /**
     * @param Picture $picture
     * @param integer $id
     */
    public static function mediaDestroy($picture, $id)
    {
        $performedwork = Performedwork::find($id);
        $performedwork->pictures()->detach($picture->id);
    }

    public function isFeatured()
    {
        if( $this->featured )
            return true;

        return false;
    }

    const IMAGE_CLASS_SINGLE        = 'col-md-3 col-lg-3 col-sm-12';
    const IMAGE_CLASS_HIGHLIGHTED   = 'col-md-6 col-lg-6 col-sm-12 highlighted';

    const IMAGE_SIZE_SINGLE         = 380;
    const IMAGE_SIZE_HIGHLIGHTED    = 1400;

    public function itemSizeClass()
    {
        if( $this->featured )
            return self::IMAGE_CLASS_HIGHLIGHTED;

        return self::IMAGE_CLASS_SINGLE;
    }

    public function itemSizePhoto()
    {
        if( $this->featured )
            return \URL::to('pictures/' . $this->pictureFirst() . '/show/highlight' );

        return \URL::to('pictures/' . $this->pictureFirst() . '/show/simple' );
    }

    public function isFeaturedHTML()
    {
        $url = \URL::to('admin/performedworks/feature/' . $this->id );

        if($this->featured)
            return '<i class="fa fa-fw fa-thumbs-up" onclick="updateFeature(\''.$url.'\', false);" style="cursor:pointer;"></i>';

        return '<i class="fa fa-fw fa-thumbs-o-up" onclick="updateFeature(\''.$url.'\', true);" style="cursor:pointer;"></i>';
    }

    public function pictureFirst()
    {
        if( count($this->pictures) > 0 )
            return $this->pictures->first()->id;
        return 'default';
    }

    public function urlFriendly()
    {
        $slug = \Str::slug($this->caption);
        $url = \URL::to('works/' . $this->id . '-' . $slug );

        return $url;
    }
}
