<?php

namespace Magenest\Movie\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

class ChangeCustomerName implements ObserverInterface
{
    public function execute(Observer $observer)
    {
        $customer = $observer->getCustomer();
        $customer->setFirstname("Magenest");
    }
}
