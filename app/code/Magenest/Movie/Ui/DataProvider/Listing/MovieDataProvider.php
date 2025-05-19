<?php

namespace Magenest\Movie\Ui\DataProvider\Listing;

use Magento\Framework\Api\Filter;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\ReportingInterface;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider;
use Magento\Framework\DB\Select;

class MovieDataProvider extends DataProvider
{
    /**
     * @var ResourceConnection
     */
    protected $resource;

    /**
     * @var \Magento\Framework\DB\Adapter\AdapterInterface
     */
    protected $connection;

    /**
     * @var ClpHelper
     */
    protected $clpHelper;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        ReportingInterface $reporting,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        RequestInterface $request,
        FilterBuilder $filterBuilder,
        ResourceConnection $resource,
        array $meta = [],
        array $data = []
    )
    {
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $reporting,
            $searchCriteriaBuilder,
            $request,
            $filterBuilder,
            $meta,
            $data
        );
        $this->resource = $resource;
        $this->connection = $resource->getConnection();
    }

    /**
     * Get data for UI component
     *
     * @return array
     */
    public function getData(): array
    {
        $collection = $this->getSearchResult();

        $data = [
            'totalRecords' => $collection->getTotalCount(),
            'items' => []
        ];

        foreach ($collection->getItems() as $item) {
            $itemData = $item->getData();

            $data['items'][] = $itemData;
        }

        return $data;
    }


    /**
     * Add order to collection
     *
     * @param string $field
     * @param string $direction
     * @return void
     */
    public function addOrder($field, $direction)
    {
        // Map UI column to database column if needed
        $fieldMapping = [
            'director_name' => 'director.name'
        ];
        $dbField = $fieldMapping[$field] ?? $field;

        // Add primary sort
        parent::addOrder($dbField, $direction);

        // Add movie_id as secondary sort for stable sorting
        if ($field !== 'movie_id') {
            $this->getCollection()->getSelect()->order('main_table.movie_id ' . Select::SQL_ASC);
        }
    }
}