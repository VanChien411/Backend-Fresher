<?php

namespace Magenest\Movie\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $connection = $setup->getConnection();

        // Movie table
        if (!$setup->tableExists('magenest_movie')) {
            $table = $connection->newTable(
                $setup->getTable('magenest_movie')
            )->addColumn(
                'movie_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,       // AUTO_INCREMENT
                    'nullable' => false,      // NOT NULL
                    'primary' => true,        // PRIMARY KEY
                    'unsigned' => true        // No negative values
                ],
                'Movie ID'
            )->addColumn(
                'name',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Movie Name'
            )->addColumn(
                'description',
                Table::TYPE_TEXT,
                null,
                ['nullable' => true],
                'Description'
            )->addColumn(
                'rating',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => true],
                'Rating'
            )->addColumn(
                'director_id',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'unsigned' => true],
                'Director ID'
            )->addForeignKey(
                $setup->getFkName('magenest_movie', 'director_id', 'magenest_director', 'director_id'),
                // Foreign key name (Magento will automatically set the name according to the standard)
                'director_id',                            // Columns in current table
                $setup->getTable('magenest_director'),    // The table is referenced
                'director_id',                            // Column in the referenced table
                Table::ACTION_CASCADE                     // If you delete director → delete movie too (deleting foreign key id will delete related records)
            )->setComment('Magenest Movie');
            $connection->createTable($table);
        }

        // Magenest_director table
        if (!$setup->tableExists('magenest_director')) {
            $table = $connection->newTable(
                $setup->getTable('magenest_director')
            )->addColumn(
                'director_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true],
                'Director ID'
            )->addColumn(
                'name',
                Table::TYPE_TEXT,
                null,
                ['nullable' => false],
                'Director Name'
            )->setComment('Magenest Director');
            $connection->createTable($table);
        }

        // Magenest_actor table
        if (!$setup->tableExists('magenest_actor')) {
            $table = $connection->newTable(
                $setup->getTable('magenest_actor')
            )->addColumn(
                'actor_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true],
                'Actor ID'
            )->addColumn(
                'name',
                Table::TYPE_TEXT,
                null,
                ['nullable' => false],
                'Actor Name'
            )->setComment('Magenest Actor');
            $connection->createTable($table);
        }

        // Magenest_movie_actor table
        if (!$setup->tableExists('magenest_movie_actor')) {
            $table = $connection->newTable(
                $setup->getTable('magenest_movie_actor')
            )->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true],
                'ID'
            )->addColumn(
                'movie_id',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'unsigned' => true],
                'Movie ID'
            )->addColumn(
                'actor_id',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'unsigned' => true],
                'Actor ID'
            )->addForeignKey(
                $setup->getFkName('magenest_movie_actor', 'movie_id', 'magenest_movie', 'movie_id'),
                'movie_id',
                $setup->getTable('magenest_movie'),
                'movie_id',
                Table::ACTION_CASCADE
            )->addForeignKey(
                $setup->getFkName('magenest_movie_actor', 'actor_id', 'magenest_actor', 'actor_id'),
                'actor_id',
                $setup->getTable('magenest_actor'),
                'actor_id',
                Table::ACTION_CASCADE
            )->addIndex(
                // Create unique index for movie_id and actor_id pair to not allow duplicates to avoid errors
                $setup->getIdxName('magenest_movie_actor', ['movie_id', 'actor_id'], \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE),
                ['movie_id', 'actor_id'],
                ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
            )->setComment('Magenest Movie-Actor Relation');
            $connection->createTable($table);
        }

        $setup->endSetup();
    }
}
