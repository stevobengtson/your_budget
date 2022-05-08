<?php

namespace App\DataFixtures;

use App\Entity\Account;
use App\Entity\Budget;
use App\Entity\BudgetMonth;
use App\Entity\BudgetMonthCategory;
use App\Entity\Category;
use App\Entity\CategoryGroup;
use App\Entity\Payee;
use App\Entity\Transaction;
use App\Entity\User;
use Carbon\CarbonImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $adminUser = new User();
        $adminUser->email = "admin@test.com";
        // $adminUser->plainPassword = "test1234";
        $adminUser->password = '$2y$13$F1xoCv6xGzdpFLQlsQes3ex7.0Zv4x1V6yYiy3v7w7dt9vuu/4AhG';
        $adminUser->roles = ['ROLE_USER', 'ROLE_ADMIN'];
        $manager->persist($adminUser);

        $this->setupTestUserBudget($manager);

        $manager->flush();
    }

    private function setupTestUserBudget(ObjectManager $manager): void
    {
        $now = CarbonImmutable::now();

        $user = new User();
        $user->email = "test@test.com";
        // $user->plainPassword = "test1234";
        $user->password = '$2y$13$F1xoCv6xGzdpFLQlsQes3ex7.0Zv4x1V6yYiy3v7w7dt9vuu/4AhG';
        $user->roles = ['ROLE_USER'];
        $manager->persist($user);

        $budget = new Budget();
        $budget->user = $user;
        $budget->name = "Current Budget";
        $budget->startDate = $now;
        $manager->persist($budget);

        $chequingAccount = new Account();
        $chequingAccount->name = "Chequing";
        $chequingAccount->description = "This is my chequing account";
        $chequingAccount->balance = 500.00;
        $chequingAccount->budget = $budget;
        $manager->persist($chequingAccount);

        $workPayee = new Payee();
        $workPayee->budget = $budget;
        $workPayee->name = "Work";
        $manager->persist($workPayee);

        $incomeCategoryGroup = new CategoryGroup();
        $incomeCategoryGroup->name = "Income";
        $incomeCategoryGroup->assigned = 0.0;
        $manager->persist($incomeCategoryGroup);

        $incomeCategory = new Category();
        $incomeCategory->budget = $budget;
        $incomeCategory->name = "Work Income";
        $incomeCategory->category_group = $incomeCategoryGroup;
        $manager->persist($incomeCategory);

        $startTransaction = new Transaction();
        $startTransaction->account = $chequingAccount;
        $startTransaction->credit = 500.00;
        $startTransaction->cleared = true;
        $startTransaction->date = $now;
        $startTransaction->payee = $workPayee;
        $startTransaction->category = $incomeCategory;
        $manager->persist($startTransaction);

        $budgetMonth = new BudgetMonth();
        $budgetMonth->budget = $budget;
        $budgetMonth->month = $now->month;
        $budgetMonth->year = $now->year;
        $manager->persist($budgetMonth);

        $budgetMonthCategory = new BudgetMonthCategory();
        $budgetMonthCategory->budget_month = $budgetMonth;
        $budgetMonthCategory->assigned = 500.00;
        $manager->persist($budgetMonthCategory);


        $manager->flush();
    }
}
