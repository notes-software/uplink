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
</style>

<div class="row pb-3">
    <div class="col-12">
        <?= msg('RESPONSE_MSG'); ?>
    </div>

    <div class="col-12" style="min-height: 100px;">
        <div class="row">

            <span class="text-muted" style="font-size: 19px;padding: 19px;background-color: #ddd;border-radius: 50%;position: fixed;bottom: 7%;right: 10%;z-index: 1000;" onclick="makeModal()"><i class="fas fa-plus"></i></span>

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
                                            <i class="fas fa-ellipsis-v show-onhover"></i>
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
                    <div class="row">

                        <?php
                        foreach ($files as $file) {
                        ?>
                            <div class="col-sm-3 mb-4 ch-padd-hover" style="overflow: hidden;">
                                <div class="card">
                                    <div class="card-body d-flex flex-row align-items-center justify-content-between text-muted" style="padding: 14px;">
                                        <div class="d-flex flex-row align-items-center">
                                            <p class="card-text" style="width: 190px;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;"><?= $file->slug ?></p>
                                        </div>
                                        <div>
                                            <i class="fas fa-ellipsis-v show-onhover"></i>
                                        </div>
                                    </div>
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
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>