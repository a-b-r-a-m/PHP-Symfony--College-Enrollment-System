<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190904230440 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE student_subject MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE student_subject DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE student_subject DROP id');
        $this->addSql('ALTER TABLE student_subject ADD PRIMARY KEY (student_id, subject_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE student_subject DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE student_subject ADD id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE student_subject ADD PRIMARY KEY (id)');
    }
}
