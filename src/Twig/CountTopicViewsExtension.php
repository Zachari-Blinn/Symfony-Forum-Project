<?php

namespace App\Twig;

use App\Entity\Topic;
use Twig\TwigFunction;
use Twig\Extension\GlobalsInterface;
use Twig\Extension\AbstractExtension;
use Doctrine\ORM\EntityManagerInterface;

class CountTopicViewsExtension extends AbstractExtension
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * GetProvinceExtension constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('views', [$this, 'topicViewsFunction']),
        ];
    }

    public function topicViewsFunction($topic)
    {
        $topicViews = $this->em->getRepository(Topic::class)->findViewsByTopic($topic);

        return $topicViews;
    }
}
