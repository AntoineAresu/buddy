<?php

namespace App\Security\Voter;

use App\Entity\Dog;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class DogVoter extends Voter
{
    public const UPDATE = 'UPDATE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return self::UPDATE == $attribute && $subject instanceof Dog;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token, ?Vote $vote = null): bool
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        /* @phpstan-ignore method.nonObject */
        return $subject->getUser() === $user;
    }
}
