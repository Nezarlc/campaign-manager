<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250526184121 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE campaign_influencer (campaign_id INT NOT NULL, influencer_id INT NOT NULL, INDEX IDX_FA88AC0BF639F774 (campaign_id), INDEX IDX_FA88AC0B4AF97FA6 (influencer_id), PRIMARY KEY(campaign_id, influencer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE campaign_influencer ADD CONSTRAINT FK_FA88AC0BF639F774 FOREIGN KEY (campaign_id) REFERENCES campaign (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE campaign_influencer ADD CONSTRAINT FK_FA88AC0B4AF97FA6 FOREIGN KEY (influencer_id) REFERENCES influencer (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE campaign_influencer DROP FOREIGN KEY FK_FA88AC0BF639F774
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE campaign_influencer DROP FOREIGN KEY FK_FA88AC0B4AF97FA6
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE campaign_influencer
        SQL);
    }
}
