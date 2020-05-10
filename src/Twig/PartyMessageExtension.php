<?php

namespace App\Twig;

use Twig\TwigFilter;
use App\Entity\Party;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use Doctrine\ORM\EntityManagerInterface;

class PartyMessageExtension extends AbstractExtension
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
            new TwigFunction('parties', [$this, 'nextParty']),
        ];
    }

    public function nextParty()
    {
        // fait une requete doctrine dans partyRepo afin de recuperer les party qui n'ont pas eux lieux
        $party = $this->em->getRepository(Party::class)->findAllNextParty();

        return $party;
    }
}
