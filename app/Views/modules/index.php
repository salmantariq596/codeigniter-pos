<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <h1>Module Management</h1>

    <!-- Upload Module -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Upload New Module</h5>
        </div>
        <div class="card-body">
            <form action="<?= site_url('module-management/upload') ?>" method="POST" enctype="multipart/form-data" class="row align-items-center">
                <div class="col-auto">
                    <label for="module_zip" class="col-form-label">Upload Module:</label>
                </div>
                <div class="col">
                    <input type="file" name="module_zip" class="form-control" required>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>

    <hr>

    <!-- List Modules -->
    <h2>Installed Modules</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Module Name</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($modules as $module): ?>
                <tr>
                    <td><?= esc($module->name) ?></td>
                    <td><?= ucfirst(esc($module->status)) ?></td>
                    <td>
                        <a href="<?= site_url('module-management/toggle-status/' . esc($module->id)) ?>" class="btn btn-link">
                            <?= $module->status === 'active' ? 'Deactivate' : 'Activate' ?>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>