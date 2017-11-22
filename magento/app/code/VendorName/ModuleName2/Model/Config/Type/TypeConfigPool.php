<?php
/**
 * TypeConfigPool
 *
 * @copyright Copyright © 2017 Staempfli AG. All rights reserved.
 * @author    juan.alonso@staempfli.com
 */

namespace VendorName\ModuleName2\Model\Config\Type;

class TypeConfigPool
{
    const TYPE_INCLUDE_IN_CONFIG_PHP = 'includeInConfigPhp';

    private $includeInConfigPhp = [];

    public function __construct(array $includeInConfigPhp = [])
    {
        $this->includeInConfigPhp = $includeInConfigPhp;
    }

    public function isPresent($path, $type): bool
    {
        if (!isset($this->filteredPaths[$type])) {
            $this->filteredPaths[$type] = $this->getPathsByType($type);
        }
        return in_array($path, $this->filteredPaths[$type]);
    }

    private function getPathsByType($type): array
    {
        if ($type != self::TYPE_INCLUDE_IN_CONFIG_PHP) {
            return [];
        }
        return array_keys(array_filter(
            $this->includeInConfigPhp,
            function ($value) {
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            }
        ));
    }

}