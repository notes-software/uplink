<?php

use App\Core\Request;
?>

<style>
    .nav-pills .nav-link.active,
    .nav-pills .show>.nav-link {
        color: #fff !important;
        background-color: #1e7e34;
    }
</style>
<div class="modal fade" id="file_options_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <input type="hidden" id="current_file_id">
                <input type="hidden" id="current_file_slug">

                <div class="col-12">
                    <div class="row">
                        <div class="col-3">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical" style="color: #fff !important;">
                                <a class="nav-link active" id="file-pills-home-tab" data-toggle="pill" href="#file-pills-home" role="tab" aria-controls="file-pills-home" aria-selected="true">Rename</a>
                                <a class="nav-link" id="file-pills-downlaod-tab" data-toggle="pill" href="#file-pills-download" role="tab" aria-controls="file-pills-download" aria-selected="true">Download</a>
                                <a class="nav-link" id="file-pills-messages-tab" data-toggle="pill" href="#file-pills-messages" role="tab" aria-controls="file-pills-messages" aria-selected="false">Delete</a>
                                <a class="nav-link" id="file-pills-close-tab" data-toggle="pill" href="#" role="tab" aria-selected="false" onclick="close_make_modal()">Close</a>
                            </div>
                        </div>
                        <div class="col">
                            <div class="tab-content" id="file-pills-tabContent">

                                <div class="tab-pane fade show active" id="file-pills-home" role="tabpanel" aria-labelledby="file-pills-home-tab">
                                    <div class="form-group file-bin" id="file_bin">
                                        <label for="username">file name</label>
                                        <input type="text" class="form-control" name="rename_file_input" id="rename_file_input" autocomplete="off">

                                        <div class="row">
                                            <div class="col-12 mt-3">
                                                <div class="d-flex flex-row justify-content-end">
                                                    <button type="button" class="btn btn-primary" onclick="renameFileSave()">Save changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="file-pills-messages" role="tabpanel" aria-labelledby="file-pills-messages-tab">
                                    <div class="col-12" style="display: flex;flex-direction: column;">
                                        <p class="text-muted mt-1">This will delete the selected file.</p>
                                        <button type="button" class="btn btn-danger align-center" onclick="deleteFile()">Delete this file</button>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="file-pills-download" role="tabpanel" aria-labelledby="file-pills-download-tab">
                                    <div class="col-12" style="display: flex;flex-direction: column;">
                                        <p class="text-muted mt-1">This will download the selected file.</p>
                                        <button type="button" class="btn btn-primary align-center" onclick="downloadFile()">Download</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function deleteFile() {
        var fileId = $('#current_file_id').val();
        var fileSlug = $('#current_file_slug').val();
        $.post(base_url + "/drive/delete_file", {
            id: fileId,
            path: fileSlug
        }, function(data) {
            if (data == 1) {
                location.reload();
            } else {
                alert('error deleting file.');
            }
        });
    }

    function renameFileSave() {
        var rname_file_name = $("#rename_file_input").val();
        var current_file_id = $("#current_file_id").val();

        $.post(base_url + "/drive/rename_file", {
            file_name: rname_file_name,
            current_file_id: current_file_id
        }, function(data) {
            if (data == 1) {
                alert('file renamed successfully.');
            } else {
                alert('error renaming file.');
            }
        });
    }

    function downloadFile() {
        var fileSlug = $('#current_file_slug').val();
        // $.post(base_url + "/drive/download_file", {
        //     fileSlug: fileSlug
        // });
        window.location.href = base_url + "/" + fileSlug;
    }
</script>