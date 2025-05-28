<?php

namespace Magenest\DeliveryTime\Block;

use Magento\Framework\View\Element\Template;
use Magento\Checkout\Model\Session as CheckoutSession;

class Cart extends Template
{
    protected $checkoutSession;

    public function __construct(
        Template\Context $context,
        CheckoutSession  $checkoutSession,
        array            $data = []
    )
    {
        $this->checkoutSession = $checkoutSession;
        parent::__construct($context, $data);
    }

    public function getDeliveryDate()
    {
        $quote = $this->getQuote();
        return $quote->getDeliveryDate() ? $quote->getDeliveryDate() : null;
    }

    public function getQuote()
    {
        return $this->checkoutSession->getQuote();
    }
}