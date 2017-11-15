<?php
/**
 * index.php
 *
 * @category  mage2-project
 * @package   mage2-project_
 * @copyright Copyright (c) 2016 Unic AG (http://www.unic.com)
 * @author    juan.alonso@unic.com
 */

namespace VendorName\ModuleName\Controller\Index;

use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;

class HelloWorld extends \Magento\Framework\App\Action\Action
{
    protected $pageFactory;
    public function __construct(Context $context, PageFactory $pageFactory)
    {
        $this->pageFactory = $pageFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        $page_object = $this->pageFactory->create();
        return $page_object;
    }
}
