<?php
/**
 * Copyright (c) 2018. Komplizierte Technologien. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace KT\RestApiReview\Model;

use Magento\Framework\Exception\LocalizedException;

/**
 * Class ReviewManagement
 * @package KT\RestApiReview\Model
 */
class ReviewManagement implements \KT\RestApiReview\Api\ReviewManagementInterface
{

    /**
     * @var \Magento\Review\Model\ResourceModel\Review
     */
    protected $_resourceModel;

    /**
     * @var \Magento\Review\Model\ResourceModel\Review\CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @var \KT\RestApiReview\Model\ReviewFactory
     */
    protected $_reviewFactory;

    /**
     * @var \KT\RestApiReview\Model\ReviewRepository
     */
    protected $_reviewRepository;

    /**
     * @var \Magento\Review\Model\RatingFactory
     */
    protected $_ratingFactory;

    /**
     * @var \Magento\Review\Model\Rating\EntityFactory
     */
    protected $_ratingEntityFactory;

    /**
     * @var ReviewFactory|\Magento\Review\Model\ReviewFactory
     */
    protected $_reviewModelFactory;

    /**
     * @var \Magento\Review\Model\ResourceModel\Rating\Option\CollectionFactory
     */
    protected $_optionCollectionFactory;

    /**
     * @var \Magento\Catalog\Model\ProductRepository
     */
    protected $_productRepository;

    /**
     * @var \Magento\Store\Model\StoreManager
     */
    protected $_storeManager;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $_searchCriteriaBuilder;

    /**
     * @var \Magento\Framework\Api\FilterBuilder
     */
    protected $_filterBuilder;

    /**
     * @var \Magento\Review\Model\Review
     */
    protected $_model;

    /**
     * @var \Magento\Review\Model\Rating
     */
    protected $_ratingModel;

    /**
     * @var \Magento\Review\Model\Rating\Entity
     */
    protected $_ratingEntityModel;

    /**
     * ReviewManagement constructor.
     * @param ReviewFactory $reviewFactory
     * @param ReviewRepository $reviewRepository
     * @param \Magento\Review\Model\RatingFactory $ratingFactory
     * @param \Magento\Review\Model\Rating\EntityFactory $ratingEntityFactory
     * @param \Magento\Review\Model\ResourceModel\Rating\Option\CollectionFactory $optionCollectionFactory
     * @param \Magento\Review\Model\ReviewFactory $reviewModelFactory
     * @param \Magento\Review\Model\ResourceModel\Review\CollectionFactory $collectionFactory
     * @param \Magento\Review\Model\ResourceModel\Review $resourceModel
     * @param \Magento\Catalog\Model\ProductRepository $productRepository
     * @param \Magento\Store\Model\StoreManager $storeManager
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Framework\Api\FilterBuilder $filterBuilder
     */
    public function __construct(
        \KT\RestApiReview\Model\ReviewFactory $reviewFactory,
        \KT\RestApiReview\Model\ReviewRepository $reviewRepository,
        \Magento\Review\Model\RatingFactory $ratingFactory,
        \Magento\Review\Model\Rating\EntityFactory $ratingEntityFactory,
        \Magento\Review\Model\ResourceModel\Rating\Option\CollectionFactory $optionCollectionFactory,
        \Magento\Review\Model\ReviewFactory $reviewModelFactory,
        \Magento\Review\Model\ResourceModel\Review\CollectionFactory $collectionFactory,
        \Magento\Review\Model\ResourceModel\Review $resourceModel,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Store\Model\StoreManager $storeManager,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Api\FilterBuilder $filterBuilder
    )
    {
        $this->_reviewFactory = $reviewFactory;
        $this->_reviewRepository = $reviewRepository;
        $this->_ratingFactory = $ratingFactory;
        $this->_ratingEntityFactory = $ratingEntityFactory;
        $this->_reviewModelFactory = $reviewModelFactory;
        $this->_optionCollectionFactory = $optionCollectionFactory;
        $this->_collectionFactory = $collectionFactory;
        $this->_resourceModel = $resourceModel;
        $this->_productRepository = $productRepository;
        $this->_storeManager = $storeManager;
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->_filterBuilder = $filterBuilder;
    }

    public function getProductReviews($id)
    {
        $searchCriteria = $this->_searchCriteriaBuilder
            ->addFilter('entity_pk_value', $id)
            ->addFilter('entity_id', $this->getProductEntityId())
            ->create();

        return $this->_reviewRepository->getList($searchCriteria);
    }

    /**
     * @inheritdoc
     */
    public function addProductReview(
        $id,
        \KT\RestApiReview\Api\Data\RequestInterface $request
    )
    {
        try {
            $product = $this->_productRepository->getById($id);

            $review = $this->createReview(
                $request->getReview(),
                $request->getVotes(),
                $id,
                $this->getProductEntityId(),
                $request->getCustomerId()
            );;
        } catch (LocalizedException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(
                __(
                    'Could not save review: %1',
                    $e->getMessage()
                ),
                $e
            );
        }
        return $review;
    }

    protected function createReview($review, $votes, $entityPkValue, $entityId, $customerId = null) {
        $review->setId(null);

        $validate = $review->validate();
        if ($validate === true) {
            try {
                $review->setEntityId($review->getEntityIdByCode(Review::ENTITY_PRODUCT_CODE))
                    ->setEntityPkValue($entityPkValue)
                    ->setStatusId(Review::STATUS_PENDING)
                    ->setCustomerId($customerId)
                    ->setStoreId($this->_storeManager->getStore()->getId())
                    ->setStores([$this->_storeManager->getStore()->getId()])
                    ->save();

                foreach ($votes as $vote) {
                    $ratingId = $vote->getRatingId();
                    if(!$ratingId) {
                        $ratingId = $this->getRatingEntityId();
                    }

                    $this->_ratingFactory->create()
                        ->setRatingId($vote->getRatingId())
                        ->setReviewId($review->getId())
                        ->setCustomerId($customerId)
                        ->addOptionVote(
                            $this->getVoteOptionId($vote->getRatingId(), $vote->getValue()),
                            $entityPkValue
                        );
                }

                $review->aggregate();
                return $review;
            } catch (\Exception $e) {

            }
        } else {
            if (is_array($validate)) {
                foreach ($validate as $errorMessage) {
                    $this->messageManager->addError($errorMessage);
                }
            } else {
                throw new LocalizedException(_('We can\'t post your review right now.'));
            }
        }
    }

    protected function getVoteOptionId($ratingId, $value) {
        $optionCollection = $this->_optionCollectionFactory->create();
        $optionCollection->addFilter('rating_id', $ratingId)
            ->addFilter('value', $value);
        if($option = $optionCollection->getFirstItem()) {
            return $option->getId();
        }
        return null;
    }

    protected function getProductEntityId() {
        return $this->getModel()->getEntityIdByCode(\Magento\Review\Model\Review::ENTITY_PRODUCT_CODE);
    }

    protected function getModel() {
        if($this->_model === null) {
            $this->_model = $this->_reviewModelFactory->create();
        }
        return $this->_model;
    }

    protected function getRatingEntityId() {
        return $this->getRatingEntityModel()->getEntityIdByCode('Rating');
    }

    protected function getRatingEntityModel() {
        if($this->_ratingEntityModel === null) {
            $this->_ratingEntityModel = $this->_ratingEntityFactory->create();
        }
        return $this->_ratingEntityModel;
    }
}