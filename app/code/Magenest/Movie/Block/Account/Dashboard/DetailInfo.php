<?php

namespace Magenest\Movie\Block\Account\Dashboard;

use Magento\Customer\Model\Session;
use Magento\Framework\View\Element\Template;

class DetailInfo extends Template
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

    public function getCustomerImageUrl()
    {
        $customer = $this->getCustomer();

        if ($customer && $customer->getAvatar()) {
            $filename = $customer->getAvatar(); // ví dụ: 'test.png'
            $mediaUrl = $this->_urlBuilder->getBaseUrl(['_type' => \Magento\Framework\UrlInterface::URL_TYPE_MEDIA]);

            return $mediaUrl . 'customer/' . ltrim($filename, '/');
        }

        // Trả về ảnh mặc định nếu không có ảnh
        return $this->getViewFileUrl('Magento_Customer::images/avatar.png');
    }


    public function getCustomer()
    {
        if ($this->customerSession->isLoggedIn()) {
            return $this->customerSession->getCustomer();
        }
        return null;
    }
}