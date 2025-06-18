USE hw1;

/*CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(16) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    surname VARCHAR(255) NOT NULL
);
CREATE TABLE manga_ricercati (
  id INT PRIMARY KEY AUTO_INCREMENT,
  manga_id VARCHAR(255) UNIQUE,
  titolo VARCHAR(255),
  copertina_url TEXT,
  data_ricerca DATETIME DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE carrello (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  manga_id VARCHAR(100),
  titolo VARCHAR(255),
  copertina_url TEXT,
  prezzo DECIMAL(6,2)

);
CREATE TABLE preferiti (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT NOT NULL,
  manga_id VARCHAR(100) NOT NULL,
  titolo VARCHAR(255),
  copertina_url TEXT,
  UNIQUE(user_id, manga_id) 
);*/
