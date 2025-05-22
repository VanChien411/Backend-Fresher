<?php

namespace Magenest\Database\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $connection = $setup->getConnection();

        // Thêm cột vào customer_entity
//        if (!$connection->tableColumnExists($setup->getTable('customer_entity'), 'telephone')) {
//            $connection->addColumn(
//                $setup->getTable('customer_entity'),
//                'telephone',
//                [
//                    'type' => Table::TYPE_TEXT,
//                    'length' => 10,
//                    'nullable' => true,
//                    'comment' => 'Customer Telephone'
//                ]
//            );
//        }
//
//        // Thêm cột vào sales_order
//        if (!$connection->tableColumnExists($setup->getTable('sales_order'), 'customer_telephone')) {
//            $connection->addColumn(
//                $setup->getTable('sales_order'),
//                'customer_telephone',
//                [
//                    'type' => Table::TYPE_TEXT,
//                    'length' => 10,
//                    'nullable' => true,
//                    'comment' => 'Customer Telephone'
//                ]
//            );
//        }

        $setup->endSetup();
    }
}
