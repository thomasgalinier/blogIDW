<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230921070041 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE utilisateur_commentaire (utilisateur_id INT NOT NULL, commentaire_id INT NOT NULL, INDEX IDX_9316652FFB88E14F (utilisateur_id), INDEX IDX_9316652FBA9CD190 (commentaire_id), PRIMARY KEY(utilisateur_id, commentaire_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE utilisateur_commentaire ADD CONSTRAINT FK_9316652FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_commentaire ADD CONSTRAINT FK_9316652FBA9CD190 FOREIGN KEY (commentaire_id) REFERENCES commentaire (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur_commentaire DROP FOREIGN KEY FK_9316652FFB88E14F');
        $this->addSql('ALTER TABLE utilisateur_commentaire DROP FOREIGN KEY FK_9316652FBA9CD190');
        $this->addSql('DROP TABLE utilisateur_commentaire');
    }
}
