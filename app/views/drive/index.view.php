<?php require __DIR__ . '/../layouts/head.php';

use App\Core\App; ?>

<div class="row pb-3">
    <div class="col-12">
        <?= msg('RESPONSE_MSG'); ?>
    </div>

    <div class="col-12 d-flex flex-row justify-content-between">
        <span class="text-muted">Folders</span>
        <span class="text-muted" style="font-size: 14px;padding: 5; background-color: #ddd;border-radius: 3px;"><i class="fas fa-plus"></i></span>
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

<?php require __DIR__ . '/../layouts/footer.php'; ?>