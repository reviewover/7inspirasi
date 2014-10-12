<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{

    //Input::merge(Helper::array_strip_tags(Input::all()));

    try{
    //Input::merge(Helper::array_strip_tags(Input::all()));
    if(Config::get('database.connections.mysql.host') != ''){

        $plugins = Plugin::where('active', '=', 1)->get();

        //print_r($plugins); die();
        foreach($plugins as $plugin){
            $plugin_name = $plugin->slug;
            $include_file = 'content/plugins/' . $plugin_name . '/functions.php';

            // Create Settings Route for Plugin

            Route::group(array('before' => 'admin'), function(){

                Route::get( 'admin/plugin/{plugin_name}', function($plugin_name){
                    $data = array(
                        'plugin_data' => PluginData::where('plugin_slug', '=', $plugin_name)->get()
                    );
                    return View::make( 'plugins.' . $plugin_name . '.index', $data);
                });

                Route::post( 'admin/plugin/{plugin_name}', function($plugin_name){
                    $input = Input::all();
                    foreach($input as $key => $value){
                        $pluginData = PluginData::where('plugin_slug', '=', $plugin_name)->where('key', '=', $key)->first();

                        if(!empty($pluginData->id)){
                            $pluginData->value = $value;
                            $pluginData->save();
                        } else {
                            $pluginData = new PluginData;
                            $pluginData->plugin_slug = $plugin_name;
                            $pluginData->key = $key;
                            $pluginData->value = $value;
                            $pluginData->save();
                        }
                    }

                    return Redirect::to( 'admin/plugin/' . $plugin_name)->with(array('note' => 'Successfully updated plugin information', 'note_type' => 'success') );
                });

                Route::get( 'admin/plugin/{plugin_name}/{filename}', function($plugin_name, $filename = 'settings'){
                    return View::make( 'plugins' . $plugin_name . '.views.' . $filename);
                });
            });

            if(file_exists($include_file)){
               include($include_file);
            }

        }

    }

    } catch(Exception $e){

    }

});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('signin')->with(array('note' => 'You must be logged in first before performing this action.', 'note_type' => 'error'));
});

Route::filter('admin', function()
{
	if (!Auth::guest() && Auth::user()->admin == 1){

	} else {
		return Redirect::to('/');
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

App::error(function(PDOException $exception)
{
    Log::error("Error connecting to database: ".$exception->getMessage());

    return Redirect::to('/install.php');
});


App::error(function($exception, $code)
{
	return View::make('errors.index', array('exception' => $exception, 'code' => $code));
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
