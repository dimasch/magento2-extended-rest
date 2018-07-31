<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace KT\RestApiCatalog\Model\Entity\Attribute;

use \KT\RestApiCatalog\Api\Data\AttributeOptionInterface as AttributeOptionInterface;

class Option extends \Magento\Eav\Model\Entity\Attribute\Option implements AttributeOptionInterface
{
    public function setSwatchImage($image)
    {
        return $this->setData('swatch_image', $image);
    }

    public function getSwatchImage()
    {
        return $this->getData('swatch_image');
    }

    public function getStocks()
    {
        return $this->getData('stocks');
    }
    public function setStocks()
    {
        return $this->getData('stocks');
    }
}
