CREATE DATABASE webdb;
USE webdb;

CREATE TABLE accounts (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                       username varchar(50) NOT NULL UNIQUE,
                       password varchar(255) NOT NULL
);

CREATE TABLE tasks (task_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    id INT,
                    title TEXT NOT NULL,
                    FOREIGN KEY (id) REFERENCES accounts(id)
);


