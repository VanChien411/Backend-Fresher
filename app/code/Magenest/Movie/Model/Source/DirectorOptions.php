<?php
namespace Magenest\Movie\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magenest\Movie\Model\ResourceModel\Director\CollectionFactory;

class DirectorOptions implements OptionSourceInterface
{
    protected $collectionFactory;

    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    public function toOptionArray()
    {
        $options = [
            ['value' => '', 'label' => __('Select Director')]
        ];

        $collection = $this->collectionFactory->create();
        foreach ($collection as $director) {
            $options[] = [
                'value' => $director->getDirectorId(),
                'label' => $director->getName()
            ];
        }

        return $options;
    }
}