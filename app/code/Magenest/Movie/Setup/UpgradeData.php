<?php

namespace Magenest\Movie\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeData implements UpgradeDataInterface
{
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        // Run data upgrade for version 1.0.1 or lower
        if (version_compare($context->getVersion(), '2.0.3', '<')) {
            $connection = $setup->getConnection();

            // Insert sample data for magenest_director if not exists
            $directors = [
                ['name' => 'Christopher Nolan'],
                ['name' => 'Quentin Tarantino'],
                ['name' => 'Steven Spielberg']
            ];
            foreach ($directors as $director) {
                $select = $connection->select()
                    ->from($setup->getTable('magenest_director'))
                    ->where('name = ?', $director['name']);
                if (!$connection->fetchOne($select)) {
                    $connection->insert($setup->getTable('magenest_director'), $director);
                }
            }

            // Insert sample data for magenest_actor if not exists
            $actors = [
                ['name' => 'Leonardo DiCaprio'],
                ['name' => 'Brad Pitt'],
                ['name' => 'Tom Hanks'],
                ['name' => 'Christian Bale']
            ];
            foreach ($actors as $actor) {
                $select = $connection->select()
                    ->from($setup->getTable('magenest_actor'))
                    ->where('name = ?', $actor['name']);
                if (!$connection->fetchOne($select)) {
                    $connection->insert($setup->getTable('magenest_actor'), $actor);
                }
            }

            // Insert sample data for magenest_movie if not exists
            $movies = [
                [
                    'name' => 'Inception',
                    'description' => 'A thief with the ability to enter dreams and steal secrets.',
                    'rating' => 8,
                    'director_id' => 1
                ],
                [
                    'name' => 'Pulp Fiction',
                    'description' => 'The lives of two mob hitmen, a boxer, and a pair of bandits intertwine.',
                    'rating' => 9,
                    'director_id' => 2
                ],
                [
                    'name' => 'Saving Private Ryan',
                    'description' => 'A World War II rescue mission to save a paratrooper.',
                    'rating' => 8,
                    'director_id' => 3
                ]
            ];
            foreach ($movies as $movie) {
                $select = $connection->select()
                    ->from($setup->getTable('magenest_movie'))
                    ->where('name = ?', $movie['name']);
                if (!$connection->fetchOne($select)) {
                    $connection->insert($setup->getTable('magenest_movie'), $movie);
                }
            }

            // Insert sample data for magenest_movie_actor if not exists
            $movieActors = [
                ['movie_id' => 1, 'actor_id' => 1], // Inception - Leonardo DiCaprio
                ['movie_id' => 1, 'actor_id' => 4], // Inception - Christian Bale
                ['movie_id' => 2, 'actor_id' => 2], // Pulp Fiction - Brad Pitt
                ['movie_id' => 3, 'actor_id' => 3], // Saving Private Ryan - Tom Hanks
                ['movie_id' => 3, 'actor_id' => 1],  // Saving Private Ryan - Leonardo DiCaprio
                ['movie_id' => 3, 'actor_id' => 4]   // Saving Private Ryan - Christian Bale
            ];
            foreach ($movieActors as $movieActor) {
                $select = $connection->select()
                    ->from($setup->getTable('magenest_movie_actor'))
                    ->where('movie_id = ? AND actor_id = ?', $movieActor['movie_id'], $movieActor['actor_id']);
                if (!$connection->fetchOne($select)) {
                    $connection->insert($setup->getTable('magenest_movie_actor'), $movieActor);
                }
            }
        }
        $setup->endSetup();
    }
}
