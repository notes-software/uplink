<?php require __DIR__ . '/../layouts/head.php';

use App\Core\App;
use App\Core\Request; ?>

<style>
    .ch-padd-hover:hover .show-onhover {
        display: block;
    }

    .show-onhover {
        display: none;
    }

    a {
        text-decoration: none !important;
        color: #6c757d !important;
    }

    .card-text-small {
        font-size: 12px;
    }
</style>

<div class="row pb-3">
    <div class="col-12">
        <?= msg('RESPONSE_MSG'); ?>
    </div>

    <div class="col-12">
        <div class="row">

            <span class="text-muted" style="font-size: 19px;padding: 19px;background-color: #1e7e34;color: #fff !important;border-radius: 50%;position: fixed;bottom: 7%;right: 10%;z-index: 1000;box-shadow: 0 2px 5px 0 rgb(0 0 0);" onclick="makeModal()"><i class="fas fa-plus"></i></span>

            <?php
            if (count($folders) > 0) {
            ?>
                <div class="col-12 d-flex flex-row justify-content-between">
                    <span class="text-muted">Folders</span>
                </div>

                <div class="col-12 mt-3">
                    <div class="row">

                        <?php
                        foreach ($folders as $folder) {
                        ?>
                            <div class="col-sm-3 mb-4 ch-padd-hover" style="overflow: hidden;">
                                <div class="card">
                                    <div class="card-body d-flex flex-row align-items-center justify-content-between text-muted" style="padding: 14px;">
                                        <a href="<?= route("/drive/folder", $folder->folder_code) ?>">
                                            <div class="d-flex flex-row align-items-center">

                                                <i class="fas fa-folder mr-2"></i>
                                                <p class="card-text" style="width: 180px;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;"><?= $folder->folder_name ?></p>

                                            </div>
                                        </a>
                                        <div>
                                            <i class="fas fa-ellipsis-v show-onhover" onclick="openFolderOptionsModal('<?= $folder->folder_code ?>', '<?= $folder->folder_name ?>')"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <?php
    if (count($files) > 0) {
    ?>
        <div class="col-12">
            <div class="row">
                <div class="col-12 d-flex flex-row justify-content-between">
                    <span class="text-muted">Files</span>
                </div>

                <div class="col-12 mt-3">

                    <div class="card-columns">
                        <?php
                        foreach ($files as $file) {
                            $iconSize = "width: " . $file->iconsize . ";";

                            if (!checkIfImage($file->filetype)) {
                                $isNotImg = "display: inline-flex;flex-direction: row;word-break: break-all;";
                            } else {
                                $isNotImg = "";
                            }
                        ?>


                            <div class="card ch-padd-hover" style="border: 1px solid rgb(0 0 0 / 26%);overflow: hidden;<?= $isNotImg ?>">
                                <img class="card-img-top" style="<?= $iconSize ?>" src="<?= getImageView($file->filetype, $file->slug) ?>" alt="Card image cap">
                                <div class="card-body">
                                    <p class="card-text card-text-small d-flex flex-column">
                                        <?= $file->filename ?>
                                        <small class="text-muted" style="display: flex;flex-direction: row;justify-content: space-between;align-items: center;justify-items: center;">
                                            <?= $file->filesize . " MB | [{$file->filetype}]" ?>

                                            <span class="d-flex flex-row show-onhover">
                                                <i class="fas fa-cog show-onhover text-muted" style="font-size: 14px;cursor: pointer;" onclick="fileOption('<?= $file->id ?>', '<?= $file->slug ?>', '<?= $file->filename ?>')"></i>
                                            </span>
                                        </small>
                                    </p>
                                </div>
                            </div>


                        <?php } ?>
                    </div>

                </div>
            </div>
        </div>
    <?php } ?>

</div>

<?php require __DIR__ . '/make_modal.view.php'; ?>
<?php require __DIR__ . '/folder_option_modal.view.php'; ?>
<?php require __DIR__ . '/file_option_modal.view.php'; ?>

<script>
    $(document).ready(function() {
        make_modal_init();
    });

    function makeModal() {

        make_modal_init();

        $('#make_modal').modal({
            show: true,
            backdrop: 'static',
            keyboard: false
        });
    }

    function close_make_modal() {
        location.reload();
    }

    function openOptions() {
        $('.example-popover').popover({
            container: 'body'
        })
    }

    function openFolderOptionsModal(selected_folder_code, selected_folder_name) {
        $('#current_folder_code').val(selected_folder_code);
        $('#rename_folder_input').val(selected_folder_name);
        $('#folder_options_modal').modal({
            show: true,
            backdrop: 'static',
            keyboard: false
        });
    }

    function fileOption(id, path, name) {
        $('#current_file_id').val(id);
        $('#current_file_slug').val(path);
        $('#rename_file_input').val(name);
        $('#file_options_modal').modal({
            show: true,
            backdrop: 'static',
            keyboard: false
        });
    }
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>