<?php

namespace KT\RestApiCatalog\Setup;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Setup\EavSetup;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Catalog\Model\Category;


class UpgradeData implements UpgradeDataInterface
{
    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * Init
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory
    )
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        if (version_compare($context->getVersion(), '1.0.1') < 0) {
            $entityType = $eavSetup->getEntityTypeId(Category::ENTITY);

            $eavSetup->updateAttribute($entityType, 'svg_image', 'backend_type','text', null);
        }

        if (version_compare($context->getVersion(), '1.0.2') < 0) {
            $eavSetup->addAttribute(
                'catalog_product',
                'stocks',
                [
                    'type' => 'text',
                    'label' => 'Stocks',
                    'input' => 'text',
                    'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend',
                    'required' => false,
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE
                ]
            );
        }
        if (version_compare($context->getVersion(), '1.0.3') < 0) {
            $eavSetup->addAttribute(
                Category::ENTITY,
                'is_active_brand',
                [
                    'type' => 'int',
                    'label' => 'Is Active Brand',
                    'input' => 'boolean',
                    'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend',
                    'required' => false,
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE

                ]
            );
        }
        $setup->endSetup();
    }
}