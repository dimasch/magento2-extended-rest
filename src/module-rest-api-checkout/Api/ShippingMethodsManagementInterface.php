<?php

namespace KT\RestApiCheckout\Api;

interface ShippingMethodsManagementInterface
{
    /**
     * GET for ShippingMethods api
     * @return string
     */
    public function getShippingMethods();
}
