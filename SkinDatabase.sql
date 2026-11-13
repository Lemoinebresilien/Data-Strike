-- Base de données des skins CS2
SET NAMES utf8mb4;
DROP DATABASE IF EXISTS skins_cs2;
CREATE DATABASE skins_cs2 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE skins_cs2;

CREATE TABLE Arme (
    id_arme   INT AUTO_INCREMENT PRIMARY KEY,
    nom       VARCHAR(50) NOT NULL,
    categorie VARCHAR(30) NOT NULL,
    camp      ENUM('T', 'CT', 'Les deux') NOT NULL
);

CREATE TABLE Finition (
    id_finition   INT AUTO_INCREMENT PRIMARY KEY,
    nom           VARCHAR(100) NOT NULL,
    type_finition VARCHAR(50) NOT NULL
);

CREATE TABLE Skin (
    id_skin     INT AUTO_INCREMENT PRIMARY KEY,
    rarete      VARCHAR(30) NOT NULL,
    collection  VARCHAR(100),
    float_min   DECIMAL(10,9) NOT NULL DEFAULT 0,
    float_max   DECIMAL(10,9) NOT NULL DEFAULT 1,
    id_arme     INT NOT NULL,
    id_finition INT NOT NULL,
    CONSTRAINT fk_skin_arme FOREIGN KEY (id_arme)
        REFERENCES Arme(id_arme) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_skin_finition FOREIGN KEY (id_finition)
        REFERENCES Finition(id_finition) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Exemplaire (
    id_exemplaire INT AUTO_INCREMENT PRIMARY KEY,
    float_valeur  DECIMAL(10,9) NOT NULL,
    pattern_seed  SMALLINT UNSIGNED NOT NULL,
    est_stattrak  BOOLEAN NOT NULL DEFAULT FALSE,
    nametag       VARCHAR(30),
    id_skin       INT NOT NULL,
    CONSTRAINT fk_exemplaire_skin FOREIGN KEY (id_skin)
        REFERENCES Skin(id_skin) ON DELETE CASCADE ON UPDATE CASCADE
);

-- ===== Données =====

INSERT INTO Arme (nom, categorie, camp) VALUES
('AK-47',      'Fusil d''assaut',   'T'),
('M4A4',       'Fusil d''assaut',   'CT'),
('M4A1-S',     'Fusil d''assaut',   'CT'),
('AWP',        'Fusil de précision','Les deux'),
('Desert Eagle','Pistolet',         'Les deux'),
('Glock-18',   'Pistolet',          'T'),
('USP-S',      'Pistolet',          'CT');

INSERT INTO Finition (nom, type_finition) VALUES
('Redline',        'Custom Paint Job'),
('Asiimov',        'Custom Paint Job'),
('Dragon Lore',    'Custom Paint Job'),
('Fire Serpent',   'Custom Paint Job'),
('Howl',           'Custom Paint Job'),
('Hyper Beast',    'Custom Paint Job'),
('Blaze',          'Anodized Airbrushed'),
('Fade',           'Anodized Airbrushed'),
('Kill Confirmed', 'Custom Paint Job'),
('Vulcan',         'Custom Paint Job');

INSERT INTO Skin (rarete, collection, float_min, float_max, id_arme, id_finition) VALUES
('Classified',    'The Phoenix Collection',  0.100000000, 0.700000000, 1, 1),  -- AK-47 | Redline
('Covert',       'The Phoenix Collection',  0.180000000, 1.000000000, 4, 2),  -- AWP | Asiimov
('Covert',       'The Cobblestone Collection', 0.000000000, 0.700000000, 4, 3),  -- AWP | Dragon Lore
('Covert',       'The Bravo Collection',    0.060000000, 0.760000000, 1, 4),  -- AK-47 | Fire Serpent
('Contraband',  'The Huntsman Collection', 0.000000000, 0.400000000, 2, 5),  -- M4A4 | Howl
('Covert',       'The Falchion Collection', 0.000000000, 1.000000000, 3, 6),  -- M4A1-S | Hyper Beast
('Restricted',    'The Dust Collection',     0.000000000, 0.080000000, 5, 7),  -- Desert Eagle | Blaze
('Restricted',    'The Assault Collection',  0.000000000, 0.080000000, 6, 8),  -- Glock-18 | Fade
('Covert',       'The Shadow Collection',   0.000000000, 1.000000000, 7, 9),  -- USP-S | Kill Confirmed
('Covert',       'The Huntsman Collection', 0.000000000, 0.900000000, 1, 10); -- AK-47 | Vulcan

INSERT INTO Exemplaire (float_valeur, pattern_seed, est_stattrak, nametag, id_skin) VALUES
(0.143820571, 412, true,  'Donked', 1),  -- AK-47 | Redline
(0.384192036, 87,  false, NULL,     1),  -- AK-47 | Redline
(0.192847301, 655, false, NULL,     2),  -- AWP | Asiimov
(0.012583946, 231, false, NULL,     3),  -- AWP | Dragon Lore
(0.071936284, 958, true,  NULL,     4),  -- AK-47 | Fire Serpent
(0.264018375, 19,  false, '无论猫头鹰如何尖叫它都不会停下来直到找到猎物为止', 5),  -- M4A4 | Howl
(0.008471925, 503, false, NULL,     6),  -- M4A1-S | Hyper Beast
(0.552390184, 774, false, NULL,     6),  -- M4A1-S | Hyper Beast
(0.031205847, 146, true,  NULL,     7),  -- Desert Eagle | Blaze
(0.019384756, 821, false, 'Sparkle', 8), -- Glock-18 | Fade
(0.098341627, 360, false, NULL,     9),  -- USP-S | Kill Confirmed
(0.437819204, 698, false, '山丘上渐起的风，传递着讯息。', 10); -- AK-47 | Vulcan