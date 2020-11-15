<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201108173300 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_2F577D59C40FCFA8');
        $this->addSql('CREATE TEMPORARY TABLE __temp__lieu AS SELECT id, piece_id, nom FROM lieu');
        $this->addSql('DROP TABLE lieu');
        $this->addSql('CREATE TABLE lieu (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, piece_id INTEGER NOT NULL, nom VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_2F577D59C40FCFA8 FOREIGN KEY (piece_id) REFERENCES piece (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO lieu (id, piece_id, nom) SELECT id, piece_id, nom FROM __temp__lieu');
        $this->addSql('DROP TABLE __temp__lieu');
        $this->addSql('CREATE INDEX IDX_2F577D59C40FCFA8 ON lieu (piece_id)');
        $this->addSql('DROP INDEX IDX_46CD4C38C40FCFA8');
        $this->addSql('CREATE TEMPORARY TABLE __temp__objet AS SELECT id, piece_id, nom, categorie FROM objet');
        $this->addSql('DROP TABLE objet');
        $this->addSql('CREATE TABLE objet (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, piece_id INTEGER NOT NULL, nom VARCHAR(255) NOT NULL COLLATE BINARY, categorie VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_46CD4C38C40FCFA8 FOREIGN KEY (piece_id) REFERENCES piece (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO objet (id, piece_id, nom, categorie) SELECT id, piece_id, nom, categorie FROM __temp__objet');
        $this->addSql('DROP TABLE __temp__objet');
        $this->addSql('CREATE INDEX IDX_46CD4C38C40FCFA8 ON objet (piece_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_2F577D59C40FCFA8');
        $this->addSql('CREATE TEMPORARY TABLE __temp__lieu AS SELECT id, piece_id, nom FROM lieu');
        $this->addSql('DROP TABLE lieu');
        $this->addSql('CREATE TABLE lieu (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, piece_id INTEGER NOT NULL, nom VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO lieu (id, piece_id, nom) SELECT id, piece_id, nom FROM __temp__lieu');
        $this->addSql('DROP TABLE __temp__lieu');
        $this->addSql('CREATE INDEX IDX_2F577D59C40FCFA8 ON lieu (piece_id)');
        $this->addSql('DROP INDEX IDX_46CD4C38C40FCFA8');
        $this->addSql('CREATE TEMPORARY TABLE __temp__objet AS SELECT id, piece_id, nom, categorie FROM objet');
        $this->addSql('DROP TABLE objet');
        $this->addSql('CREATE TABLE objet (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, piece_id INTEGER NOT NULL, nom VARCHAR(255) NOT NULL, categorie VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO objet (id, piece_id, nom, categorie) SELECT id, piece_id, nom, categorie FROM __temp__objet');
        $this->addSql('DROP TABLE __temp__objet');
        $this->addSql('CREATE INDEX IDX_46CD4C38C40FCFA8 ON objet (piece_id)');
    }
}
