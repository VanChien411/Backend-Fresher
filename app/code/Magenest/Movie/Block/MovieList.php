<?php

namespace Magenest\Movie\Block;

use Magento\Framework\View\Element\Template;
use Magenest\Movie\Model\ResourceModel\Movie\CollectionFactory as MovieCollectionFactory;
use Magenest\Movie\Model\ResourceModel\MovieActor\CollectionFactory as MovieActorCollectionFactory;
use Magenest\Movie\Model\ActorFactory;
use Magenest\Movie\Model\DirectorFactory;

class MovieList extends Template
{
    protected $movieCollectionFactory;
    protected $movieActorCollectionFactory;
    protected $actorFactory;
    protected $directorFactory;

    public function __construct(
        Template\Context $context,
        MovieCollectionFactory $movieCollectionFactory,
        MovieActorCollectionFactory $movieActorCollectionFactory,
        ActorFactory $actorFactory,
        DirectorFactory $directorFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->movieCollectionFactory = $movieCollectionFactory;
        $this->movieActorCollectionFactory = $movieActorCollectionFactory;
        $this->actorFactory = $actorFactory;
        $this->directorFactory = $directorFactory;
    }

    public function getMovieData()
    {
        $collection = $this->movieCollectionFactory->create();
        $movies = [];

        foreach ($collection as $movie) {
            // Get director name
            $director = $this->directorFactory->create()->load($movie->getDirectorId());

            // Get actor IDs from junction table
            $actorCollection = $this->movieActorCollectionFactory->create()
                ->addFieldToFilter('movie_id', $movie->getId());

            $actorNames = [];
            foreach ($actorCollection as $relation) {
                $actor = $this->actorFactory->create()->load($relation->getActorId());
                $actorNames[] = $actor->getName();
            }

            $movies[] = [
                'name' => $movie->getName(),
                'director' => $director->getName(),
                'rating' => $movie->getRating(),
                'description' => $movie->getDescription(),
                'actors' => implode(', ', $actorNames)
            ];
        }

        return $movies;
    }
}
