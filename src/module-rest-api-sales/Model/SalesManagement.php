<?php

namespace KT\RestApiSales\Model;

use \KT\RestApiSales\Api\SalesManagementInterface as SalesManagementInterface;

class SalesManagement implements SalesManagementInterface
{
    /**
     * @var \Magento\Sales\Model\OrderRepository
     */
    protected $_orderRepository;
    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    protected $_customerRepository;
    /**
     * @var Logger
     */
    protected $_logger;

    public function __construct(
        \Magento\Sales\Model\OrderRepository $orderRepository,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
    )
    {
        $this->_orderRepository = $orderRepository;
        $this->_customerRepository = $customerRepository;
    }

    public function cancelOrder($orderId, $customerId)
    {

        if($this->_customerRepository->getById($customerId)){
            $order = $this->_orderRepository->get($orderId);
            $order->cancel();
            $order->save();
            return true;
        } else return false;

    }
}