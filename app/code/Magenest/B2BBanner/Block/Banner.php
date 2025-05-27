<?php

namespace Magenest\B2BBanner\Block;

use Magento\Framework\App\Http\Context;
use Magento\Customer\Model\Session;
use Magento\Customer\Model\Context as CustomerContext;
use Magento\Framework\View\Element\Template;


class Banner extends Template
{
    protected $httpContext;
    protected $customerSession;

    public function __construct(
        Template\Context $context,
        Context          $httpContext,
        Session          $customerSession,
        array            $data = []
    )
    {
        $this->httpContext = $httpContext;
        $this->customerSession = $customerSession;
        parent::__construct($context, $data);
    }

    public function canShowBanner()
    {
        $isLoggedIn = $this->httpContext->getValue(CustomerContext::CONTEXT_AUTH);

        if ($isLoggedIn && $this->customerSession->getCustomerId()) {
            $customer = $this->customerSession->getCustomer();
            return (bool)$customer->getData('is_b2b');
        }

        return false;
    }
}
