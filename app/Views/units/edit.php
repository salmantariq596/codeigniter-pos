<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="h4 mb-4">Edit Unit</h1>
            <form method="post" action="/units/update/<?= $unit['id']; ?>" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="name" 
                        name="name" 
                        value="<?= $unit['name']; ?>" 
                        placeholder="Enter unit name" 
                        required>
                    <div class="invalid-feedback">Please provide a unit name.</div>
                </div>
                <div class="mb-3">
                    <label for="short_name" class="form-label">Short Name</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="short_name" 
                        name="short_name" 
                        value="<?= $unit['short_name']; ?>" 
                        placeholder="Enter short name" 
                        required>
                    <div class="invalid-feedback">Please provide a short name.</div>
                </div>
                <div class="mb-3">
                    <label for="base_unit" class="form-label">Base Unit</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="base_unit" 
                        name="base_unit" 
                        value="<?= $unit['base_unit']; ?>" 
                        placeholder="Enter base unit (optional)">
                </div>
                <div class="mb-3">
                    <label for="operate" class="form-label">Operate</label>
                    <select 
                        class="form-select" 
                        id="operate" 
                        name="operate" 
                        required>
                        <option value="*" <?= $unit['operate'] === '*' ? 'selected' : ''; ?>>Multiply</option>
                        <option value="/" <?= $unit['operate'] === '/' ? 'selected' : ''; ?>>Divide</option>
                    </select>
                    <div class="invalid-feedback">Please select an operation.</div>
                </div>
                <div class="mb-3">
                    <label for="operate_value" class="form-label">Operate Value</label>
                    <input 
                        type="number" 
                        step="0.01" 
                        class="form-control" 
                        id="operate_value" 
                        name="operate_value" 
                        value="<?= $unit['operate_value']; ?>" 
                        placeholder="Enter operate value" 
                        required>
                    <div class="invalid-feedback">Please provide a valid operate value.</div>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Update Unit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Enable Bootstrap validation styles for forms
    (function () {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>

<?= $this->endSection() ?>
