<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h2>Expenses List</h2>
    <a href="<?= base_url('expenses/create') ?>" class="btn btn-primary mb-3">Add New Expense</a>
    
    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('message') ?>
        </div>
    <?php endif; ?>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Date</th>
                <th>Category</th>
                <th>Amount</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($expenses as $expense): ?>
            <tr>
                <td><?= date('Y-m-d', strtotime($expense['expense_date'])) ?></td>
                <td><?= esc($expense['category']) ?></td>
                <td>$<?= number_format($expense['amount'], 2) ?></td>
                <td><?= esc($expense['description']) ?></td>
                <td>
                    <a href="<?= base_url('expenses/edit/' . $expense['id']) ?>" class="btn btn-sm btn-info">Edit</a>
                    <a href="<?= base_url('expenses/delete/' . $expense['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
