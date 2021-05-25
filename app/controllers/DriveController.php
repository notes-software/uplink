<?php

namespace App\Controllers;

use App\Core\App;
use App\Core\Auth;
use App\Core\Request;
use App\Core\Filesystem;

class DriveController
{
    protected $pageTitle;

    public function index()
    {
        $pageTitle = "Drive";
        $crumbs = 'Drive';
        $user_id = Auth::user('id');
        $folders = App::get('database')->selectLoop("*", "user_folder", "user_id = '$user_id' AND parent_folder = '0'");
        $files = App::get('database')->selectLoop("*", "user_files", "user_id = '$user_id' AND folder_id = '0'");

        return view('/drive/index', compact('pageTitle', 'folders', 'files', 'crumbs'));
    }

    public function newFolder()
    {
        $request = Request::validate('/drive');
        $folderCode = randChar(3) . date('ymdhis');
        $user_id = Auth::user('id');
        $current_folder_code = $request['current_folder'];
        $curr_folder = App::get('database')->select("*", "user_folder", "user_id = '$user_id' AND folder_code = '$current_folder_code'");

        $data_form = [
            "folder_code" => $folderCode,
            "user_id" => $user_id,
            "folder_name" => $request['folder_name'],
            "parent_folder" => $curr_folder['id'],
            "created_at" => date('Y-m-d h:i:s'),
            "updated_at" => date('Y-m-d h:i:s')
        ];

        $response = App::get('database')->insert("user_folder", $data_form);
        echo $response;
    }

    public function uploadFile($code)
    {
        $user_id = Auth::user('id');
        if ($code == "nodata") {
            $curr_folder = 0;
        } else {
            $curr_folder_query = App::get('database')->select("*", "user_folder", "user_id = '$user_id' AND folder_code = '$code'");
            $curr_folder = $curr_folder_query['id'];
        }

        if (Request::hasFile('upload_file')) {
            $file_tmp = $_FILES['upload_file']['tmp_name'];
            $filename = $_FILES['upload_file']['name'];
            $folder = uniqid() . '-' . date('Ymdhis');
            $temp_dir = "public/assets/drive/{$user_id}/";

            $this->saveFilesInDb($user_id, $curr_folder, $temp_dir . $filename);

            Request::storeAs($file_tmp, $temp_dir, $_FILES['upload_file']['type'], $filename);

            echo $folder;
        }

        echo '';
    }

    public function saveFilesInDb($user_id, $folder_id, $path)
    {
        $fileCode = randChar(3) . date('ymdhis');

        $data_form = [
            "file_code" => $fileCode,
            "user_id" => $user_id,
            "folder_id" => $folder_id,
            "slug" => $path,
            "created_at" => date('Y-m-d h:i:s'),
            "updated_at" => date('Y-m-d h:i:s')
        ];

        App::get('database')->insert("user_files", $data_form);
    }

    public function folderDetail($code)
    {
        $pageTitle = "Folder";
        $folderCode = $code;
        $user_id = Auth::user('id');
        $folderSelected = App::get('database')->select("*", "user_folder", "user_id = '$user_id' AND folder_code = '$code'");

        $prev = previous_folder($folderSelected['id']);

        $displayPrev = ($prev['folder_code'] != "")
            ? '<a href="' . route('/drive') . '">Drive > </a><a href="' . route('/drive/folder', $prev['folder_code']) . '">' . $prev['folder_name'] . ' > </a>'
            : '<a href="' . route('/drive') . '">Drive ></a> ';

        $crumbs = $displayPrev . $folderSelected['folder_name'];

        $folders = App::get('database')->selectLoop("*", "user_folder", "user_id = '$user_id' AND parent_folder = '$folderSelected[id]'");

        $files = App::get('database')->selectLoop("*", "user_files", "user_id = '$user_id' AND folder_id = '$folderSelected[id]'");

        return view('/drive/index', compact('pageTitle', 'folders', 'files', 'crumbs', 'folderCode'));
    }
}
