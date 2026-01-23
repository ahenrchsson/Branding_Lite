<?php

declare(strict_types=1);

require_once __DIR__ . '/inc/favicon.class.php';

function plugin_branding_lite_add_header(): void
{
    $url = PluginBrandingLiteFavicon::getPublicUrl();
    $mime = PluginBrandingLiteFavicon::getMime();

    if ($url === null || $mime === null) {
        return;
    }

    $escapedUrl = htmlescape($url);
    $escapedMime = htmlescape($mime);

    echo "<link rel=\"icon\" href=\"{$escapedUrl}\" type=\"{$escapedMime}\">";
    echo "<link rel=\"shortcut icon\" href=\"{$escapedUrl}\" type=\"{$escapedMime}\">";
    echo "<link rel=\"apple-touch-icon\" href=\"{$escapedUrl}\">";
}
