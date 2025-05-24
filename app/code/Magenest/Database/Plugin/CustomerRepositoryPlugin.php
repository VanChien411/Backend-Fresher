<?php

namespace Magenest\Database\Plugin;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Exception\LocalizedException;

class CustomerRepositoryPlugin
{
    public function beforeSave(
        \Magento\Customer\Api\CustomerRepositoryInterface $subject,
        CustomerInterface                                 $customer
    )
    {
        $telephoneAttr = $customer->getCustomAttribute('telephone');

        if ($telephoneAttr) {
            $value = $telephoneAttr->getValue();

            // Convert +84 to 0 nếu cần
            if (strpos($value, '+84') === 0) {
                $value = '0' . substr($value, 3);
            }

            // Kiểm tra: phải có 10 chữ số và bắt đầu bằng 0
            if (!preg_match('/^0[0-9]{9}$/', $value)) {
                throw new LocalizedException(__('Please enter a valid telephone number starting with 0 and exactly 10 digits.'));
            }

            // Cập nhật lại giá trị đã xử lý
            $customer->setCustomAttribute('telephone', $value);
        }

        return [$customer];
    }
}
