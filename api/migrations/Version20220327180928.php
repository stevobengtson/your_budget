<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220327180928 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE "account" (id UUID NOT NULL, budget_id UUID DEFAULT NULL, name VARCHAR(1024) NOT NULL, description TEXT NOT NULL, balance NUMERIC(12, 3) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7D3656A436ABA6B8 ON "account" (budget_id)');
        $this->addSql('COMMENT ON COLUMN "account".id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN "account".budget_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE "budget" (id UUID NOT NULL, user_id UUID DEFAULT NULL, name VARCHAR(1024) NOT NULL, start_date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_73F2F77BA76ED395 ON "budget" (user_id)');
        $this->addSql('COMMENT ON COLUMN "budget".id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN "budget".user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE "budget_month" (id UUID NOT NULL, budget_id UUID DEFAULT NULL, year INT NOT NULL, month INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E5A785F036ABA6B8 ON "budget_month" (budget_id)');
        $this->addSql('COMMENT ON COLUMN "budget_month".id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN "budget_month".budget_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE "budget_month_category" (id UUID NOT NULL, budget_month_id UUID DEFAULT NULL, assigned NUMERIC(12, 3) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_61247354DDC3EC40 ON "budget_month_category" (budget_month_id)');
        $this->addSql('COMMENT ON COLUMN "budget_month_category".id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN "budget_month_category".budget_month_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE "category" (id UUID NOT NULL, budget_id UUID DEFAULT NULL, category_group_id UUID DEFAULT NULL, name VARCHAR(1024) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_64C19C136ABA6B8 ON "category" (budget_id)');
        $this->addSql('CREATE INDEX IDX_64C19C1492E5D3C ON "category" (category_group_id)');
        $this->addSql('COMMENT ON COLUMN "category".id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN "category".budget_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN "category".category_group_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE "category_group" (id UUID NOT NULL, assigned NUMERIC(12, 3) NOT NULL, name VARCHAR(1024) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN "category_group".id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE "payee" (id UUID NOT NULL, budget_id UUID DEFAULT NULL, name VARCHAR(1024) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C218DE5E36ABA6B8 ON "payee" (budget_id)');
        $this->addSql('COMMENT ON COLUMN "payee".id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN "payee".budget_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE "transaction" (id UUID NOT NULL, account_id UUID DEFAULT NULL, payee_id UUID DEFAULT NULL, category_id UUID DEFAULT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, credit NUMERIC(12, 3) NOT NULL, debit NUMERIC(12, 3) NOT NULL, cleared BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_723705D19B6B5FBA ON "transaction" (account_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_723705D1CB4B68F ON "transaction" (payee_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_723705D112469DE2 ON "transaction" (category_id)');
        $this->addSql('COMMENT ON COLUMN "transaction".id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN "transaction".account_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN "transaction".payee_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN "transaction".category_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE "user" (id UUID NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('COMMENT ON COLUMN "user".id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE "account" ADD CONSTRAINT FK_7D3656A436ABA6B8 FOREIGN KEY (budget_id) REFERENCES "budget" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "budget" ADD CONSTRAINT FK_73F2F77BA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "budget_month" ADD CONSTRAINT FK_E5A785F036ABA6B8 FOREIGN KEY (budget_id) REFERENCES "budget" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "budget_month_category" ADD CONSTRAINT FK_61247354DDC3EC40 FOREIGN KEY (budget_month_id) REFERENCES "budget_month" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "category" ADD CONSTRAINT FK_64C19C136ABA6B8 FOREIGN KEY (budget_id) REFERENCES "budget" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "category" ADD CONSTRAINT FK_64C19C1492E5D3C FOREIGN KEY (category_group_id) REFERENCES "category_group" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "payee" ADD CONSTRAINT FK_C218DE5E36ABA6B8 FOREIGN KEY (budget_id) REFERENCES "budget" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "transaction" ADD CONSTRAINT FK_723705D19B6B5FBA FOREIGN KEY (account_id) REFERENCES "account" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "transaction" ADD CONSTRAINT FK_723705D1CB4B68F FOREIGN KEY (payee_id) REFERENCES "payee" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "transaction" ADD CONSTRAINT FK_723705D112469DE2 FOREIGN KEY (category_id) REFERENCES "category" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "transaction" DROP CONSTRAINT FK_723705D19B6B5FBA');
        $this->addSql('ALTER TABLE "account" DROP CONSTRAINT FK_7D3656A436ABA6B8');
        $this->addSql('ALTER TABLE "budget_month" DROP CONSTRAINT FK_E5A785F036ABA6B8');
        $this->addSql('ALTER TABLE "category" DROP CONSTRAINT FK_64C19C136ABA6B8');
        $this->addSql('ALTER TABLE "payee" DROP CONSTRAINT FK_C218DE5E36ABA6B8');
        $this->addSql('ALTER TABLE "budget_month_category" DROP CONSTRAINT FK_61247354DDC3EC40');
        $this->addSql('ALTER TABLE "transaction" DROP CONSTRAINT FK_723705D112469DE2');
        $this->addSql('ALTER TABLE "category" DROP CONSTRAINT FK_64C19C1492E5D3C');
        $this->addSql('ALTER TABLE "transaction" DROP CONSTRAINT FK_723705D1CB4B68F');
        $this->addSql('ALTER TABLE "budget" DROP CONSTRAINT FK_73F2F77BA76ED395');
        $this->addSql('DROP TABLE "account"');
        $this->addSql('DROP TABLE "budget"');
        $this->addSql('DROP TABLE "budget_month"');
        $this->addSql('DROP TABLE "budget_month_category"');
        $this->addSql('DROP TABLE "category"');
        $this->addSql('DROP TABLE "category_group"');
        $this->addSql('DROP TABLE "payee"');
        $this->addSql('DROP TABLE "transaction"');
        $this->addSql('DROP TABLE "user"');
    }
}
