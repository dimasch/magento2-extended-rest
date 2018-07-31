<?php
namespace KT\RestApiReview\Api\Data;

interface VoteInterface
{
    const ENTITY_ID = 'vote_id';
    const REVIEW_ID = 'review_id';
    const ATTRIBUTE_CODE = 'attribute_code';
    const ENTITY_PK_VALUE = 'entity_pk_value';
    const RATING_ID = 'rating_id';
    const PERCENT = 'percent';
    const VALUE = 'value';

    /**
     * Get rating id.
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set rating id.
     *
     * @param int|null $value
     * @return void
     */
    public function setId($value);

    /**
     * Get review id.
     *
     * @return int
     */
    public function getReviewId();

    /**
     * Set review id.
     *
     * @param int $value
     * @return void
     */
    public function setReviewId($value);

    /**
     * Get rating code.
     *
     * @return string
     */
    public function getAttributeCode();

    /**
     * Set rating code.
     *
     * @param string $value
     * @return void
     */
    public function setAttributeCode($value);

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
    public function setEntityPkValue($value);

    /**
     * Get rating ID
     *
     * @return int
     */
    public function getRatingId();

    /**
     * Set rating ID
     *
     * @param int $value
     * @return void
     */
    public function setRatingId($value);

    /**
     * Get rating percent value.
     *
     * @return int
     */
    public function getPercent();

    /**
     * Set rating percent value.
     *
     * @param int $value
     * @return void
     */
    public function setPercent($value);

    /**
     * Get rating value.
     *
     * @return int
     */
    public function getValue();

    /**
     * Set rating value.
     *
     * @param int $value
     * @return void
     */
    public function setValue($value);
}