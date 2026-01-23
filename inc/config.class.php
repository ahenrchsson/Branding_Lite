<?php

declare(strict_types=1);

require_once __DIR__ . '/favicon.class.php';

class PluginBrandingLiteConfig extends CommonDBTM
{
    public static function canUpdate(): bool
    {
        return Session::haveRight('config', UPDATE);
    }

    public static function showForm(): void
    {
        Session::checkRight('config', UPDATE);

        $action = Plugin::getWebDir('branding_lite') . '/front/config.form.php';
        echo "<form method='post' action='" . htmlescape($action) . "' enctype='multipart/form-data'>";
        echo "<div class='center'>";
        echo "<table class='tab_cadre_fixe'>";
        echo "<tr><th colspan='2'>" . __('Branding Lite - Favicon') . "</th></tr>";
        echo "<tr class='tab_bg_1'>";
        echo "<td>" . __('Upload favicon') . "</td>";
        echo "<td><input type='file' name='favicon_file' accept='image/*'></td>";
        echo "</tr>";
        echo "<tr class='tab_bg_1'>";
        echo "<td colspan='2' class='center'>";
        echo "<input type='submit' name='update' class='submit' value='" . __('Save') . "'>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
        echo "</div>";
        echo Html::hidden('_glpi_csrf_token', ['value' => Session::getNewCSRFToken()]);
        Html::closeForm();
    }

    public function post_updateItem(): void
    {
    }
}
