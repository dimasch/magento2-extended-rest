<?php
/**
 * Copyright (c) 2018. Komplizierte Technologien. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace KT\RestApiReview\Model;

use KT\RestApiReview\Api\Data\VoteInterface;
use Magento\Framework\Model\ResourceModel\AbstractResource;

class Vote extends \Magento\Framework\Model\AbstractExtensibleModel implements VoteInterface
{
    /**
     * Rating resource model
     *
     * @var \Magento\Review\Model\ResourceModel\Rating\CollectionFactory
     */
    protected $_ratingsFactory;

    /**
     * Rating resource option model
     *
     * @var \Magento\Review\Model\ResourceModel\Rating\Option\Vote\CollectionFactory
     */
    protected $_votesFactory;

    protected $_ratingsCollection;

    /**
     * Review constructor.
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory
     * @param \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory
     * @param AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory,
        \Magento\Review\Model\ResourceModel\Rating\CollectionFactory $ratingsFactory,
        \Magento\Review\Model\ResourceModel\Rating\Option\Vote\CollectionFactory $votesFactory,
        AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->_ratingsFactory = $ratingsFactory;
        $this->_votesFactory = $votesFactory;

        parent::__construct(
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory,
            $resource,
            $resourceCollection,
            $data
        );
    }

    protected function _construct()
    {
        $this->_init('Magento\Review\Model\ResourceModel\Rating\Option\Vote');
    }

    /**
     * {@inheritdoc}
     */
    public function getReviewId()
    {
        return $this->getData(self::REVIEW_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributeCode()
    {
        return $this->getData(self::ATTRIBUTE_CODE);
    }

    /**
     * {@inheritdoc}
     */
    public function getRatingId()
    {
        return $this->getData(self::RATING_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setRatingId($value)
    {
        return $this->setData(self::RATING_ID, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityPkValue()
    {
        return $this->getData(self::ENTITY_PK_VALUE);
    }

    /**
     * {@inheritdoc}
     */
    public function setEntityPkValue($value)
    {
        return $this->setData(self::ENTITY_PK_VALUE, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getPercent()
    {
        return $this->getData(self::PERCENT);
    }

    /**
     * {@inheritdoc}
     */
    public function setPercent($value)
    {
        return $this->setData(self::PERCENT, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return $this->getData(self::VALUE);
    }

    /**
     * {@inheritdoc}
     */
    public function setValue($value)
    {
        return $this->setData(self::VALUE, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function setReviewId($value)
    {
        return $this->setData(self::REVIEW_ID, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function setAttributeCode($value)
    {
        return $this->setData(self::ATTRIBUTE_CODE, $value);
    }



    /**
     * {@inheritdoc}
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * {@inheritdoc}
     */
    public function setExtensionAttributes(
        $extensionAttributes
    )
    {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}
