<?php

namespace Magenest\PopupOffer\Block\Adminhtml\System\Config\Form\Field;

use Magento\Framework\View\Element\Html\Select;
use Magento\Customer\Model\ResourceModel\Group\CollectionFactory;

class CustomerGroup extends Select
{
    protected $groupCollectionFactory;

    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        CollectionFactory                       $groupCollectionFactory,
        array                                   $data = []
    )
    {
        $this->groupCollectionFactory = $groupCollectionFactory;
        parent::__construct($context, $data);
    }

    public function setInputName($value)
    {
        return $this->setName($value);
    }

    public function _toHtml()
    {
        if (!$this->getOptions()) {
            $groups = $this->groupCollectionFactory->create();
            foreach ($groups as $group) {
                $this->addOption($group->getCustomerGroupId(), $group->getCode());
            }
        }
        return parent::_toHtml();
    }
}
