<?php

namespace Magenest\Movie\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Framework\Stdlib\ArrayManager;

class HideOriginalFields extends AbstractModifier
{
    /**
     * @var ArrayManager
     */
    private $arrayManager;

    /**
     * @param ArrayManager $arrayManager
     */
    public function __construct(
        ArrayManager $arrayManager
    )
    {
        $this->arrayManager = $arrayManager;
    }

    public function modifyMeta(array $meta)
    {
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/debug.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);

        $logger->info('Modifier is being executed');
        $logger->info('Meta keys: ' . implode(', ', array_keys($meta)));

        // Try to hide fields in the online-course-info fieldset
        if (isset($meta['online-course-info'])) {
            $meta['online-course-info']['children']['online_course_start']['arguments']['data']['config']['visible'] = false;
            $meta['online-course-info']['children']['online_course_end']['arguments']['data']['config']['visible'] = false;
            $logger->info('Fields should be hidden in online-course-info');
        }

        // Also try to hide fields in product-details if they exist there
        if (isset($meta['product-details'])) {
            if (isset($meta['product-details']['children']['container_online_course_start'])) {
                $meta['product-details']['children']['container_online_course_start']['arguments']['data']['config']['visible'] = false;
            }
            if (isset($meta['product-details']['children']['container_online_course_end'])) {
                $meta['product-details']['children']['container_online_course_end']['arguments']['data']['config']['visible'] = false;
            }
            $logger->info('Fields should be hidden in product-details');
        }

        return $meta;
    }

    public function modifyData(array $data)
    {
        return $data;
    }
}
