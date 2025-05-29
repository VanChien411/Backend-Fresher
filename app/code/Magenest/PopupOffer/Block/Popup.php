<?php

namespace Magenest\PopupOffer\Block;

use Magento\Framework\View\Element\Template;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Popup extends Template
{
    const XML_PATH = 'popup_offer/offers/customer_group_offers'; // Đường dẫn đúng nếu bạn dùng dynamic row
    protected $customerSession;
    protected $scopeConfig;

    public function __construct(
        Template\Context     $context,
        Session              $customerSession,
        ScopeConfigInterface $scopeConfig,
        array                $data = []
    )
    {
        $this->customerSession = $customerSession;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }

    public function getOfferMessage()
    {
        if (!$this->customerSession->isLoggedIn()) {
            return null; // Chỉ hiển thị cho khách hàng đã đăng nhập
        }

        $groupId = $this->customerSession->getCustomer()->getData("group_id");
        $json = $this->scopeConfig->getValue(self::XML_PATH);

        if (!$json) {
            return null;
        }

        $offers = json_decode($json, true);
        if (!is_array($offers)) {
            return null;
        }

        foreach ($offers as $offer) {
            if (isset($offer['customer_group_id']) && $offer['customer_group_id'] == $groupId) {
                return $offer['message'] ?? null;
            }
        }

        return null;
    }

    public function getCustomerGroupId()
    {
        return $this->customerSession->getCustomer()->getData("group_id");
    }

}
