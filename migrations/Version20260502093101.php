<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260502093101 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE crossing (id INT AUTO_INCREMENT NOT NULL, distance INT NOT NULL, location VARCHAR(255) NOT NULL, freedom_level VARCHAR(255) NOT NULL, reaction VARCHAR(255) DEFAULT NULL, dog_id INT NOT NULL, INDEX IDX_1145D3AC634DFEB (dog_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE dog (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, birth_date DATE NOT NULL, user_id INT NOT NULL, INDEX IDX_812C397DA76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE night (id INT AUTO_INCREMENT NOT NULL, end DATETIME NOT NULL, start DATETIME NOT NULL, dog_id INT NOT NULL, INDEX IDX_11DA0F97634DFEB (dog_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE crossing ADD CONSTRAINT FK_1145D3AC634DFEB FOREIGN KEY (dog_id) REFERENCES dog (id)');
        $this->addSql('ALTER TABLE dog ADD CONSTRAINT FK_812C397DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE night ADD CONSTRAINT FK_11DA0F97634DFEB FOREIGN KEY (dog_id) REFERENCES dog (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE crossing DROP FOREIGN KEY FK_1145D3AC634DFEB');
        $this->addSql('ALTER TABLE dog DROP FOREIGN KEY FK_812C397DA76ED395');
        $this->addSql('ALTER TABLE night DROP FOREIGN KEY FK_11DA0F97634DFEB');
        $this->addSql('DROP TABLE crossing');
        $this->addSql('DROP TABLE dog');
        $this->addSql('DROP TABLE night');
    }
}
