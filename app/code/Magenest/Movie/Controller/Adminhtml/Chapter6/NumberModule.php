<?php

namespace Magenest\Movie\Controller\Adminhtml\Chapter6;

use Magento\Backend\Block\Template;
use Magento\Framework\Module\ModuleListInterface;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory as CustomerCollectionFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory as OrderCollectionFactory;
use Magento\Sales\Model\ResourceModel\Order\Invoice\CollectionFactory as InvoiceCollectionFactory;
use Magento\Sales\Model\ResourceModel\Order\Creditmemo\CollectionFactory as CreditmemoCollectionFactory;

class NumberModule extends Template
{
    protected $moduleList;
    protected $customerFactory;
    protected $productFactory;
    protected $orderFactory;
    protected $invoiceFactory;
    protected $creditmemoFactory;

    public function __construct(
        Template\Context            $context,
        ModuleListInterface         $moduleList,
        CustomerCollectionFactory   $customerFactory,
        ProductCollectionFactory    $productFactory,
        OrderCollectionFactory      $orderFactory,
        InvoiceCollectionFactory    $invoiceFactory,
        CreditmemoCollectionFactory $creditmemoFactory,
        array                       $data = []
    )
    {
        parent::__construct($context, $data);
        $this->moduleList = $moduleList;
        $this->customerFactory = $customerFactory;
        $this->productFactory = $productFactory;
        $this->orderFactory = $orderFactory;
        $this->invoiceFactory = $invoiceFactory;
        $this->creditmemoFactory = $creditmemoFactory;
    }

    public function getModuleStats()
    {
        $allModules = $this->moduleList->getAll();
        $magento = 0;
        $others = 0;

        foreach ($allModules as $name => $module) {
            if (strpos($name, 'Magento_') === 0) {
                $magento++;
            } else {
                $others++;
            }
        }

        return [
            'total' => $magento + $others,
            'magento' => $magento,
            'others' => $others,
        ];
    }

    public function getEntityCounts()
    {
        return [
            'customers' => $this->customerFactory->create()->getSize(),
            'products' => $this->productFactory->create()->getSize(),
            'orders' => $this->orderFactory->create()->getSize(),
            'invoices' => $this->invoiceFactory->create()->getSize(),
            'creditmemos' => $this->creditmemoFactory->create()->getSize(),
        ];
    }
}
