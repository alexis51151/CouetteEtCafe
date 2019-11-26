<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191126081758 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE unavaibility_collection (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)');
        $this->addSql('DROP INDEX IDX_FF0F87A454177093');
        $this->addSql('CREATE TEMPORARY TABLE __temp__unavaibility AS SELECT id, room_id, date_debut, date_fin FROM unavaibility');
        $this->addSql('DROP TABLE unavaibility');
        $this->addSql('CREATE TABLE unavaibility (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, room_id INTEGER NOT NULL, unavaibility_collection_id INTEGER DEFAULT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, CONSTRAINT FK_FF0F87A454177093 FOREIGN KEY (room_id) REFERENCES room (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_FF0F87A41C142166 FOREIGN KEY (unavaibility_collection_id) REFERENCES unavaibility_collection (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO unavaibility (id, room_id, date_debut, date_fin) SELECT id, room_id, date_debut, date_fin FROM __temp__unavaibility');
        $this->addSql('DROP TABLE __temp__unavaibility');
        $this->addSql('CREATE INDEX IDX_FF0F87A454177093 ON unavaibility (room_id)');
        $this->addSql('CREATE INDEX IDX_FF0F87A41C142166 ON unavaibility (unavaibility_collection_id)');
        $this->addSql('DROP INDEX UNIQ_C7440455A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__client AS SELECT id, user_id, prenom, mail, family_name FROM client');
        $this->addSql('DROP TABLE client');
        $this->addSql('CREATE TABLE client (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL COLLATE BINARY, mail VARCHAR(255) DEFAULT NULL COLLATE BINARY, family_name VARCHAR(255) DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_C7440455A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO client (id, user_id, prenom, mail, family_name) SELECT id, user_id, prenom, mail, family_name FROM __temp__client');
        $this->addSql('DROP TABLE __temp__client');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455A76ED395 ON client (user_id)');
        $this->addSql('DROP INDEX IDX_4C62E638F675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__contact AS SELECT id, author_id, content FROM contact');
        $this->addSql('DROP TABLE contact');
        $this->addSql('CREATE TABLE contact (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER DEFAULT NULL, content CLOB NOT NULL COLLATE BINARY, CONSTRAINT FK_4C62E638F675F31B FOREIGN KEY (author_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO contact (id, author_id, content) SELECT id, author_id, content FROM __temp__contact');
        $this->addSql('DROP TABLE __temp__contact');
        $this->addSql('CREATE INDEX IDX_4C62E638F675F31B ON contact (author_id)');
        $this->addSql('DROP INDEX IDX_42C8495554177093');
        $this->addSql('DROP INDEX IDX_42C8495519EB6921');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reservation AS SELECT id, room_id, client_id, date_debut, date_fin, confirmed FROM reservation');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('CREATE TABLE reservation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, room_id INTEGER NOT NULL, client_id INTEGER NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, confirmed BOOLEAN DEFAULT NULL, CONSTRAINT FK_42C8495519EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_42C8495554177093 FOREIGN KEY (room_id) REFERENCES room (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO reservation (id, room_id, client_id, date_debut, date_fin, confirmed) SELECT id, room_id, client_id, date_debut, date_fin, confirmed FROM __temp__reservation');
        $this->addSql('DROP TABLE __temp__reservation');
        $this->addSql('CREATE INDEX IDX_42C8495554177093 ON reservation (room_id)');
        $this->addSql('CREATE INDEX IDX_42C8495519EB6921 ON reservation (client_id)');
        $this->addSql('DROP INDEX IDX_729F519B7E3C61F9');
        $this->addSql('CREATE TEMPORARY TABLE __temp__room AS SELECT id, owner_id, summary, description, capacity, superficy, price, address, image_updated_at, image_name FROM room');
        $this->addSql('DROP TABLE room');
        $this->addSql('CREATE TABLE room (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER DEFAULT NULL, summary VARCHAR(255) NOT NULL COLLATE BINARY, description VARCHAR(255) NOT NULL COLLATE BINARY, capacity INTEGER DEFAULT NULL, superficy DOUBLE PRECISION DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, address CLOB DEFAULT NULL COLLATE BINARY, image_updated_at DATETIME DEFAULT NULL, image_name VARCHAR(255) DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_729F519B7E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO room (id, owner_id, summary, description, capacity, superficy, price, address, image_updated_at, image_name) SELECT id, owner_id, summary, description, capacity, superficy, price, address, image_updated_at, image_name FROM __temp__room');
        $this->addSql('DROP TABLE __temp__room');
        $this->addSql('CREATE INDEX IDX_729F519B7E3C61F9 ON room (owner_id)');
        $this->addSql('DROP INDEX IDX_4E2C37B754177093');
        $this->addSql('DROP INDEX IDX_4E2C37B798260155');
        $this->addSql('CREATE TEMPORARY TABLE __temp__room_region AS SELECT room_id, region_id FROM room_region');
        $this->addSql('DROP TABLE room_region');
        $this->addSql('CREATE TABLE room_region (room_id INTEGER NOT NULL, region_id INTEGER NOT NULL, PRIMARY KEY(room_id, region_id), CONSTRAINT FK_4E2C37B754177093 FOREIGN KEY (room_id) REFERENCES room (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4E2C37B798260155 FOREIGN KEY (region_id) REFERENCES region (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO room_region (room_id, region_id) SELECT room_id, region_id FROM __temp__room_region');
        $this->addSql('DROP TABLE __temp__room_region');
        $this->addSql('CREATE INDEX IDX_4E2C37B754177093 ON room_region (room_id)');
        $this->addSql('CREATE INDEX IDX_4E2C37B798260155 ON room_region (region_id)');
        $this->addSql('DROP INDEX IDX_67F068BC54177093');
        $this->addSql('DROP INDEX IDX_67F068BCA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__commentaire AS SELECT id, user_id, room_id, contenu, date FROM commentaire');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('CREATE TABLE commentaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, room_id INTEGER NOT NULL, contenu CLOB NOT NULL COLLATE BINARY, date DATE DEFAULT NULL, CONSTRAINT FK_67F068BCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_67F068BC54177093 FOREIGN KEY (room_id) REFERENCES room (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO commentaire (id, user_id, room_id, contenu, date) SELECT id, user_id, room_id, contenu, date FROM __temp__commentaire');
        $this->addSql('DROP TABLE __temp__commentaire');
        $this->addSql('CREATE INDEX IDX_67F068BC54177093 ON commentaire (room_id)');
        $this->addSql('CREATE INDEX IDX_67F068BCA76ED395 ON commentaire (user_id)');
        $this->addSql('DROP INDEX IDX_E08E40E454177093');
        $this->addSql('CREATE TEMPORARY TABLE __temp__unavailabilities AS SELECT id, room_id, date_debut, date_fin FROM unavailabilities');
        $this->addSql('DROP TABLE unavailabilities');
        $this->addSql('CREATE TABLE unavailabilities (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, room_id INTEGER DEFAULT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, CONSTRAINT FK_E08E40E454177093 FOREIGN KEY (room_id) REFERENCES room (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO unavailabilities (id, room_id, date_debut, date_fin) SELECT id, room_id, date_debut, date_fin FROM __temp__unavailabilities');
        $this->addSql('DROP TABLE __temp__unavailabilities');
        $this->addSql('CREATE INDEX IDX_E08E40E454177093 ON unavailabilities (room_id)');
        $this->addSql('DROP INDEX UNIQ_CF60E67CA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__owner AS SELECT id, user_id, firstname, address, country, family_name FROM owner');
        $this->addSql('DROP TABLE owner');
        $this->addSql('CREATE TABLE owner (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, firstname VARCHAR(255) DEFAULT NULL COLLATE BINARY, address CLOB DEFAULT NULL COLLATE BINARY, country VARCHAR(2) DEFAULT NULL COLLATE BINARY, family_name VARCHAR(255) DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_CF60E67CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO owner (id, user_id, firstname, address, country, family_name) SELECT id, user_id, firstname, address, country, family_name FROM __temp__owner');
        $this->addSql('DROP TABLE __temp__owner');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CF60E67CA76ED395 ON owner (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE unavaibility_collection');
        $this->addSql('DROP INDEX UNIQ_C7440455A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__client AS SELECT id, user_id, family_name, prenom, mail FROM client');
        $this->addSql('DROP TABLE client');
        $this->addSql('CREATE TABLE client (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, family_name VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, mail VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO client (id, user_id, family_name, prenom, mail) SELECT id, user_id, family_name, prenom, mail FROM __temp__client');
        $this->addSql('DROP TABLE __temp__client');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455A76ED395 ON client (user_id)');
        $this->addSql('DROP INDEX IDX_67F068BCA76ED395');
        $this->addSql('DROP INDEX IDX_67F068BC54177093');
        $this->addSql('CREATE TEMPORARY TABLE __temp__commentaire AS SELECT id, user_id, room_id, contenu, date FROM commentaire');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('CREATE TABLE commentaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, room_id INTEGER NOT NULL, contenu CLOB NOT NULL, date DATE DEFAULT NULL)');
        $this->addSql('INSERT INTO commentaire (id, user_id, room_id, contenu, date) SELECT id, user_id, room_id, contenu, date FROM __temp__commentaire');
        $this->addSql('DROP TABLE __temp__commentaire');
        $this->addSql('CREATE INDEX IDX_67F068BCA76ED395 ON commentaire (user_id)');
        $this->addSql('CREATE INDEX IDX_67F068BC54177093 ON commentaire (room_id)');
        $this->addSql('DROP INDEX IDX_4C62E638F675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__contact AS SELECT id, author_id, content FROM contact');
        $this->addSql('DROP TABLE contact');
        $this->addSql('CREATE TABLE contact (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER DEFAULT NULL, content CLOB NOT NULL)');
        $this->addSql('INSERT INTO contact (id, author_id, content) SELECT id, author_id, content FROM __temp__contact');
        $this->addSql('DROP TABLE __temp__contact');
        $this->addSql('CREATE INDEX IDX_4C62E638F675F31B ON contact (author_id)');
        $this->addSql('DROP INDEX UNIQ_CF60E67CA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__owner AS SELECT id, user_id, firstname, family_name, address, country FROM owner');
        $this->addSql('DROP TABLE owner');
        $this->addSql('CREATE TABLE owner (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, firstname VARCHAR(255) DEFAULT NULL, family_name VARCHAR(255) DEFAULT NULL, address CLOB DEFAULT NULL, country VARCHAR(2) DEFAULT NULL)');
        $this->addSql('INSERT INTO owner (id, user_id, firstname, family_name, address, country) SELECT id, user_id, firstname, family_name, address, country FROM __temp__owner');
        $this->addSql('DROP TABLE __temp__owner');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CF60E67CA76ED395 ON owner (user_id)');
        $this->addSql('DROP INDEX IDX_42C8495519EB6921');
        $this->addSql('DROP INDEX IDX_42C8495554177093');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reservation AS SELECT id, client_id, room_id, date_debut, date_fin, confirmed FROM reservation');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('CREATE TABLE reservation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, client_id INTEGER NOT NULL, room_id INTEGER NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, confirmed BOOLEAN DEFAULT NULL)');
        $this->addSql('INSERT INTO reservation (id, client_id, room_id, date_debut, date_fin, confirmed) SELECT id, client_id, room_id, date_debut, date_fin, confirmed FROM __temp__reservation');
        $this->addSql('DROP TABLE __temp__reservation');
        $this->addSql('CREATE INDEX IDX_42C8495519EB6921 ON reservation (client_id)');
        $this->addSql('CREATE INDEX IDX_42C8495554177093 ON reservation (room_id)');
        $this->addSql('DROP INDEX IDX_729F519B7E3C61F9');
        $this->addSql('CREATE TEMPORARY TABLE __temp__room AS SELECT id, owner_id, summary, description, capacity, superficy, price, address, image_name, image_updated_at FROM room');
        $this->addSql('DROP TABLE room');
        $this->addSql('CREATE TABLE room (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER DEFAULT NULL, summary VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, capacity INTEGER DEFAULT NULL, superficy DOUBLE PRECISION DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, address CLOB DEFAULT NULL, image_name VARCHAR(255) DEFAULT NULL, image_updated_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO room (id, owner_id, summary, description, capacity, superficy, price, address, image_name, image_updated_at) SELECT id, owner_id, summary, description, capacity, superficy, price, address, image_name, image_updated_at FROM __temp__room');
        $this->addSql('DROP TABLE __temp__room');
        $this->addSql('CREATE INDEX IDX_729F519B7E3C61F9 ON room (owner_id)');
        $this->addSql('DROP INDEX IDX_4E2C37B754177093');
        $this->addSql('DROP INDEX IDX_4E2C37B798260155');
        $this->addSql('CREATE TEMPORARY TABLE __temp__room_region AS SELECT room_id, region_id FROM room_region');
        $this->addSql('DROP TABLE room_region');
        $this->addSql('CREATE TABLE room_region (room_id INTEGER NOT NULL, region_id INTEGER NOT NULL, PRIMARY KEY(room_id, region_id))');
        $this->addSql('INSERT INTO room_region (room_id, region_id) SELECT room_id, region_id FROM __temp__room_region');
        $this->addSql('DROP TABLE __temp__room_region');
        $this->addSql('CREATE INDEX IDX_4E2C37B754177093 ON room_region (room_id)');
        $this->addSql('CREATE INDEX IDX_4E2C37B798260155 ON room_region (region_id)');
        $this->addSql('DROP INDEX IDX_FF0F87A454177093');
        $this->addSql('DROP INDEX IDX_FF0F87A41C142166');
        $this->addSql('CREATE TEMPORARY TABLE __temp__unavaibility AS SELECT id, room_id, date_debut, date_fin FROM unavaibility');
        $this->addSql('DROP TABLE unavaibility');
        $this->addSql('CREATE TABLE unavaibility (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, room_id INTEGER NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL)');
        $this->addSql('INSERT INTO unavaibility (id, room_id, date_debut, date_fin) SELECT id, room_id, date_debut, date_fin FROM __temp__unavaibility');
        $this->addSql('DROP TABLE __temp__unavaibility');
        $this->addSql('CREATE INDEX IDX_FF0F87A454177093 ON unavaibility (room_id)');
        $this->addSql('DROP INDEX IDX_E08E40E454177093');
        $this->addSql('CREATE TEMPORARY TABLE __temp__unavailabilities AS SELECT id, room_id, date_debut, date_fin FROM unavailabilities');
        $this->addSql('DROP TABLE unavailabilities');
        $this->addSql('CREATE TABLE unavailabilities (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, room_id INTEGER DEFAULT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL)');
        $this->addSql('INSERT INTO unavailabilities (id, room_id, date_debut, date_fin) SELECT id, room_id, date_debut, date_fin FROM __temp__unavailabilities');
        $this->addSql('DROP TABLE __temp__unavailabilities');
        $this->addSql('CREATE INDEX IDX_E08E40E454177093 ON unavailabilities (room_id)');
    }
}
