<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\Comment;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class CommentVoter extends Voter
{
    const VIEW = 'view';
    const EDIT = 'edit';
    const DELETE = 'delete';

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::VIEW, self::EDIT, self::DELETE]))
        {
            return false;
        }

        if (!$subject instanceof Comment)
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

        /** @var Comment $comment */
        $comment = $subject;
        
        switch ($attribute)
        {
            case self::EDIT:
                return $this->canEdit($comment, $user);
            case self::DELETE:
                return $this->canDelete($comment, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canEdit(Comment $comment, User $user)
    {
        return $user === $comment->getUser();
    }

    private function canDelete(Comment $comment, User $user)
    {
        return $user === $comment->getUser();
    }
}
