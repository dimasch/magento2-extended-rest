<?php
namespace KT\RestApiReview\Api;

use KT\RestApiReview\Api\Data\ReviewInterface;

interface ReviewManagementInterface
{
    /**
     * Get product reviews by Product ID
     *
     * @param string $id
     * @return \KT\RestApiReview\Api\Data\ReviewSearchResultsInterface
     */
    public function getProductReviews($id);

    /**
     * Add product review
     *
     * @param string $id
     * @param \KT\RestApiReview\Api\Data\RequestInterface $request
     * @return \KT\RestApiReview\Api\Data\ReviewInterface
     */
    public function addProductReview(
        $id,
        \KT\RestApiReview\Api\Data\RequestInterface $request
    );
}
