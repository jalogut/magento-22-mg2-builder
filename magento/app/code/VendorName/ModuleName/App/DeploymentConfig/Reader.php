<?php
/**
 * Reader
 *
 * @copyright Copyright © 2017 Staempfli AG. All rights reserved.
 * @author    juan.alonso@staempfli.com
 */

namespace VendorName\ModuleName\App\DeploymentConfig;

use Magento\Framework\App\DeploymentConfig\Reader as MagentoReader;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Config\File\ConfigFilePool;
use Magento\Framework\Filesystem\DriverPool;

class Reader extends MagentoReader
{
    const CONFIG_ENV_MODE = 'CONFIG_ENV_MODE';
    /**
     * @var string
     */
    private $configEnvMode;

    /**
     * @var DirectoryList
     */
    private $dirList;

    /**
     * @var ConfigFilePool
     */
    private $configFilePool;

    /**
     * @var DriverPool
     */
    private $driverPool;

    /**
     * Constructor
     *
     * @param DirectoryList $dirList
     * @param DriverPool $driverPool
     * @param ConfigFilePool $configFilePool
     * @param null|string $file
     * @throws \InvalidArgumentException
     */
    public function __construct(
        DirectoryList $dirList,
        DriverPool $driverPool,
        ConfigFilePool $configFilePool,
        $file = null
    ) {
        $this->dirList = $dirList;
        $this->configFilePool = $configFilePool;
        $this->driverPool = $driverPool;
        parent::__construct($dirList, $driverPool, $configFilePool, $file);
    }

    public function load($fileKey = null)
    {
        $configEnvMode = $this->getConfigEnvMode();
        if ($configEnvMode) {
            putenv(self::CONFIG_ENV_MODE . "=" . $configEnvMode);
        }
        return parent::load($fileKey);
    }

    /**
     * Get CONFIG_ENV_MODE from env.php file configuration
     *
     * @return string
     */
    private function getConfigEnvMode() : string
    {
        if (!isset($this->configEnvMode)) {
            $configPath = $this->dirList->getPath(DirectoryList::CONFIG);
            $fileDriver = $this->driverPool->getDriver(DriverPool::FILE);
            $envFile = $configPath . '/' . $this->configFilePool->getPath(ConfigFilePool::APP_ENV);
            if ($fileDriver->isExists($envFile)) {
                $config = include $envFile;
                $this->configEnvMode = $config[self::CONFIG_ENV_MODE] ?? "";
            } else {
                $this->configEnvMode = "";
            }
        }
        return $this->configEnvMode;
    }
}