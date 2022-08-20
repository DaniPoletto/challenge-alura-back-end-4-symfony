<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220804174259 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE despesas
        (
            id serial NOT NULL,
            descricao character varying(255) NOT NULL,
            valor numeric(10, 2) NOT NULL,
            data date NOT NULL,
            PRIMARY KEY (id)
        );');
        $this->addSql('CREATE TABLE receitas
        (
            id serial NOT NULL,
            descricao character varying(255) NOT NULL,
            valor numeric(10, 2) NOT NULL,
            data date NOT NULL,
            PRIMARY KEY (id)
        );');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE despesas');
        $this->addSql('DROP TABLE receitas');
    }
}
