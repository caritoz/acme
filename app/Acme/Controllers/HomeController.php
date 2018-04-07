<?php
namespace Acme\Controllers;
use Acme\Models\Client;
use Acme\Models\Performedwork;
use Acme\Models\Picture;
use Acme\Models\Album;

class HomeController extends \BaseController {

    //TODO: This should be overwrite by const defined by lang.
    const PAGE_TITLE = "Acme";
    const IMAGE_SIZE_SINGLE = 380;
    const IMAGE_SIZE_HIGHLIGHTED = 580;
    const IMAGE_CLASS_SINGLE = 'col-md-3 col-lg-3 col-sm-12';
    const IMAGE_CLASS_HIGHLIGHTED = 'col-md-6 col-lg-6 col-sm-12';
    const TITLE_PARAMETER_COLUMN = 'short_content';
    const IMAGE_PARAMETER_COLUMN = 'short_content';

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
    public function index()
    {
        HomeController::SetViewPage();
        return \View::make('frontend.index');
    }

    public function showRenders()
    {
        self::SetViewPage();

        $albums     = Album::Flota();
        $clients    = Client::all();

        return \View::make('frontend.renders')
            ->with('clients', $clients)
            ->with('albums', $albums);
    }

    public function showRenders2()
    {
        self::SetViewPage();

        $albums     = Album::Flota();
        $clients    = Client::all();

        return \View::make('frontend.renders2')
            ->with('clients', $clients)
            ->with('albums', $albums);
    }

	public function showUnderConstruction()
	{
		//return \View::make('frontend.down');
		return \View::make('frontend.enconstruccion');
	}

    public function showContact()
	{
        self::SetViewPage();

		return \View::make('frontend.contact');
	}

    public function postContact()
    {
        //Get all the data and store it inside Store Variable
        $data = \Input::all();

        //Validation rules
        $rules = array (
            'nombre' => 'required|alpha',
//            'phone_number'=>'numeric|min:8',
            'email' => 'required|email',
//            'message' => 'required|min:25'
        );

        //Validate data
        $validator  = \Validator::make ($data, $rules);

        //If everything is correct than run passes.
        if ($validator->passes())
        {
            $data = array_merge(\Input::all(),
                [
                    'now' => date('m/d/Y @ h:i a'),
                    'body' => \Input::get('message')
                ]);

            //Send email using Laravel send function
            \Mail::send('emails.contact', $data, function($message) use ($data)
            {
                //email 'From' field: Get users email add and name
                $message->from('foo@foo.com', $data['nombre']);

                //email 'To' field: change this to emails that you want to be notified.
                $message->to('foo@foo.com', 'Acme')
                    ->subject('Requerimiento de Contacto');
            });

//            return \Redirect::to('/#contacto');
            return \Response::json(['status' => 'OK', 'messages'=> 'El mensaje ha sido enviado.', 'redirect' => route('frontend.index')] );
        }
        else
        {
            //return contact form with errors
            //return Redirect::to('/')->withErrors($validator);
            return \Response::json(['status' => 'ERROR', 'errors' => $validator->getMessageBag()->toArray()]);
        }
    }

    public function showAbout()
    {
        HomeController::SetViewPage();
        return \View::make('frontend.about');
    }

    public function showBlog()
    {
        HomeController::SetViewPage();
        return \View::make('frontend.blog');
    }

	public function showToursVirtuales()
    {
        HomeController::SetViewPage();
        return \View::make('frontend.360');
    }

    public function showAnimations()
    {
        HomeController::SetViewPage();
        return \View::make('frontend.animations');
    }
	
    public static function SetViewPage()
    {
        $pageTitle = self::PAGE_TITLE;
        $projects   = Performedwork::searchPublished()->get();

        \View::share('pageTitle',$pageTitle);
        \View::share('projects', $projects);
    }
}
