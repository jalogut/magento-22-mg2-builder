<?php
/**
 * IgnoreComments
 *
 * @copyright Copyright © 2017 Staempfli AG. All rights reserved.
 * @author    juan.alonso@staempfli.com
 */

namespace VendorName\ModuleName2\Model\Config\Export;

use Magento\Framework\App\Config\CommentInterface;

class IgnoreComments implements CommentInterface
{
    public function get()
    {
        return "";
    }
}