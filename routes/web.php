<?php

Auth::routes();
Route::get('/', 'HomeController@index');
Route::get('/qgrid', 'QgridController@index');
Route::get('/qgrid/add', 'QgridController@create')->name('/qgrid/add');
Route::get('/qgrid/export_csv', 'QgridController@export_csv')->name('/qgrid/export_csv');
Route::get('/qgrid/export_json', 'QgridController@export_json')->name('/qgrid/export_json');
Route::post('/qgrid/update{id}', 'QgridController@update')->name('/qgrid/update');
Route::post('/qgrid/delete{id}', 'QgridController@delete')->name('/qgrid/delete');
Route::get('page/add', 'PageController@create');
Route::get('page/{page}/delete', [
    'as'   => 'page.delete',
    'uses' => 'PageController@destroy',
]);
Route::resource('/page', 'PageController');

Route::post('fileUpload', ['as'=>'fileUpload','uses'=>'HomeController@fileUpload']);

function is_active_sorter($key, $direction = 'ASC')
{
    if (request('sortby') == $key && request('sortdir') == $direction) {
        return true;
    }

    return false;
}


