<div class="error-container">

    <div class="error-header">
        <h1 class="error-title">Error <?= esc($errorDetails['status_code']) ?></h1>
        <div class="error-message">
            <?= esc($errorDetails['message']) ?>
        </div>
    </div>

    <?php if ($isDevelopment): ?>
        <div class="button-group">
            <a href="/" class="button button-primary">Return Home</a>
            <button onclick="window.history.back()" class="button button-secondary">Go Back</button>
        </div>
        <div class="error-details">
            <h2>Technical Details</h2>
            <div class="meta-item">
                <span class="meta-label">Error Type:</span>
                <span><?= esc($errorDetails['error_type']) ?></span>
            </div>
            <div class="meta-item">
                <span class="meta-label">File:</span>
                <span><?= esc($errorDetails['file']) ?></span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Line:</span>
                <span><?= esc($errorDetails['line']) ?></span>
            </div>
            <?php if (isset($errorDetails['trace'])): ?>
                <h3>Stack Trace</h3>
                <pre><?= esc($errorDetails['trace']) ?></pre>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="button-group">
        <a href="/" class="button button-primary">Return Home</a>
        <button onclick="window.history.back()" class="button button-secondary">Go Back</button>
    </div>
</div>