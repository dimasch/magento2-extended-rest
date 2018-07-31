<?php
/**
 * Copyright © 2016 Komplizierte Technologien. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Author: Valeriy Yeroslaev
 * Date: 12.03.18
 */
namespace KT\Syncstatic\Helper;

use Magento\Framework\App\Helper\Context;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var string
     */
    protected $_scopeStore;

    public function __construct(Context $context)
    {
        parent::__construct($context);
        $this->_scopeStore = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
    }

    public function getConfig($key)
    {
        return $this->scopeConfig->getValue('kt_syncstatic/settings/' . $key, $this->_scopeStore);
    }
}