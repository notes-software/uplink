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
<div class="modal fade" id="folder_options_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <input type="hidden" id="current_folder_code" value="<?= $folderCode ?>">
                <div class="col-12">
                    <div class="row">
                        <div class="col-3">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical" style="color: #fff !important;">
                                <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Rename</a>
                                <!-- <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Share</a> -->
                                <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Delete</a>
                                <a class="nav-link" id="file-pills-close-tab" data-toggle="pill" href="#" role="tab" aria-selected="false" onclick="close_make_modal()">Close</a>
                            </div>
                        </div>
                        <div class="col">
                            <div class="tab-content" id="v-pills-tabContent">

                                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                    <div class="form-group folder-bin" id="folder_bin">
                                        <label for="username">Folder name</label>
                                        <input type="text" class="form-control" name="rename_folder_input" id="rename_folder_input" autocomplete="off">

                                        <div class="row">
                                            <div class="col-12 mt-3">
                                                <div class="d-flex flex-row justify-content-end">
                                                    <button type="button" class="btn btn-primary" onclick="renameFolderSave()">Save changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                    on development
                                </div> -->

                                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                                    <div class="col-12" style="display: flex;flex-direction: column;">
                                        <p class="text-muted mt-1">This will delete this folder and all the files and subfolders.</p>
                                        <button type="button" class="btn btn-danger align-center" onclick="deleteCurrFolder()">Delete this folder</button>
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
    function renameFolderSave() {
        var rname_folder_name = $("#rename_folder_input").val();
        var current_folder_code = $("#current_folder_code").val();

        $.post(base_url + "/drive/rename_folder", {
            folder_name: rname_folder_name,
            current_folder_code: current_folder_code
        }, function(data) {
            if (data == 1) {
                alert('folder renamed successfully.');
            } else {
                alert('error renaming folder.');
            }
        });
    }

    function deleteCurrFolder() {
        var current_folder_code = $("#current_folder_code").val();

        $.post(base_url + "/drive/delete_folder", {
            current_folder_code: current_folder_code
        }, function(data) {
            if (data == 1) {
                alert('folder deleted successfully.');
            } else {
                alert('error deleting folder.');
            }
        });
    }
</script>