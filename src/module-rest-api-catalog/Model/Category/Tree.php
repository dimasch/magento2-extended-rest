<?php

namespace KT\RestApiCatalog\Model\Category;

use Magento\Framework\Data\Tree\Node;

/**
 * Retrieve category data represented in tree structure
 */
class Tree extends \Magento\Catalog\Model\Category\Tree
{
    protected function prepareCollection()
    {
        parent::prepareCollection();
        $this->categoryCollection->addAttributeToSelect('svg_image');
        $this->categoryCollection->addAttributeToSelect('include_in_menu');
    }

    /**
     * @param Node $node
     * @param null $depth
     * @param int $currentLevel
     * @return \KT\RestApiCatalog\Api\Data\CategoryTreeInterface
     */
    public function getTree($node, $depth = null, $currentLevel = 0)
    {
        /** @var \KT\RestApiCatalog\Api\Data\CategoryTreeInterface[] $children */
        $children = $this->getChildren($node, $depth, $currentLevel);
        /** @var \KT\RestApiCatalog\Api\Data\CategoryTreeInterface $tree */
        $tree = $this->treeFactory->create();
        $tree->setId($node->getId())
            ->setParentId($node->getParentId())
            ->setName($node->getName())
            ->setPosition($node->getPosition())
            ->setLevel($node->getLevel())
            ->setIsActive($node->getIsActive())
            ->setProductCount($node->getProductCount())
            ->setChildrenData($children)
            ->setSvgImage($node->getSvgImage())
            ->setIncludeInMenu($node->getIncludeInMenu())
            ->setSeoUrlKey($node->getEntityId())
            ->setUrlKey($node->getEntityId());
        return $tree;
    }

}
