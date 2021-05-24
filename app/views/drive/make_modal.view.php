<div class="modal fade" id="make_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
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
                            <input type="text" class="form-control" name="folder_name" autocomplete="off">

                            <div class="row">
                                <div class="col-12 mt-3">
                                    <div class="d-flex flex-row justify-content-end">
                                        <button type="button" class="btn btn-secondary mr-1" onclick="close_make_modal()">Close</button>
                                        <button type="button" class="btn btn-primary">Save changes</button>
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