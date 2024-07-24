<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240724110327 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE service_media (id INT AUTO_INCREMENT NOT NULL, service_id INT DEFAULT NULL, path VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, extention VARCHAR(255) DEFAULT NULL, INDEX IDX_C35E4CEBED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE service_media ADD CONSTRAINT FK_C35E4CEBED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service_media DROP FOREIGN KEY FK_C35E4CEBED5CA9E6');
        $this->addSql('DROP TABLE service_media');
    }
}
