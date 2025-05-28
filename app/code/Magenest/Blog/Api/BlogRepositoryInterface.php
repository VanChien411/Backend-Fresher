<?php

namespace Magenest\Blog\Api;

interface BlogRepositoryInterface
{
    /**
     * Get blog by ID
     *
     * @param int $id
     * @return \Magenest\Blog\Api\ResponseBlogInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getBlog(int $id);

    /**
     * Get all blogs
     *
     * @return \Magenest\Blog\Api\ResponseBlogInterface[]
     */
    public function getAllBlogs();

    /**
     * Create new blog post
     *
     * @param \Magenest\Blog\Api\RequestBlogInterface $blog
     * @return \Magenest\Blog\Api\ResponseBlogInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function createBlog(\Magenest\Blog\Api\RequestBlogInterface $blog);

    /**
     * Update blog post by ID
     *
     * @param int $id
     * @param \Magenest\Blog\Api\RequestBlogInterface $blog
     * @return \Magenest\Blog\Api\ResponseBlogInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function updateBlog(int $id, \Magenest\Blog\Api\RequestBlogInterface $blog);

    /**
     * Delete blog post by ID
     *
     * @param int $id
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteBlog(int $id);
}