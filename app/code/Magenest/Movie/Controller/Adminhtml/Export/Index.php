<?php

namespace Magenest\Movie\Controller\Adminhtml\Export;

use Magento\Backend\App\Action;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory as OrderCollectionFactory;

class Index extends Action
{
    protected $fileFactory;
    protected $orderCollectionFactory;

    public function __construct(
        Action\Context         $context,
        FileFactory            $fileFactory,
        OrderCollectionFactory $orderCollectionFactory
    )
    {
        $this->fileFactory = $fileFactory;
        $this->orderCollectionFactory = $orderCollectionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        // Lấy danh sách đơn hàng
        $orderCollection = $this->orderCollectionFactory->create();
        $orderCollection->addFieldToSelect(['increment_id', 'created_at', 'customer_email', 'grand_total']);

        // Chuẩn bị dữ liệu cho CSV
        $csvData = [];
        $csvData[] = [
            'ID', 'Purchaser', 'Purchase Date', 'Brand', 'Ref Code', 'Product Name', 'Product Qty', 'Unit Price', 'Grand Total (Base)'
        ];

        foreach ($orderCollection as $order) {
            foreach ($order->getAllVisibleItems() as $item) {
                $csvData[] = [
                    $order->getIncrementId(),
                    'Main Website', // Purchaser
                    $order->getCreatedAt(),
                    'MLB', // Brand (giả sử là MLB, bạn có thể thay đổi logic)
                    '32SHH2011-50L', // Ref Code (giả sử, bạn có thể lấy từ dữ liệu thực tế)
                    $item->getName(),
                    $item->getQtyOrdered(),
                    $item->getPrice(),
                    $order->getGrandTotal()
                ];
            }
        }

        // Tạo nội dung CSV
        $fileName = 'orders_export_' . date('Ymd_His') . '.csv';
        $content = '';
        foreach ($csvData as $row) {
            $content .= implode(',', $row) . "\n";
        }

        // Xuất file CSV
        return $this->fileFactory->create(
            $fileName,
            $content,
            DirectoryList::VAR_DIR,
            'text/csv'
        );
    }
}