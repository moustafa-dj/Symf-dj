<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240723112001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service ADD domain_id INT NOT NULL');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2115F0EE5 FOREIGN KEY (domain_id) REFERENCES domain (id)');
        $this->addSql('CREATE INDEX IDX_E19D9AD2115F0EE5 ON service (domain_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2115F0EE5');
        $this->addSql('DROP INDEX IDX_E19D9AD2115F0EE5 ON service');
        $this->addSql('ALTER TABLE service DROP domain_id');
    }
}
