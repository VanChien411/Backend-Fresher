<?php

namespace Magenest\Banner\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class GenericActions extends Column
{
    protected $urlBuilder;

    public function __construct(
        ContextInterface   $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface       $urlBuilder,
        array              $components = [],
        array              $data = []
    )
    {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $indexField = $this->getData('config/indexField') ?: 'id';
            foreach ($dataSource['data']['items'] as &$item) {
                $name = $this->getData('name');
                if (isset($item[$indexField])) {
                    // Hành động Edit
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl(
                            $this->getData('config/editUrl') ?: '*/edit',
                            [$indexField => $item[$indexField]]
                        ),
                        'label' => __('Edit'),
                        'hidden' => false,
                    ];
                    // Hành động Delete (tùy chọn)
                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(
                            $this->getData('config/deleteUrl') ?: '*/delete',
                            [$indexField => $item[$indexField]]
                        ),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete'),
                            'message' => __('Are you sure you want to delete this record?')
                        ],
                        'hidden' => false,
                    ];
                }
            }
        }
        return $dataSource;
    }
}