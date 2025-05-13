<?php

namespace Magenest\Movie\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Cache\Manager as CacheManager;
use Psr\Log\LoggerInterface;

class ChangePingToPong implements ObserverInterface
{
    protected $configWriter;
    protected $scopeConfig;
    protected $cacheManager;
    protected $logger;

    public function __construct(
        WriterInterface $configWriter,
        ScopeConfigInterface $scopeConfig,
        CacheManager $cacheManager,
        LoggerInterface $logger
    ) {
        $this->configWriter = $configWriter;
        $this->scopeConfig = $scopeConfig;
        $this->cacheManager = $cacheManager;
        $this->logger = $logger;
    }

    public function execute(Observer $observer)
    {
        try {
            // Lấy giá trị config đã được lưu
            $currentValue = $this->scopeConfig->getValue(
                'movie/general/movie_text',
                ScopeConfigInterface::SCOPE_TYPE_DEFAULT
            );

            if ($currentValue === 'Ping') {
                // Lưu giá trị mới là Pong
                $this->configWriter->save(
                    'movie/general/movie_text',
                    'Pong',
                    ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
                    0
                );

                // Xóa cache configuration
                $this->cacheManager->clean(['config']);
            } else {
                $this->logger->info('Config value is not Ping, no change made.');
            }
        } catch (\Exception $e) {
            $this->logger->error('Error saving config: ' . $e->getMessage());
        }
    }
}
