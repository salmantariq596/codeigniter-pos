<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Units</h1>
        <a href="/units/create" class="btn btn-primary">Add New Unit</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Short Name</th>
                    <th>Base Unit</th>
                    <th>Operate</th>
                    <th>Operate Value</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($units as $unit): ?>
                <tr>
                    <td><?= $unit['id']; ?></td>
                    <td><?= $unit['name']; ?></td>
                    <td><?= $unit['short_name']; ?></td>
                    <td><?= $unit['base_unit']; ?></td>
                    <td><?= $unit['operate']; ?></td>
                    <td><?= $unit['operate_value']; ?></td>
                    <td>
                        <a href="/units/edit/<?= $unit['id']; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                        <a href="/units/delete/<?= $unit['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
