CREATE DATABASE zoo_assad

USE zoo_assad;

CREATE TABLE utilisateurs(
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    user_role ENUM('visiteur', 'guide', 'admin') NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    actif BOOLEAN DEFAULT,
    guide_approuve BOOLEAN DEFAULT 
);

CREATE TABLE habitats (
    id_hab INT AUTO_INCREMENT PRIMARY KEY,
    hab_name VARCHAR(100) NOT NULL,
    typeclimat VARCHAR(100),
    description TEXT,
    zonezoo VARCHAR(100)
);

CREATE TABLE animaux(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name_animal VARCHAR(100) NOT NULL,
    alimentation VARCHAR(100),
    image VARCHAR(255),
    live VARCHAR(100),
    description TEXT,
    id_habitat INT,
    views_animal INT DEFAULT 0,
    FOREIGN KEY (id_habitat) REFERENCES habitats(id_hab)
        ON DELETE SET NULL
);


CREATE TABLE visitesguidees (
    id_visites INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description_visites TEXT,
    date_visite DATE NOT NULL,
    start_visite TIME NOT NULL,
    duree_visite INT NOT NULL,
    langue VARCHAR(50),
    capacite_max INT NOT NULL,
    prix DECIMAL(8,2),
    statut ENUM('active','annulee') DEFAULT 'active',
    id_guide INT,
    views_visite INT DEFAULT 0,
    FOREIGN KEY (id_guide) REFERENCES utilisateurs(id)
        ON DELETE CASCADE
);

CREATE TABLE apesvisite (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title_step VARCHAR(150) NOT NULL,
    description_step TEXT,
    ordre_step INT NOT NULL,
    id_visite INT,
    FOREIGN KEY (id_visite) REFERENCES visitesguidees(id_visites)
        ON DELETE CASCADE
);

CREATE TABLE reservations (
    id_reserv INT AUTO_INCREMENT PRIMARY KEY,
    idvisite INT NOT NULL,
    iduser INT NOT NULL,
    numbers INT NOT NULL,
    date_reservation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idvisite) REFERENCES visitesguidees(id_visites)
        ON DELETE CASCADE,
    FOREIGN KEY (iduser) REFERENCES utilisateurs(id)
        ON DELETE CASCADE
);


INSERT INTO assad_users (username, email, user_role, password_hash )
VALUES (
  'Admin',
  'admin@gmail.com',
  'admin',
  'admin2007'
  
);