<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170926124843 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE wine DROP FOREIGN KEY FK_560C6468DD02142A');
        $this->addSql('ALTER TABLE wine ADD CONSTRAINT FK_560C6468DD02142A FOREIGN KEY (wine_country_id) REFERENCES wine_country (id) ON DELETE SET NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE wine DROP FOREIGN KEY FK_560C6468DD02142A');
        $this->addSql('ALTER TABLE wine ADD CONSTRAINT FK_560C6468DD02142A FOREIGN KEY (wine_country_id) REFERENCES wine_country (id)');
    }
}
