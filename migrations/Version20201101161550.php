<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201101161550 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lieu (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, piece_id INTEGER NOT NULL, nom VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_2F577D59C40FCFA8 ON lieu (piece_id)');
        $this->addSql('CREATE TABLE objet (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, piece_id INTEGER NOT NULL, nom VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_46CD4C38C40FCFA8 ON objet (piece_id)');
        $this->addSql('CREATE TABLE piece (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE lieu');
        $this->addSql('DROP TABLE objet');
        $this->addSql('DROP TABLE piece');
    }
}
