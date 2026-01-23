<?php

declare(strict_types=1);

include ('../../../inc/includes.php');
require_once __DIR__ . '/../inc/favicon.class.php';

Session::setPublicAccess();

$path = PluginBrandingLiteFavicon::getStoredPath();
$mime = PluginBrandingLiteFavicon::getMime();

if ($path === null || $mime === null || !is_file($path)) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    return;
}

header('Content-Type: ' . $mime);
header('Cache-Control: public, max-age=86400');
header('X-Content-Type-Options: nosniff');

readfile($path);
