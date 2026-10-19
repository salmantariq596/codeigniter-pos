<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2>Add New Expense</h2>
        </div>
        <div class="card-body">
            <?php if (session()->has('errors')): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach (session('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('expenses/store') ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="expense_date" class="form-label">Date <span class="text-danger">*</span></label>
                        <input type="date" 
                               class="form-control <?= session('errors.expense_date') ? 'is-invalid' : '' ?>" 
                               id="expense_date" 
                               name="expense_date" 
                               value="<?= old('expense_date') ?>" 
                               required>
                        <?php if (session('errors.expense_date')): ?>
                            <div class="invalid-feedback">
                                <?= session('errors.expense_date') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                        <select class="form-select <?= session('errors.category') ? 'is-invalid' : '' ?>" 
                                id="category" 
                                name="category" 
                                required>
                            <option value="">Select Category</option>
                            <option value="Utilities" <?= old('category') == 'Utilities' ? 'selected' : '' ?>>Utilities</option>
                            <option value="Rent" <?= old('category') == 'Rent' ? 'selected' : '' ?>>Rent</option>
                            <option value="Supplies" <?= old('category') == 'Supplies' ? 'selected' : '' ?>>Supplies</option>
                            <option value="Salary" <?= old('category') == 'Salary' ? 'selected' : '' ?>>Salary</option>
                            <option value="Others" <?= old('category') == 'Others' ? 'selected' : '' ?>>Others</option>
                        </select>
                        <?php if (session('errors.category')): ?>
                            <div class="invalid-feedback">
                                <?= session('errors.category') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" 
                                   step="0.01" 
                                   class="form-control <?= session('errors.amount') ? 'is-invalid' : '' ?>" 
                                   id="amount" 
                                   name="amount" 
                                   value="<?= old('amount') ?>" 
                                   required>
                            <?php if (session('errors.amount')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.amount') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control <?= session('errors.description') ? 'is-invalid' : '' ?>" 
                              id="description" 
                              name="description" 
                              rows="3"><?= old('description') ?></textarea>
                    <?php if (session('errors.description')): ?>
                        <div class="invalid-feedback">
                            <?= session('errors.description') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Expense
                    </button>
                    <a href="<?= base_url('expenses') ?>" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
