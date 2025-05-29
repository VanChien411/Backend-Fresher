<?php

namespace Magenest\Banner\Model\DataProvider\Banner;

use Magenest\Banner\Model\ResourceModel\Banner\CollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

class FormDataProvider extends AbstractDataProvider
{
    protected $collection;
    protected $loadedData;
    protected $request;
    protected $urlBuilder;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        RequestInterface $request,
        UrlInterface $urlBuilder,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $collectionFactory->create();
        $this->request = $request;
        $this->urlBuilder = $urlBuilder;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        $data = [];
        $bannerId = $this->request->getParam($this->requestFieldName);

        if ($bannerId) {
            $banner = $this->collection->getItemById($bannerId);
            if ($banner) {
                $bannerData = $banner->getData();

                // Format lại phần 'image' nếu có ảnh
                if (!empty($bannerData['image'])) {
                    $imagePath = $bannerData['image'];
                    $bannerData['image'] = [[
                        'name' => basename($imagePath),
                        'url' => $imagePath,
                        'type' => 'image',
                    ]];
                }

                $data[$bannerId]['data'] = $bannerData;
            }
        }

        return $data;
    }
}
