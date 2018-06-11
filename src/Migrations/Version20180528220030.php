<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180528220030 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE enclosure (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE security (id INT AUTO_INCREMENT NOT NULL, enclosure_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_C59BD5C1D04FE1E5 (enclosure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE security ADD CONSTRAINT FK_C59BD5C1D04FE1E5 FOREIGN KEY (enclosure_id) REFERENCES enclosure (id)');
        $this->addSql('ALTER TABLE dinosaur ADD enclosure_id INT DEFAULT NULL, ADD genus VARCHAR(255) NOT NULL, ADD is_carnivorous TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE dinosaur ADD CONSTRAINT FK_DAEDC56ED04FE1E5 FOREIGN KEY (enclosure_id) REFERENCES enclosure (id)');
        $this->addSql('CREATE INDEX IDX_DAEDC56ED04FE1E5 ON dinosaur (enclosure_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE security DROP FOREIGN KEY FK_C59BD5C1D04FE1E5');
        $this->addSql('ALTER TABLE dinosaur DROP FOREIGN KEY FK_DAEDC56ED04FE1E5');
        $this->addSql('DROP TABLE enclosure');
        $this->addSql('DROP TABLE security');
        $this->addSql('DROP INDEX IDX_DAEDC56ED04FE1E5 ON dinosaur');
        $this->addSql('ALTER TABLE dinosaur DROP enclosure_id, DROP genus, DROP is_carnivorous');
    }
}
