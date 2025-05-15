<?php

namespace Magenest\KnockoutJs\Block;

use Magento\Framework\View\Element\Template;

class ButtonList extends Template
{

    public function __construct(
        Template\Context $context,
        array            $data = []
    )
    {
        parent::__construct($context, $data);

    }

    public function getMovieData()
    {
        return [];
    }
}
