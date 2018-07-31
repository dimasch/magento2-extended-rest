<?php

namespace KT\RestApiCatalog\Model\ResourceModel\Eav;

class Attribute extends \Magento\Catalog\Model\ResourceModel\Eav\Attribute
{
    public function setSwatchImage($image)
    {
        return $this->setData('swatch_image', $image);
    }

    public function getSwatchImage()
    {
        return $this->getData('swatch_image');
    }

    public function setStocks($data)
    {
        return $this->setData('stocks', $data);
    }

    public function getStocks()
    {
        return $this->getData('stocks');
    }

    public function setOptions(array $options = null)
    {
        if ($options !== null) {
            $optionDataArray = [];
            foreach ($options as $option) {
                $optionData = $this->dataObjectProcessor->buildOutputDataArray(
                    $option,
                    \KT\RestApiCatalog\Api\Data\AttributeOptionInterface::class
                );
                $optionDataArray[] = $optionData;
            }
            $this->setData(self::OPTIONS, $optionDataArray);
        } else {
            $this->setData(self::OPTIONS, $options);
        }
        return $this;
    }
}
