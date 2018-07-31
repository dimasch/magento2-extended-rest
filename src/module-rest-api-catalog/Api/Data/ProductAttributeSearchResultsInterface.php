<?php
namespace KT\RestApiCatalog\Api\Data;

/**
 * @api
 */
interface ProductAttributeSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get attributes list.
     *
     * @return \KT\RestApiCatalog\Api\Data\ProductAttributeInterface[]
     */
    public function getItems();

    /**
     * Set attributes list.
     *
     * @param \KT\RestApiCatalog\Api\Data\ProductAttributeInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
