<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220622161131 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cat DROP FOREIGN KEY FK_9E5E43A8A8B4A30F');
        $this->addSql('DROP INDEX IDX_9E5E43A8A8B4A30F ON cat');
        $this->addSql('ALTER TABLE cat ADD vaccination DATE DEFAULT NULL, DROP breed_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cat ADD breed_id INT DEFAULT NULL, DROP vaccination');
        $this->addSql('ALTER TABLE cat ADD CONSTRAINT FK_9E5E43A8A8B4A30F FOREIGN KEY (breed_id) REFERENCES breed (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_9E5E43A8A8B4A30F ON cat (breed_id)');
    }
}
