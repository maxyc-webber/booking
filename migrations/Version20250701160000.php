<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250701160000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add phone column to booking table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE booking ADD phone VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE booking DROP phone');
    }
}
