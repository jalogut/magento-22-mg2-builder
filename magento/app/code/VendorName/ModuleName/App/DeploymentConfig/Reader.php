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
    const CONFIG_ENV = 'CONFIG_ENV';

    private $dirList;
    private $driverPool;
    private $configFilePool;

    public function __construct(
        DirectoryList $dirList,
        DriverPool $driverPool,
        ConfigFilePool $configFilePool,
        $file = null
    ) {
        parent::__construct($dirList, $driverPool, $configFilePool, $file);
        $this->dirList = $dirList;
        $this->driverPool = $driverPool;
        $this->configFilePool = $configFilePool;
    }

    public function load($fileKey = null)
    {
        $this->setConfigEnvironment();
        return parent::load($fileKey);
    }

    private function setConfigEnvironment()
    {
        $path = $this->dirList->getPath(DirectoryList::CONFIG);
        $fileDriver = $this->driverPool->getDriver(DriverPool::FILE);
        $envFile = $path . '/' . $this->configFilePool->getPath(ConfigFilePool::APP_ENV);
        if ($fileDriver->isExists($envFile)) {
            $config = include $envFile;
            if (isset($config[self::CONFIG_ENV])) {
                putenv(self::CONFIG_ENV . "=" . $config[self::CONFIG_ENV]);
            }
        }
    }
}