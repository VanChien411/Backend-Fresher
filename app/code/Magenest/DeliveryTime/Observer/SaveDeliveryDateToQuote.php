<?php

namespace Magenest\DeliveryTime\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\App\RequestInterface;

class SaveDeliveryDateToQuote implements ObserverInterface
{
    protected $checkoutSession;
    protected $request;

    public function __construct(
        CheckoutSession  $checkoutSession,
        RequestInterface $request
    )
    {
        $this->checkoutSession = $checkoutSession;
        $this->request = $request;
    }

    public function execute(Observer $observer)
    {
        $deliveryType = $this->request->getParam('delivery_type');
        $deliveryDate = $this->request->getParam('delivery_date');
        $quote = $this->checkoutSession->getQuote();

        if ($deliveryType === 'same_day') {
            $quote->setDeliveryDate(date('Y-m-d'));
        } elseif ($deliveryType === 'custom_date' && $deliveryDate) {
            $quote->setDeliveryDate($deliveryDate);
        } else {
            $quote->setDeliveryDate(null);
        }

        $quote->save();
    }
}