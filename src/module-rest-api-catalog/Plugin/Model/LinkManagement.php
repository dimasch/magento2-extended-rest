<?php


namespace KT\RestApiCatalog\Plugin\Model;

use Magento\Catalog\Model\Product\Gallery\ReadHandler as GalleryReadHandler;
use Magento\Catalog\Api\ProductRepositoryInterface as productRepository;

class LinkManagement
{
    /**
     * @var
     */
    protected $product;

    /**
     * @var GalleryReadHandler
     */
    protected $gallery;

    /**
     * @var productRepository
     */
    protected $_product;

    public function __construct(
        \KT\RestApiCatalog\Model\Product $product,
        GalleryReadHandler $galleryHandler,
        productRepository $productRepository
    )
    {
        $this->product = $product;
        $this->gallery = $galleryHandler;
        $this->_product = $productRepository;
    }

    public function afterGetChildren(
        \Magento\ConfigurableProduct\Model\LinkManagement $subject,
        $result
    ) {
        foreach ($result as &$res)
        {
            $product = $this->_getProduct($res->getSku());
            $images = [];
            /* Get product images from product collection */
            foreach($product->getMediaGallery()['images'] as $imageCollection) {
                $images[] = $imageCollection['file'];
            }
            $res->setData('image', implode(";" , $images));
            $tempSwatch = $this->product->setSwatchImage($res);
            $res->setCustomAttribute('swatch_image',$tempSwatch);

            $tempStocks = $this->product->setStocks($res);
            $res->setCustomAttribute('stocks',$tempStocks);

            $tempSpecialPrice = $this->product->setSpecialPrice($res);

            $res->setCustomAttribute('special_price', $tempSpecialPrice);
        }
        return $result;
    }

    private function _getProduct( $entity_id ) {
        return $this->_product->get($entity_id);
    }

}
