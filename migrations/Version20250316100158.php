<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250316100158 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_wallet ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_wallet ADD CONSTRAINT FK_193A8922A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_193A8922A76ED395 ON user_wallet (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_wallet DROP FOREIGN KEY FK_193A8922A76ED395');
        $this->addSql('DROP INDEX UNIQ_193A8922A76ED395 ON user_wallet');
        $this->addSql('ALTER TABLE user_wallet DROP user_id');
    }
}
