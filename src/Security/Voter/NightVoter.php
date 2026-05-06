<?php

namespace App\Security\Voter;

use App\Entity\Night;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

final class NightVoter extends Voter
{
    public function __construct(private readonly AuthorizationCheckerInterface $authorizationChecker)
    {
    }

    public const UPDATE = 'UPDATE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return self::UPDATE == $attribute && $subject instanceof Night;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token, ?Vote $vote = null): bool
    {
        /* @phpstan-ignore method.nonObject */
        return $this->authorizationChecker->isGranted($attribute, $subject->getDog());
    }
}
