<?php

namespace App\EventListener;

use App\Entity\User;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserChangeListener
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function prePersist(User $user, LifecycleEventArgs $args): void
    {
        $this->updatePassword($user);
    }

    public function preUpdate(User $user, LifecycleEventArgs $args): void
    {
        $this->updatePassword($user);
    }

    private function updatePassword(User $user): void
    {
        if (empty($user->plainPassword)) {
            return;
        }

        // Hash the password if not already done
        $user->password = $this->passwordHasher->hashPassword($user, $user->plainPassword);
        $user->eraseCredentials();
    }
}
