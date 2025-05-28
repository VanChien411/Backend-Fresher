<?php

namespace Magenest\Blog\Model\ResourceModel\Blog;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magenest\Blog\Model\Blog as BlogModel;
use Magenest\Blog\Model\ResourceModel\Blog as BlogResource;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(BlogModel::class, BlogResource::class);
    }

    protected function _initSelect()
    {
        parent::_initSelect();
        // Join bảng admin_user để lấy thông tin author
        $this->getSelect()->joinLeft(
            ['author_user' => $this->getTable('admin_user')],
            'main_table.author_id = author_user.user_id',
            [
                'author_username' => 'author_user.username',
                'author_email' => 'author_user.email',
                'author_firstname' => 'author_user.firstname',
                'author_lastname' => 'author_user.lastname'
            ]);
        return $this;
    }

}
