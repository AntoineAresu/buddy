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
}
