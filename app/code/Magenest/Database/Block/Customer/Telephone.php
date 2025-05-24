<?php

namespace Magenest\Database\Block\Customer;

use Magento\Framework\View\Element\Template;
use Magento\Customer\Model\Session;

class Telephone extends Template
{
    protected $customerSession;

    public function __construct(
        Template\Context $context,
        Session $customerSession,
        array $data = []
    ) {
        $this->customerSession = $customerSession;
        parent::__construct($context, $data);
    }

    public function getCustomer()
    {
        return $this->customerSession->getCustomer();
    }
}
