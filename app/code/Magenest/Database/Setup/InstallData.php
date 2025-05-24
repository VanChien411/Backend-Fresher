<?php

namespace Magenest\Database\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Config;

// <== thêm dòng này

class InstallData implements InstallDataInterface
{
    protected $eavSetupFactory;
    protected $eavConfig;

    public function __construct(
        EavSetupFactory $eavSetupFactory,
        Config          $eavConfig // <== inject thêm
    )
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig = $eavConfig;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        // Tạo attribute customer telephone
        $eavSetup->addAttribute(
            Customer::ENTITY,
            'telephone',
            [
                'type' => 'varchar',
                'label' => 'Telephone',
                'input' => 'text',
                'required' => false,
                'visible' => true,
                'user_defined' => true,
                'position' => 999,
                'system' => 0,
                'backend' => '',
                'frontend' => '',
                'source' => '',
                'default' => '',
                'is_used_in_grid' => true,
                'is_visible_in_grid' => true,
                'is_filterable_in_grid' => true,
                'is_searchable_in_grid' => true
            ]
        );

        $attribute = $eavSetup->getEavConfig()->getAttribute(Customer::ENTITY, 'telephone'); // ✅ dùng đúng
        $attribute->setData(
            'used_in_forms',
            ['adminhtml_customer', 'customer_account_create', 'customer_account_edit']
        );

        $attribute->save();

        $setup->endSetup();
    }
}
