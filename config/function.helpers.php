<?php

use App\Core\App;
use App\Core\Auth;

function previous_folder($folder_id)
{
    $user_id = Auth::user('id');
    $prev = App::get('database')->select("*", "user_folder", "user_id = '$user_id' and id = '$folder_id'");

    if ($prev['parent_folder'] != 0) {
        $prevData = App::get('database')->select("*", "user_folder", "user_id = '$user_id' and id = '$prev[parent_folder]'");

        return $prevData;
    }

    return [];
}
