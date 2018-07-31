<?php

namespace KT\RestApiCatalog\Model;

use \KT\RestApiCatalog\Api\CategoriesManagementInterface as CategoriesManagementInterface;

class CategoriesManagement implements CategoriesManagementInterface
{
    /**
     * @var \Magento\Catalog\Api\CategoryRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * @var \Magento\Catalog\Model\Category\Tree
     */
    protected $categoryTree;

    /**
     * @var \Magento\Framework\App\ScopeResolverInterface
     */
    private $scopeResolver;
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
     */
    private $categoriesFactory;


    public function __construct(
        \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository,
        \Magento\Catalog\Model\Category\Tree $categoryTree,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoriesFactory
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->categoryTree = $categoryTree;
        $this->categoriesFactory = $categoriesFactory;
    }
    /**
     * {@inheritdoc}
     */
    public function getTree($rootCategoryId = null, $depth = null)
    {
        $category = null;
        if ($rootCategoryId !== null) {
            /** @var \Magento\Catalog\Model\Category $category */
            $category = $this->categoryRepository->get($rootCategoryId);
        } elseif ($this->isAdminStore()) {
            $category = $this->getTopLevelCategory();
        }
        $result = $this->categoryTree->getTree($this->categoryTree->getRootNode($category), $depth);
        return $result;
    }

    /**
     * @return bool
     */
    private function isAdminStore()
    {
        return $this->getScopeResolver()->getScope()->getCode() == \Magento\Store\Model\Store::ADMIN_CODE;
    }

    private function getScopeResolver()
    {
        if ($this->scopeResolver == null) {
            $this->scopeResolver = \Magento\Framework\App\ObjectManager::getInstance()
                ->get(\Magento\Framework\App\ScopeResolverInterface::class);
        }

        return $this->scopeResolver;
    }

    private function getTopLevelCategory()
    {
        $categoriesCollection = $this->categoriesFactory->create()->addAttributeToSelect('svg_image');
        return $categoriesCollection->addFilter('level', ['eq' => 0])->getFirstItem();
    }

    public function getCustomAttributes($catId)
    {
        return $this->categoryRepository->get($catId)->getCustomAttributes();
    }

    /**
     * @param $catId
     * @param $attr
     * @return \Magento\Catalog\Api\Data\CategoryInterface|mixed
     */
    public function setCustomAttributes($catId, $attr)
    {
        $cat = $this->categoryRepository->get($catId);
        $cat->setCustomAttributes($attr);
        return $cat;
    }
}
