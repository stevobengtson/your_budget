<?php

namespace App\EventListener;

use App\Entity\Budget;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Security;

class BudgetChangeListener
{
    public function __construct(private Security $security)
    {
    }

    public function prePersist(Budget $budget, LifecycleEventArgs $args): void
    {
        if ($budget->getUser() == null) {
            $budget->setUser($this->security->getUser());
        }
    }
}
