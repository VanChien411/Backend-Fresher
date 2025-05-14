<?php

namespace Magenest\Movie\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

class ResetMovieRating implements ObserverInterface
{
    public function execute(Observer $observer)
    {
        $movie = $observer->getData('movie');
        $movie->setData('rating', 0);
    }
}
