<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181127121257 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE region_animal (region_id INT NOT NULL, animal_id INT NOT NULL, INDEX IDX_797FDF4A98260155 (region_id), UNIQUE INDEX UNIQ_797FDF4A8E962C16 (animal_id), PRIMARY KEY(region_id, animal_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE region_animal ADD CONSTRAINT FK_797FDF4A98260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE region_animal ADD CONSTRAINT FK_797FDF4A8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE animal ADD region_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F98260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6AAB231F98260155 ON animal (region_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE region_animal');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F98260155');
        $this->addSql('DROP INDEX UNIQ_6AAB231F98260155 ON animal');
        $this->addSql('ALTER TABLE animal DROP region_id');
    }
}
