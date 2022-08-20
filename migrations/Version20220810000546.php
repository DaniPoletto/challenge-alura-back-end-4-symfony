<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220810000546 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE IF EXISTS despesas
        ADD COLUMN categoria_id integer NOT NULL;');
        $this->addSql('ALTER TABLE IF EXISTS public.despesas
        ADD CONSTRAINT "FK_73CC26923397707A" FOREIGN KEY (categoria_id)
        REFERENCES public.categoria (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE NO ACTION
        NOT VALID');
        // $this->addSql('CREATE INDEX IDX_73CC26923397707A ON despesas (categoria_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE despesas DROP FOREIGN KEY FK_73CC26923397707A');
        $this->addSql('DROP INDEX IDX_73CC26923397707A ON despesas');
        $this->addSql('ALTER TABLE despesas DROP categoria_id');
    }
}
