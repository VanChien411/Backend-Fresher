<?php

namespace Magenest\Blog\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magenest\Blog\Model\ResourceModel\Blog\CollectionFactory;
use Magento\Framework\Controller\Result\RawFactory;

class Index extends Action
{
    protected $collectionFactory;
    protected $resultRawFactory;

    public function __construct(
        Context           $context,
        CollectionFactory $collectionFactory,
        RawFactory        $resultRawFactory
    )
    {
        $this->collectionFactory = $collectionFactory;
        $this->resultRawFactory = $resultRawFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $collection = $this->collectionFactory->create();
        $resultRaw = $this->resultRawFactory->create();

        if ($collection->getSize() === 0) {
            return $resultRaw->setContents('No blog posts found.');
        }

        $html = '<h1>All Blog Posts</h1><ul>';

        foreach ($collection as $blog) {
            $author = $blog->getAuthor();
            $authorName = $author ? $author->getUsername() : 'Unknown';

            $html .= '<li>';
            $html .= '<strong>' . $blog->getTitle() . '</strong>';
            $html .= ' by ' . $authorName . '<br/>';
            $html .= 'URL: ' . $blog->getUrlRewrite() . '<br/>';
            $html .= '</li><hr>';
        }

        $html .= '</ul>';

        return $resultRaw->setContents($html);
    }
}
