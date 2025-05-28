<?php

namespace Magenest\Blog\Model\Api;

use Magenest\Blog\Api\ResponseBlogInterface;
use Magento\Framework\DataObject;

class ResponseBlog extends DataObject implements ResponseBlogInterface
{
    public function getId(): int
    {
        return $this->_getData(self::DATA_ID);
    }

    public function getTitle(): string
    {
        return $this->_getData(self::DATA_TITLE);
    }

    public function getContent(): ?string
    {
        return $this->_getData(self::DATA_CONTENT);
    }

    public function getDescription(): ?string
    {
        return $this->_getData(self::DATA_DESCRIPTION);
    }

    public function getAuthorId(): int
    {
        return $this->_getData(self::DATA_AUTHOR_ID);
    }

    public function getUrlRewrite(): string
    {
        return $this->_getData(self::DATA_URL_REWRITE);
    }

    public function getStatus(): int
    {
        return $this->_getData(self::DATA_STATUS);
    }

    public function getCreateAt(): string
    {
        return $this->_getData(self::DATA_CREATE_AT);
    }

    public function getUpdateAt(): string
    {
        return $this->_getData(self::DATA_UPDATE_AT);
    }

    public function getCategories(): array
    {
        return $this->_getData(self::DATA_CATEGORIES) ?? [];
    }

    public function setId(int $id): mixed
    {
        return $this->setData(self::DATA_ID, $id);
    }

    public function setTitle(string $title): mixed
    {
        return $this->setData(self::DATA_TITLE, $title);
    }

    public function setContent(?string $content): mixed
    {
        return $this->setData(self::DATA_CONTENT, $content);
    }

    public function setDescription(?string $description): mixed
    {
        return $this->setData(self::DATA_DESCRIPTION, $description);
    }

    public function setAuthorId(int $authorId): mixed
    {
        return $this->setData(self::DATA_AUTHOR_ID, $authorId);
    }

    public function setUrlRewrite(string $urlRewrite): mixed
    {
        return $this->setData(self::DATA_URL_REWRITE, $urlRewrite);
    }

    public function setStatus(int $status): mixed
    {
        return $this->setData(self::DATA_STATUS, $status);
    }

    public function setCreateAt(string $createAt): mixed
    {
        return $this->setData(self::DATA_CREATE_AT, $createAt);
    }

    public function setUpdateAt(string $updateAt): mixed
    {
        return $this->setData(self::DATA_UPDATE_AT, $updateAt);
    }

    public function setCategories(array $categories): mixed
    {
        return $this->setData(self::DATA_CATEGORIES, $categories);
    }
}