<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250701132331 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create desks and bookings tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE desk (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, desk_id INT NOT NULL, user VARCHAR(255) NOT NULL, start_time DATETIME NOT NULL, end_time DATETIME NOT NULL, INDEX IDX_E00CED5BD4CBDFF6 (desk_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CED5BD4CBDFF6 FOREIGN KEY (desk_id) REFERENCES desk (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CED5BD4CBDFF6');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE desk');
    }
}
