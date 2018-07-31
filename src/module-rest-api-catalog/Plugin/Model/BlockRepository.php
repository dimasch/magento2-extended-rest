<?php


namespace KT\RestApiCatalog\Plugin\Model;

class BlockRepository
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
        \Magento\Cms\Model\BlockRepository $subject,

        $result
    ) {
        return $this->_contentProxy->filterShortCodes($result);
    }
}