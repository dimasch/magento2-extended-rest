<?php
/**
 *
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace KT\RestApiCatalog\Api\Data;

/**
 * @api
 */
interface ProductAttributeInterface extends \Magento\Catalog\Api\Data\EavAttributeInterface
{
    const ENTITY_TYPE_CODE = 'catalog_product';
    const CODE_TIER_PRICE_FIELD_PRICE = 'price';
    const CODE_HAS_WEIGHT = 'product_has_weight';
    const CODE_SPECIAL_PRICE = 'special_price';
    const CODE_PRICE = 'price';
    const CODE_TIER_PRICE_FIELD_PRICE_QTY = 'price_qty';
    const CODE_SHORT_DESCRIPTION = 'short_description';
    const CODE_SEO_FIELD_META_TITLE = 'meta_title';
    const CODE_STATUS = 'status';
    const CODE_NAME = 'name';
    const CODE_SKU = 'sku';
    const CODE_SEO_FIELD_META_KEYWORD = 'meta_keyword';
    const CODE_DESCRIPTION = 'description';
    const CODE_COST = 'cost';
    const CODE_SEO_FIELD_URL_KEY = 'url_key';
    const CODE_TIER_PRICE = 'tier_price';
    const CODE_SEO_FIELD_META_DESCRIPTION = 'meta_description';
    const CODE_WEIGHT = 'weight';

    /**
     * @return mixed
     */
    public function getSwatchImage();

    /**
     * @param string $image
     * @return mixed
     */
    public function setSwatchImage($image);

    /**
     * Return options of the attribute (key => value pairs for select)
     *
     * @return \KT\RestApiCatalog\Api\Data\AttributeOptionInterface[]|null
     */
    public function getOptions();

    /**
     * Set options of the attribute (key => value pairs for select)
     *
     * @param \KT\RestApiCatalog\Api\Data\AttributeOptionInterface[] $options
     * @return $this
     */
    public function setOptions(array $options = null);

    /**
     * @return mixed
     */
    public function getProductImages();

    /**
     * @param $data
     * @return mixed
     */
    public function setProductImages($data);
}