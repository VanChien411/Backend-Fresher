<?php

namespace Magenest\Course\Ui\DataProvider\Product\Form\Modifier;

use Magento\Ui\DataProvider\Modifier\ModifierInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\App\ResourceConnection;

class ReferenceMaterial implements ModifierInterface
{
    protected $resource;

    public function __construct(ResourceConnection $resource)
    {
        $this->resource = $resource;
    }

    public function modifyData(array $data)
    {
        $productId = array_key_first($data);
        $connection = $this->resource->getConnection();
        $table = $this->resource->getTableName('magenest_course_reference');

        $select = $connection->select()
            ->from($table)
            ->where('product_id = ?', $productId);

        $rows = $connection->fetchAll($select);

        $data[$productId]['product']['reference_rows'] = $rows;

        return $data;
    }

    public function modifyMeta(array $meta)
    {
        return $this->addReferenceMaterialFields($meta);
    }

    private function addReferenceMaterialFields(array $meta): array
    {
        $meta['reference_materials'] = [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Reference Materials'),
                        'componentType' => 'fieldset',
                        'collapsible' => true,
                        'sortOrder' => 50,
                    ],
                ],
            ],
            'children' => [
                'reference_rows' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => 'dynamicRows',
                                'label' => false,
                                'component' => 'Magento_Ui/js/dynamic-rows/dynamic-rows',
                                'recordTemplate' => 'record',
                                'dataScope' => 'reference_rows',
                                'addButtonLabel' => __('Add'),
                                'deleteButtonLabel' => __('Delete'),
                                'columnsHeader' => true,
                                'sortOrder' => 10,
                            ],
                        ],
                    ],
                    'children' => [
                        'record' => [
                            'arguments' => [
                                'data' => [
                                    'config' => [
                                        'componentType' => 'container',
                                        'isTemplate' => true,
                                        'is_collection' => true,
                                        'component' => 'Magento_Ui/js/dynamic-rows/record',
                                        'dataScope' => '',
                                    ],
                                ],
                            ],
                            'children' => [
                                'label' => [
                                    'arguments' => [
                                        'data' => [
                                            'config' => [
                                                'dataType' => 'text',
                                                'formElement' => 'input',
                                                'componentType' => 'field',
                                                'label' => __('Label'),
                                                'dataScope' => 'label',
                                            ],
                                        ],
                                    ],
                                ],
                                'type' => [
                                    'arguments' => [
                                        'data' => [
                                            'config' => [
                                                'dataType' => 'text',
                                                'formElement' => 'select',
                                                'componentType' => 'field',
                                                'label' => __('Type'),
                                                'dataScope' => 'type',
                                                'options' => [
                                                    ['label' => __('Link'), 'value' => 'link'],
                                                    ['label' => __('Hình ảnh'), 'value' => 'image'],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                                'value' => [
                                    'arguments' => [
                                        'data' => [
                                            'config' => [
                                                'dataType' => 'text',
                                                'formElement' => 'input',
                                                'componentType' => 'field',
                                                'label' => __('Link'),
                                                'dataScope' => 'value',
                                                'imports' => [
                                                    'visible' => '${ $.parentName }.type:value == link',
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                                'image_upload' => [
                                    'arguments' => [
                                        'data' => [
                                            'config' => [
                                                'dataType' => 'text',
                                                'formElement' => 'fileUploader',
                                                'componentType' => 'field',
                                                'label' => __('Image Upload'),
                                                'dataScope' => 'image_upload',
                                                'uploaderConfig' => [
                                                    'url' => 'your_module/image/upload',
                                                ],
                                                'imports' => [
                                                    'visible' => '${ $.parentName }.type:value == image',
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        return $meta;
    }
}
