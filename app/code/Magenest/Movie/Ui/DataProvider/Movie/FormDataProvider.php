<?php

namespace Magenest\Movie\Ui\DataProvider\Movie;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Magenest\Movie\Model\ResourceModel\Movie\CollectionFactory;
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
        $movieId = $this->request->getParam($this->requestFieldName);

        if ($movieId) {
            $movie = $this->collection->getItemById($movieId);
            if ($movie) {
                // Đẩy dữ liệu vào scope `data`
                $data[$movieId]['data'] = $movie->getData();
            }
        }

        return $data;
    }

}
