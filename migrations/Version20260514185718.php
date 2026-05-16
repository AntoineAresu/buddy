<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260514185718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ocd (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, duration INT NOT NULL, note VARCHAR(255) DEFAULT NULL, dog_id INT NOT NULL, INDEX IDX_B8C5C82A634DFEB (dog_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE ocd ADD CONSTRAINT FK_B8C5C82A634DFEB FOREIGN KEY (dog_id) REFERENCES dog (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ocd DROP FOREIGN KEY FK_B8C5C82A634DFEB');
        $this->addSql('DROP TABLE ocd');
    }
}
