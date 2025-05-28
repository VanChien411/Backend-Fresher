<?php

namespace Magenest\Blog\Model\Api;

use Magenest\Blog\Api\BlogRepositoryInterface;
use Magenest\Blog\Api\RequestBlogInterface;
use Magenest\Blog\Api\ResponseBlogInterfaceFactory;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\LocalizedException;

class BlogRepository implements BlogRepositoryInterface
{
    private $resourceConnection;
    private $responseBlogFactory;

    /**
     * @param ResourceConnection $resourceConnection
     * @param ResponseBlogInterfaceFactory $responseBlogFactory
     */
    public function __construct(
        ResourceConnection           $resourceConnection,
        ResponseBlogInterfaceFactory $responseBlogFactory
    )
    {
        $this->resourceConnection = $resourceConnection;
        $this->responseBlogFactory = $responseBlogFactory;
    }

    /**
     * @return array|\Magenest\Blog\Api\ResponseBlogInterface[]
     */
    public function getAllBlogs(): array
    {
        $connection = $this->resourceConnection->getConnection();
        $blogTable = $this->resourceConnection->getTableName('magenest_blog');
        $categoryTable = $this->resourceConnection->getTableName('magenest_category');
        $blogCategoryTable = $this->resourceConnection->getTableName('magenest_blog_category');

        // Fetch all blogs
        $select = $connection->select()->from(['b' => $blogTable]);
        $blogs = $connection->fetchAll($select);

        $result = [];
        foreach ($blogs as $blog) {
            // Fetch associated category names
            $categorySelect = $connection->select()
                ->from(['bc' => $blogCategoryTable])
                ->join(['c' => $categoryTable], 'bc.category_id = c.id', ['c.name'])
                ->where('bc.blog_id = ?', $blog['id']);
            $categories = $connection->fetchAll($categorySelect);
            $categoryNames = array_column($categories, 'name');

            /** @var \Magenest\Blog\Api\ResponseBlogInterface $response */
            $response = $this->responseBlogFactory->create();
            $response->setId((int)$blog['id'])
                ->setAuthorId((int)$blog['author_id'])
                ->setTitle($blog['title'])
                ->setDescription($blog['description'] ?? null)
                ->setContent($blog['content'] ?? null)
                ->setUrlRewrite($blog['url_rewrite'])
                ->setStatus((int)$blog['status'])
                ->setCreateAt($blog['create_at'])
                ->setUpdateAt($blog['update_at'])
                ->setCategories($categoryNames);

            $result[] = $response;
        }

        return $result;
    }

    /**
     * @param RequestBlogInterface $blog
     * @return \Magenest\Blog\Api\ResponseBlogInterface
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function createBlog(RequestBlogInterface $blog): \Magenest\Blog\Api\ResponseBlogInterface
    {
        $connection = $this->resourceConnection->getConnection();
        $blogTable = $this->resourceConnection->getTableName('magenest_blog');
        $blogCategoryTable = $this->resourceConnection->getTableName('magenest_blog_category');
        $categoryTable = $this->resourceConnection->getTableName('magenest_category');
        $adminTable = $this->resourceConnection->getTableName('admin_user');

        // Validate required fields
        if (!$blog->getTitle() || !$blog->getAuthorId() || !$blog->getUrlRewrite()) {
            throw new LocalizedException(__('Title, author_id, and url_rewrite are required.'));
        }

        // Validate author_id exists in admin_user
        $adminSelect = $connection->select()
            ->from($adminTable, ['user_id'])
            ->where('user_id = ?', $blog->getAuthorId());
        if (!$connection->fetchOne($adminSelect)) {
            throw new LocalizedException(__('Invalid author_id.'));
        }

        // Validate unique url_rewrite
        $urlSelect = $connection->select()
            ->from($blogTable, ['id'])
            ->where('url_rewrite = ?', $blog->getUrlRewrite());
        if ($connection->fetchOne($urlSelect)) {
            throw new LocalizedException(__('URL rewrite already exists.'));
        }

        // Validate categories
        $categories = $blog->getCategories();
        if (!empty($categories)) {
            foreach ($categories as $categoryId) {
                $categorySelect = $connection->select()
                    ->from($categoryTable, ['id'])
                    ->where('id = ?', $categoryId);
                if (!$connection->fetchOne($categorySelect)) {
                    throw new LocalizedException(__('Invalid category ID: %1', $categoryId));
                }
            }
        }

        // Prepare blog data
        $blogData = [
            'author_id' => $blog->getAuthorId(),
            'title' => $blog->getTitle(),
            'description' => $blog->getDescription() ?? null,
            'content' => $blog->getContent() ?? null,
            'url_rewrite' => $blog->getUrlRewrite(),
            'status' => $blog->getStatus() ?: 1,
            'create_at' => date('Y-m-d H:i:s'),
            'update_at' => date('Y-m-d H:i:s')
        ];

        // Insert blog
        $connection->insert($blogTable, $blogData);
        $blogId = $connection->lastInsertId($blogTable);

        // Insert categories
        foreach ($categories as $categoryId) {
            $connection->insert($blogCategoryTable, [
                'blog_id' => $blogId,
                'category_id' => $categoryId
            ]);
        }

        return $this->getBlog($blogId);
    }

    /**
     * @param int $id
     * @return \Magenest\Blog\Api\ResponseBlogInterface
     * @throws NoSuchEntityException
     */
    public function getBlog(int $id): \Magenest\Blog\Api\ResponseBlogInterface
    {
        $connection = $this->resourceConnection->getConnection();
        $blogTable = $this->resourceConnection->getTableName('magenest_blog');
        $categoryTable = $this->resourceConnection->getTableName('magenest_category');
        $blogCategoryTable = $this->resourceConnection->getTableName('magenest_blog_category');

        // Fetch blog data
        $select = $connection->select()
            ->from(['b' => $blogTable])
            ->where('b.id = ?', $id);
        $blog = $connection->fetchRow($select);

        if (!$blog) {
            throw new NoSuchEntityException(__('Blog post not found.'));
        }

        // Fetch associated category names
        $categorySelect = $connection->select()
            ->from(['bc' => $blogCategoryTable])
            ->join(['c' => $categoryTable], 'bc.category_id = c.id', ['c.name'])
            ->where('bc.blog_id = ?', $id);
        $categories = $connection->fetchAll($categorySelect);
        $categoryNames = array_column($categories, 'name');

        /** @var \Magenest\Blog\Api\ResponseBlogInterface $response */
        $response = $this->responseBlogFactory->create();
        $response->setId((int)$blog['id'])
            ->setAuthorId((int)$blog['author_id'])
            ->setTitle($blog['title'])
            ->setDescription($blog['description'] ?? null)
            ->setContent($blog['content'] ?? null)
            ->setUrlRewrite($blog['url_rewrite'])
            ->setStatus((int)$blog['status'])
            ->setCreateAt($blog['create_at'])
            ->setUpdateAt($blog['update_at'])
            ->setCategories($categoryNames);

        return $response;
    }

    /**
     * @param int $id
     * @param RequestBlogInterface $blog
     * @return \Magenest\Blog\Api\ResponseBlogInterface
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function updateBlog(int $id, RequestBlogInterface $blog): \Magenest\Blog\Api\ResponseBlogInterface
    {
        $connection = $this->resourceConnection->getConnection();
        $blogTable = $this->resourceConnection->getTableName('magenest_blog');
        $blogCategoryTable = $this->resourceConnection->getTableName('magenest_blog_category');
        $categoryTable = $this->resourceConnection->getTableName('magenest_category');
        $adminTable = $this->resourceConnection->getTableName('admin_user');

        // Verify blog exists
        $select = $connection->select()
            ->from($blogTable, ['id'])
            ->where('id = ?', $id);
        if (!$connection->fetchOne($select)) {
            throw new NoSuchEntityException(__('Blog post not found.'));
        }

        // Validate required fields
        if (!$blog->getTitle() || !$blog->getAuthorId() || !$blog->getUrlRewrite()) {
            throw new LocalizedException(__('Title, author_id, and url_rewrite are required.'));
        }

        // Validate author_id exists
        $adminSelect = $connection->select()
            ->from($adminTable, ['user_id'])
            ->where('user_id = ?', $blog->getAuthorId());
        if (!$connection->fetchOne($adminSelect)) {
            throw new LocalizedException(__('Invalid author_id.'));
        }

        // Validate unique url_rewrite (excluding current blog)
        $urlSelect = $connection->select()
            ->from($blogTable, ['id'])
            ->where('url_rewrite = ?', $blog->getUrlRewrite())
            ->where('id != ?', $id);
        if ($connection->fetchOne($urlSelect)) {
            throw new LocalizedException(__('URL rewrite already exists.'));
        }

        // Validate categories
        $categories = $blog->getCategories();
        if (!empty($categories)) {
            foreach ($categories as $categoryId) {
                $categorySelect = $connection->select()
                    ->from($categoryTable, ['id'])
                    ->where('id = ?', $categoryId);
                if (!$connection->fetchOne($categorySelect)) {
                    throw new LocalizedException(__('Invalid category ID: %1', $categoryId));
                }
            }
        }

        // Prepare blog data
        $blogData = [
            'author_id' => $blog->getAuthorId(),
            'title' => $blog->getTitle(),
            'description' => $blog->getDescription() ?? null,
            'content' => $blog->getContent() ?? null,
            'url_rewrite' => $blog->getUrlRewrite(),
            'status' => $blog->getStatus() ?: 1,
            'update_at' => date('Y-m-d H:i:s')
        ];

        // Update blog
        $connection->update($blogTable, $blogData, ['id = ?' => $id]);

        // Update categories
        $connection->delete($blogCategoryTable, ['blog_id = ?' => $id]);
        foreach ($categories as $categoryId) {
            $connection->insert($blogCategoryTable, [
                'blog_id' => $id,
                'category_id' => $categoryId
            ]);
        }

        return $this->getBlog($id);
    }

    /**
     * @param int $id
     * @return bool
     * @throws NoSuchEntityException
     */
    public function deleteBlog(int $id): bool
    {
        $connection = $this->resourceConnection->getConnection();
        $blogTable = $this->resourceConnection->getTableName('magenest_blog');

        // Verify blog exists
        $select = $connection->select()
            ->from($blogTable, ['id'])
            ->where('id = ?', $id);
        if (!$connection->fetchOne($select)) {
            throw new NoSuchEntityException(__('Blog post not found.'));
        }

        // Delete blog (cascades to blog_category due to foreign key)
        $connection->delete($blogTable, ['id = ?' => $id]);

        return true;
    }
}