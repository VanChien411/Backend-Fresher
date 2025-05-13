<?php
namespace Magenest\Movie\Controller\Adminhtml\Actor\Save;

/**
 * Interceptor class for @see \Magenest\Movie\Controller\Adminhtml\Actor\Save
 */
class Interceptor extends \Magenest\Movie\Controller\Adminhtml\Actor\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magenest\Movie\Model\ActorFactory $actorFactory)
    {
        $this->___init();
        parent::__construct($context, $actorFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        return $pluginInfo ? $this->___callPlugins('execute', func_get_args(), $pluginInfo) : parent::execute();
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'dispatch');
        return $pluginInfo ? $this->___callPlugins('dispatch', func_get_args(), $pluginInfo) : parent::dispatch($request);
    }
}
