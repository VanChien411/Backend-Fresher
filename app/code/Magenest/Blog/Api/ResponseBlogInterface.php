<?php

namespace Magenest\Blog\Api;

interface ResponseBlogInterface
{
    const DATA_ID = 'id';
    const DATA_TITLE = 'title';
    const DATA_CONTENT = 'content';
    const DATA_DESCRIPTION = 'description';
    const DATA_AUTHOR_ID = 'author_id';
    const DATA_URL_REWRITE = 'url_rewrite';
    const DATA_STATUS = 'status';
    const DATA_CREATE_AT = 'create_at';
    const DATA_UPDATE_AT = 'update_at';
    const DATA_CATEGORIES = 'categories';

    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return string|null
     */
    public function getContent();

    /**
     * @return string|null
     */
    public function getDescription();

    /**
     * @return int
     */
    public function getAuthorId();

    /**
     * @return string
     */
    public function getUrlRewrite();

    /**
     * @return int
     */
    public function getStatus();

    /**
     * @return string
     */
    public function getCreateAt();

    /**
     * @return string
     */
    public function getUpdateAt();

    /**
     * @return int[]
     */
    public function getCategories();

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id);

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title);

    /**
     * @param string|null $content
     * @return $this
     */
    public function setContent(?string $content);

    /**
     * @param string|null $content
     * @return $this
     */
    public function setDescription(?string $content);

    /**
     * @param int $authorId
     * @return $this
     */
    public function setAuthorId(int $authorId);

    /**
     * @param string $urlRewrite
     * @return $this
     */
    public function setUrlRewrite(string $urlRewrite);

    /**
     * @param int $status
     * @return $this
     */
    public function setStatus(int $status);

    /**
     * @param string $createAt
     * @return $this
     */
    public function setCreateAt(string $createAt);

    /**
     * @param string $updateAt
     * @return $this
     */
    public function setUpdateAt(string $updateAt);

    /**
     * @param int[] $categories
     * @return $this
     */
    public function setCategories(array $categories);

}