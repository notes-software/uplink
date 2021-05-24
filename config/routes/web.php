<?php

// upload
$router->post('/file/upload', ['FileUploadController@store', 'auth']);
$router->delete('/file/upload', ['FileUploadController@delete', 'auth']);

// your routes goes here
$router->get('/', ['WelcomeController@home', 'auth']);
$router->get('/home', ['WelcomeController@home', 'auth']);

// Drive
$router->get('/drive', ['DriveController@index', 'auth']);

// Notes
$router->get('/notes', ['NotesController@index', 'auth']);
