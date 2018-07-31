<?php

namespace KT\RestApiCheckout\Model;

class ShippingMethodsManagement
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var \Magento\Shipping\Model\Config
     */
    protected $_shippingConfig;

    /**
     * ShippingMethodsManagement constructor.
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Shipping\Model\Config $shippingConfig
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Shipping\Model\Config $shippingConfig
    )
    {
        $this->_scopeConfig = $scopeConfig;
        $this->_shippingConfig = $shippingConfig;
    }

    /**
     * @return array
     */
    public function getShippingMethods()
    {
        $deliveryMethods = [];
        $activeCarriers = $this->_shippingConfig->getActiveCarriers();
        // id for ES Required!
        $i = 0;

        foreach ($activeCarriers as $carrierCode => $carrierModel) {
            if ($carrierMethods = $carrierModel->getAllowedMethods()) {
                $carrierTitle = $this->_scopeConfig->getValue('carriers/' . $carrierCode . '/title');
                $carrierActive = $this->_scopeConfig->getValue('carriers/' . $carrierCode . '/active');

                if ($carrierActive == 1) {

                    foreach ($carrierMethods as $methodCode => $method) {
                        $code = $carrierCode . '_' . $methodCode;

                        $deliveryMethods[] = [
                            'id' => $i,
                            'title' => $carrierTitle,
                            'carrier' => $carrierCode,
                            'method' => $methodCode,
                            'code' => $code
                        ];

                        $i++;
                    }

                }

            }
        }

        return $deliveryMethods;
    }
}
