<?php


namespace KT\RestApiCatalog\Api;

/**
 * @api
 */
interface ProductRepositoryInterface
{

    /**
     * Create product
     *
     * @param \KT\RestApiCatalog\Api\Data\ProductInterface $product
     * @param bool $saveOptions
     * @return \KT\RestApiCatalog\Api\Data\ProductInterface
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\KT\RestApiCatalog\Api\Data\ProductInterface $product, $saveOptions = false);

    /**
     * Get info about product by product SKU
     *
     * @param string $sku
     * @param bool $editMode
     * @param int|null $storeId
     * @param bool $forceReload
     * @return \KT\RestApiCatalog\Api\Data\ProductInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get($sku, $editMode = false, $storeId = null, $forceReload = false);

    /**
     * Get info about product by product id
     *
     * @param int $productId
     * @param bool $editMode
     * @param int|null $storeId
     * @param bool $forceReload
     * @return \KT\RestApiCatalog\Api\Data\ProductInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($productId, $editMode = false, $storeId = null, $forceReload = false);

    /**
     * Delete product
     *
     * @param \KT\RestApiCatalog\Api\Data\ProductInterface $product
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\StateException
     */
    public function delete(\KT\RestApiCatalog\Api\Data\ProductInterface $product);

    /**
     * @param string $sku
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function deleteById($sku);


    /**
     * Get product list
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \KT\RestApiCatalog\Api\Data\ProductSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}