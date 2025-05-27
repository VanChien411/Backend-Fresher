<?php

namespace Magenest\Blog\Api;

use Magenest\Blog\Api\Data\BlogInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface BlogRepositoryInterface
{
    public function save(BlogInterface $blog);

    public function getById($id);

    public function getList(SearchCriteriaInterface $searchCriteria);

    public function delete(BlogInterface $blog);

    public function deleteById($id);
}
