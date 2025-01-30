<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250129200101 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create tables and insert initial data';
    }

    public function up(Schema $schema): void
    {
        // Crear las tablas
        $this->addSql('CREATE TABLE activity (id INT AUTO_INCREMENT NOT NULL, activity_type_id INT NOT NULL, date_start DATETIME NOT NULL, date_end DATETIME NOT NULL, INDEX IDX_AC74095AC51EFA73 (activity_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE activity_monitor (activity_id INT NOT NULL, monitor_id INT NOT NULL, INDEX IDX_E147EF6581C06096 (activity_id), INDEX IDX_E147EF654CE1C902 (monitor_id), PRIMARY KEY(activity_id, monitor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE activity_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, number_monitors INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE monitor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Relaciones entre tablas
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095AC51EFA73 FOREIGN KEY (activity_type_id) REFERENCES activity_type (id)');
        $this->addSql('ALTER TABLE activity_monitor ADD CONSTRAINT FK_E147EF6581C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activity_monitor ADD CONSTRAINT FK_E147EF654CE1C902 FOREIGN KEY (monitor_id) REFERENCES monitor (id) ON DELETE CASCADE');

        // Insertar datos iniciales en `activity_type`
        $this->addSql("INSERT INTO activity_type (name, number_monitors) VALUES 
            ('Yoga', 1),
            ('BodyPump', 2),
            ('Pilates', 1)");

        // Insertar datos iniciales en `monitor`
        $this->addSql("INSERT INTO monitor (name, email, phone, photo) VALUES 
            ('John Doe', 'john@example.com', '123456789', 'http://photo.com/john'),
            ('Jane Doe', 'jane@example.com', '987654321', 'http://photo.com/jane'),
            ('Mike Smith', 'mike@example.com', '555555555', 'http://photo.com/mike')");

        // Insertar datos iniciales en `activity`
        $this->addSql("INSERT INTO activity (activity_type_id, date_start, date_end) VALUES
            (1, '2025-02-10 09:00:00', '2025-02-10 10:30:00'),
            (2, '2025-02-10 13:30:00', '2025-02-10 15:00:00'),
            (3, '2025-02-10 17:30:00', '2025-02-10 19:00:00')");

        // Insertar datos iniciales en `activity_monitor` (relaciones N:M)
        $this->addSql("INSERT INTO activity_monitor (activity_id, monitor_id) VALUES
            (1, 1),
            (2, 2),
            (3, 3)");
    }

    public function down(Schema $schema): void
    {
        // Eliminar las tablas y relaciones si se revierte la migración
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095AC51EFA73');
        $this->addSql('ALTER TABLE activity_monitor DROP FOREIGN KEY FK_E147EF6581C06096');
        $this->addSql('ALTER TABLE activity_monitor DROP FOREIGN KEY FK_E147EF654CE1C902');
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE activity_monitor');
        $this->addSql('DROP TABLE activity_type');
        $this->addSql('DROP TABLE monitor');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
