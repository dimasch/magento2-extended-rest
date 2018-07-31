<?php
/**
 *
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace KT\RestApiCatalog\Api\Data;

/**
 * Created from:
 * @codeCoverageIgnore
 * @api
 */
interface AttributeOptionInterface
{
       /**
     * Get option label
     *
     * @return string
     */
    public function getLabel();

    /**
     * Set option label
     *
     * @param string $label
     * @return $this
     */
    public function setLabel($label);

    /**
     * Get option value
     *
     * @return string
     */
    public function getValue();

    /**
     * Set option value
     *
     * @param string $value
     * @return string
     */
    public function setValue($value);

    /**
     * Get option order
     *
     * @return int|null
     */
    public function getSortOrder();

    /**
     * Set option order
     *
     * @param int $sortOrder
     * @return $this
     */
    public function setSortOrder($sortOrder);

    /**
     * is default
     *
     * @return bool|null
     */
    public function getIsDefault();

    /**
     * set is default
     *
     * @param bool $isDefault
     * @return $this
     */
    public function setIsDefault($isDefault);

    /**
     * Get option label for store scopes
     *
     * @return \Magento\Eav\Api\Data\AttributeOptionLabelInterface[]|null
     */
    public function getStoreLabels();

    /**
     * Set option label for store scopes
     *
     * @param \Magento\Eav\Api\Data\AttributeOptionLabelInterface[] $storeLabels
     * @return $this
     */
    public function setStoreLabels(array $storeLabels = null);

    /**
     * @return mixed
     */
    public function getSwatchImage();

    /**
     * @param string $image
     * @return mixed
     */
    public function setSwatchImage($image);
}
