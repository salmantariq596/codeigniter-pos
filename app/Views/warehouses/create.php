<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-primary">Add Warehouse</h1>
        <a href="/warehouses" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="/warehouses/store" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Warehouse Name</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="form-control" 
                        placeholder="Enter warehouse name" 
                        required>
                </div>
                <div class="mb-3">
                    <label for="location" class="form-label fw-bold">Location</label>
                    <input 
                        type="text" 
                        name="location" 
                        id="location" 
                        class="form-control" 
                        placeholder="Enter warehouse location" 
                        required>
                </div>
                <div class="mb-3">
                    <label for="capacity" class="form-label fw-bold">Capacity</label>
                    <input 
                        type="number" 
                        name="capacity" 
                        id="capacity" 
                        class="form-control" 
                        placeholder="Enter warehouse capacity" 
                        min="1" 
                        required>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success me-2">
                        <i class="bi bi-check-circle"></i> Save
                    </button>
                    <a href="/warehouses" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
