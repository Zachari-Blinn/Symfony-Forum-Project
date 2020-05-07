<?php

namespace App\Twig;

use App\Entity\Category;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use Doctrine\ORM\EntityManagerInterface;

class CountAllMessagesExtension extends AbstractExtension
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
            new TwigFunction('messages', [$this, 'messagesFunction']),
        ];
    }

    public function messagesFunction($comment)
    {
        $categoryMessages = $this->em->getRepository(Category::class)->countAllMessages($comment);

        return $categoryMessages;
    }
}
