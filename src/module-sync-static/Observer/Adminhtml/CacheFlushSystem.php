<?php


namespace KT\SyncStatic\Observer\Adminhtml;

class CacheFlushSystem implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \KT\SyncStatic\Helper\Data
     */
    protected $_helper;
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $_logger;

    public function __construct(
        \KT\SyncStatic\Helper\Data $helper,
        \Psr\Log\LoggerInterface $logger
    )
    {
        $this->_helper = $helper;
        $this->_logger = $logger;
    }

    /**
     * Execute observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {
        $url = $this->_helper->getConfig('url');
        $path = $this->_helper->getConfig('path_static');

        $ch = curl_init($url.$path);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json'
        ));
        $result = json_decode(curl_exec($ch), true);
        curl_close($ch);

        if($result['status'] != 'done'){
            $this->_logger->debug($result['message']);
        }
    }
}