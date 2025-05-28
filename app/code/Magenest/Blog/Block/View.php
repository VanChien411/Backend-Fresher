<?php

namespace Magenest\Blog\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magenest\Blog\Model\Blog;

class View extends Template
{
    /** @var Blog */
    protected $blog;

    public function __construct(Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }

    /**
     * @return Blog|null
     */
    public function getBlog()
    {
        return $this->blog;
    }

    /**
     * @param Blog $blog
     * @return $this
     */
    public function setBlog(Blog $blog)
    {
        $this->blog = $blog;
        return $this;
    }
}