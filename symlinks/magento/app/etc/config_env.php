<?php
$config = [];

if (strtoupper(getenv('CONFIG_ENV_MODE')) == 'LOCAL') {
    $configLocal = array(
        'system' =>
            array(
                'default' =>
                    array(
                        'dev' =>
                            array(
                                'js' =>
                                    array(
                                        'minify_files' => '0',
                                    ),
                                'css' =>
                                    array(
                                        'minify_files' => '0',
                                    ),
                                'static' =>
                                    array(
                                        'sign' => '0',
                                    ),
                            ),
                        # Disable Varnish
                        'system' =>
                            array(
                                'full_page_cache' =>
                                    array(
                                        'caching_application' => '1',
                                    ),
                            ),
                    ),
            ),
    );
    $config = array_replace_recursive($config, $configLocal);
}

if (in_array(strtoupper(getenv('CONFIG_ENV_MODE')), ['LOCAL', 'JENKINS'])) {
    $configLocal = array(
        'modules' =>
            array (
                'TddWizard_Fixtures' => 1,
            ),
    );
    $config = array_replace_recursive($config, $configLocal);
}

return $config;
