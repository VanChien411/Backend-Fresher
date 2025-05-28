<?php

namespace Magenest\DeliveryTime\Setup\Patch\Schema;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\SchemaPatchInterface;

class AddDeliveryDateToQuote implements SchemaPatchInterface
{
    private $moduleDataSetup;

    public function __construct(ModuleDataSetupInterface $moduleDataSetup)
    {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    public static function getDependencies()
    {
        return [];
    }

    public function apply()
    {
        $connection = $this->moduleDataSetup->getConnection();
        $quoteTable = $this->moduleDataSetup->getTable('quote');

        if (!$connection->tableColumnExists($quoteTable, 'delivery_date')) {
            $connection->addColumn(
                $quoteTable,
                'delivery_date',
                [
                    'type' => Table::TYPE_DATETIME,
                    'nullable' => true,
                    'default' => null,
                    'comment' => 'Delivery Date',
                ]
            );
        }

        return $this;
    }

    public function getAliases()
    {
        return [];
    }
}
