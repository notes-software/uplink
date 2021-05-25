<?php

namespace App\Controllers;

use App\Core\App;
use App\Core\Auth;
use App\Core\Request;

class ProfileController
{
    protected $pageTitle;

    public function index()
    {
        $pageTitle = "Profile";
        $crumbs = 'Drive';
        $user_id = Auth::user('id');
        $user_data = App::get('database')->select("*", 'users', "id='$user_id'");

        return view('/auth/profile', compact('user_data', 'pageTitle', 'crumbs'));
    }

    public function update()
    {
        $request = Request::validate('/profile', [
            'email' => ['required', 'email']
        ]);

        $user_id = Auth::user('id');

        $update_data = [
            'email' => "$request[email]",
            'fullname' => "$request[name]"
        ];

        App::get('database')->update('users', $update_data, "id = '$user_id'");
        redirect("/profile", ["Profile information updated.", 'success']);
    }

    public function changePass()
    {
        $request = Request::validate('/profile', [
            'old-password' => ['required'],
            'new-password' => ['required'],
            'confirm-password' => ['required']
        ]);

        $response_message = Auth::resetPassword($request);
        redirect("/profile", $response_message);
    }

    public function delete()
    {
        Request::validate();
        $user_id = Auth::user('id');
        App::get('database')->delete('users', "id = '$user_id'");

        Auth::logout();
    }
}
