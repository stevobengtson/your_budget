<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220514054534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX uniq_723705d1cb4b68f');
        $this->addSql('DROP INDEX uniq_723705d112469de2');
        $this->addSql('CREATE INDEX IDX_723705D1CB4B68F ON transaction (payee_id)');
        $this->addSql('CREATE INDEX IDX_723705D112469DE2 ON transaction (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX IDX_723705D1CB4B68F');
        $this->addSql('DROP INDEX IDX_723705D112469DE2');
        $this->addSql('CREATE UNIQUE INDEX uniq_723705d1cb4b68f ON "transaction" (payee_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_723705d112469de2 ON "transaction" (category_id)');
    }
}
