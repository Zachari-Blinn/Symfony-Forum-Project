<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\Forum;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class ForumVoter extends Voter
{
    const EDIT = 'edit';
    const DELETE = 'delete';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::EDIT, self::DELETE]))
        {
            return false;
        }

        if (!$subject instanceof Forum)
        {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User)
        {
            return false;
        }

        // ROLE_SUPER_ADMIN can do anything! The power!
        if ($this->security->isGranted('ROLE_SUPER_ADMIN'))
        {
            return true;
        }
        
        switch ($attribute)
        {
            case self::EDIT:
                return $this->canEdit();
            case self::DELETE:
                return $this->canDelete();
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canEdit()
    {
        if($this->security->isGranted('ROLE_CATEGORY_EDIT')) return true;
    }

    private function canDelete()
    {
        if($this->security->isGranted('ROLE_CATEGORY_DELETE')) return true;
    }
    
}
