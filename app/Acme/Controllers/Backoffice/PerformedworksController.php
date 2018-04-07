<?php
namespace Acme\Controllers\Backoffice;
use Acme\Models\Performedwork;

use Acme\Models\PerformedworkFeatured;
use Acme\Models\Picture;
use Acme\Models\Album;
use Acme\Facades\PictureControl;
use Acme\Services\PictureHandler;

use Carbon\Carbon;

class PerformedworksController extends \BaseController {

	/**
	 * Performedwork Repository
	 *
	 * @var Performedwork
	 */
	protected $performedwork;

	public function __construct(Performedwork $performedwork)
	{
		$this->performedwork = $performedwork;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $query = \Request::get('q');

        $performedworks = $query
            ? $this->performedwork->search($query)->paginate(10)
            : $this->performedwork->paginate(10);

		return \View::make('admin.performedworks.index', compact('performedworks'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return \View::make('admin.performedworks.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = \Input::except(['published', 'featured', 'description']);
		$validation = \Validator::make($input, Performedwork::$rules);

		if ($validation->passes())
		{
            $input = array_merge($input, [
                'published' => \Input::has('published'),
                'description' => \Acme\Helpers\StringHelper::CleanHTMLTextareaTidy(\Input::get('description'))
            ]);

			$performedwork = $this->performedwork->create($input);

            if(\Input::has('featured') ):
                $performedworkFeatured = new PerformedworkFeatured;
                $performedworkFeatured->performedwork_id = $performedwork->id;
                $performedworkFeatured->featured_order = PerformedworkFeatured::makeOrder($performedwork->id);
                $performedworkFeatured->save();
            endif;

            \Notification::success('The work was saved.');

//			return \Redirect::route('admin.performedworks.index');
            return \Redirect::route('admin.performedworks.edit', array('id' => $performedwork->id));
		}

		return \Redirect::route('admin.performedworks.create')
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
		$performedwork = $this->performedwork->findOrFail($id);

		return \View::make('admin.performedworks.show', compact('performedwork'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$performedwork = $this->performedwork->find($id);

		if (is_null($performedwork))
		{
			return \Redirect::route('admin.performedworks.index');
		}

        $album  = Album::find(Album::WORKS);

        $json   = PictureControl::showEdit($id, $performedwork, $album);

		return \View::make('admin.performedworks.edit', compact('performedwork'))->with('json', $json)->with('id',$id)->with('album', Album::WORKS);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
//		$input = array_except(\Input::all(), '_method', 'published', 'featured');
		$input = \Input::except('_method', 'published', 'featured', 'description');
		$validation = \Validator::make($input, Performedwork::$rules);

		if ($validation->passes())
		{
            $input = array_merge($input, [
                'published' => \Input::has('published'),
                'description' => \Acme\Helpers\StringHelper::CleanHTMLTextareaTidy(\Input::get('description'))
            ]);

			$performedwork = $this->performedwork->find($id);
			$performedwork->update($input);

            if(\Input::has('featured') && !$performedwork->featured ):
                $performedworkFeatured = new PerformedworkFeatured;
                $performedworkFeatured->performedwork_id = $performedwork->id;
                $performedworkFeatured->featured_order = PerformedworkFeatured::makeOrder($performedwork->id);
                $performedworkFeatured->save();
            elseif( !\Input::has('featured') ) :
                $performedwork->featured()->delete();
            endif;

            \Notification::success('The work was saved.');

			return \Redirect::route('admin.performedworks.show', $id);
		}

		return \Redirect::route('admin.performedworks.edit', $id)
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
        $performedwork = $this->performedwork->find($id);

        if(count($performedwork->pictures) > 0):
            foreach($performedwork->pictures as $pictures)
            {
                PictureHandler::mediaDestroy(Album::WORKS, $pictures->id, $id);
            }
        endif;

        $performedwork->featured()->delete();
        $performedwork->delete();

		return \Redirect::route('admin.performedworks.index');
	}

    /**
     * @param $id
     * @return mixed
     */
    public function publish($id)
    {
        try
        {
            $performedwork = $this->performedwork->find($id);

            if(!$performedwork->published ):
                $performedwork->published = true;
            else :
                $performedwork->published = false;
            endif;

            $performedwork->save();

            $performedwork = $this->performedwork->find($id);

            return \Response::json(array('status' => 'OK', 'message' => 'Saved!', 'id' => $performedwork->id, 'html' => $performedwork->isPublishHTML(),'published' => $performedwork->published));

        }
        catch(\Exception $ex)
        {
            return \Response::json(array('status' => 'ERROR', 'message' => $ex->getMessage()));
        }
    }

    public function feature($id)
    {
        try
        {
            $featured = false;
            $performedwork = $this->performedwork->find($id);

            if(!$performedwork->featured ):
                $performedworkFeatured = new PerformedworkFeatured;
                $performedworkFeatured->performedwork_id = $performedwork->id;
                $performedworkFeatured->featured_order = PerformedworkFeatured::makeOrder($performedwork->id);
                $performedworkFeatured->save();

                $featured = true;
            else :
                $performedwork->featured()->delete();
            endif;

            $performedwork = $this->performedwork->find($id);

            return \Response::json(array('status' => 'OK', 'message' => 'Saved!', 'id' => $performedwork->id, 'html' => $performedwork->isFeaturedHTML(),'featured' => $featured));
        }
        catch(\Exception $ex)
        {
            return \Response::json(array('status' => 'ERROR', 'message' => $ex->getMessage()));
        }
    }

    /**
    * @param $id
    * @return mixed
     */
    public function getOrders($id)
    {
        $entity     = $this->performedwork->find($id);

        $pictures = array();
        if(count($entity->pictures) > 0):
            $pictures = $entity->pictures()->OrderAscending()->get();
        endif;

        return \View::make('admin.pictures.orders')->with('pictures', $pictures);
    }
}
