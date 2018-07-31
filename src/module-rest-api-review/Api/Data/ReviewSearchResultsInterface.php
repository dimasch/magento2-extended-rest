<?php
/**
 * Copyright (c) 2018. Komplizierte Technologien. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace KT\RestApiReview\Api\Data;

/**
 * @api
 */
interface ReviewSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get url rewrite list.
     *
     * @return \KT\RestApiReview\Api\Data\ReviewInterface[]
     */
    public function getItems();

    /**
     * Set url rewrite list.
     *
     * @param \KT\RestApiReview\Api\Data\ReviewInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}