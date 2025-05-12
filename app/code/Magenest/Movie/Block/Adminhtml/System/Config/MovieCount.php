<?php

namespace Magenest\Movie\Block\Adminhtml\System\Config;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magenest\Movie\Model\ResourceModel\Movie\CollectionFactory as MovieCollectionFactory;

class MovieCount extends Field
{
    protected $movieCollectionFactory;

    public function __construct(
        MovieCollectionFactory $movieCollectionFactory,
        \Magento\Backend\Block\Template\Context $context,
        array $data = []
    ) {
        $this->movieCollectionFactory = $movieCollectionFactory;
        parent::__construct($context, $data);
    }

    protected function _getElementHtml(AbstractElement $element)
    {
        $collection = $this->movieCollectionFactory->create();
        $count = $collection->getSize();

        return "<div> <strong>{$count}</strong></div>";
    }
}
