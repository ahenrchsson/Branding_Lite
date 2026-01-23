<?php

declare(strict_types=1);

class PluginBrandingLiteFavicon
{
    public const CONFIG_CONTEXT = 'plugin:branding_lite';
    public const UPLOAD_DIR = GLPI_VAR_DIR . '/files/_uploads/branding_lite';
    public const MAX_UPLOAD_BYTES = 2097152; // 2 MB

    public static function getConfig(): array
    {
        return Config::getConfigurationValues(self::CONFIG_CONTEXT);
    }

    public static function getFilename(): ?string
    {
        $config = self::getConfig();
        return $config['favicon_filename'] ?? null;
    }

    public static function getMime(): ?string
    {
        $config = self::getConfig();
        return $config['favicon_mime'] ?? null;
    }

    public static function getVersion(): ?int
    {
        $config = self::getConfig();
        $version = $config['favicon_version'] ?? null;
        if ($version === null || $version === '') {
            return null;
        }
        return (int) $version;
    }

    public static function getStoredPath(): ?string
    {
        $filename = self::getFilename();
        if (!$filename) {
            return null;
        }
        return self::UPLOAD_DIR . '/' . $filename;
    }

    public static function getPublicUrl(): ?string
    {
        $version = self::getVersion();
        if ($version === null) {
            return null;
        }
        return '/plugins/branding_lite/favicon.php?v=' . $version;
    }

    public static function saveUploadedFile(array $file): array
    {
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            return ['ok' => false, 'message' => __('No file uploaded')];
        }

        if (($file['size'] ?? 0) > self::MAX_UPLOAD_BYTES) {
            return ['ok' => false, 'message' => __('File too large')];
        }

        $mime = self::detectMime($file['tmp_name']);
        if ($mime === null || strpos($mime, 'image/') !== 0) {
            return ['ok' => false, 'message' => __('Invalid image type')];
        }

        $extension = self::mimeToExtension($mime, $file['name'] ?? '');
        $filename = 'favicon.' . $extension;

        if (!self::ensureUploadDir()) {
            return ['ok' => false, 'message' => __('Unable to create upload directory')];
        }

        $destination = self::UPLOAD_DIR . '/' . $filename;
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            return ['ok' => false, 'message' => __('Unable to save uploaded file')];
        }

        Config::setConfigurationValues(self::CONFIG_CONTEXT, [
            'favicon_filename' => $filename,
            'favicon_mime' => $mime,
            'favicon_version' => (string) time(),
        ]);

        return ['ok' => true, 'message' => __('Favicon updated')];
    }

    private static function detectMime(string $path): ?string
    {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($path);
        if (!is_string($mime) || $mime === '') {
            return null;
        }
        return $mime;
    }

    private static function mimeToExtension(string $mime, string $originalName): string
    {
        $map = [
            'image/png' => 'png',
            'image/jpeg' => 'jpg',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
            'image/svg+xml' => 'svg',
            'image/x-icon' => 'ico',
            'image/vnd.microsoft.icon' => 'ico',
            'image/avif' => 'avif',
        ];

        if (isset($map[$mime])) {
            return $map[$mime];
        }

        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $extension = preg_replace('/[^a-z0-9]+/', '', $extension);
        if ($extension === '') {
            return 'img';
        }

        return $extension;
    }

    private static function ensureUploadDir(): bool
    {
        if (is_dir(self::UPLOAD_DIR)) {
            return true;
        }

        return mkdir(self::UPLOAD_DIR, 0750, true);
    }
}
