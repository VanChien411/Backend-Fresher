<?php

namespace Magenest\Course\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class CreateCourseReferenceTable implements DataPatchInterface
{
    private $moduleDataSetup;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup
    )
    {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    public static function getDependencies()
    {
        return [];
    }

    public function apply()
    {
        $setup = $this->moduleDataSetup;
        $connection = $setup->getConnection();

        $table = $connection
            ->newTable($setup->getTable('magenest_course_reference'))
            ->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Entity ID'
            )
            ->addColumn(
                'product_id',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false],
                'Product ID'
            )
            ->addColumn(
                'label',
                Table::TYPE_TEXT,
                null,
                ['nullable' => true],
                'Label'
            )
            ->addColumn(
                'value',
                Table::TYPE_TEXT,
                null,
                ['nullable' => true],
                'Value'
            )
            ->addColumn(
                'type',
                Table::TYPE_TEXT,
                50,
                ['nullable' => true],
                'Type'
            )
            ->setComment('Magenest Course Reference Table');

        $connection->createTable($table);
    }

    public function getAliases()
    {
        return [];
    }
}