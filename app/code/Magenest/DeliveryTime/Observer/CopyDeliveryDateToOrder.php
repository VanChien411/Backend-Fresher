<?php

namespace Magenest\DeliveryTime\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class CopyDeliveryDateToOrder implements ObserverInterface
{
    public function execute(Observer $observer)
    {
        $quote = $observer->getEvent()->getQuote();
        $order = $observer->getEvent()->getOrder();
        $deliveryDate = $quote->getDeliveryDate();
        if ($deliveryDate) {
            $order->setDeliveryDate($deliveryDate);
        }
    }
}