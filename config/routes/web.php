<?php

use App\Core\Routing\Route;

// upload
Route::post('/file/upload', ['FileUploadController@store', ['auth']]);
Route::delete('/file/upload', ['FileUploadController@delete', ['auth']]);

// your routes goes here
Route::get('/', ['WelcomeController@home', ['auth']]);
Route::get('/home', ['WelcomeController@home', ['auth']]);

// Drive
Route::get('/drive', ['DriveController@index', ['auth']]);
Route::post('/drive/new_folder', ['DriveController@newFolder', ['auth']]);
Route::post('/drive/uploadFile/{code}', ['DriveController@uploadFile', ['auth']]);
Route::get('/drive/folder/{code}', ['DriveController@folderDetail', ['auth']]);
Route::post('/drive/rename_folder', ['DriveController@renameFolder', ['auth']]);
Route::post('/drive/rename_file', ['DriveController@renameFile', ['auth']]);
Route::post('/drive/delete_folder', ['DriveController@deleteFolder', ['auth']]);
Route::post('/drive/delete_file', ['DriveController@deleteFile', ['auth']]);
Route::post('/drive/download_file', ['DriveController@downloadFile', ['auth']]);

// Notes
Route::get('/notes', ['NotesController@index', ['auth']]);
