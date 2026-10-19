<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-primary">Manage Warehouses</h1>
        <a href="/warehouses/create" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i> Add Warehouse
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover table-bordered ">
                <thead class="">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Location</th>
                        <th scope="col">Capacity</th>
                        <th scope="col" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($warehouses)): ?>
                        <?php foreach ($warehouses as $warehouse): ?>
                            <tr>
                                <td><?= $warehouse['id'] ?></td>
                                <td><?= $warehouse['name'] ?></td>
                                <td><?= $warehouse['location'] ?></td>
                                <td><?= $warehouse['capacity'] ?></td>
                                <td class="text-center">
                                    <a href="/warehouses/edit/<?= $warehouse['id'] ?>" class="btn btn-warning btn-sm me-2">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <a href="/warehouses/delete/<?= $warehouse['id'] ?>" 
                                       class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Are you sure you want to delete this warehouse?');">
                                        <i class="bi bi-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">No warehouses available.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
