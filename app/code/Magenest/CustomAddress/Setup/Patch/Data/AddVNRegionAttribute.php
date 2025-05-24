<?php

namespace Magenest\CustomAddress\Setup\Patch\Data;

use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;

class AddVNRegionAttribute implements DataPatchInterface
{
    /** @var ModuleDataSetupInterface */
    private $moduleDataSetup;

    /** @var CustomerSetupFactory */
    private $customerSetupFactory;

    /** @var AttributeSetFactory */
    private $attributeSetFactory;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CustomerSetupFactory     $customerSetupFactory,
        AttributeSetFactory      $attributeSetFactory
    )
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }

    public function apply()
    {
        // Start setup transaction
        $connection = $this->moduleDataSetup->getConnection();
        $connection->startSetup();

        /** @var \Magento\Customer\Setup\CustomerSetup $customerSetup */
        $customerSetup = $this->customerSetupFactory->create(['setup' => $this->moduleDataSetup]);

        // Load customer_address entity metadata
        $customerAddressEntity = $customerSetup->getEavConfig()->getEntityType('customer_address');
        $attributeSetId = $customerAddressEntity->getDefaultAttributeSetId();

        // Determine the default attribute group
        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

        // Add the attribute vn_region
        $customerSetup->addAttribute(
            'customer_address',
            'vn_region',
            [
                'type' => 'int',
                'label' => 'Miền (VN Region)',
                'input' => 'select',
                'source' => \Magenest\CustomAddress\Model\Config\Source\VNRegion::class,
                'required' => false,
                'visible' => true,
                'user_defined' => true,
                'system' => false,
                'position' => 200
            ]
        );

        // Assign attribute to attribute set/group and forms
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer_address', 'vn_region');
        $attribute->addData([
            'attribute_set_id' => $attributeSetId,
            'attribute_group_id' => $attributeGroupId,
            'used_in_forms' => [
                'adminhtml_customer_address',
                'customer_address_edit',
                'customer_register_address',
                'customer_address'
            ]
        ]);
        $attribute->save();

        // End setup transaction
        $connection->endSetup();

        return $this;
    }
}
