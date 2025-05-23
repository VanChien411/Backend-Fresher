<?php

declare(strict_types=1);

namespace Laminas\View\Helper;

use Laminas\View\Exception\InvalidArgumentException;

use function array_merge;
use function implode;
use function is_array;
use function is_string;

use const PHP_EOL;

/** @final */
class HtmlObject extends AbstractHtmlElement
{
    /**
     * Output an object set
     *
     * @param  string $data    The data file
     * @param  string $type    Data file type
     * @param  array  $attribs Attribs for the object tag
     * @param  array  $params  Params for in the object tag
     * @param  string|list<string>|null $content Alternative content for object
     * @throws InvalidArgumentException
     * @return string
     */
    public function __invoke(
        $data = null,
        $type = null,
        array $attribs = [],
        array $params = [],
        $content = null
    ) {
        if ($data === null || $type === null) {
            throw new InvalidArgumentException(
                'HTMLObject: missing argument. $data and $type are required in '
                . 'htmlObject($data, $type, array $attribs = array(), array $params = array(), $content = null)'
            );
        }

        // Merge data and type
        $attribs = array_merge(['data' => $data, 'type' => $type], $attribs);

        // Params
        $paramHtml      = [];
        $closingBracket = $this->getClosingBracket();

        foreach ($params as $param => $options) {
            if (is_string($options)) {
                $options = ['value' => $options];
            }

            $options = array_merge(['name' => $param], $options);

            $paramHtml[] = '<param' . $this->htmlAttribs($options) . $closingBracket;
        }

        // Content
        if (is_array($content)) {
            $content = implode(PHP_EOL, $content);
        }

        // Object header
        return '<object' . $this->htmlAttribs($attribs) . '>' . PHP_EOL
                 . implode(PHP_EOL, $paramHtml) . PHP_EOL
                 . ($content ? $content . PHP_EOL : '')
                 . '</object>';
    }
}
