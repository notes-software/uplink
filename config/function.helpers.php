<?php

use App\Core\App;
use App\Core\Auth;

function previous_folder($folder_id)
{
    $user_id = Auth::user('id');
    $prev = DB()->select("*", "user_folder", "user_id = '$user_id' and id = '$folder_id'")->get();

    if ($prev['parent_folder'] != 0) {
        $prevData = DB()->select("*", "user_folder", "user_id = '$user_id' and id = '$prev[parent_folder]'")->get();

        return $prevData;
    }

    return [];
}

function checkIfImage($filetype)
{
    $image_icons_array = array("JPEG", "JPG", "EXIF", "TIFF", "GIF", "BMP", "PNG", "SVG", "ICO", "PPM", "PGM", "PNM");

    if (in_array($filetype, $image_icons_array)) {
        $response = true;
    } else {
        $response = false;
    }

    return $response;
}

function getImageView($filetype, $path)
{
    $logo_path = public_url("/assets/sprnva/file_extension_icon/");
    $image_icons_array = array("JPEG", "JPG", "EXIF", "TIFF", "GIF", "BMP", "PNG", "SVG", "ICO", "PPM", "PGM", "PNM");
    $file_icons_array = array("XLS", "DOCX", "CSV", "TXT", "ZIP", "EXE", "XLSX", "PPT", "PPTX");

    if (in_array($filetype, $image_icons_array)) {
        $icon = public_url("/../" . $path);
    } else {
        if (in_array($filetype, $file_icons_array)) {
            $icon = $logo_path . $filetype . '.png';
        } else {
            $icon = $logo_path . 'FILE.png';
        }
    }

    return $icon;
}

function fileDownloader($filePAth)
{
    $filetype = filetype($filePAth);
    $filename = basename($filePAth);
    header("Content-Type: " . $filetype);
    header("Content-Length: " . filesize($filePAth));
    header("Content-Disposition: attachment; filename=" . $filename);
    readfile($filePAth);
}
