<?php
$config = [];

if (strtoupper(getenv('ENV')) == 'LOCAL') {
    $configLocal = [
        'system' =>
            array(
                'default' =>
                    array(
                        'dev' =>
                            array(
                                'js' =>
                                    array(
                                        'merge_files' => '0',
                                    ),
                            ),
                    ),
            ),
    ];
    $config = array_replace_recursive($config, $configLocal);
}

return $config;
