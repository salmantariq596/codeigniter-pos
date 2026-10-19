<?= $this->extend('layout/layout') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css">
<style>
    .dataTables_wrapper {
        padding: 20px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    
    .table thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
    }
    
    .btn-action {
        padding: 0.25rem 0.5rem;
        margin: 0 0.2rem;
        border-radius: 4px;
    }
    
    .btn-edit {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #000;
    }
    
    .btn-delete {
        background-color: #dc3545;
        border-color: #dc3545;
        color: #fff;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h3">User Management</h1>
            <p class="text-muted">Manage your system users</p>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body">
            <table id="userTable" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    // Helper function to format dates
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleString('en-US', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
    }

    const userTable = $('#userTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '<?= base_url('fetch-all-users') ?>',
            type: 'GET',
            error: function (xhr, error, thrown) {
                console.error('Ajax error:', error);
            }
        },
        columns: [
            { data: 'id' },
            { data: 'username' },
            { data: 'email' },
            { 
                data: 'created_at',
                render: function(data, type, row) {
                    if (type === 'display') {
                        return formatDate(data);
                    }
                    return data;
                }
            },
            {
                data: null,
                orderable: false,
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-action btn-edit" onclick="editUser(${row.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-action btn-delete" onclick="deleteUser(${row.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    `;
                }
            }
        ],
        order: [[0, 'desc']], // Sort by ID in descending order
        pageLength: 10,        // Show 10 entries per page
        responsive: true       // Enable responsive features
    });
});

// User management functions
function editUser(id) {
    console.log('Edit user:', id);
    // Implement your edit logic here
}

function deleteUser(id) {
    if (confirm('Are you sure you want to delete this user?')) {
        console.log('Delete user:', id);
        // Implement your delete logic here
    }
}
</script>
<?= $this->endSection() ?>