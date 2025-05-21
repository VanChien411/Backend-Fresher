<?php

namespace Magenest\Movie\Plugin;

use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\General;
use function PHPUnit\Framework\equalTo;

class HideProductAttributes
{
    /**
     * @var array
     */
    private $fieldsToHide = [
        'container_online_course_end',
        'container_online_course_start'
    ];


    public function __construct()
    {

    }

    /**
     * After plugin to modify meta data and hide specific fields
     *
     * @param General $subject
     * @param array $meta
     * @return array
     */
    public function afterModifyMeta(General $subject, array $meta)
    {
        $groupCode = 'online-course-info';  // Make sure this matches the attribute group code

        if (isset($meta[$groupCode]['children'])) {
            foreach ($this->fieldsToHide as $fieldCode) {
                if (isset($meta[$groupCode]['children'][$fieldCode])) {
                    if ($fieldCode == "container_online_course_start") {
                        $meta[$groupCode]['children'][$fieldCode]['children']['online_course_start']['arguments']['data']['config']['visible'] = false;
                        $meta[$groupCode]['children'][$fieldCode]['arguments']['online_course_start']['data']['config']['disabled'] = true;
                    } else if ($fieldCode == "container_online_course_end") {
                        $meta[$groupCode]['children'][$fieldCode]['children']['online_course_end']['arguments']['data']['config']['visible'] = false;
                        $meta[$groupCode]['children'][$fieldCode]['arguments']['online_course_end']['data']['config']['disabled'] = true;
                    } else {
                        $meta[$groupCode]['children'][$fieldCode]['arguments']['data']['config']['visible'] = false;
                        $meta[$groupCode]['children'][$fieldCode]['arguments']['data']['config']['disabled'] = true;
                    }
                }
            }
        } else {
            $this->logger->info('Group not found: ' . $groupCode);
        }

        return $meta;
    }
}
