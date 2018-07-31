<?php
/**
 * Copyright (c) 2018. Komplizierte Technologien. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace KT\RestApiReview\Api\Data;

interface RequestInterface
{
    /**
     * Get review
     *
     * @return \KT\RestApiReview\Api\Data\ReviewInterface
     */
    public function getReview();

    /**
     * Set review
     *
     * @param \KT\RestApiReview\Api\Data\ReviewInterface $value
     * @return void
     */
    public function setReview($value);

    /**
     * Get Review votes
     *
     * @return \KT\RestApiReview\Api\Data\VoteInterface[]
     */
    public function getVotes();

    /**
     * Set Review votes
     *
     * @param \KT\RestApiReview\Api\Data\VoteInterface[] $value
     * @return void
     */
    public function setVotes($value);

    /**
     * Get Review customer ID.
     *
     * @return string
    */
    public function getCustomerId();

    /**
     * Set Review customer ID.
     *
     * @param void $value
     * @return void
     */
    public function setCustomerId($value);
}