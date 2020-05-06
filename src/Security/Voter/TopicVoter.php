<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\Topic;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class TopicVoter extends Voter
{
    // these strings are just invented: you can use anything
    const VIEW = 'view';
    const EDIT = 'edit';
    const DELETE = 'delete';

    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::VIEW, self::EDIT, self::DELETE]))
        {
            return false;
        }

        // only vote on `Topic` objects
        if (!$subject instanceof Topic) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // you know $subject is a Post object, thanks to `supports()`
        /** @var Topic $topic */
        $topic = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($topic, $user);
            case self::EDIT:
                return $this->canEdit($topic, $user);
            case self::DELETE:
                return $this->canDelete($topic, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(Topic $topic, User $user)
    {

    }

    private function canEdit(Topic $topic, User $user)
    {
        // si l'utilisateur est le propriétaire
        return $user === $topic->getUser();
    }

    private function canDelete(Topic $topic, User $user)
    {

    }
}
