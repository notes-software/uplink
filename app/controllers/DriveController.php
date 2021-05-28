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

            $file_name = explode('_', str_replace(array('.', ' ', ',', '-'), '_', $_FILES['upload_file']['name']));
            array_pop($file_name);

            $fileSize = $_FILES['upload_file']['size'] / 1000000;
            $file_type = explode('.', $_FILES['upload_file']['name']);
            $file_type_end = end($file_type);
            $fileType = strtoupper($file_type_end);

            $filename = strtoupper(randChar(4)) . date('Ymdhis') . "." . $file_type_end;

            $image_icons_array = array("JPEG", "JPG", "EXIF", "TIFF", "GIF", "BMP", "PNG", "SVG", "ICO", "PPM", "PGM", "PNM");
            if (in_array($fileType, $image_icons_array)) {
                $previewSize = '100%';
            } else {
                $previewSize = '25%';
            }

            $folder = uniqid() . '-' . date('Ymdhis');
            $temp_dir = "public/assets/drive/{$user_id}/";

            $folderName = implode('_', $file_name);
            $this->saveFilesInDb($user_id, $curr_folder, $temp_dir . $filename, $folderName, $fileSize, $fileType, $previewSize);

            Request::storeAs($file_tmp, $temp_dir, $_FILES['upload_file']['type'], $filename);

            echo $folder;
        }

        echo '';
    }

    public function saveFilesInDb($user_id, $folder_id, $path, $file_name, $fileSize, $fileType, $previewSize)
    {
        $fileCode = randChar(3) . date('ymdhis');

        $data_form = [
            "file_code" => $fileCode,
            "user_id" => $user_id,
            "folder_id" => $folder_id,
            "slug" => $path,
            "filetype" => $fileType,
            "filename" => $file_name,
            "filesize" => $fileSize,
            "iconsize" => $previewSize,
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
            ? '<a href="' . route('/drive') . '">Drive / </a><a href="' . route('/drive/folder', $prev['folder_code']) . '">' . $prev['folder_name'] . ' / </a>'
            : '<a href="' . route('/drive') . '">Drive /</a> ';

        $crumbs = $displayPrev . $folderSelected['folder_name'];

        $folders = App::get('database')->selectLoop("*", "user_folder", "user_id = '$user_id' AND parent_folder = '$folderSelected[id]'");

        $files = App::get('database')->selectLoop("*", "user_files", "user_id = '$user_id' AND folder_id = '$folderSelected[id]'");

        return view('/drive/index', compact('pageTitle', 'folders', 'files', 'crumbs', 'folderCode'));
    }

    public function renameFolder()
    {
        $user_id = Auth::user('id');
        $request = Request::validate('/drive', [
            "rename_folder_input" => "required"
        ]);

        $form_data = [
            "folder_name" => $request['folder_name'],
            "updated_at" => date('Y-m-d h:i:s')
        ];

        $response = App::get('database')->update("user_folder", $form_data, "folder_code = '$request[current_folder_code]' AND user_id = '$user_id'");

        echo $response;
    }

    public function deleteFolder()
    {
        $user_id = Auth::user('id');
        $request = Request::validate('/drive');

        $folder = App::get('database')->select("*", "user_folder", "folder_code = '$request[current_folder_code]' AND user_id = '$user_id'");

        $this->deleteFolders($user_id, $folder['id']);
        echo 1;
    }

    public function deleteFolders($user_id, $folder_id)
    {
        $file = new Filesystem;

        $users_files = App::get('database')->selectLoop("*", "user_files", "folder_id = '$folder_id' AND user_id = '$user_id'");
        foreach ($users_files as $files) {
            if (Filesystem::exists($files->slug)) {
                $file->delete($files->slug);
                App::get('database')->delete("user_files", "id = '$files->id' AND user_id = '$user_id'");
            }
        }

        App::get('database')->delete("user_folder", "id = '$folder_id' AND user_id = '$user_id'");

        $sub_folder_list = App::get('database')->selectLoop("*", "user_folder", "parent_folder = '$folder_id' AND user_id = '$user_id'");
        foreach ($sub_folder_list as $sub_folder) {
            $this->deleteFolders($user_id, $sub_folder->id);
        }
    }

    public function deleteFile()
    {
        $user_id = Auth::user('id');
        $request = Request::validate('/drive');
        $file = new Filesystem;

        if (Filesystem::exists($request['path'])) {
            $file->delete($request['path']);
            App::get('database')->delete("user_files", "id = '$request[id]' AND user_id = '$user_id'");
            echo 1;
        }
    }

    public function renameFile()
    {
        $user_id = Auth::user('id');
        $request = Request::validate('/drive', [
            "rename_file_input" => "required"
        ]);

        $form_data = [
            "filename" => $request['file_name'],
            "updated_at" => date('Y-m-d h:i:s')
        ];

        $response = App::get('database')->update("user_files", $form_data, "id = '$request[current_file_id]' AND user_id = '$user_id'");

        echo $response;
    }

    public function downloadFile()
    {
        $user_id = Auth::user('id');
        $request = Request::validate('/drive');
        $filePAth = $request['fileSlug'];

        if (file_exists($filePAth)) {
            echo fileDownloader($filePAth);
        } else {
            http_response_code(404);
            die();
        }

        // return view('/drive/file_downloader', compact('filetype', 'filename', 'filePAth'));
    }
}
