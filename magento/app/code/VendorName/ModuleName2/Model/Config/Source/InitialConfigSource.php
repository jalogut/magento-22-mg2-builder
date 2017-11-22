<?php
/**
 * InitialConfigSource
 *
 * @copyright Copyright © 2017 Staempfli AG. All rights reserved.
 * @author    juan.alonso@staempfli.com
 */

namespace VendorName\ModuleName2\Model\Config\Source;

use Magento\Framework\App\Config\ConfigSourceInterface;
use Magento\Framework\Config\File\ConfigFilePool;
use Magento\Framework\App\DeploymentConfig\Reader;
use Magento\Framework\DataObject;

class InitialConfigSource implements ConfigSourceInterface
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * @var string
     */
    private $configType;

    /**
     * @var string
     * @deprecated 100.2.0 Initial configs can not be separated since 2.2.0 version
     */
    private $fileKey;

    /**
     * DataProvider constructor.
     *
     * @param Reader $reader
     * @param string $configType
     * @param string $fileKey
     */
    public function __construct(Reader $reader, $configType, $fileKey = null)
    {
        $this->reader = $reader;
        $this->configType = $configType;
        $this->fileKey = $fileKey;
    }

    /**
     * @inheritdoc
     */
    public function get($path = '')
    {
        $data = new DataObject($this->reader->load(ConfigFilePool::APP_CONFIG));
        if ($path !== '' && $path !== null) {
            $path = '/' . $path;
        }
        return $data->getData($this->configType . $path) ?: [];
    }
}
