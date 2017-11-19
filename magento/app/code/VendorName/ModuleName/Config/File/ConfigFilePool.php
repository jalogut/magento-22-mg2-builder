<?php
/**
 * ConfigFilePool
 *
 * @copyright Copyright © 2017 Staempfli AG. All rights reserved.
 * @author    juan.alonso@staempfli.com
 */

namespace VendorName\ModuleName\Config\File;

use Magento\Framework\Config\File\ConfigFilePool as MagentoConfigFilePool;

class ConfigFilePool extends MagentoConfigFilePool
{
    /**
     * Default files for configuration
     *
     * @var array
     */
    private $applicationConfigFiles = [
        self::APP_CONFIG => 'config.php',
        self::APP_ENV => 'env.php',
    ];

    private $configFilesOrder = [
        self::APP_CONFIG => 1,
        self::APP_ENV => 99,
    ];

    /**
     * Constructor
     *
     * @param array $additionalConfigFiles
     */
    public function __construct($additionalConfigFiles = [], array $additionalSortOrder = [])
    {
        $this->applicationConfigFiles = array_merge($this->applicationConfigFiles, $additionalConfigFiles);
        $filesOrder = array_merge($this->configFilesOrder, $additionalSortOrder);
        $this->sortConfigFiles($filesOrder);
    }

    private function sortConfigFiles(array $sortOrder)
    {
        uksort(
            $this->applicationConfigFiles,
            function ($a, $b) use ($sortOrder)
            {
                return $sortOrder[$a] <=> $sortOrder[$b];
            }
        );
    }

    /**
     * Returns application config files.
     *
     * @return array
     */
    public function getPaths()
    {
        return $this->applicationConfigFiles;
    }

    /**
     * Returns file path by config key
     *
     * @param string $fileKey
     * @return string
     * @throws \Exception
     */
    public function getPath($fileKey)
    {
        $configFiles = $this->getPaths();
        if (!isset($configFiles[$fileKey])) {
            throw new \Exception('File config key does not exist.');
        }
        return $configFiles[$fileKey];

    }
}