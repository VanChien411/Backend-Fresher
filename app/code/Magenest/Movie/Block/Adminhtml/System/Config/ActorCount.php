<?php

namespace Magenest\Movie\Block\Adminhtml\System\Config;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magenest\Movie\Model\ResourceModel\Actor\CollectionFactory as ActorCollectionFactory;

class ActorCount extends Field
{
    protected $actorCollectionFactory;

    public function __construct(
        ActorCollectionFactory $actorCollectionFactory,
        \Magento\Backend\Block\Template\Context $context,
        array $data = []
    ) {
        $this->actorCollectionFactory = $actorCollectionFactory;
        parent::__construct($context, $data);
    }

    protected function _getElementHtml(AbstractElement $element)
    {
        $collection = $this->actorCollectionFactory->create();
        $count = $collection->getSize();

        return "<div> <strong>{$count}</strong></div>";
    }
}
