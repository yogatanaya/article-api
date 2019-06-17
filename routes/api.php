<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// All Article 
Route::get('articles', 'ArticleController@index');

// Single Article
Route::get('article/{id}', 'ArticleController@show');

// Create  
Route::post('article', 'ArticleController@store');

// update
Route::put('article', 'ArticleController@store');

// delete
Route::delete('article/{id}', 'ArticleController@destroy');
