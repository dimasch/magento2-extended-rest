<?php


namespace KT\RestApiSales\Api;

interface SalesManagementInterface
{


    /**
     * Retrieve list of categories
     *
     * @param int $orderId
     * @param int $customerId
     * @return bool
     */
    public function cancelOrder($orderId, $customerId);


}
