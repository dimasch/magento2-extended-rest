<?php


namespace KT\RestApiCatalog\Api\Data;

/**
 * Interface CategoryTreeInterface
 * @package KT\RestApiCatalog\Api\Data
 */
interface CategoryTreeInterface
{
    /**
     * @return int|null
     */
    public function getId();

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get parent category ID
     *
     * @return int
     */
    public function getParentId();

    /**
     * Set parent category ID
     *
     * @param int $parentId
     * @return $this
     */
    public function setParentId($parentId);

    /**
     * Get category name
     *
     * @return string
     */
    public function getName();

    /**
     * Set category name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * Check whether category is active
     *
     * @return bool
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function getIsActive();

    /**
     * Set whether category is active
     *
     * @param bool $isActive
     * @return $this
     */
    public function setIsActive($isActive);

    /**
     * Get category position
     *
     * @return int
     */
    public function getPosition();

    /**
     * Set category position
     *
     * @param int $position
     * @return $this
     */
    public function setPosition($position);

    /**
     * Get category level
     *
     * @return int
     */
    public function getLevel();

    /**
     * Set category level
     *
     * @param int $level
     * @return $this
     */
    public function setLevel($level);

    /**
     * Get product count
     *
     * @return int
     */
    public function getProductCount();

    /**
     * Set product count
     *
     * @param int $productCount
     * @return $this
     */
    public function setProductCount($productCount);


    /**
     * @param \KT\RestApiCatalog\Api\Data\CategoryTreeInterface[] $childrenData
     * @return $this
     */
    public function setChildrenData(array $childrenData = null);

     /**
     * @return string
     */
    public function getSvgImage();

    /**
     * @param $image
     * @return string
     */
    public function setSvgImage($image);

    /**
     * @return string
     */
    public function getIncludeInMenu();

    /**
     * @param $data
     * @return string
     */
    public function setIncludeInMenu($data);

    /**
     * @param int $entityId
     * @return mixed[]
     */
    public function setSeoUrlKey($entityId);

    /**
     * @return mixed[]
     */
    public function getSeoUrlKey();

    /**
     * @param int $entityId
     * @return mixed[]
     */
    public function setUrlKey($entityId);

    /**
     * @return mixed[]
     */
    public function getUrlKey();

    /**
     * @return \KT\RestApiCatalog\Api\Data\CategoryTreeInterface[]
     */
    public function getChildrenData();




}
