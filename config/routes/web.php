<?php

// upload
$router->post('/file/upload', ['FileUploadController@store', 'auth']);
$router->delete('/file/upload', ['FileUploadController@delete', 'auth']);

// your routes goes here
$router->get('/', ['WelcomeController@home', 'auth']);
$router->get('/home', ['WelcomeController@home', 'auth']);

// Drive
$router->get('/drive', ['DriveController@index', 'auth']);
$router->post('/drive/new_folder', ['DriveController@newFolder', 'auth']);
$router->post('/drive/uploadFile/{code}', ['DriveController@uploadFile', 'auth']);
$router->get('/drive/folder/{code}', ['DriveController@folderDetail', 'auth']);

// Notes
$router->get('/notes', ['NotesController@index', 'auth']);
