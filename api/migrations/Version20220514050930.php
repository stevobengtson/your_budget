<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220514050930 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account ADD created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE account ADD updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE budget ADD created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE budget ADD updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE budget DROP start_date');
        $this->addSql('ALTER TABLE budget_month ADD created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE budget_month ADD updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE budget_month_category ADD created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE budget_month_category ADD updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE category ADD created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE category ADD updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE category_group ADD created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE category_group ADD updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE payee ADD created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE payee ADD updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE transaction ADD created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE transaction ADD updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE transaction ALTER credit DROP NOT NULL');
        $this->addSql('ALTER TABLE transaction ALTER debit DROP NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "budget" ADD start_date DATE NOT NULL');
        $this->addSql('ALTER TABLE "budget" DROP created');
        $this->addSql('ALTER TABLE "budget" DROP updated');
        $this->addSql('ALTER TABLE "account" DROP created');
        $this->addSql('ALTER TABLE "account" DROP updated');
        $this->addSql('ALTER TABLE "user" DROP created');
        $this->addSql('ALTER TABLE "user" DROP updated');
        $this->addSql('ALTER TABLE "budget_month" DROP created');
        $this->addSql('ALTER TABLE "budget_month" DROP updated');
        $this->addSql('ALTER TABLE "budget_month_category" DROP created');
        $this->addSql('ALTER TABLE "budget_month_category" DROP updated');
        $this->addSql('ALTER TABLE "category" DROP created');
        $this->addSql('ALTER TABLE "category" DROP updated');
        $this->addSql('ALTER TABLE "category_group" DROP created');
        $this->addSql('ALTER TABLE "category_group" DROP updated');
        $this->addSql('ALTER TABLE "payee" DROP created');
        $this->addSql('ALTER TABLE "payee" DROP updated');
        $this->addSql('ALTER TABLE "transaction" DROP created');
        $this->addSql('ALTER TABLE "transaction" DROP updated');
        $this->addSql('ALTER TABLE "transaction" ALTER credit SET NOT NULL');
        $this->addSql('ALTER TABLE "transaction" ALTER debit SET NOT NULL');
    }
}
