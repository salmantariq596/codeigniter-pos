<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>

<div class="container">
    <!-- Current Version Card -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">
                <i class="fas fa-code-branch me-2"></i>
                Version Management
            </h3>
        </div>
        <div class="card-body">
            <div class="alert alert-<?= $current_version ? 'success' : 'warning' ?>">
                <h4 class="alert-heading">
                    <i class="fas fa-<?= $current_version ? 'check-circle' : 'exclamation-triangle' ?> me-2"></i>
                    <?= $current_version ? "Current Version: v{$current_version}" : 'No version information available' ?>
                </h4>
            </div>

            <div id="update-status" class="mb-4"></div>

            <button class="btn btn-primary" onclick="checkUpdates()">
                <i class="fas fa-sync-alt me-2"></i> Check for Updates
            </button>
        </div>
    </div>

    <!-- Version History Card -->
    <div class="card">
        <div class="card-header bg-secondary text-white">
            <h4 class="mb-0">
                <i class="fas fa-history me-2"></i>
                Version History
            </h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Version</th>
                            <th>Release Date</th>
                            <th>Last Checked</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($versions as $version): ?>
                            <tr>
                                <td class="fw-bold text-primary">v<?= esc($version->version) ?></td>
                                <td><?= date('M j, Y', strtotime($version->created_at)) ?></td>
                                <td>
                                    <?= $version->last_checked ?
                                        date('M j, H:i', strtotime($version->last_checked)) :
                                        'Never' ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    const API_BASE = '<?= site_url('version-management') ?>';

    async function checkUpdates() {
        const statusDiv = document.getElementById('update-status');
        statusDiv.innerHTML = `
        <div class="alert alert-warning">
            <i class="fas fa-sync fa-spin me-2"></i>
            Checking for updates...
        </div>
    `;

        try {
            const response = await fetch(`${API_BASE}/check`);
            const {
                success,
                data,
                error
            } = await response.json();

            if (!success) throw new Error(error || 'Failed to check updates');

            if (data.requires_update) {
                let featuresHtml = '';
                if (data.features && data.features.length > 0) {
                    featuresHtml = `
                        <div class="mt-3">
                            <h5>New Features:</h5>
                            <ul>
                                ${data.features.map(feature => `<li>${feature}</li>`).join('')}
                            </ul>
                        </div>
                    `;
                }

                statusDiv.innerHTML = `
                <div class="alert alert-success">
                    <h4><i class="fas fa-download me-2"></i>New Version Available!</h4>
                    <p>${data.message}</p>
                    ${featuresHtml}
                    <button class="btn btn-success mt-3" onclick="performUpdate()">
                        <i class="fas fa-download me-2"></i>Update to v${data.remote_version}
                    </button>
                </div>
            `;
            } else {
                statusDiv.innerHTML = `
                <div class="alert alert-info">
                    <i class="fas fa-check-circle me-2"></i>
                    ${data.message}
                </div>
            `;
            }
        } catch (error) {
            statusDiv.innerHTML = `
            <div class="alert alert-danger">
                <i class="fas fa-times-circle me-2"></i>
                ${error.message}
            </div>
        `;
        }
    }

    async function performUpdate() {
        const statusDiv = document.getElementById('update-status');
        statusDiv.innerHTML = `
        <div class="alert alert-warning">
            <i class="fas fa-spinner fa-spin me-2"></i>
            Updating system...
        </div>
    `;

        try {
            // Get CSRF token from meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            const response = await fetch(`${API_BASE}/update`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();

            if (!result.success) {
                throw new Error(result.error || 'Update failed');
            }

            statusDiv.innerHTML = `
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>
                ${result.data.message} Reloading...
            </div>
        `;

            setTimeout(() => location.reload(), 2000);
        } catch (error) {
            statusDiv.innerHTML = `
            <div class="alert alert-danger">
                <i class="fas fa-times-circle me-2"></i>
                ${error.message}
            </div>
        `;
        }
    }
</script>
<script>

</script>


<?= $this->endSection() ?>