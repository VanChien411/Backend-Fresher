<?php

declare(strict_types=1);

namespace Laminas\View\Helper;

use Laminas\View\Exception;
use Laminas\View\Model\ModelInterface;
use Traversable;

use function func_num_args;
use function get_object_vars;
use function is_object;
use function is_scalar;
use function method_exists;

/**
 * Helper for rendering a template fragment in its own variable scope.
 *
 * @final
 */
class Partial extends AbstractHelper
{
    /**
     * Variable to which object will be assigned
     *
     * @var string
     */
    protected $objectKey;

    /**
     * Renders a template fragment within a variable scope distinct from the
     * calling View object. It proxies to view's render function
     *
     * @param  string|ModelInterface $name   Name of view script, or a view model
     * @param  array|object          $values Variables to populate in the view
     * @throws Exception\RuntimeException
     * @return string|Partial
     */
    public function __invoke($name = null, $values = null)
    {
        if (0 === func_num_args()) {
            return $this;
        }

        // If we were passed only a view model, just render it.
        if ($name instanceof ModelInterface) {
            return $this->getView()->render($name);
        }

        if (is_scalar($values)) {
            $values = [];
        } elseif ($values instanceof ModelInterface) {
            $values = $values->getVariables();
        } elseif (is_object($values)) {
            if (null !== ($objectKey = $this->getObjectKey())) {
                $values = [$objectKey => $values];
            } elseif (method_exists($values, 'toArray')) {
                $values = $values->toArray();
            } elseif (! $values instanceof Traversable) {
                $values = get_object_vars($values);
            }
        }

        return $this->getView()->render($name, $values);
    }

    /**
     * Set object key
     *
     * @param string|null $key
     * @return self
     */
    public function setObjectKey($key)
    {
        if (null === $key) {
            $this->objectKey = null;
            return $this;
        }

        $this->objectKey = (string) $key;

        return $this;
    }

    /**
     * Retrieve object key
     *
     * The objectKey is the variable to which an object in the iterator will be
     * assigned.
     *
     * @return null|string
     */
    public function getObjectKey()
    {
        return $this->objectKey;
    }
}
