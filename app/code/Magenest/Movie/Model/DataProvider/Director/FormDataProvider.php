<?php

namespace Magenest\Movie\Model\DataProvider\Director;

use Magenest\Movie\Model\ResourceModel\Director\CollectionFactory;
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
    )
    {
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
