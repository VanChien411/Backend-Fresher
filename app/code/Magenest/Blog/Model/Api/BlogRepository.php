<?php

namespace Magenest\Blog\Model\Api;

use Magenest\Blog\Api\BlogRepositoryInterface;
use Magenest\Blog\Api\RequestBlogInterface;
use Magenest\Blog\Api\ResponseBlogInterfaceFactory;
use Magenest\Blog\Model\BlogFactory;
use Magenest\Blog\Model\ResourceModel\Blog as BlogResource;
use Magenest\Blog\Model\CategoryFactory;
use Magenest\Blog\Model\ResourceModel\Category as CategoryResource;
use Magenest\Blog\Model\BlogCategoryFactory;
use Magenest\Blog\Model\ResourceModel\BlogCategory as BlogCategoryResource;
use Magento\User\Model\UserFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\LocalizedException;

class BlogRepository implements BlogRepositoryInterface
{
    private $responseBlogFactory;
    private $blogFactory;
    private $blogResource;
    private $categoryFactory;
    private $categoryResource;
    private $blogCategoryFactory;
    private $blogCategoryResource;
    private $userFactory;

    public function __construct(
        ResponseBlogInterfaceFactory $responseBlogFactory,
        BlogFactory                  $blogFactory,
        BlogResource                 $blogResource,
        CategoryFactory              $categoryFactory,
        CategoryResource             $categoryResource,
        BlogCategoryFactory          $blogCategoryFactory,
        BlogCategoryResource         $blogCategoryResource,
        UserFactory                  $userFactory
    )
    {
        $this->responseBlogFactory = $responseBlogFactory;
        $this->blogFactory = $blogFactory;
        $this->blogResource = $blogResource;
        $this->categoryFactory = $categoryFactory;
        $this->categoryResource = $categoryResource;
        $this->blogCategoryFactory = $blogCategoryFactory;
        $this->blogCategoryResource = $blogCategoryResource;
        $this->userFactory = $userFactory;
    }

    public function getAllBlogs(): array
    {
        $blogCollection = $this->blogFactory->create()->getCollection();
        $result = [];

        foreach ($blogCollection as $blogModel) {
            // Fetch associated categories
            $blogCategoryCollection = $this->blogCategoryFactory->create()->getCollection()
                ->addFieldToFilter('blog_id', $blogModel->getId());
            $categoryIds = $blogCategoryCollection->getColumnValues('category_id');
            $categoryNames = [];
            foreach ($categoryIds as $categoryId) {
                $categoryModel = $this->categoryFactory->create();
                $this->categoryResource->load($categoryModel, $categoryId);
                if ($categoryModel->getId()) {
                    $categoryNames[] = $categoryModel->getName();
                }
            }

            /** @var \Magenest\Blog\Api\ResponseBlogInterface $response */
            $response = $this->responseBlogFactory->create();
            $response->setId((int)$blogModel->getId())
                ->setAuthorId((int)$blogModel->getAuthorId())
                ->setTitle($blogModel->getTitle())
                ->setDescription($blogModel->getDescription() ?? null)
                ->setContent($blogModel->getContent() ?? null)
                ->setUrlRewrite($blogModel->getUrlRewrite())
                ->setStatus((int)$blogModel->getStatus())
                ->setCreateAt($blogModel->getCreatedAt() ?? '')
                ->setUpdateAt($blogModel->getUpdatedAt() ?? '')
                ->setCategories($categoryNames);

            $result[] = $response;
        }

        return $result;
    }

    public function createBlog(RequestBlogInterface $blog): \Magenest\Blog\Api\ResponseBlogInterface
    {
        // Validate required fields
        if (!$blog->getTitle() || !$blog->getAuthorId() || !$blog->getUrlRewrite()) {
            throw new LocalizedException(__('Title, author_id, and url_rewrite are required.'));
        }

        // Validate author_id
        $userModel = $this->userFactory->create();
        $userModel->load($blog->getAuthorId());
        if (!$userModel->getId()) {
            throw new LocalizedException(__('Invalid author_id.'));
        }

        // Validate categories
        $categories = $blog->getCategories();
        if (!empty($categories)) {
            foreach ($categories as $categoryId) {
                if (!is_int($categoryId)) {
                    throw new LocalizedException(__('Category IDs must be integers.'));
                }
                $categoryModel = $this->categoryFactory->create();
                $this->categoryResource->load($categoryModel, $categoryId);
                if (!$categoryModel->getId()) {
                    throw new LocalizedException(__('Invalid category ID: %1', $categoryId));
                }
            }
        }

        // Create blog model instance
        /** @var \Magenest\Blog\Model\Blog $blogModel */
        $blogModel = $this->blogFactory->create();
        $blogModel->setData([
            'author_id' => $blog->getAuthorId(),
            'title' => $blog->getTitle(),
            'description' => $blog->getDescription() ?? null,
            'content' => $blog->getContent() ?? null,
            'url_rewrite' => $blog->getUrlRewrite(),
            'status' => $blog->getStatus() ?: 1
        ]);

        try {
            // Save blog model (triggers beforeSave and afterSave)
            $this->blogResource->save($blogModel);
        } catch (\Exception $e) {
            throw new LocalizedException(__($e->getMessage()));
        }

        $blogId = $blogModel->getId();

        // Save blog-category associations
        foreach ($categories as $categoryId) {
            $blogCategoryModel = $this->blogCategoryFactory->create();
            $blogCategoryModel->setData([
                'blog_id' => $blogId,
                'category_id' => $categoryId
            ]);
            $this->blogCategoryResource->save($blogCategoryModel);
        }

        return $this->getBlog($blogId);
    }

    public function getBlog(int $id): \Magenest\Blog\Api\ResponseBlogInterface
    {
        /** @var \Magenest\Blog\Model\Blog $blogModel */
        $blogModel = $this->blogFactory->create();
        $this->blogResource->load($blogModel, $id);

        if (!$blogModel->getId()) {
            throw new NoSuchEntityException(__('Blog post not found.'));
        }

        // Fetch associated categories
        $blogCategoryCollection = $this->blogCategoryFactory->create()->getCollection()
            ->addFieldToFilter('blog_id', $id);
        $categoryIds = $blogCategoryCollection->getColumnValues('category_id');
        $categoryNames = [];
        foreach ($categoryIds as $categoryId) {
            $categoryModel = $this->categoryFactory->create();
            $this->categoryResource->load($categoryModel, $categoryId);
            if ($categoryModel->getId()) {
                $categoryNames[] = $categoryModel->getName();
            }
        }

        /** @var \Magenest\Blog\Api\ResponseBlogInterface $response */
        $response = $this->responseBlogFactory->create();
        $response->setId((int)$blogModel->getId())
            ->setAuthorId((int)$blogModel->getAuthorId())
            ->setTitle($blogModel->getTitle())
            ->setDescription($blogModel->getDescription() ?? null)
            ->setContent($blogModel->getContent() ?? null)
            ->setUrlRewrite($blogModel->getUrlRewrite())
            ->setStatus((int)$blogModel->getStatus())
            ->setCreateAt($blogModel->getCreatedAt() ?? '')
            ->setUpdateAt($blogModel->getUpdatedAt() ?? '')
            ->setCategories($categoryNames);

        return $response;
    }

    public function updateBlog(int $id, RequestBlogInterface $blog): \Magenest\Blog\Api\ResponseBlogInterface
    {
        // Load blog model
        $blogModel = $this->blogFactory->create();
        $this->blogResource->load($blogModel, $id);

        if (!$blogModel->getId()) {
            throw new NoSuchEntityException(__('Blog post not found.'));
        }

        // Validate required fields
        if (!$blog->getTitle() || !$blog->getAuthorId() || !$blog->getUrlRewrite()) {
            throw new LocalizedException(__('Title, author_id, and url_rewrite are required.'));
        }

        // Validate author_id
        $userModel = $this->userFactory->create()->load($blog->getAuthorId());
        if (!$userModel->getId()) {
            throw new LocalizedException(__('Invalid author_id.'));
        }

        // Validate categories
        $categories = $blog->getCategories();
        if (!is_array($categories)) {
            $categories = [];
        }

        foreach ($categories as $categoryId) {
            if (!is_int($categoryId)) {
                throw new LocalizedException(__('Category IDs must be integers.'));
            }
            $categoryModel = $this->categoryFactory->create();
            $this->categoryResource->load($categoryModel, $categoryId);
            if (!$categoryModel->getId()) {
                throw new LocalizedException(__('Invalid category ID: %1', $categoryId));
            }
        }

        // Cập nhật dữ liệu blog
        $blogModel->addData([
            'author_id' => $blog->getAuthorId(),
            'title' => $blog->getTitle(),
            'description' => $blog->getDescription() ?? null,
            'content' => $blog->getContent() ?? null,
            'url_rewrite' => $blog->getUrlRewrite(),
            'status' => $blog->getStatus() ?: 1
        ]);

        try {
            $this->blogResource->save($blogModel);
        } catch (\Exception $e) {
            throw new LocalizedException(__('Could not update blog: %1', $e->getMessage()));
        }

        // XÓA toàn bộ quan hệ cũ (KHÔNG dùng $this->blogCategoryResource->delete($model))
        $connection = $this->blogCategoryResource->getConnection();
        $connection->delete(
            $this->blogCategoryResource->getMainTable(),
            ['blog_id = ?' => $id]
        );

        // Thêm lại quan hệ blog - category mới
        foreach ($categories as $categoryId) {
            $blogCategoryModel = $this->blogCategoryFactory->create();
            $blogCategoryModel->setData([
                'blog_id' => $id,
                'category_id' => $categoryId
            ]);
            $this->blogCategoryResource->save($blogCategoryModel);
        }

        // Trả về blog đã cập nhật
        return $this->getBlog($id);
    }

    public function deleteBlog(int $id): bool
    {
        /** @var \Magenest\Blog\Model\Blog $blogModel */
        $blogModel = $this->blogFactory->create();
        $this->blogResource->load($blogModel, $id);

        if (!$blogModel->getId()) {
            throw new NoSuchEntityException(__('Blog post not found.'));
        }

        try {
            // Delete blog model (cascades to blog_category if configured)
            $this->blogResource->delete($blogModel);
        } catch (\Exception $e) {
            throw new LocalizedException(__('Unable to delete blog: %1', $e->getMessage()));
        }

        return true;
    }
}