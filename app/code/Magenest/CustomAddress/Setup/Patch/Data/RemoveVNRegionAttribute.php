<?php

namespace Magenest\CustomAddress\Setup\Patch\Data;

use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class RemoveVNRegionAttribute implements DataPatchInterface
{
    /** @var ModuleDataSetupInterface */
    private $moduleDataSetup;

    /** @var CustomerSetupFactory */
    private $customerSetupFactory;

    /**
     * Constructor
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CustomerSetupFactory $customerSetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CustomerSetupFactory     $customerSetupFactory
    )
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->customerSetupFactory = $customerSetupFactory;
    }

    /**
     * Get dependencies
     *
     * @return array
     */
    public static function getDependencies()
    {
        return [\Magenest\CustomAddress\Setup\Patch\Data\AddVNRegionAttribute::class];
    }

    /**
     * Get aliases
     *
     * @return array
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * Apply the patch
     *
     * @return $this
     */
    public function apply()
    {
        $connection = $this->moduleDataSetup->getConnection();
        $connection->startSetup();

        /** @var \Magento\Customer\Setup\CustomerSetup $customerSetup */
        $customerSetup = $this->customerSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $customerSetup->removeAttribute('customer_address', 'vn_region');

        $connection->endSetup();

        return $this;
    }
}