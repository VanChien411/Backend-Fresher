<?php

namespace Magenest\DeliveryTime\Setup\Patch\Schema;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddDeliveryDateToSalesOrder implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * Constructor
     */
    public function __construct(ModuleDataSetupInterface $moduleDataSetup)
    {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $setup = $this->moduleDataSetup;
        $setup->getConnection()->startSetup();

        $salesOrderTable = $setup->getTable('sales_order');

        if (!$setup->getConnection()->tableColumnExists($salesOrderTable, 'delivery_date')) {
            $setup->getConnection()->addColumn(
                $salesOrderTable,
                'delivery_date',
                [
                    'type' => Table::TYPE_DATETIME,
                    'nullable' => true,
                    'default' => null,
                    'comment' => 'Delivery Date',
                ]
            );
        }

        $setup->getConnection()->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
