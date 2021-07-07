<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210705103933 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chest_history (id INT AUTO_INCREMENT NOT NULL, nft_id INT DEFAULT NULL, wallet_id VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, amount INT NOT NULL, timestamp DATETIME NOT NULL, chain_id VARCHAR(255) NOT NULL, block INT NOT NULL, tx_hash VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_35713283E813668D (nft_id), INDEX IDX_35713283712520F3 (wallet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE market (nft_id INT NOT NULL, seller_id VARCHAR(255) NOT NULL, chain_id VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, currency VARCHAR(255) NOT NULL, expiration INT NOT NULL, timestamp DATETIME NOT NULL, INDEX IDX_6BAC85CB8DE820D9 (seller_id), PRIMARY KEY(nft_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE market_history (id INT AUTO_INCREMENT NOT NULL, nft_id INT NOT NULL, seller_wallet VARCHAR(255) NOT NULL, buyer_wallet VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, currency VARCHAR(255) NOT NULL, timestamp DATETIME NOT NULL, chain_id VARCHAR(255) NOT NULL, block INT NOT NULL, tx_hash VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_2E2C98CB966C2F62 (chain_id), INDEX IDX_2E2C98CBE813668D (nft_id), INDEX IDX_2E2C98CBC9185535 (seller_wallet), INDEX IDX_2E2C98CBDA239CFF (buyer_wallet), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nft (id INT AUTO_INCREMENT NOT NULL, nft_id INT NOT NULL, name VARCHAR(255) NOT NULL, category INT NOT NULL, item INT NOT NULL, level INT NOT NULL, boost VARCHAR(255) NOT NULL, reduction VARCHAR(255) NOT NULL, random INT NOT NULL, timestamp DATETIME NOT NULL, chain_id VARCHAR(255) NOT NULL, block INT NOT NULL, tx_hash VARCHAR(255) NOT NULL, is_locked INT NOT NULL, img_url VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D9C7463CE813668D (nft_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chest_history ADD CONSTRAINT FK_35713283E813668D FOREIGN KEY (nft_id) REFERENCES nft (id)');
        $this->addSql('ALTER TABLE chest_history ADD CONSTRAINT FK_35713283712520F3 FOREIGN KEY (wallet_id) REFERENCES wallet (wallet_id)');
        $this->addSql('ALTER TABLE market ADD CONSTRAINT FK_6BAC85CBE813668D FOREIGN KEY (nft_id) REFERENCES nft (id)');
        $this->addSql('ALTER TABLE market ADD CONSTRAINT FK_6BAC85CB8DE820D9 FOREIGN KEY (seller_id) REFERENCES wallet (wallet_id)');
        $this->addSql('ALTER TABLE market_history ADD CONSTRAINT FK_2E2C98CBE813668D FOREIGN KEY (nft_id) REFERENCES nft (id)');
        $this->addSql('ALTER TABLE market_history ADD CONSTRAINT FK_2E2C98CBC9185535 FOREIGN KEY (seller_wallet) REFERENCES wallet (wallet_id)');
        $this->addSql('ALTER TABLE market_history ADD CONSTRAINT FK_2E2C98CBDA239CFF FOREIGN KEY (buyer_wallet) REFERENCES wallet (wallet_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chest_history DROP FOREIGN KEY FK_35713283E813668D');
        $this->addSql('ALTER TABLE market DROP FOREIGN KEY FK_6BAC85CBE813668D');
        $this->addSql('ALTER TABLE market_history DROP FOREIGN KEY FK_2E2C98CBE813668D');
        $this->addSql('DROP TABLE chest_history');
        $this->addSql('DROP TABLE market');
        $this->addSql('DROP TABLE market_history');
        $this->addSql('DROP TABLE nft');
    }
}
