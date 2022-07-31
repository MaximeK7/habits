<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220731160854 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE habit (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, color VARCHAR(6) NOT NULL, INDEX IDX_44FE217212469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE habit_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, color VARCHAR(6) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE habit_record (id INT AUTO_INCREMENT NOT NULL, habit_id INT NOT NULL, date_completed DATETIME DEFAULT NULL, INDEX IDX_36724ED5E7AEB3B2 (habit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE habit ADD CONSTRAINT FK_44FE217212469DE2 FOREIGN KEY (category_id) REFERENCES habit_category (id)');
        $this->addSql('ALTER TABLE habit_record ADD CONSTRAINT FK_36724ED5E7AEB3B2 FOREIGN KEY (habit_id) REFERENCES habit (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE habit_record DROP FOREIGN KEY FK_36724ED5E7AEB3B2');
        $this->addSql('ALTER TABLE habit DROP FOREIGN KEY FK_44FE217212469DE2');
        $this->addSql('DROP TABLE habit');
        $this->addSql('DROP TABLE habit_category');
        $this->addSql('DROP TABLE habit_record');
    }
}
