<?php

namespace Magenest\Blog\Model\DataProvider\Blog;

use Magenest\Blog\Model\ResourceModel\Blog\CollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

class FormDataProvider extends AbstractDataProvider
{
    protected $collection;
    protected $loadedData;
    protected $request;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        RequestInterface $request,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->request = $request;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        $data = [];
        $blogId = $this->request->getParam($this->requestFieldName);

        if ($blogId) {
            $blog = $this->collection->getItemById($blogId);
            if ($blog) {
                $data[$blogId]['data'] = $blog->getData();
            }
        }

        return $data;
    }
}
