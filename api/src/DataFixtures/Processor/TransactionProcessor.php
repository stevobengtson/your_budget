<?php

namespace App\DataFixtures\Processor;

use App\Entity\Transaction;
use Fidry\AliceDataFixtures\ProcessorInterface;

class TransactionProcessor implements ProcessorInterface
{

    public function preProcess(string $id, object $object): void
    {
        if ($object instanceof Transaction) {
            if ($object->getCredit() != null) {
                $object->setDebit(null);
            }
        }
    }

    public function postProcess(string $id, object $object): void
    {

    }

}