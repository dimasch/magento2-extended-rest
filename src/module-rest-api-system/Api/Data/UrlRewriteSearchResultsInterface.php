<?php
/**
 * Copyright (c) 2018. Komplizierte Technologien. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace KT\RestApiSystem\Api\Data;

/**
 * @api
 */
interface UrlRewriteSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get url rewrite list.
     *
     * @return \KT\RestApiSystem\Api\Data\UrlRewriteInterface[]
     */
    public function getItems();

    /**
     * Set url rewrite list.
     *
     * @param \KT\RestApiSystem\Api\Data\UrlRewriteInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}