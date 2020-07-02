<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//use App\Image;

use App\Comment;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
/*
    $images = Image::all();

    foreach ($images as $image) {
        echo $image->user->name." ".$image->user->surname.'<br>';
        echo $image->image_path.'<br>';
        //contidad de likes
        echo 'likes '.count($image->likes).'<br>';
        //
        echo $image->description.'<br>';
       

        echo '<br><strong>Comentarios</strong><br>';
        foreach ($image->comments as $comment) {
            echo '<br>'.$comment->user->name.' '.$comment->user->surname.': ';
            echo  '<br>'.$comment->content;
        }
        echo '<hr>';
    }

    die();*/

    return view('welcome');
});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/configuracion','UserController@config')->name('config');

Route::post('/user/update','UserController@update')->name('user.update');
Route::get('/user/avatar/{fileName}','UserController@getImage')->name('user.avatar');
Route::get('/profile/{id}','UserController@profile')->name('user.profile');
Route::get('/search','UserController@search')->name('user.search');
Route::get('/searched/{value?}', 'UserController@search')->name('user.searched');

Route::get('/imagenUpdate','ImageController@create')->name('image.create');
Route::post('/image/save','ImageController@save')->name('image.save');
Route::get('/image/delete/{id}','ImageController@deleteImage')->name('image.delete');
Route::get('/image/edit/{id}','ImageController@edit')->name('image.edit');
Route::post('/image/update','ImageController@update')->name('image.update');

Route::get('/image/file/{filename}','ImageController@getImage')->name('image.file');
Route::get('/imagen/{id}','ImageController@details')->name('image.detail');

Route::post('/comment/save','CommentController@save')->name('comment.save');
Route::get('/comment/delete/{id}','CommentController@delete')->name('comment.delete');

Route::get('/like/{image_id}','LikeController@like')->name('like.save');
Route::get('/dislike/{image_id}','LikeController@dislike')->name('like.delete');
Route::get('/likes','LikeController@likes')->name('like.likes');
