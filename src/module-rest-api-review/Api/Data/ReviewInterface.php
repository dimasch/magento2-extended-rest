<?php
namespace KT\RestApiReview\Api\Data;

interface ReviewInterface
{
    const ID = 'review_id';
    const TITLE = 'title';
    const DETAIL = 'detail';
    const NICKNAME = 'nickname';
    const CUSTOMER_ID = 'customer_id';
    const RATINGS = 'ratings';
    const ENTITY_ID = 'entity_id';
    const ENTITY_PK_VALUE = 'entity_pk_value';
    const STATUS_ID = 'status_id';
    const REVIEW_TYPE = 'review_type';

    /**
     * Get review id.
     *
     * @return int
    */
    public function getId();

    /**
     * Set review id.
     *
     * @param int $value
     * @return void
     */
    public function setId($value);

    /**
     * Get Review title.
     *
     * @return string
    */
    public function getTitle();

    /**
     * Set Review title.
     *
     * @param string $value
     * @return void
     */
    public function setTitle($value);

    /**
     * Get Review detail.
     *
     * @return string
    */
    public function getDetail();

    /**
     * Set Review detail.
     *
     * @param void $value
     * @return void
     */
    public function setDetail($value);

    /**
     * Get author nickname.
     *
     * @return string
    */
    public function getNickname();

    /**
     * Set author nickname.
     *
     * @param string $value
     * @return void
     */
    public function setNickname($value);

    /**
     * Get customer id.
     *
     * @return int|null
    */
    public function getCustomerId();

    /**
     * Set customer id.
     *
     * @param int|null $value
     * @return void
     */
    public function setCustomerId($value);

    /**
     * Get review rating votes.
     *
     * @return \KT\RestApiReview\Api\Data\VoteInterface[]
    */
    public function getVotes();

    /**
     * Set review rating votes
     *
     * @param \KT\RestApiReview\Api\Data\VoteInterface[] $value
     * @return void
     */
    public function setVotes($value);

    /**
     * Get review entity type.
     *
     * @return string
     */
    public function getEntityId();

    /**
     * Set review entity type.
     *
     * @param string $value
     * @return void
     */
    public function setEntityId($value);

    /**
     * Get entity ID
     *
     * @return int
    */
    public function getEntityPkValue();

    /**
     * Set entity ID
     *
     * @param int $value
     * @return void
     */
    public function setEntityPkValue(int $value);

    /**
     * Get review status.
     * Possible values: 1 - Approved, 2 - Pending, 3 - Not Approved.
     *
     * @return int
    */
    public function getStatusId();

    /**
     * Set review status.
     * Possible values: 1 - Approved, 2 - Pending, 3 - Not Approved.
     *
     * @param int $value
     * @return void
    */
    public function setStatusId($value);
}