<?php
namespace Magento\Customer\Controller\Account\EditPost;

/**
 * Interceptor class for @see \Magento\Customer\Controller\Account\EditPost
 */
class Interceptor extends \Magento\Customer\Controller\Account\EditPost implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\Session $customerSession, \Magento\Customer\Api\AccountManagementInterface $accountManagement, \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository, \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator, \Magento\Customer\Model\CustomerExtractor $customerExtractor, ?\Magento\Framework\Escaper $escaper = null, ?\Magento\Customer\Model\AddressRegistry $addressRegistry = null, ?\Magento\Framework\Filesystem $filesystem = null, ?\Magento\Customer\Api\SessionCleanerInterface $sessionCleaner = null, ?\Magento\Customer\Model\AccountConfirmation $accountConfirmation = null, ?\Magento\Customer\Model\Url $customerUrl = null)
    {
        $this->___init();
        parent::__construct($context, $customerSession, $accountManagement, $customerRepository, $formKeyValidator, $customerExtractor, $escaper, $addressRegistry, $filesystem, $sessionCleaner, $accountConfirmation, $customerUrl);
    }

    /**
     * {@inheritdoc}
     */
    public function createCsrfValidationException(\Magento\Framework\App\RequestInterface $request) : ?\Magento\Framework\App\Request\InvalidRequestException
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'createCsrfValidationException');
        return $pluginInfo ? $this->___callPlugins('createCsrfValidationException', func_get_args(), $pluginInfo) : parent::createCsrfValidationException($request);
    }

    /**
     * {@inheritdoc}
     */
    public function validateForCsrf(\Magento\Framework\App\RequestInterface $request) : ?bool
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'validateForCsrf');
        return $pluginInfo ? $this->___callPlugins('validateForCsrf', func_get_args(), $pluginInfo) : parent::validateForCsrf($request);
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

    /**
     * {@inheritdoc}
     */
    public function getActionFlag()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getActionFlag');
        return $pluginInfo ? $this->___callPlugins('getActionFlag', func_get_args(), $pluginInfo) : parent::getActionFlag();
    }

    /**
     * {@inheritdoc}
     */
    public function getRequest()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getRequest');
        return $pluginInfo ? $this->___callPlugins('getRequest', func_get_args(), $pluginInfo) : parent::getRequest();
    }

    /**
     * {@inheritdoc}
     */
    public function getResponse()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getResponse');
        return $pluginInfo ? $this->___callPlugins('getResponse', func_get_args(), $pluginInfo) : parent::getResponse();
    }
}
