<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AppVersion;
use CodeIgniter\HTTP\ResponseInterface;

class VersionController extends BaseController
{
    private const CACHE_KEY = 'version_config';
    private const CACHE_TTL = 30; // 5 minutes

    private $cache;
    protected $versionModel;

    public function __construct()
    {
        parent::__construct();
        $this->cache = \Config\Services::cache();
    }


    /**
     * Display the version history and current version.
     */
    public function index()
    {
        $userId = session()->get('user')['id'];
        $user = $this->userModel->find($userId);
        // Fetch the current version
        $currentVersion = $this->versionModel->getCurrentVersion();

        // Fetch the version history
        $versionHistory = $this->versionModel->orderBy('created_at', 'DESC')->findAll();

        // Render the view with data
        return $this->render('versions/version_list', [
            'data' => 'value',
            'user' => $user,
            'current_version' => $currentVersion,
            'versions' => $versionHistory
        ]);
    }

    /**
     * Check for updates and return version information.
     */
    public function checkVersion(): ResponseInterface
    {
        try {
            $config = $this->fetchVersionConfig();

            if (!$config['success']) {
                return $this->respondError($config['message'], ResponseInterface::HTTP_SERVICE_UNAVAILABLE);
            }

            return $this->respondSuccess($config['data']);
        } catch (\Exception $e) {
            log_message('error', 'Version check failed: ' . $e->getMessage());
            return $this->respondError('Internal server error', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Perform the update process.
     */
    public function performUpdate(): ResponseInterface
    {
        try {
            // Step 1: Enable maintenance mode
            $this->enableMaintenanceMode();

            // Step 2: Create a backup
            // $backupDir = $this->createBackup();

            // Step 3: Download the update package
            $updatePackagePath = $this->downloadUpdatePackage();

            // Step 4: Validate the update package
            // $this->validateUpdatePackage($updatePackagePath);

            // Step 5: Install the update
            $this->installUpdatePackage($updatePackagePath);

            // Step 6: Update version information in the database
            $this->versionModel->insert(['version' => $this->getRemoteVersion()]);

            // Step 7: Clear cache
            $this->cache->delete(self::CACHE_KEY);

            // Step 8: Disable maintenance mode
            $this->disableMaintenanceMode();

            return $this->respondSuccess([
                'message' => 'Update successful',
                // 'backup_location' => $backupDir,
            ]);
        } catch (\Exception $e) {
            // Rollback on failure
            if (isset($backupDir)) {
                $this->rollback($backupDir);
            }
            $this->disableMaintenanceMode();

            log_message('error', 'Update failed: ' . $e->getMessage());
            return $this->respondError('Update operation failed: ' . $e->getMessage(), ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Rollback to a previous version using a backup.
     */
    public function rollback(string $backupDir): ResponseInterface
    {
        try {
            $this->enableMaintenanceMode();
            $this->processFilesRecursively($backupDir, ROOTPATH);
            $this->disableMaintenanceMode();

            return $this->respondSuccess(['message' => 'Rollback successful']);
        } catch (\Exception $e) {
            log_message('error', 'Rollback failed: ' . $e->getMessage());
            return $this->respondError('Rollback operation failed', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // ==================================================
    // PRIVATE METHODS
    // ==================================================

    /**
     * Fetch version configuration from the remote server.
     */
    private function fetchVersionConfig(): array
    {
        if ($cached = $this->cache->get(self::CACHE_KEY)) {
            return ['success' => true, 'data' => $cached];
        }

        $remoteConfig = $this->fetchAppConfigFromGitHub();

        if (!$remoteConfig) {
            return ['success' => false, 'message' => 'Failed to fetch remote configuration'];
        }

        $processed = $this->processConfig($remoteConfig);
        $this->cache->save(self::CACHE_KEY, $processed, self::CACHE_TTL);

        return ['success' => true, 'data' => $processed];
    }

    /**
     * Get the remote version from the configuration.
     */
    private function getRemoteVersion(): string
    {
        $config = $this->fetchVersionConfig();
        if (!$config['success']) {
            throw new \RuntimeException('Failed to fetch remote version');
        }
        return $config['data']['remote_version'];
    }

    /**
     * Process the remote configuration.
     */
    private function processConfig(array $config): array
    {
        $currentVersion = $this->versionModel->getCurrentVersion();
        $remoteVersion = $config['version'];

        // Log the version comparison
        log_message('debug', "Version check - Current: {$currentVersion}, Remote: {$remoteVersion}");

        // Compare versions
        $comparison = version_compare($remoteVersion, $currentVersion ?? '0.0.0');

        return [
            'current_version' => $currentVersion,
            'remote_version' => $remoteVersion,
            'status' => $this->getStatus($comparison),
            'message' => $this->getMessage($comparison, $config),
            'requires_update' => $comparison > 0, // True if remote > current
            'last_checked' => date('Y-m-d H:i:s'),
            'update_url' => $config['update_url'] ?? '', // URL to the update package
        ];
    }

    /**
     * Get the status based on version comparison.
     */
    private function getStatus(int $comparison): string
    {
        return match ($comparison) {
            1 => 'update_available',
            0 => 'current',
            -1 => 'downgrade_recommended'
        };
    }

    /**
     * Get the message based on version comparison.
     */
    private function getMessage(int $comparison, array $config): string
    {
        return match ($comparison) {
            1 => $config['update_message'] ?? 'New version available',
            0 => 'System is up to date',
            -1 => $config['downgrade_message'] ?? 'Local version is newer'
        };
    }

    /**
     * Fetch app_config.json from the remote server.
     */

    private function fetchAppConfigFromGitHub(): ?array
    {
        $configUrl = getenv('app.config_file_path');

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $configUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_TIMEOUT => 15,
        ]);

        $response = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($statusCode === 200) {
            $configData = json_decode($response, true);

            if (isset($configData['update_url'])) {
                $this->updateEnvVariable('app.update_package_url', $configData['update_url']);
            }

            return $configData;
        }

        log_message('error', "Failed to fetch app_config.json: HTTP {$statusCode}");
        return null;
    }



    private function updateEnvVariable(string $key, string $value): void
    {
        $envPath = ROOTPATH . '.env';

        if (!file_exists($envPath)) {
            log_message('error', ".env file not found at {$envPath}");
            return;
        }

        $envContent = file_get_contents($envPath);

        if (preg_match("/^{$key}=.*/m", $envContent)) {
            // Update existing key
            $envContent = preg_replace("/^{$key}=.*/m", "{$key}=\"{$value}\"", $envContent);
        } else {
            // Add new key at the end
            $envContent .= PHP_EOL . "{$key}=\"{$value}\"";
        }

        file_put_contents($envPath, $envContent);
    }


    /**
     * Download the update package from the remote server.
     */
    private function downloadUpdatePackage(): string
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'update_');

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => getenv('app.update_package_url'),
            CURLOPT_FILE => fopen($tempFile, 'w+'),
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_TIMEOUT => 50,
        ]);

        curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            unlink($tempFile);
            throw new \RuntimeException("Failed to download update package: {$error}");
        }

        return $tempFile;
    }

    /**
     * Validate the update package.
     */
    private function validateUpdatePackage(string $packagePath): void
    {
        $expectedHash = getenv('UPDATE_PACKAGE_HASH');
        $actualHash = hash_file('sha256', $packagePath);

        if (!hash_equals($expectedHash, $actualHash)) {
            throw new \RuntimeException("Package integrity check failed");
        }
    }

    /**
     * Install the update package.
     */
    private function installUpdatePackage(string $packagePath): void
    {
        $zip = new \ZipArchive;
        if ($zip->open($packagePath) !== true) {
            throw new \RuntimeException("Failed to open update package");
        }

        $tempDir = sys_get_temp_dir() . '/update_' . uniqid();
        mkdir($tempDir, 0755, true);

        if (!$zip->extractTo($tempDir)) {
            $zip->close();
            $this->removeDirectory($tempDir);
            throw new \RuntimeException("Failed to extract update package");
        }
        $zip->close();

        $this->processFilesRecursively($tempDir, ROOTPATH);
        $this->removeDirectory($tempDir);
        unlink($packagePath);
    }

    /**
     * Process files recursively for replacement.
     */
    private function processFilesRecursively(string $source, string $destination): void
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {
            $relativePath = substr($item->getPathname(), strlen($source) + 1);
            $targetPath = $destination . DIRECTORY_SEPARATOR . $relativePath;

            if ($item->isDir()) {
                $this->createDirectory($targetPath);
            } else {
                $this->processFile($item->getPathname(), $targetPath);
            }
        }
    }

    /**
     * Process individual files.
     */
    private function processFile(string $sourceFile, string $targetFile): void
    {
        $targetDir = dirname($targetFile);
        $this->createDirectory($targetDir);

        if ($this->filesIdentical($sourceFile, $targetFile)) {
            return;
        }

        $tempTarget = $targetFile . '.tmp';
        copy($sourceFile, $tempTarget);
        chmod($tempTarget, file_exists($targetFile) ? fileperms($targetFile) : 0644);
        rename($tempTarget, $targetFile);
    }

    /**
     * Check if two files are identical.
     */
    private function filesIdentical(string $fileA, string $fileB): bool
    {
        if (!file_exists($fileB)) return false;
        if (filesize($fileA) !== filesize($fileB)) return false;
        return hash_file('sha256', $fileA) === hash_file('sha256', $fileB);
    }

    /**
     * Create a directory if it doesn't exist.
     */
    private function createDirectory(string $path): void
    {
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
    }

    /**
     * Remove a directory and its contents.
     */
    private function removeDirectory(string $dir): void
    {
        if (!file_exists($dir)) return;

        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($files as $file) {
            if ($file->isDir()) {
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        rmdir($dir);
    }

    /**
     * Enable maintenance mode.
     */
    private function enableMaintenanceMode(): void
    {
        file_put_contents(ROOTPATH . 'maintenance.lock', time());
    }

    /**
     * Disable maintenance mode.
     */
    private function disableMaintenanceMode(): void
    {
        if (file_exists(ROOTPATH . 'maintenance.lock')) {
            unlink(ROOTPATH . 'maintenance.lock');
        }
    }

    /**
     * Create a backup of the current system.
     */
    private function createBackup(): string
    {
        $backupDir = WRITEPATH . 'backups/' . date('Y-m-d_His');
        mkdir($backupDir, 0755, true);

        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(ROOTPATH, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($files as $file) {
            $target = $backupDir . substr($file->getPathname(), strlen(ROOTPATH));
            if ($file->isDir()) {
                mkdir($target, 0755);
            } else {
                copy($file->getPathname(), $target);
            }
        }

        return $backupDir;
    }

    /**
     * Respond with success.
     */
    private function respondSuccess($data, int $code = 200): ResponseInterface
    {
        return $this->response
            ->setStatusCode($code)
            ->setContentType('application/json')
            ->setJSON([
                'success' => true,
                'data' => $data
            ]);
    }

    /**
     * Respond with error.
     */
    private function respondError(string $message, int $code): ResponseInterface
    {
        return $this->response
            ->setStatusCode($code)
            ->setContentType('application/json')
            ->setJSON([
                'success' => false,
                'error' => $message
            ]);
    }
}
