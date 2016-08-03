<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//爬虫 路由
Route::group(['namespace' => 'Crawler'], function(){
    // 控制器在 "App\Http\Controllers\Crawler" 命名空间下

    //Route::get('/crawlerstart','CrawlerController@getUrl');
    Route::get('/crawlerstart','CrawlerController@analyse');
});


Route::get('/index','Esearch\EsController@index');
Route::get('/search','Esearch\EsController@search');

Route::get('/get','Redis\RedisController@get');
Route::get('/set','Redis\RedisController@set');

Route::get('/test',function(){
   $num =0;

    while (1){
        echo str_repeat(' ', 1024*25);

        ob_flush();
        echo $num;
        sleep(1);
        $num++;
    }
});


Route::get('/', function () {
    return view('welcome');
});
