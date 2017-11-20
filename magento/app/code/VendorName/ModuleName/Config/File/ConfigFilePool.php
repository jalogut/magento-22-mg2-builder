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

    private $configFiles = [];

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
        parent::__construct($additionalConfigFiles);
        $this->configFilesOrder = array_merge($this->configFilesOrder, $additionalSortOrder);
    }

    private function setConfigEnvironmentMode()
    {
        $files = $this->getPaths();

    }

    /**
     * Returns application config files.
     *
     * @return array
     */
    public function getPaths()
    {
        if (!$this->configFiles) {
            $this->configFiles = $this->sortConfigFiles(parent::getPaths(), $this->configFilesOrder);
        }
        return $this->configFiles;
    }

    private function sortConfigFiles(array $configFiles, array $sortOrder) : array
    {
        uksort(
            $configFiles,
            function ($a, $b) use ($sortOrder) {
                return $sortOrder[$a] <=> $sortOrder[$b];
            }
        );
        return $configFiles;
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