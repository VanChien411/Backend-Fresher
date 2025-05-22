<?php

namespace Magenest\Database\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Model\Config as EavConfig;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Customer\Model\Customer;

class RemoveTelephoneAttribute implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @var EavConfig
     */
    private $eavConfig;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory          $eavSetupFactory,
        EavConfig                $eavConfig
    )
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig = $eavConfig;
    }

    public static function getDependencies()
    {
        return [];
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        // Lấy attribute 'telephone' từ entity customer
        $attribute = $this->eavConfig->getAttribute(Customer::ENTITY, 'telephone');

        if ($attribute && $attribute->getId()) {
            // Xóa attribute bằng cách gọi delete(), đảm bảo xóa sạch
            $attribute->delete();
        }

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public function getAliases()
    {
        return [];
    }
}
