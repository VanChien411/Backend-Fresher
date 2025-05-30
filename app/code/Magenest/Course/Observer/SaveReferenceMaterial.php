<?php

namespace Magenest\Course\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResourceConnection;

class SaveReferenceMaterial implements ObserverInterface
{
    protected $request;
    protected $resource;

    public function __construct(
        RequestInterface   $request,
        ResourceConnection $resource
    )
    {
        $this->request = $request;
        $this->resource = $resource;
    }

    public function execute(Observer $observer)
    {
        $product = $observer->getEvent()->getProduct();
        $postData = $this->request->getPostValue();

        if (!isset($postData['product']['reference_rows'])) {
            return;
        }

        $connection = $this->resource->getConnection();
        $tableName = $this->resource->getTableName('magenest_course_reference');

// Xoá dữ liệu cũ
        $connection->delete($tableName, ['product_id = ?' => $product->getId()]);

        foreach ($postData['product']['reference_rows'] as $row) {
            $connection->insert($tableName, [
                'product_id' => $product->getId(),
                'label' => $row['label'] ?? '',
                'value' => $row['value'] ?? '',
                'type' => $row['type'] ?? '',
            ]);
        }
    }
}
