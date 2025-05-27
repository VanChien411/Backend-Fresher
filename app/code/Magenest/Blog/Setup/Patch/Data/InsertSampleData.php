<?php

namespace Magenest\Blog\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class InsertSampleData implements DataPatchInterface
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
        $this->moduleDataSetup->startSetup();

        // Chèn dữ liệu mẫu vào bảng magenest_category
        $categories = [
            ['name' => 'Technology'],
            ['name' => 'Lifestyle'],
            ['name' => 'Travel'],
            ['name' => 'Food'],
        ];
        $this->moduleDataSetup->getConnection()->insertMultiple(
            $this->moduleDataSetup->getTable('magenest_category'),
            $categories
        );

        // Chèn dữ liệu mẫu vào bảng magenest_blog
        // Giả định: admin_user có user_id từ 1 đến 4
        $blogs = [
            [
                'author_id' => 1,
                'title' => 'Introduction to AI',
                'description' => 'A brief overview of artificial intelligence.',
                'content' => 'Artificial intelligence (AI) is the simulation of human intelligence in machines...',
                'url_rewrite' => 'introduction-to-ai',
                'status' => 1,
            ],
            [
                'author_id' => 2,
                'title' => 'Healthy Living Tips',
                'description' => 'Tips for maintaining a healthy lifestyle.',
                'content' => 'Living a healthy lifestyle involves balanced nutrition, regular exercise...',
                'url_rewrite' => 'healthy-living-tips',
                'status' => 1,
            ],
            [
                'author_id' => 3,
                'title' => 'Top 10 Travel Destinations',
                'description' => 'Discover the best places to visit around the world.',
                'content' => 'From the beaches of Bali to the mountains of Switzerland...',
                'url_rewrite' => 'top-10-travel-destinations',
                'status' => 1,
            ],
            [
                'author_id' => 4,
                'title' => 'Delicious Recipes for Beginners',
                'description' => 'Easy-to-follow recipes for novice cooks.',
                'content' => 'Cooking can be fun and rewarding. Start with these simple recipes...',
                'url_rewrite' => 'delicious-recipes-for-beginners',
                'status' => 1,
            ],
        ];
        $this->moduleDataSetup->getConnection()->insertMultiple(
            $this->moduleDataSetup->getTable('magenest_blog'),
            $blogs
        );

        // Chèn dữ liệu mẫu vào bảng magenest_blog_category
        // Giả định: ID của blog và danh mục bắt đầu từ 1
        $blogCategories = [
            ['blog_id' => 1, 'category_id' => 1], // Blog 1 thuộc danh mục Technology
            ['blog_id' => 2, 'category_id' => 2], // Blog 2 thuộc danh mục Lifestyle
            ['blog_id' => 3, 'category_id' => 3], // Blog 3 thuộc danh mục Travel
            ['blog_id' => 4, 'category_id' => 4], // Blog 4 thuộc danh mục Food
        ];
        $this->moduleDataSetup->getConnection()->insertMultiple(
            $this->moduleDataSetup->getTable('magenest_blog_category'),
            $blogCategories
        );

        $this->moduleDataSetup->endSetup();
    }

    public function getAliases()
    {
        return [];
    }
}