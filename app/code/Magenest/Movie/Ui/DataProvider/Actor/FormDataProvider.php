<?php

namespace Magenest\Movie\Ui\DataProvider\Actor;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Magenest\Movie\Model\ResourceModel\Actor\CollectionFactory;
use Magento\Framework\App\RequestInterface;

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
        $id = $this->request->getParam($this->requestFieldName);

        if ($id) {
            $movie = $this->collection->getItemById($id);
            if ($movie) {
                // Đẩy dữ liệu vào scope `data`
                $data[$id]['data'] = $movie->getData();
            }
        }

        return $data;
    }
}
