<?php

namespace KT\RestApiCatalog\Api\Data;

/**
 * @api
 */
interface ProductSearchResultsInterface
{
    /**
     * Get attributes list.
     *
     * @return \KT\RestApiCatalog\Api\Data\ProductInterface[]
     */
    public function getItems();

     /**
     * Set attributes list.
     *
     * @param \KT\RestApiCatalog\Api\Data\ProductInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}