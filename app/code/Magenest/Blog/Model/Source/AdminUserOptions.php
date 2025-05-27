<?php

namespace Magenest\Blog\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\User\Model\ResourceModel\User\CollectionFactory;

class AdminUserOptions implements OptionSourceInterface
{
    protected $userCollectionFactory;

    public function __construct(
        CollectionFactory $userCollectionFactory
    ) {
        $this->userCollectionFactory = $userCollectionFactory;
    }

    public function toOptionArray()
    {
        $collection = $this->userCollectionFactory->create();
        $options = [];

        foreach ($collection as $user) {
            $options[] = [
                'value' => $user->getId(),
                'label' => $user->getUsername() . ' (' . $user->getEmail() . ')'
            ];
        }

        return $options;
    }
}
