<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['prefix' => 'backend', 'middleware' => ['role:backend']], function () {
    Route::get('/', 'Backend\BackendController@index')->name('index-backend');

    // Silkroad
    Route::group(['prefix' => 'silkroad'], function () {
        Route::get('/user', 'Backend\SilkroadController@indexSroUser')->name('sro-user-index-user-backend');
        Route::get('/user-datatables', 'Backend\SilkroadController@sroUserDatatables')->name('sro-user-datatables-backend');
        Route::get('/user/{user}/edit', 'Backend\SilkroadController@sroUserEdit')->name('sro-user-edit-backend');

        Route::get('/players', 'Backend\SilkroadController@indexSroPlayer')->name('sro-players-index-backend');
        Route::get('/players-datatables', 'Backend\SilkroadController@SroPlayerDatatables')->name('sro-players-datatables-backend');
        Route::get('/players/{char}/edit', 'Backend\SilkroadController@sroPlayerEdit')->name('sro-players-edit-backend');
    });

    Route::group(['prefix' => 'web'], function () {
        Route::group(['prefix' => 'downloads'], function () {
            Route::get('/', 'Backend\DownloadsController@index')->name('downloads-index-backend');
            Route::get('/add', 'Backend\DownloadsController@create')->name('downloads-create-backend');
            Route::get('/create', 'Backend\DownloadsController@show')->name('downloads-show-backend');
            Route::post('/create', 'Backend\DownloadsController@create')->name('downloads-create-backend');
            Route::get('/{download}/edit', 'Backend\DownloadsController@edit')->name('downloads-edit-backend');
            Route::patch('/{download}/update', 'Backend\DownloadsController@update')->name('downloads-update-backend');
            Route::post('/{download}/destroy', 'Backend\DownloadsController@destroy')->name('downloads-destroy-backend');
        });
        Route::group(['prefix' => 'images'], function () {
            Route::get('/', 'Backend\ImagesController@index')->name('images-index-backend');
            Route::get('/add', 'Backend\ImagesController@show')->name('images-show-backend');
            Route::post('/create', 'Backend\ImagesController@create')->name('images-create-backend');
            Route::post('/{image}/destroy', 'Backend\ImagesController@destroy')->name('images-destroy-backend');
        });

        Route::resource('/news', 'Backend\NewsController', [
            'as' => 'backend-news'
        ]);
    });

    // Logging
    Route::get('/smc-log', 'Backend\BackendController@smclogIndex')->name('smclog-index-backend');
    Route::get('/smc-log-datatables', 'Backend\BackendController@smclogDatatables')->name('smclog-datatables-backend');
});