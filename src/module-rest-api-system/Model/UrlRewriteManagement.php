<?php
/**
 * Copyright (c) 2018. Komplizierte Technologien. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace KT\RestApiSystem\Model;

use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\Search\FilterGroup;

/**
 * Class CoreConfigManagement
 * @package KT\RestApiSystem\Model
 */
class UrlRewriteManagement implements \KT\RestApiSystem\Api\UrlRewriteManagementInterface
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var \Magento\UrlRewrite\Model\ResourceModel\UrlRewriteCollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @var \KT\RestApiSystem\Api\Data\UrlRewriteSearchResultsInterface
     */
    protected $_searchResultsFactory;

    /**
     * @var \KT\RestApiSystem\Model\UrlRewriteFactory
     */
    protected $_urlRewriteFactory;


    /**
     * UrlRewriteManagement constructor.
     * @param \Magento\UrlRewrite\Model\ResourceModel\UrlRewriteCollectionFactory $collectionFactory
     * @param \KT\RestApiSystem\Api\Data\UrlRewriteSearchResultsInterfaceFactory $searchResultsFactory
     * @param UrlRewriteFactory $urlRewriteFactory
     */
    public function __construct(
        \Magento\UrlRewrite\Model\ResourceModel\UrlRewriteCollectionFactory $collectionFactory,
        \KT\RestApiSystem\Api\Data\UrlRewriteSearchResultsInterfaceFactory $searchResultsFactory,
        \KT\RestApiSystem\Model\UrlRewriteFactory $urlRewriteFactory
    )
    {
        $this->_collectionFactory = $collectionFactory;
        $this->_searchResultsFactory = $searchResultsFactory;
        $this->_urlRewriteFactory = $urlRewriteFactory;
    }


    /**
     * @inheritdoc
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        $searchResults = $this->_searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        $collection = $this->_collectionFactory->create();

        //Add filters from root filter group to the collection
        foreach ($searchCriteria->getFilterGroups() as $group) {
            $this->addFilterGroupToCollection($group, $collection);
        }

        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $searchCriteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($searchCriteria->getSortOrders() as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());
        $items = [];
        foreach($collection->getItems() as $item) {
            $urlRewrite = $this->_urlRewriteFactory->create();
            $urlRewrite->setData($item->getData());

            $items[] = $urlRewrite;
        }

        $searchResults->setItems($items);
        return $searchResults;
    }

    /**
     * Helper function that adds a FilterGroup to the collection.
     *
     * @param $filterGroup FilterGroup
     * @param $collection CreditCollection
     * @return void
     * @throws \Magento\Framework\Exception\InputException
     */
    protected function addFilterGroupToCollection(
        FilterGroup $filterGroup,
        \Magento\UrlRewrite\Model\ResourceModel\UrlRewriteCollection $collection
    )
    {
        $fields = [];
        $conditions = [];
        foreach ($filterGroup->getFilters() as $filter) {
            $fields[] = $filter->getField();
            $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
            $conditions[] = [$condition => $filter->getValue()];
        }
        if ($fields) {
            $collection->addFieldToFilter($fields, $conditions);
        }
    }
}