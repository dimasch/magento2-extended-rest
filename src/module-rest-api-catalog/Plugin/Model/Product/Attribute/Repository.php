<?php


namespace KT\RestApiCatalog\Plugin\Model\Product\Attribute;

use Magento\Catalog\Api\ProductRepositoryInterface as productRepository;

class Repository
{

    /**
     * @var \KT\RestApiCatalog\Model\Product
     */
    protected $_product;

    /**
     * @var productRepository
     */
    protected $_productRepo;

    /**
     * Repository constructor.
     * @param \KT\RestApiCatalog\Model\Product $product
     */
    public function __construct(
        \KT\RestApiCatalog\Model\Product $product,
        productRepository $productRepository
    )
    {
        $this->_product = $product;
        $this->_productRepo = $productRepository;
    }

    public function afterGet(
        \Magento\Catalog\Model\Product\Attribute\Repository $subject,
        $result
    ) {
        $options = $result->getOptions();
        foreach($options as &$option)
        {

            $color = $option->getData('value');
            if($color != "")
            {
                $connector = $this->_product->getResource()->getConnection();

                $bind = ['option_id' => $color];
                $select = $connector->select()->from(
                    ['main_table' => $this->_product->getResource()->getTable('eav_attribute_option_swatch')]
                )->where(
                    'main_table.option_id = :option_id'
                );
                $tmpresult = $connector->fetchRow($select, $bind);
                $option->addData(["swatch_image"=>$tmpresult['value']]);
                $option->addData(["stocks"=>$tmpresult['value']]);
            }
        }
        $result->setOptions($options);

        return $result;
    }

    /**
     * @param \Magento\Catalog\Model\Product\Attribute\Repository $subject
     * @param $result
     * @return mixed
     */
    public function afterGetList(
        \Magento\Catalog\Model\Product\Attribute\Repository $subject,
        $result
    ) {
        $items = $result->getItems();
        foreach($items as &$item) {
            if ($item->getData('attribute_code') == 'color') {
                $options = $item->getOptions();
                foreach($options as &$option)
                {

                    $color = $option->getData('value');
                    if($color != "")
                    {
                        $connector = $this->_product->getResource()->getConnection();

                        $bind = ['option_id' => $color];
                        $select = $connector->select()->from(
                            ['main_table' => $this->_product->getResource()->getTable('eav_attribute_option_swatch')]
                        )->where(
                            'main_table.option_id = :option_id'
                        );
                        $tmpresult = $connector->fetchRow($select, $bind);
                        $option->addData(["swatch_image"=>$tmpresult['value']]);
                        $option->addData(["stocks"=>$tmpresult['value']]);
                    }
                }
                $item->setOptions($options);
            }
        }
        return $result;
    }

}