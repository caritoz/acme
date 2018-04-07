<?php
namespace Acme\Controllers\Backoffice;
use Acme\Models\Client;
use Acme\Models\Album;
use Acme\Facades\PictureControl;

class ClientsController extends \BaseController
{
    /**
     * Client Repository
     *
     * @var Client
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

	/**
	 * Display a listing of clients
	 *
	 * @return Response
	 */
	public function index()
	{
//		$clients = $this->client->all();

        $query = \Request::get('q');

        $clients = $query
            ? $this->client->search($query)->paginate(5)
            : $this->client->paginate(5);

		return \View::make('admin.clients.index', compact('clients'));
	}

	/**
	 * Show the form for creating a new client
	 *
	 * @return Response
	 */
	public function create()
	{
        \Input::flash();

		return \View::make('admin.clients.create');
	}

	/**
	 * Store a newly created client in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make($data = \Input::all(), Client::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

        $client = $this->client->create($data);

        \Notification::success('The client was saved.');

//		return \Redirect::route('admin.clients.index');
        return \Redirect::route('admin.clients.edit', array('id' => $client->id));
	}

	/**
	 * Display the specified client.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$client = $this->client->findOrFail($id);

		return \View::make('clients.show', compact('client'));
	}

	/**
	 * Show the form for editing the specified client.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        \Input::flash();

		$client = $this->client->find($id);

        $album  = Album::find(Album::CLIENT);

        $json   = PictureControl::showEdit($id, $client, $album);

        return \View::make('admin.clients.edit', compact('client'))->with('json', $json)->with('id',$id)->with('album', Album::CLIENT);

//		return \View::make('admin.clients.edit', compact('client'));
	}

	/**
	 * Update the specified client in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$client = $this->client->findOrFail($id);

		$validator = \Validator::make($data = \Input::all(), Client::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$client->update($data);

		return \Redirect::route('admin.clients.index');
	}

	/**
	 * Remove the specified client from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $this->client->destroy($id);

		return \Redirect::route('admin.clients.index');
	}

}
