<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::get('pictures/default/show/{filter}', 'Acme\\Controllers\\PicturesController@showDefault');

Route::model('picture', 'Acme\\Models\\Picture');
Route::pattern('picture', '[0-9]+');
Route::get('pictures/{picture}/show/{filter}', 'Acme\\Controllers\\PicturesController@show');

/*************************************************************** FRONT END */
//Route::get('/', function()
//{
//	return \View::make('frontend.down');
//});


/*Route::get('/',              array('as' => 'frontend.index' , 'uses' => 'Acme\\Controllers\\HomeController@showUnderConstruction'));
Route::get('/uat',              array('as' => 'frontend.index' , 'uses' => 'Acme\\Controllers\\HomeController@index'));*/
Route::get('/', array('as' => 'frontend.index', 'uses' => 'Acme\\Controllers\\HomeController@index'));
Route::get('/about', array('as' => 'frontend.index', 'uses' => 'Acme\\Controllers\\HomeController@showAbout'));
Route::get('/news', array('as' => 'frontend.index', 'uses' => 'Acme\\Controllers\\HomeController@showBlog'));
Route::get('/animaciones', array('as' => 'frontend.animations',
    'uses' => 'Acme\\Controllers\\HomeController@showAnimations'));
Route::get('/renders', array('as' => 'frontend.renders',
    'uses' => 'Acme\\Controllers\\HomeController@showRenders'));
Route::get('/renders2', array('as' => 'frontend.renders2',
    'uses' => 'Acme\\Controllers\\HomeController@showRenders2'));
Route::get('/recorrido-virtual', array('as' => 'frontend.index', 'uses' => 'Acme\\Controllers\\HomeController@showUnderConstruction'));
Route::get('/tours-virtuales', array('as' => 'frontend.index', 'uses' => 'Acme\\Controllers\\HomeController@showToursVirtuales'));
Route::get('/contact', array('as' => 'frontend.index', 'uses' => 'Acme\\Controllers\\HomeController@showContact'));
Route::post('/contact-form', array('as' => 'frontend.index', 'uses' => 'Acme\\Controllers\\HomeController@postContact'));

Route::group(['prefix' => 'albums'], function () {
    Route::get('/', ['as' => "frontend.gallery.index", 'uses' => "Acme\\Controllers\\AlbumsController@index"]);
    Route::get('/{id}-{name}', ['as' => "frontend.gallery.show", 'uses' => "Acme\\Controllers\\AlbumsController@show"])->where('id', '[0-9]+');
});

Route::group(['prefix' => 'works'], function () {
    Route::get('/', ['as' => "frontend.performedworks.index", 'uses' => "Acme\\Controllers\\PerformedworksController@index"]);
    Route::get('/{id}-{name}', ['as' => "frontend.performedworks.show", 'uses' => "Acme\\Controllers\\PerformedworksController@show"])->where('id', '[0-9]+');
});

/*************************************************************** BACK OFFICE */
Route::group(array('prefix' => 'admin'), function () {
    // Public pages (login / authenticate)
    Route::get('logout', array('as' => 'admin.logout', 'uses' => 'Acme\\Controllers\\Backoffice\\AuthController@getLogout'));
    Route::get('login', array('as' => 'admin.login', 'uses' => 'Acme\\Controllers\\Backoffice\\AuthController@getLogin'));
    Route::post('login', array('as' => 'admin.login.post', 'uses' => 'Acme\\Controllers\\Backoffice\\AuthController@postLogin'));

    Route::group(array('before' => 'auth'), function () {

        Route::get('/', array('as' => 'admin.index', 'uses' => 'Acme\\Controllers\\Backoffice\\AdminController@index'));

        Route::resource('clients', 'Acme\\Controllers\\Backoffice\\ClientsController');
        Route::resource('performedworks', 'Acme\\Controllers\\Backoffice\\PerformedworksController');

        Route::resource('albums', 'Acme\\Controllers\\Backoffice\\AlbumsController');
        Route::get('albums/orders/{id}', array('as' => 'admin.albums.orders', 'uses' => 'Acme\\Controllers\\Backoffice\\AlbumsController@getOrders'));
        Route::post('albums/uploads', 'Acme\\Controllers\\Backoffice\\UploadController@storeAlbum');

        Route::get('performedworks/orders/{id}', array('as' => 'admin.performedworks.orders', 'uses' => 'Acme\\Controllers\\Backoffice\\PerformedworksController@getOrders'));

        Route::resource('pictures', 'Acme\\Controllers\\Backoffice\\PicturesController');
        Route::post('orders', array('as' => 'admin.pictures.orders', 'uses' => 'Acme\\Controllers\\Backoffice\\PicturesController@storeOrders'));

        Route::post('performedworks/feature/{id}', array('as' => 'admin.performedworks.feature', 'uses' => 'Acme\\Controllers\\Backoffice\\PerformedworksController@feature'));

        Route::post('performedworks/publish/{id}', array('as' => 'admin.performedworks.publish', 'uses' => 'Acme\\Controllers\\Backoffice\\PerformedworksController@publish'));

        Route::resource('uploads', 'Acme\\Controllers\\Backoffice\\UploadController', array('only' => array('store')));
        Route::post('uploads/destroy/{id}', array('as' => 'admin.uploads.destroy', 'uses' => 'Acme\\Controllers\\Backoffice\\UploadController@destroy'));
    });
});