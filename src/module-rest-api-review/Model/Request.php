<?php
/**
 * Copyright (c) 2018. Komplizierte Technologien. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace KT\RestApiReview\Model;

class Request implements \KT\RestApiReview\Api\Data\RequestInterface
{
    protected $review;
    protected $votes;
    protected $customerId;

    /**
     * @inheritdoc
     */
    public function getReview()
    {
        return $this->review;
    }

    /**
     * @inheritdoc
     */
    public function setReview($value)
    {
        $this->review = $value;
    }

    /**
     * @inheritdoc
     */
    public function getVotes()
    {
        return $this->votes;
    }

    /**
     * @inheritdoc
     */
    public function setVotes($value)
    {
        $this->votes = $value;
    }

    /**
     * @inheritdoc
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * @inheritdoc
     */
    public function setCustomerId($value)
    {
        $this->customerId = $value;
    }
}
