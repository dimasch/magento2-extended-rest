<?php
/**
 * Copyright (c) 2018. Komplizierte Technologien. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace KT\RestApiReview\Model;

use KT\RestApiReview\Api\Data\ReviewInterface;
use Magento\Framework\Model\ResourceModel\AbstractResource;

class Review extends \Magento\Review\Model\Review implements ReviewInterface
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

    protected $_votesCollection;

    /**
     * Review constructor.
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Review\Model\ResourceModel\Review\Product\CollectionFactory $productFactory
     * @param \Magento\Review\Model\ResourceModel\Review\Status\CollectionFactory $statusFactory
     * @param \Magento\Review\Model\ResourceModel\Review\Summary\CollectionFactory $summaryFactory
     * @param \Magento\Review\Model\Review\SummaryFactory $summaryModFactory
     * @param \Magento\Review\Model\Review\Summary $reviewSummary
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\UrlInterface $urlModel
     * @param \Magento\Review\Model\ResourceModel\Rating\CollectionFactory $ratingsFactory
     * @param \Magento\Review\Model\ResourceModel\Rating\Option\Vote\CollectionFactory $votesFactory
     * @param AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Review\Model\ResourceModel\Review\Product\CollectionFactory $productFactory,
        \Magento\Review\Model\ResourceModel\Review\Status\CollectionFactory $statusFactory,
        \Magento\Review\Model\ResourceModel\Review\Summary\CollectionFactory $summaryFactory,
        \Magento\Review\Model\Review\SummaryFactory $summaryModFactory,
        \Magento\Review\Model\Review\Summary $reviewSummary,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\UrlInterface $urlModel,
        \Magento\Review\Model\ResourceModel\Rating\CollectionFactory $ratingsFactory,
        \Magento\Review\Model\ResourceModel\Rating\Option\Vote\CollectionFactory $votesFactory,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {

        $this->_ratingsFactory = $ratingsFactory;
        $this->_votesFactory = $votesFactory;

        parent::__construct(
            $context,
            $registry,
            $productFactory,
            $statusFactory,
            $summaryFactory,
            $summaryModFactory,
            $reviewSummary,
            $storeManager,
            $urlModel,
            $resource,
            $resourceCollection,
            $data
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle($value)
    {
        return $this->setData(self::TITLE, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getDetail()
    {
        return $this->getData(self::DETAIL);
    }

    /**
     * {@inheritdoc}
     */
    public function setDetail($value)
    {
        return $this->setData(self::DETAIL, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getNickname()
    {
        return $this->getData(self::NICKNAME);
    }

    /**
     * {@inheritdoc}
     */
    public function setNickname($value)
    {
        return $this->setData(self::NICKNAME, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setCustomerId($value)
    {
        return $this->setData(self::CUSTOMER_ID, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getVotes()
    {
        if($this->_votesCollection === null) {
            $votesCollection = $this->_votesFactory->create()
//                ->setEntityPkFilter($this->getReviewEntityId())
                ->setReviewFilter($this->getId())
                ->load();

            $this->_votesCollection = $votesCollection->getItems();
        }
        return $this->_votesCollection;
    }

    /**
     * {@inheritdoc}
     */
    public function setVotes($value)
    {
        $this->_votesCollection = $value;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityPkValue() : int
    {
        return (int) $this->getData(self::ENTITY_PK_VALUE);
    }

    /**
     * {@inheritdoc}
     */
    public function setEntityPkValue(int $value)
    {
        return $this->setData(self::ENTITY_PK_VALUE, $value);
    }


    /**
     * {@inheritdoc}
     */
    public function getStatusId() : int
    {
        return $this->getData(self::STATUS_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setStatusId($value)
    {
        return $this->setData(self::STATUS_ID, $value);
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
