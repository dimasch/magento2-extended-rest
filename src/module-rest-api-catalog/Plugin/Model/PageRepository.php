<?php


namespace KT\RestApiCatalog\Plugin\Model;

class PageRepository
{
    /**
     * @var \KT\RestApiCatalog\Helper\ContentProxy
     */
    protected $_contentProxy;

    public function __construct(
        \KT\RestApiCatalog\Helper\ContentProxy $contentProxy
    )
    {
        $this->_contentProxy = $contentProxy;
    }

    public function afterGetList(
        \Magento\Cms\Model\PageRepository $subject,
        $result
    ) {
        return $this->_contentProxy->filterShortCodes($result);
    }
}