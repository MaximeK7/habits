<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220731170617 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE habit ADD created_date DATETIME DEFAULT NULL, ADD updated_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE habit_category ADD created_date DATETIME DEFAULT NULL, ADD updated_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE habit_record ADD created_date DATETIME DEFAULT NULL, ADD updated_date DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE habit DROP created_date, DROP updated_date');
        $this->addSql('ALTER TABLE habit_category DROP created_date, DROP updated_date');
        $this->addSql('ALTER TABLE habit_record DROP created_date, DROP updated_date');
    }
}
