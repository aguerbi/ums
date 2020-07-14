<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200714143124 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE adherent (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, cin VARCHAR(255) NOT NULL, mobile VARCHAR(255) NOT NULL, INDEX IDX_90D3F060979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE card (id INT AUTO_INCREMENT NOT NULL, adherent_id INT NOT NULL, number_card VARCHAR(255) NOT NULL, delivery_at DATETIME NOT NULL, year VARCHAR(255) NOT NULL, INDEX IDX_161498D325F06C53 (adherent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, fax VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, address LONGTEXT DEFAULT NULL, director VARCHAR(255) DEFAULT NULL, mobile VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, title VARCHAR(255) NOT NULL, document VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_3BAE0AA7979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE syndicat (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_477041765E237E06 (name), INDEX IDX_47704176979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE syndicat_adherent (syndicat_id INT NOT NULL, adherent_id INT NOT NULL, INDEX IDX_26A827D38F5ADEED (syndicat_id), INDEX IDX_26A827D325F06C53 (adherent_id), PRIMARY KEY(syndicat_id, adherent_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adherent ADD CONSTRAINT FK_90D3F060979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D325F06C53 FOREIGN KEY (adherent_id) REFERENCES adherent (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE syndicat ADD CONSTRAINT FK_47704176979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE syndicat_adherent ADD CONSTRAINT FK_26A827D38F5ADEED FOREIGN KEY (syndicat_id) REFERENCES syndicat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE syndicat_adherent ADD CONSTRAINT FK_26A827D325F06C53 FOREIGN KEY (adherent_id) REFERENCES adherent (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D325F06C53');
        $this->addSql('ALTER TABLE syndicat_adherent DROP FOREIGN KEY FK_26A827D325F06C53');
        $this->addSql('ALTER TABLE adherent DROP FOREIGN KEY FK_90D3F060979B1AD6');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7979B1AD6');
        $this->addSql('ALTER TABLE syndicat DROP FOREIGN KEY FK_47704176979B1AD6');
        $this->addSql('ALTER TABLE syndicat_adherent DROP FOREIGN KEY FK_26A827D38F5ADEED');
        $this->addSql('DROP TABLE adherent');
        $this->addSql('DROP TABLE card');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE syndicat');
        $this->addSql('DROP TABLE syndicat_adherent');
        $this->addSql('DROP TABLE user');
    }
}
