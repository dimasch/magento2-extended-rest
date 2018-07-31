<?php

namespace KT\RestApiCatalog\Helper;

use Magento\Framework\App\Helper\Context;

class ContentProxy extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * @var \Magento\Cms\Model\Template\FilterProvider
     */
    protected $_filterProvider;

    public function __construct(
        \Magento\Cms\Model\Template\FilterProvider $filterProvider
    )
    {
        $this->_filterProvider = $filterProvider;
    }

    public function filterShortCodes($result) /* Get content text, replace {{shortCode}} on http:// */
    {
        $newItems = array();
        foreach ($result->getItems() as $item) {
            if(is_array($item)) {
                $newItem = array_merge($item, array('content' => $this->_filterProvider->getPageFilter()->filter( $item['content'])));
            } else {
                $newItem = array_merge($item->getData(), array('content' => $this->_filterProvider->getPageFilter()->filter( $item['content'])));
            }
            $newItems[] = $newItem;
        }
        $result->setItems($newItems);
        return $result;
    }
}