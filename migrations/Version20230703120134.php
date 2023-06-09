<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230703120134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649B4C494AD');
        $this->addSql('CREATE TABLE expert_user (decision_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_3AE2FC6ABDEE7539 (decision_id), INDEX IDX_3AE2FC6AA76ED395 (user_id), PRIMARY KEY(decision_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE impacted_user (decision_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_E1639B25BDEE7539 (decision_id), INDEX IDX_E1639B25A76ED395 (user_id), PRIMARY KEY(decision_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE expert_user ADD CONSTRAINT FK_3AE2FC6ABDEE7539 FOREIGN KEY (decision_id) REFERENCES decision (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE expert_user ADD CONSTRAINT FK_3AE2FC6AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE impacted_user ADD CONSTRAINT FK_E1639B25BDEE7539 FOREIGN KEY (decision_id) REFERENCES decision (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE impacted_user ADD CONSTRAINT FK_E1639B25A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE user_situation');
        $this->addSql('DROP INDEX IDX_8D93D649B4C494AD ON user');
        $this->addSql('ALTER TABLE user DROP user_situation_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_situation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE expert_user DROP FOREIGN KEY FK_3AE2FC6ABDEE7539');
        $this->addSql('ALTER TABLE expert_user DROP FOREIGN KEY FK_3AE2FC6AA76ED395');
        $this->addSql('ALTER TABLE impacted_user DROP FOREIGN KEY FK_E1639B25BDEE7539');
        $this->addSql('ALTER TABLE impacted_user DROP FOREIGN KEY FK_E1639B25A76ED395');
        $this->addSql('DROP TABLE expert_user');
        $this->addSql('DROP TABLE impacted_user');
        $this->addSql('ALTER TABLE user ADD user_situation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B4C494AD FOREIGN KEY (user_situation_id) REFERENCES user_situation (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8D93D649B4C494AD ON user (user_situation_id)');
    }
}
