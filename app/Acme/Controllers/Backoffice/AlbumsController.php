<?php
namespace Acme\Controllers\Backoffice;

use Acme\Models\Picture;
use Acme\Models\Album;
use Acme\Facades\PictureControl;
use Acme\Services\PictureHandler;

class AlbumsController extends \BaseController
{
	/**
	 * Album Repository
	 *
	 * @var Album
	 */
	protected $album;

	public function __construct(Album $album)
	{
		$this->album = $album;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
//		$albums = $this->album->all();

        $query = \Request::get('q');

        $albums = $query
            ? $this->album->search($query)->paginate(5)
            : $this->album->paginate(5);

		return \View::make('admin.albums.index', compact('albums'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return \View::make('admin.albums.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = \Input::all();
		$validation = \Validator::make($input, Album::$rules);

		if ($validation->passes())
		{
            $input = array_merge($input, [
                'folder' => \Str::slug(\Input::get('caption'))
            ]);

			$album = $this->album->create($input);

            $path = public_path(). '/pictures/'. $album->folder;

            \File::makeDirectory($path, $mode = 0777, true, true);

            \Notification::success('The album was saved.');

//			return \Redirect::route('admin.albums.index');
            return \Redirect::route('admin.albums.edit', array('id' => $album->id));
		}

		return \Redirect::route('admin.albums.create')
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
		$album = $this->album->findOrFail($id);

		return \View::make('admin.albums.show', compact('album'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$album = $this->album->find($id);

		if (is_null($album))
		{
			return \Redirect::route('admin.albums.index');
		}

        $json   = PictureControl::showEditByAlbum($album);

		return \View::make('admin.albums.edit', compact('album'))
            ->with('json', $json)
            ->with('id', $id);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = array_except(\Input::all(), '_method');
		$validation = \Validator::make($input, Album::$rules);

		if ($validation->passes())
		{
			$album = $this->album->find($id);
			$album->update($input);

			return Redirect::route('admin.albums.show', $id);
		}

		return \Redirect::route('admin.albums.edit', $id)
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
        $album = $this->album->find($id);

        if( count($album->pictures) > 0 ):
            \Notification::error('The album could be not deleted. It contains images.');
        else:
            $path = public_path(). '/pictures/'. $album->folder;

            \File::deleteDirectory( $path );

            $album->delete();

            \Notification::success('The album was deleted.');
        endif;

		return \Redirect::route('admin.albums.index');
	}

    /**
     * @param $id
     * @return mixed
     */
    public function getOrders($id)
    {
        $entity     = $this->album->find($id);

        $pictures = array();
        if(count($entity->pictures) > 0):
            $pictures = $entity->pictures()->OrderAscending()->get();
        endif;

        return \View::make('admin.pictures.orders')->with('pictures', $pictures);
    }

}
