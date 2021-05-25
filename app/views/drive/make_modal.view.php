<?php

use App\Core\Request;
?>
<div class="modal fade" id="make_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <input type="hidden" id="current_folder" value="<?= $folderCode ?>">
                <div class="col-12">
                    <div class="form-group">
                        <label for="username">Options</label>
                        <select class="form-control" name="make_option" id="make_option" onchange="selectOption()">
                            <option value="">-- select --</option>
                            <option value="1">New Folder</option>
                            <option value="2">Upload Files</option>
                        </select>
                    </div>

                    <div class="content">
                        <div class="form-group folder-bin" id="folder_bin">
                            <label for="username">Folder name</label>
                            <input type="text" class="form-control" name="folder_name" id="folder_name" autocomplete="off">

                            <div class="row">
                                <div class="col-12 mt-3">
                                    <div class="d-flex flex-row justify-content-end">
                                        <button type="button" class="btn btn-secondary mr-1" onclick="close_make_modal()">Close</button>
                                        <button type="button" class="btn btn-primary" onclick="saveFolder()">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group d-flex flex-column file-bin" id="file_bin" style="position: relative;max-width: 30rem;">
                            <input type="file" id="upload_file" name="upload_file" multiple data-max-files="10">

                            <div class="row">
                                <div class="col-12 mt-3">
                                    <div class="d-flex flex-row justify-content-end">
                                        <button type="button" class="btn btn-secondary mr-1" onclick="close_make_modal()">Close</button>
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
    function saveFolder() {
        var folder_name = $("#folder_name").val();
        var current_folder = $("#current_folder").val();
        if (folder_name != "") {
            $.post(base_url + "/drive/new_folder", {
                folder_name: folder_name,
                current_folder: current_folder
            }, function(data) {
                if (data == 1) {
                    location.reload();
                } else {
                    alert('error adding folder.');
                }
            });
        }
    }

    function make_modal_init() {
        $("#make_option").val("");
        $("#folder_bin").css({
            "cssText": "display: none !important"
        });
        $("#file_bin").css({
            "cssText": "display: none !important"
        });
    }

    function selectOption() {
        var optionSelected = $("#make_option").val();
        if (optionSelected == 1) {
            $("#folder_bin").css({
                "cssText": "display: block !important"
            });
            $("#file_bin").css({
                "cssText": "display: none !important"
            });
        } else {
            $("#folder_bin").css({
                "cssText": "display: none !important"
            });
            $("#file_bin").css({
                "cssText": "display: block !important"
            });

            var curr_folder = $("#current_folder").val();
            var current_folder = (curr_folder != "") ? curr_folder : 'nodata';


            FilePond.setOptions({
                server: {
                    url: base_url + '/drive/uploadFile/' + current_folder,
                    headers: {
                        'X-CSRF-TOKEN': '<?= Request::csrf_token() ?>'
                    }
                }
            });

            FilePond.registerPlugin(
                FilePondPluginFileEncode,
                FilePondPluginFileValidateSize,
                FilePondPluginImageExifOrientation,
                FilePondPluginImagePreview
            );

            FilePond.create(document.querySelector('input[type="file"]'));
        }
    }
</script>