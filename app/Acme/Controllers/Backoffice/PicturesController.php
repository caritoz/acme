<?php
namespace Acme\Controllers\Backoffice;
use Acme\Models\Picture;
use Acme\Models\Album;
use Acme\Services\PictureHandler;

use Intervention\Image\ImageManagerStatic as Image;
use Whoops\Example\Exception;

//use Krucas\Notification\Notification;

class PicturesController extends \BaseController {

	/**
	 * Picture Repository
	 *
	 * @var Picture
	 */
	protected $picture;

	public function __construct(Picture $picture)
	{
		$this->picture = $picture;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $query = \Request::get('q');

        $pictures = $query
                    ? $this->picture->search($query)->paginate(10)
                    : $this->picture->paginate(10);

//		$pictures = $this->picture->all();
//		$pictures = $this->picture->paginate(10);

		return \View::make('admin.pictures.index', compact('pictures'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
 	 */
	public function create()
	{
        $type_images = array('jpg' => 'JPG', 'png' => 'PNG');
        $albums = Album::all()->lists('caption', 'id');

		return \View::make('admin.pictures.create')->with('albums', $albums)->with('type_images', $type_images);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input      = \Input::except('photo');
		$validation = \Validator::make($input, Picture::$rules);

		if ( $validation->passes() && (\Input::hasFile('photo')) )
		{

            // resizing an uploaded file
            $file = \Input::file('photo');

            $picture = new Picture();
            $picture->caption   = \Input::get('caption');
            $picture->short_desc  = \Input::get('short_desc');
            $picture->album_id  = \Input::get('album_id');
            $picture->path = \Input::get('album_id'); //hack
            $picture->type_picture  = strtolower($file->getClientOriginalExtension());
            $picture->order_picture = Picture::makeOrder($picture->album_id);

            $picture->save();

//            $picture = $this->picture->create($input);

            // make paths
            $album      = Album::findOrFail($picture->album_id);
            $filename   = $picture->factoryFileName($album, $file, null);
            $picture->path = $filename;
            $picture->save();

            Image::make($file)
                ->save( public_path('pictures').'/'.$album->folder. '/'. $filename );// make paths

            \Krucas\Notification\Notification::success('Imagen guardada.');

			return \Redirect::route('admin.pictures.index');
		}

		return \Redirect::route('admin.pictures.create')
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$picture = $this->picture->findOrFail($id);

		return \View::make('admin.pictures.show', compact('picture'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$picture = $this->picture->find($id);

        $type_images = array('jpg' => 'JPG', 'png' => 'PNG');
        $albums = Album::all()->lists('caption', 'id');

		if (is_null($picture))
		{
			return \Redirect::route('admin.pictures.index');
		}

		return \View::make('admin.pictures.edit', compact('picture'))->with('albums', $albums)->with('type_images', $type_images);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = array_except(\Input::all(), '_method', 'photo');
		$validation = \Validator::make($input, Picture::$rules);

		if ( $validation->passes()  )
		{
            $picture = $this->picture->find($id);

            $picture->caption       = \Input::get('caption');
            $picture->short_desc    = \Input::get('short_desc');
            $picture->album_id      = \Input::get('album_id');
//            $picture->path          = \Input::get('album_id'); //hack

            $picture->order_picture = Picture::makeOrder($picture->album_id);
            $picture->save();

            if (\Input::hasFile('photo')):
                // resizing an uploaded file
                $file = \Input::file('photo');

                $picture->type_picture  = strtolower($file->getClientOriginalExtension());
                $picture->save();

                // make paths
                $album      = Album::findOrFail($picture->album_id);
                $filename   = $picture->factoryFileName($album, $file, null);
                $picture->path = $filename;
                $picture->save();

                Image::make($file)
    //                ->resize(Picture::SLIDER_WIDTH, Picture::SLIDER_HEIGHT)
                    ->save( public_path('pictures').'/'.$album->folder. '/'. $filename );// make paths
            endif;

			return \Redirect::route('admin.pictures.show', $id);
		}

		return \Redirect::route('admin.pictures.edit', $id)
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $picture = $this->picture->find($id);

        PictureHandler::mediaDestroy($picture->album_id, $id);

		return \Redirect::route('admin.pictures.index');
	}

    /**
    * @return mixed
    */
    public function storeOrders()
    {
        try
        {
            if(\Input::has('order')):
                $orders_pictures    = \Input::get('order');
                $id_pictures        = explode(',',$orders_pictures);

                $order = 1;
                foreach($id_pictures as $id_picture)
                {
                    $picture = $this->picture->find($id_picture);
                    $picture->order_picture = $order;
                    $picture->save();
                    $order++;
                }
                return \Response::json(array('status' => 'OK', 'message' => 'Saved!'));
            endif;
        }
        catch (Exception $ex)
        {
            return \Response::json(array('status' => 'ERROR', 'message' => $ex->getMessage()));
        }

    }
}