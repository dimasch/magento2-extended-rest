<?php

namespace KT\RestApiCatalog\Model;

use KT\RestApiCatalog\Api\Data\ProductInterface as ProductInterface;

class Product extends \Magento\Catalog\Model\Product
{
     /**
     * @return string
     */
    public function getSwatchImage()
    {
        return $this->getData('swatch_image');
    }

    /**
     * @param int $data
     * @return $this
     */
    public function setSwatchImage($data)
    {
        $data = (is_numeric($data) || is_string($data))? $this : $data;
        $connector = $this->_getResource()->getConnection();
        $color = $data->getCustomAttribute('color');
        if($color !== null)
        {
            $bind = ['option_id' => $color->getValue()];
            $select = $connector->select()->from(
                ['main_table' => $this->_getResource()->getTable('eav_attribute_option_swatch')]
            )->where(
                'main_table.option_id = :option_id'
            );
            $result = $connector->fetchRow($select, $bind);
            $this->setCustomAttribute("swatch_image",$result['value']);
            return $result['value'];
        }
    }

    public function setStocks($data)
    {
        $connector = $this->_getResource()->getConnection();
        $bind = ['sku' => $data->getSku()];

        $select = $connector->select()
        ->from(['cpe' => $data->_getResource()->getTable('catalog_product_entity')])
        ->join(
            ['csi' => $data->_getResource()->getTable('cataloginventory_stock_item')],
            'cpe.entity_id = csi.product_id'
        )
        ->join(
            ['cs' => $data->_getResource()->getTable('cataloginventory_stock')],
            'csi.stock_id = cs.stock_id'
        )
        ->where(
                'cpe.sku = :sku'
        );
        $returnArr = [];
        $result = $connector->fetchAll($select, $bind);
        foreach ($result as $key => $res)
        {
            $returnArr[] = implode(",", array($res['stock_id'], $res['stock_name'], $res['qty']));
        }
        return implode("|", $returnArr);
    }

    public function getStocks()
    {
        return $this->getData('stocks');
    }    

    public function getSpecialPrice()
    {
        $this->getData('special_price');
    }

    public function setSpecialPrice($data)
    {
        if(is_numeric($data)){
            $this->addData(['special_price' => $data]);
            return $data;
        }
        else{
            $connector = $this->_getResource()->getConnection();
            $relation = ($data->getPrice() == '0')? 'cpr.parent_id = cpe.entity_id' : 'cpr.child_id = cpe.entity_id';
            $select = $connector->select()
                ->from(['cpr' => $this->_getResource()->getTable('catalog_product_relation')])
                ->join(
                    ['cpe' => $this->_getResource()->getTable('catalog_product_entity')],
                    $relation
                )
                ->join(
                    ['cped' => $this->_getResource()->getTable('catalog_product_entity_decimal')],
                    'cpr.child_id = cped.entity_id'
                )
                ->join(
                    ['ea' => $this->_getResource()->getTable('eav_attribute')],
                    'cped.attribute_id = ea.attribute_id'
                )
                ->where(
                    'cpe.sku = :sku'
                )

                ->where(
                    'ea.attribute_code = :attribute_code'
                );

            $bind = [
                'sku' => ($this->getSku() == null)? $data->getSku() : $this->getSku(),
                'attribute_code' => 'special_price'
            ];
            $result = $connector->fetchRow($select, $bind);
            $specialEntityId = ($data->getPrice() != '0')? $result['parent_id'] : $result['child_id'];
            $selectSpecial = $connector->select()
                ->from(['cped' => $this->_getResource()->getTable('catalog_product_entity_datetime')])
                ->join(
                    ['ea' => $this->_getResource()->getTable('eav_attribute')],
                    'cped.attribute_id = ea.attribute_id'
                )
                ->where(
                    'ea.attribute_code = :attribute_code'
                )
                ->where(
                    'cped.entity_id = :entity_id'
                );
            $resultSpecialFrom = $connector->fetchRow(
                $selectSpecial,
                [
                    'attribute_code' => 'special_from_date',
                    'entity_id' => $specialEntityId
                ]
            );
            $resultSpecialTo = $connector->fetchRow(
                $selectSpecial,
                [
                    'attribute_code' => 'special_to_date',
                    'entity_id' => $specialEntityId
                ]
            );
            if(
                (date("Y-m-d H:i:s") > $resultSpecialFrom['value'] || $resultSpecialFrom['value'] == null)
                && (date("Y-m-d H:i:s") < $resultSpecialTo['value'] || $resultSpecialTo['value'] == null)
            ){
                $specialPrice = ($result != null) ? $result['value'] : null;
                $this->addData(['special_price' => $specialPrice]);
                return $specialPrice;
            }
        }
    }
}
