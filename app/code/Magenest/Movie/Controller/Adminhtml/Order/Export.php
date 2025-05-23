<?php

namespace Magenest\Movie\Controller\Adminhtml\Order;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\App\Filesystem\DirectoryList;

class Export extends Action
{
    protected $orderCollectionFactory;
    protected $fileFactory;

    public function __construct(
        Context           $context,
        CollectionFactory $orderCollectionFactory,
        FileFactory       $fileFactory
    )
    {
        parent::__construct($context);
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->fileFactory = $fileFactory;
    }

    public function execute()
    {
        $selected = $this->getRequest()->getParam('selected', []);
        if (empty($selected)) {
            $this->messageManager->addErrorMessage(__('No orders selected.'));
            return $this->_redirect('sales/order/index');
        }

        // Load order collection based on selected IDs
        $collection = $this->orderCollectionFactory->create()
            ->addFieldToFilter('entity_id', ['in' => $selected]);

        // Prepare CSV content
        $csvData = [];
        $csvData[] = [
            'Order ID', 'Customer Name', 'Order Status', 'Created At',
            'Product SKU', 'Product Name', 'Qty Ordered', 'Price', 'Row Total'
        ];

        foreach ($collection as $order) {
            $orderId = $order->getIncrementId();
            $customerName = $order->getCustomerName();
            $status = $order->getStatus();
            $createdAt = $order->getCreatedAt();

            foreach ($order->getAllVisibleItems() as $item) {
                $csvData[] = [
                    $orderId,
                    $customerName,
                    $status,
                    $createdAt,
                    $item->getSku(),
                    $item->getName(),
                    (int)$item->getQtyOrdered(),
                    number_format($item->getPrice(), 2),
                    number_format($item->getRowTotal(), 2)
                ];
            }
        }

        // Create CSV content
        $content = '';
        foreach ($csvData as $row) {
            $content .= implode(',', $row) . "\n";
        }

        // Return file for download
        return $this->fileFactory->create(
            'order_products_export_' . date('Ymd_His') . '.csv',
            $content,
            DirectoryList::VAR_DIR,
            'text/csv'
        );
    }
}
