<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220107095924 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "user" ADD agreed_terms_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER firstname DROP NOT NULL');
        $this->addSql('COMMENT ON COLUMN "user".agreed_terms_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE video ADD url VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE video DROP title');
        $this->addSql('ALTER TABLE video DROP link');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE video ADD link VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE video RENAME COLUMN url TO title');
        $this->addSql('ALTER TABLE "user" DROP agreed_terms_at');
        $this->addSql('ALTER TABLE "user" ALTER firstname SET NOT NULL');
    }
}
