<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210419091018 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message ADD idtheuser_id INT NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F9433D126 FOREIGN KEY (idtheuser_id) REFERENCES the_user (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F9433D126 ON message (idtheuser_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F9433D126');
        $this->addSql('DROP INDEX IDX_B6BD307F9433D126 ON message');
        $this->addSql('ALTER TABLE message DROP idtheuser_id');
    }
}
