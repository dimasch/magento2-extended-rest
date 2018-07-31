<?php
/**
 * Copyright (c) 2018. Komplizierte Technologien. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace KT\RestApiReview\Model;

use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\Search\FilterGroup;

/**
 * Class ReviewRepository
 * @package KT\RestApiReview\Model
 */
class ReviewRepository implements \KT\RestApiReview\Api\ReviewRepositoryInterface
{
    /**
     * @var array
     */
    protected $_instances = [];

    /**
     * @var \Magento\Review\Model\ResourceModel\Review
     */
    protected $_resourceModel;


    /**
     * @var \Magento\Review\Model\ResourceModel\Review\CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @var \KT\RestApiReview\Api\Data\ReviewSearchResultsInterfaceFactory
     */
    protected $_searchResultsFactory;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $_searchCriteriaBuilder;

    /**
     * @var \Magento\Framework\Api\FilterBuilder
     */
    protected $_filterBuilder;

    /**
     * @var \Magento\Review\Model\ReviewFactory
     */
    protected $_reviewFactory;

    /**
     * @var ReviewFactory
     */
//    protected $_reviewModelFactory;

    /**
     * @var \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface
     */
    protected $_extensionAttributesJoinProcessor;


    /**
     * ReviewRepository constructor.
     * @param ReviewFactory $reviewFactory
     * @param \Magento\Review\Model\ResourceModel\Review\CollectionFactory $collectionFactory
     * @param \Magento\Review\Model\ResourceModel\Review $resourceModel
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \KT\RestApiReview\Api\Data\ReviewSearchResultsInterfaceFactory $searchResultsFactory
     * @param \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $extensionAttributesJoinProcessor
     */
    public function __construct(

        \KT\RestApiReview\Model\ReviewFactory $reviewFactory,
        \Magento\Review\Model\ResourceModel\Review\CollectionFactory $collectionFactory,
        \Magento\Review\Model\ResourceModel\Review $resourceModel,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \KT\RestApiReview\Api\Data\ReviewSearchResultsInterfaceFactory $searchResultsFactory,
        \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $extensionAttributesJoinProcessor
    )
    {
        $this->_reviewFactory = $reviewFactory;
        $this->_collectionFactory = $collectionFactory;
        $this->_resourceModel = $resourceModel;
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->_searchResultsFactory = $searchResultsFactory;
        $this->_extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
    }


    /**
     * @inheritdoc
     */
    public function save(\KT\RestApiReview\Api\Data\ReviewInterface $review)
    {
        try {
            $this->_resourceModel->save($review);
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(
                __(
                    'Could not save review: %1',
                    $e->getMessage()
                ),
                $e
            );
        }
        unset($this->_instances[$review->getId()]);
        return $review;
    }


    /**
     * @inheritdoc
     */
    public function get($id, $storeId = null)
    {
        $cacheKey = null !== $storeId ? $storeId : 'all';
        if (!isset($this->instances[$id][$cacheKey])) {
            $review = $this->_reviewFactory->create();
            if (null !== $storeId) {
                $review->setStoreId($storeId);
            }
            $review->load($id);
            if (!$review->getId()) {
                return false;
            }

            $this->_instances[$id][$cacheKey] = $review;
        }
        return $this->_instances[$id][$cacheKey];
    }

    /**
     * @inheritdoc
     */
    public function delete(\KT\RestApiReview\Api\Data\ReviewInterface $review)
    {
        try {
            $id = $review->getId();
            $this->_resourceModel->delete($review);
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\StateException(
                __(
                    'Cannot delete review with id %1',
                    $review->getId()
                ),
                $e
            );
        }
        unset($this->_instances[$id]);
        return true;
    }


    /**
     * @inheritdoc
     */
    public function deleteById($id)
    {
        $review = $this->get($id);
        if(!$review) {
            throw new \Magento\Framework\Exception\NotFoundException(
                __(
                    'Review with id %1 not found',
                    $id
                )
            );
        }
        return $this->delete($review);
    }

    /**
     * @inheritdoc
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        $searchResults = $this->_searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        $collection = $this->_collectionFactory->create();

        //Add filters from root filter group to the collection
        foreach ($searchCriteria->getFilterGroups() as $group) {
            $this->addFilterGroupToCollection($group, $collection);
        }

        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $searchCriteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($searchCriteria->getSortOrders() as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());
        $reviews = $collection->getItems();

        $reviewModels = [];
        foreach ($reviews as $review) {
            $reviewModel = $this->_reviewFactory->create();
            $reviewModel->setData($review->getData());
            $reviewModels[] = $reviewModel;
        }

        $searchResults->setItems($reviewModels);
        return $searchResults;
    }


    /**
     * Helper function that adds a FilterGroup to the collection.
     *
     * @param $filterGroup FilterGroup
     * @param $collection
     * @return void
     * @throws \Magento\Framework\Exception\InputException
     */
    protected function addFilterGroupToCollection(
        FilterGroup $filterGroup,
        \Magento\Review\Model\ResourceModel\Review\Collection $collection
    )
    {
        $fields = [];
        $conditions = [];
        foreach ($filterGroup->getFilters() as $filter) {
            $fields[] = $filter->getField();
            $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
            $conditions[] = [$condition => $filter->getValue()];
        }
        if ($fields) {
            $collection->addFieldToFilter($fields, $conditions);
        }
    }
}