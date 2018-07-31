<?php
/**
 * Copyright (c) 2018. Komplizierte Technologien. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace KT\RestApiSystem\Model;

/**
 * Class CoreConfigManagement
 * @package KT\RestApiSystem\Model
 */
class CoreConfigManagement implements \KT\RestApiSystem\Api\CoreConfigManagementInterface
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var \Magento\Config\Model\ResourceModel\Config\Data\CollectionFactory
     */
    protected $_scopeCollectionFactory;

    /**
     * CoreConfigManagement constructor.
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Config\Model\ResourceModel\Config\Data\CollectionFactory $scopeCollectionFactory
    )
    {
        $this->_scopeConfig = $scopeConfig;
        $this->_scopeCollectionFactory = $scopeCollectionFactory;
    }

    /**
     * @inheritdoc
     */
    public function getList()
    {
        $collection = $this->_scopeCollectionFactory->create();
        $items = $collection->getItems();

        $configs = [];
        foreach ($items as $item) {
            $configs[] = [
                'config_id' => $item->getId(),
                'scope' => $item->getScope(),
                'scope_id' => $item->getScopeId(),
                'path' => $item->getPath(),
                'value' => $item->getValue(),
            ];
        }
        return $configs;
    }

    /**
     * @inheritdoc
     */
    public function getTree()
    {
        $configs = $this->_scopeConfig->getValue();
        $this->arrayUTF8Encode($configs);
        return $configs;
    }

    /**
     * @inheritdoc
     */
    public function getByKey($key)
    {
        $configs = $this->_scopeConfig->getValue($key);
        $this->arrayUTF8Encode($configs);
        return $configs;
    }


    protected function arrayUTF8Encode(&$array) {
        array_walk_recursive($array, function(&$item, $key){
            if(!mb_detect_encoding($item, 'utf-8', true)){
                $item = utf8_encode($item);
            }
        });
    }
}