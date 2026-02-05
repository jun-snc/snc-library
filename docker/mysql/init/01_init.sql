-- SNCライブラリ - グラフィックデザイン
-- DB初期化SQL（MySQL 8想定）
-- Laravel Migration形式のテーブル構成

CREATE TABLE IF NOT EXISTS genres (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_genres_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS tags (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_tags_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS images (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  genre_id BIGINT UNSIGNED NOT NULL,
  memo TEXT NULL,
  original_path VARCHAR(255) NOT NULL,
  display_path VARCHAR(255) NOT NULL,
  thumb_path VARCHAR(255) NOT NULL,
  original_name VARCHAR(255) NOT NULL,
  mime_type VARCHAR(100) NOT NULL,
  width INT UNSIGNED NOT NULL,
  height INT UNSIGNED NOT NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (id),
  KEY idx_images_genre_id (genre_id),
  KEY idx_images_created_at (created_at),
  CONSTRAINT fk_images_genre_id FOREIGN KEY (genre_id) REFERENCES genres (id)
    ON UPDATE RESTRICT ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Laravel命名規約に従い image_tag（単数形）
CREATE TABLE IF NOT EXISTS image_tag (
  image_id BIGINT UNSIGNED NOT NULL,
  tag_id BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (image_id, tag_id),
  KEY idx_image_tag_tag_id (tag_id),
  CONSTRAINT fk_image_tag_image_id FOREIGN KEY (image_id) REFERENCES images (id)
    ON UPDATE RESTRICT ON DELETE CASCADE,
  CONSTRAINT fk_image_tag_tag_id FOREIGN KEY (tag_id) REFERENCES tags (id)
    ON UPDATE RESTRICT ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- サンプルデータ（開発用）
INSERT INTO genres (name, created_at, updated_at) VALUES 
('ロゴデザイン', NOW(), NOW()),
('バナー', NOW(), NOW()),
('イラスト', NOW(), NOW()),
('写真', NOW(), NOW());

INSERT INTO tags (name, created_at, updated_at) VALUES 
('赤', NOW(), NOW()),
('青', NOW(), NOW()),
('黄色', NOW(), NOW()),
('シンプル', NOW(), NOW()),
('モダン', NOW(), NOW()),
('レトロ', NOW(), NOW());
