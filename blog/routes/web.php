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

Route::get('/posts/create','PostsController@create');//检查主板状态并创建任务
Route::post('/posts','PostsController@store');
Route::get('/posts/tasklist','TeststatusController@create');
Route::get('/posts/taskrecord','TestrecordController@create');
Route::post('/posts/taskrecord/loglist','TestrecordController@findlog');
Route::get('/posts/updatestatus/{id}/{time}','TeststatusController@updatafreestatus');
//程序测试路径
//Route::get('/posts/test/{id}/{time}','TeststatusController@about');//
//Route::get('/posts/queuetest','TestrecordController@sendReminderEmail');
Route::get('/posts/test/{id}/{time}','TestrecordController@sendReminderEmail');
//Route::get('/posts/test','TeststatusController@switchShift');
Route::get('/posts/test','TeststatusController@fileRead1');
Route::get('/task','TeststatusController@task');
Route::post('/data1','TeststatusController@dataProcess');

//Route::post('/aa','TeststatusController@task');

//上传结果路径
Route::post('/data','TeststatusController@logPosition');//需要mac地址和任务名

Route::get('/asdf', function () {
    return view('new');
    //return 1;
});

//log查看路径
Route::get('/log/{macAddr}/{taskType}/{fileName}','TeststatusController@fileRead');



Route::get('/sda','TestrecordController@rtmp');





