<?php

namespace KT\RestApiCatalog\Model;

class ProductRepository extends \Magento\Catalog\Model\ProductRepository

{

    /**
     * {@inheritdoc}
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        $result = parent::getList($searchCriteria);
        $items = $result->getItems();
        foreach($items as &$item)
        {
            if($item->getColor())
            {
                $item->setSwatchImage($item->getColor());                
            }
            $item->setSpecialPrice($item);
            $item->setProductImages($item);
        }
        $result->setItems($items);
        return $result;
    }
}
