<?php

namespace Magenest\B2BBanner\Block\Header;

use Magento\Framework\View\Element\Template;
use Magento\Customer\Model\Session;

class B2BInfo extends Template
{
    protected $customerSession;

    public function __construct(
        Template\Context $context,
        Session          $customerSession,
        array            $data = []
    )
    {
        $this->customerSession = $customerSession;
        parent::__construct($context, $data);
    }

    public function getLabel()
    {
        if ($this->customerSession->isLoggedIn()) {
            $isB2B = $this->customerSession->getCustomer()->getData('is_b2b');
            return $isB2B ? '(B2B)' : '(Tài khoản thường)';
        }

        return '';
    }
}

