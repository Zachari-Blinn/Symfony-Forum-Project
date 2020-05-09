<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\Party;
use App\Entity\Topic;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class PartyVoter extends Voter
{
    const PARTICIPATE = 'participate';
    const EDIT = 'edit';
    const DELETE = 'delete';

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::PARTICIPATE, self::EDIT, self::DELETE]))
        {
            return false;
        }

        if (!$subject instanceof Party)
        {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        /** @var Party $party */
        $party = $subject;

        // ROLE_SUPER_ADMIN can do anything! The power!
        if ($this->security->isGranted('ROLE_SUPER_ADMIN'))
        {
            return true;
        }
        
        switch ($attribute)
        {
            case self::EDIT:
                return $this->canEdit($party, $user);
            case self::DELETE:
                return $this->canDelete($party, $user);
            case self::PARTICIPATE:
                return $this->canParticipate($party, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canEdit(Party $party, User $user)
    {
        return $user === $party->getUser();
    }

    private function canDelete(Party $party, User $user)
    {
        return $user === $party->getUser();
    }

    public function canParticipate(Party $party, User $user)
    {
        // l'auteur peut participer
        return $user === $party->getUser();

        // si la party n'est plus active, si la date d'expiration est dépassé, si la date de la partie est dépassé
        if($party->getIsAtive() == false || new \DateTime('now') > $party->getExpireAt() || new \DateTime('now') > $party->getPartyAt())
        {
            return false;
        }

        // si les anonymous ne sont pas acceptés 
        if (!$user instanceof User && $party->getAllowAnonymous() == false)
        {
            return false;
        }
    }

}
