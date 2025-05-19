<?php

namespace Magenest\Movie\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class MovieActions extends Column
{
    const MOVIE_URL_PATH_EDIT = 'movie/movie/edit';
    const MOVIE_URL_PATH_DELETE = 'movie/movie/delete';

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
            foreach ($dataSource['data']['items'] as &$item) {
                $name = $this->getData('name');
                if (isset($item['movie_id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl(self::MOVIE_URL_PATH_EDIT, ['movie_id' => $item['movie_id']]),
                        'label' => __('Edit')
                    ];
                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(self::MOVIE_URL_PATH_DELETE, ['movie_id' => $item['movie_id']]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete "${ $.$data.name }"'),
                            'message' => __('Are you sure you want to delete "${ $.$data.name }" record?')
                        ]
                    ];
                }
            }
        }
        return $dataSource;
    }
}