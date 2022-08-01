<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220801133954 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F819395C3F3');
        $this->addSql('DROP INDEX IDX_D4E6F819395C3F3 ON address');
        $this->addSql('ALTER TABLE address DROP customer_id, DROP billing, DROP delivery');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address ADD customer_id INT NOT NULL, ADD billing TINYINT(1) NOT NULL, ADD delivery TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F819395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('CREATE INDEX IDX_D4E6F819395C3F3 ON address (customer_id)');
    }
}
