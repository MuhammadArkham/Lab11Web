-- Jalankan di phpMyAdmin > lab_ci4 > tab SQL

USE lab_ci4;

CREATE TABLE IF NOT EXISTS kategori (
    id_kategori INT(11) AUTO_INCREMENT,
    nama_kategori VARCHAR(100) NOT NULL,
    slug_kategori VARCHAR(100),
    PRIMARY KEY (id_kategori)
);

INSERT INTO kategori (nama_kategori, slug_kategori) VALUES
('Berita', 'berita'),
('Tutorial', 'tutorial'),
('Teknologi', 'teknologi'),
('Pendidikan', 'pendidikan');

ALTER TABLE artikel
ADD COLUMN id_kategori INT(11),
ADD CONSTRAINT fk_kategori_artikel
FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori);

UPDATE artikel SET id_kategori = 1 WHERE id_kategori IS NULL;
