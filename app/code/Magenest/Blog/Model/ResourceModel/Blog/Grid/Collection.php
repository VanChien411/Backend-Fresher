<?php

namespace Magenest\Blog\Model\ResourceModel\Blog\Grid;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;
use Psr\Log\LoggerInterface as Logger;
use Magenest\Blog\Model\ResourceModel\Blog as BlogResource;

class Collection extends SearchResult
{
    /**
     * Initialize dependencies.
     *
     * @param EntityFactory $entityFactory
     * @param Logger $logger
     * @param FetchStrategy $fetchStrategy
     * @param EventManager $eventManager
     * @param string $mainTable
     * @param string $resourceModel
     */
    public function __construct(
        EntityFactory $entityFactory,
        Logger        $logger,
        FetchStrategy $fetchStrategy,
        EventManager  $eventManager,
                      $mainTable = 'magenest_blog', // Replace with your actual blog table name
                      $resourceModel = BlogResource::class
    )
    {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $mainTable, $resourceModel);
    }

    /**
     * Get aggregations.
     *
     * @return \Magento\Framework\Api\Search\AggregationInterface
     */
    public function getAggregations()
    {
        return $this->aggregations;
    }

    /**
     * Set aggregations.
     *
     * @param \Magento\Framework\Api\Search\AggregationInterface $aggregations
     * @return $this
     */
    public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
        return $this;
    }

    /**
     * Get search criteria.
     *
     * @return \Magento\Framework\Api\SearchCriteriaInterface|null
     */
    public function getSearchCriteria()
    {
        return null;
    }

    /**
     * Set search criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return $this
     */
    public function setSearchCriteria(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null)
    {
        return $this;
    }

    /**
     * Get total count.
     *
     * @return int
     */
    public function getTotalCount()
    {
        return $this->getSize();
    }

    /**
     * Set total count.
     *
     * @param int $totalCount
     * @return $this
     */
    public function setTotalCount($totalCount)
    {
        return $this;
    }

    /**
     * Set items.
     *
     * @param array|null $items
     * @return $this
     */
    public function setItems(array $items = null)
    {
        return $this;
    }

    /**
     * Initialize select query.
     *
     * @return $this
     */
    protected function _initSelect()
    {
        parent::_initSelect();

        // Join bảng admin_user để lấy thông tin author
        $this->getSelect()->joinLeft(
            ['author_user' => $this->getTable('admin_user')],
            'main_table.author_id = author_user.user_id',
            [
                'author_username' => 'author_user.username',
                'author_email' => 'author_user.email',
                'author_firstname' => 'author_user.firstname',
                'author_lastname' => 'author_user.lastname'
            ]
        );

        // Map columns to main_table for filtering
        $tableDescription = $this->getConnection()->describeTable($this->getMainTable());
        foreach ($tableDescription as $columnInfo) {
            $this->addFilterToMap($columnInfo['COLUMN_NAME'], 'main_table.' . $columnInfo['COLUMN_NAME']);
        }

        // Nếu cần filter các cột từ admin_user thì thêm ở đây
        $this->addFilterToMap('author_username', 'author_user.username');
        $this->addFilterToMap('author_email', 'author_user.email');
        $this->addFilterToMap('author_firstname', 'author_user.firstname');
        $this->addFilterToMap('author_lastname', 'author_user.lastname');

        return $this;
    }

}