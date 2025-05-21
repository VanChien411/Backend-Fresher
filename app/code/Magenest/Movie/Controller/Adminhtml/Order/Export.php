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
        $csvData[] = ['Order ID', 'Customer Name', 'Grand Total', 'Status', 'Created At'];

        foreach ($collection as $order) {
            $csvData[] = [
                $order->getIncrementId(),
                $order->getCustomerName(),
                $order->getGrandTotal(),
                $order->getStatus(),
                $order->getCreatedAt()
            ];
        }

        // Create CSV file
        $content = '';
        foreach ($csvData as $row) {
            $content .= implode(',', $row) . "\n";
        }

        // Return file for download
        return $this->fileFactory->create(
            'orders_export_' . date('Ymd_His') . '.csv',
            $content,
            DirectoryList::VAR_DIR,
            'text/csv'
        );
    }
}