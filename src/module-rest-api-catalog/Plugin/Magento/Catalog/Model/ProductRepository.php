<?php

namespace KT\RestApiCatalog\Plugin\Magento\Catalog\Model;

use Magento\Catalog\Api\ProductRepositoryInterface as productRepositoryInterface;

class ProductRepository {

    /**
     * @var productRepositoryInterface
     */
    protected $_productRepositoryInterface;

    /**
     * @var \Magento\Catalog\Model\Product\Gallery\ReadHandler
     */
    protected $_mediaGalleryReadHandler;

    /**
     * ProductRepository constructor.
     * @param productRepositoryInterface $productRepository
     */
    public function __construct(
        productRepositoryInterface $productRepository,
        \Magento\Catalog\Model\Product\Gallery\ReadHandler $mediaGalleryReadHandler
    )
    {
        $this->_productRepositoryInterface = $productRepository;
        $this->_mediaGalleryReadHandler = $mediaGalleryReadHandler;
    }

    /**
     * @param \Magento\Catalog\Model\ProductRepository $subject
     * @param $result
     * @return mixed
     */
    public function afterGetList(
        \Magento\Catalog\Model\ProductRepository $subject,
        $result
    ) {

        $items = $result->getItems();
        foreach($items as &$item) {
            /**
             * Get mage product collection.
             * Validate, if out is not valid - then continue...
             */
            if( !$product = $this->_getProduct($item->getSku()) ) {
                continue;
            }

            $this->_mediaGalleryReadHandler->execute($product);

            $images = [];
            if (count($product->getMediaGallery())) {
                foreach($product->getMediaGallery()['images'] as $imageCollection) {
                    $images[] = $imageCollection['file'];
                }
            }

            $item->setImage(implode(";" , $images));
        }

        return $result;
    }

    /**
     * @param $product_sku
     * @return \Magento\Catalog\Api\Data\ProductInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function _getProduct($sku) {
        return $this->_productRepositoryInterface->get($sku);
    }

}
