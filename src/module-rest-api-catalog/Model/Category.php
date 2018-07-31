<?php

namespace KT\RestApiCatalog\Model;

use KT\RestApiCatalog\Api\Data\CategoryTreeInterface as CategoryTreeInterface ;


class Category extends \Magento\Catalog\Model\Category implements CategoryTreeInterface
{
    public function getSvgImage()
    {
        return $this->getData('svg_image');
    }

    public function setSvgImage($image)
    {
        return $this->setData('svg_image', $image);
    }

    public function getIncludeInMenu()
    {
        return $this->getData('include_in_menu');
    }

    public function setIncludeInMenu($data)
    {
        return $this->setData('include_in_menu', $data);
    }

    /**
     * @return \KT\RestApiCatalog\Api\Data\CategoryTreeInterface[]|null
     */
    public function getChildrenData()
    {
        return $this->getData(self::KEY_CHILDREN_DATA);
    }

    public function setSeoUrlKey($entityId)
    {
        $connector = $this->getResource()->getConnection();
        $bind = ['attribute_code' => 'url_key', 'entity_id' => $entityId];

        $select = $connector->select()
            ->from(['ea' => $this->_getResource()->getTable('eav_attribute')])
            ->join(
                ['ccev' => $this->_getResource()->getTable('catalog_category_entity_varchar')],
                'ea.attribute_id = ccev.attribute_id'
            )
            ->where(
                'ea.attribute_code = :attribute_code'
            )
            ->where(
                'ccev.entity_id = :entity_id'
            );
        $result = $connector->fetchRow($select, $bind);
        return $this->setData('seoUrlKey',$result['value']);
    }

    public function getSeoUrlKey()
    {
        return $this->getData('seoUrlKey');
    }

    public function setUrlKey($entityId)
    {
        $connector = $this->getResource()->getConnection();
        $bind = ['attribute_code' => 'url_key', 'entity_id' => $entityId];

        $select = $connector->select()
            ->from(['ea' => $this->_getResource()->getTable('eav_attribute')])
            ->join(
                ['ccev' => $this->_getResource()->getTable('catalog_category_entity_varchar')],
                'ea.attribute_id = ccev.attribute_id'
            )
            ->where(
                'ea.attribute_code = :attribute_code'
            )
            ->where(
                'ccev.entity_id = :entity_id'
            );
        $result = $connector->fetchRow($select, $bind);
        return $this->setData('urlKey', $result['value']);
    }

    public function getUrlKey()
    {
        return $this->getData('urlKey');
    }

}