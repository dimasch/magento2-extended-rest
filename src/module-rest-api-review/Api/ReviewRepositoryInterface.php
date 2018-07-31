<?php
namespace KT\RestApiReview\Api;

interface ReviewRepositoryInterface
{
    /**
     * Save review.
     *
     * @param \KT\RestApiReview\Api\Data\ReviewInterface $review
     * @return \KT\RestApiReview\Api\Data\ReviewInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\KT\RestApiReview\Api\Data\ReviewInterface $review);

    /**
     * Get review by id.
     *
     * @param int $id
     * @param int|null $storeId
     * @return \KT\RestApiReview\Api\Data\ReviewInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get($id, $storeId = null);

    /**
     * Delete review.
     *
     * @param \KT\RestApiReview\Api\Data\ReviewInterface $review
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(\KT\RestApiReview\Api\Data\ReviewInterface $review);

    /**
     * Delete review by id.
     *
     * @param int $id
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById($id);


    /**
     * Lists the review items that match specified search criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \KT\RestApiReview\Api\Data\ReviewSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}