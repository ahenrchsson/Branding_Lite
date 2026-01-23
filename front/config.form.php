<?php

declare(strict_types=1);

include ('../../../inc/includes.php');
require_once __DIR__ . '/../inc/config.class.php';

Session::checkRight('config', UPDATE);

if (isset($_POST['update'])) {
    Session::checkValidToken();
    $result = PluginBrandingLiteFavicon::saveUploadedFile($_FILES['favicon_file'] ?? []);
    if ($result['ok']) {
        Session::addMessageAfterRedirect($result['message'], false, INFO);
    } else {
        Session::addMessageAfterRedirect($result['message'], false, ERROR);
    }
    Html::redirect($_SERVER['PHP_SELF']);
}

Html::header(__('Branding Lite - Favicon'), $_SERVER['PHP_SELF'], 'config', 'plugins');

PluginBrandingLiteConfig::showForm();

Html::footer();
