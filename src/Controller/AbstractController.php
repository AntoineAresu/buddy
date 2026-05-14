<?php

namespace App\Controller;

use App\Entity\User;

class AbstractController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    #[\Override]
    public function getUser(): ?User
    {
        /** @var User $user */
        $user = parent::getUser();

        return $user;
    }

    public function getDateFromQuery(?string $date = null): \DateTime
    {
        if ($date && \DateTime::createFromFormat('Y-m-d', $date)) {
            return \DateTime::createFromFormat('Y-m-d', $date)->setTime(0, 0);
        }

        return new \DateTime()->setTime(0, 0);
    }
}
