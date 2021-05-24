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

    .file-bin-hide {
        display: none !important;
    }

    .file-bin-show {
        display: block !important;
    }

    .folder-bin-show {
        display: block !important;
    }

    .folder-bin-hide {
        display: none !important;
    }
</style>

<div class="row pb-3">
    <div class="col-12">
        <?= msg('RESPONSE_MSG'); ?>
    </div>

    <div class="col-12" style="min-height: 100px;">
        <div class="row">
            <div class="col-12 d-flex flex-row justify-content-between">
                <span class="text-muted">Folders</span>
                <span class="text-muted" style="font-size: 14px;padding: 5; background-color: #ddd;border-radius: 3px;" onclick="makeModal()"><i class="fas fa-plus"></i></span>
            </div>

            <div class="col-12 mt-3">
                <div class="row">

                    <div class="col-sm-3 mb-4 ch-padd-hover" style="overflow: hidden;">
                        <div class="card">
                            <div class="card-body d-flex flex-row align-items-center justify-content-between text-muted" style="padding: 14px;">
                                <div class="d-flex flex-row align-items-center">
                                    <i class="fas fa-folder mr-2"></i>
                                    <p class="card-text" style="width: 180px;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;">folder 1 asdasdajhkjdhakjsdkjahskjdka</p>
                                </div>
                                <div>
                                    <i class="fas fa-ellipsis-v show-onhover"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="row">
            <div class="col-12 d-flex flex-row justify-content-between">
                <span class="text-muted">Files</span>
            </div>

            <div class="col-12 mt-3">
                <div class="row">

                    <div class="col-sm-3 mb-4">
                        <div class="card">
                            <div class="card-body d-flex flex-row align-items-center text-muted" style="padding: 14px;">
                                <i class="fas fa-folder mr-2"></i>
                                <p class="card-text">folder 1</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

<?php require __DIR__ . '/make_modal.view.php'; ?>

<script>
    $(document).ready(function() {
        $("#make_option").val("");
        $("#folder_bin").css({
            "cssText": "display: none !important"
        });
        $("#file_bin").css({
            "cssText": "display: none !important"
        });
    });

    function makeModal() {

        $("#make_option").val("");

        $("#folder_bin").css({
            "cssText": "display: none !important"
        });
        $("#file_bin").css({
            "cssText": "display: none !important"
        });

        $('#make_modal').modal({
            show: true,
            backdrop: 'static',
            keyboard: false
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

            FilePond.setOptions({
                server: {
                    url: base_url + '/file/upload',
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

    function close_make_modal() {
        location.reload();
    }
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>