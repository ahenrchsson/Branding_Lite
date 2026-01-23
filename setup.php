<?php

declare(strict_types=1);

function plugin_init_branding_lite(): void
{
    global $PLUGIN_HOOKS;

    $PLUGIN_HOOKS['csrf_compliant']['branding_lite'] = true;
    $PLUGIN_HOOKS['config_page']['branding_lite'] = 'front/config.form.php';
    $PLUGIN_HOOKS['add_header']['branding_lite'] = 'plugin_branding_lite_add_header';

    Plugin::registerClass('PluginBrandingLiteConfig');
}

function plugin_version_branding_lite(): array
{
    return [
        'name' => 'Branding Lite',
        'version' => '1.0.0',
        'author' => 'Branding Lite',
        'license' => 'GPLv3+',
        'homepage' => 'https://glpi-project.org',
        'requirements' => [
            'glpi' => [
                'min' => '11.0.0',
            ],
        ],
    ];
}

function plugin_branding_lite_check_prerequisites(): bool
{
    return true;
}

function plugin_branding_lite_check_config(): bool
{
    return true;
}
