<?php
namespace Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\General;

/**
 * Interceptor class for @see \Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\General
 */
class Interceptor extends \Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\General implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Model\Locator\LocatorInterface $locator, \Magento\Framework\Stdlib\ArrayManager $arrayManager, ?\Magento\Eav\Api\AttributeRepositoryInterface $attributeRepository = null)
    {
        $this->___init();
        parent::__construct($locator, $arrayManager, $attributeRepository);
    }

    /**
     * {@inheritdoc}
     */
    public function modifyMeta(array $meta)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'modifyMeta');
        return $pluginInfo ? $this->___callPlugins('modifyMeta', func_get_args(), $pluginInfo) : parent::modifyMeta($meta);
    }
}
