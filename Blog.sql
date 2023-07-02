CREATE DATABASE IF NOT EXISTS db_ApiRest_Blog;
use db_ApiRest_Blog;

CREATE TABLE categories (
id				int(255) AUTO_INCREMENT NOT NULL,
name			varchar(100) NOT NULL,
created_at		datetime DEFAULT NULL,
updated_at		datetime DEFAULT NULL,
CONSTRAINT pk_categories PRIMARY KEY(id)
)ENGINE=InnoDB;

CREATE TABLE users (
id				int(255) AUTO_INCREMENT NOT NULL,
name			varchar(50) NOT NULL,
surname			varchar(100) NOT NULL,
role			varchar(20) NOT NULL,
email			varchar(255) NOT NULL,
password		varchar(255) NOT NULL,
description		text NOT NULL,
image			varchar(255),
created_at		datetime DEFAULT NULL,
updated_at		datetime DEFAULT NULL,
remember_token	varchar(255),
CONSTRAINT pk_users PRIMARY KEY(id),
CONSTRAINT uq_email UNIQUE(email)
)ENGINE=InnoDB;

CREATE TABLE posts (
id 				int(255) AUTO_INCREMENT NOT NULL,
user_id			int(255) NOT NULL,
category_id		int(255) NOT NULL,
title			varchar(255) NOT NULL,
content			text NOT NULL,
image			varchar(255),
created_at		datetime DEFAULT NULL,
updated_at		datetime DEFAULT NULL,
CONSTRAINT pk_posts PRIMARY KEY(id),
CONSTRAINT fk_post_user FOREIGN KEY(user_id) REFERENCES users(id),
CONSTRAINT fk_post_category FOREIGN KEY(category_id) REFERENCES categories(id)
)ENGINE=InnoDB;

/*Categories*/
INSERT INTO categories (name, created_at, updated_at) VALUES ('Technology', '2022-01-01 12:00:00', '2022-01-01 12:00:00');
INSERT INTO categories (name, created_at, updated_at) VALUES ('Business', '2022-01-01 12:00:00', '2022-01-01 12:00:00');
INSERT INTO categories (name, created_at, updated_at) VALUES ('Lifestyle', '2022-01-01 12:00:00', '2022-01-01 12:00:00');

-- Users
INSERT INTO users (name, surname, role, email, password, description, image, created_at, updated_at, remember_token)
VALUES ('John', 'Doe', 'admin', 'johndoe@example.com', 'password1', 'John is an admin with experience in managing systems', 'johndoe.jpg', '2022-01-01 12:00:00', '2022-01-01 12:00:00', 'token1');

INSERT INTO users (name, surname, role, email, password, description, image, created_at, updated_at, remember_token)
VALUES ('Jane', 'Smith', 'user', 'janesmith@example.com', 'password2', 'Jane is a user with experience in data analysis', 'janesmith.jpg', '2022-01-01 12:00:00', '2022-01-01 12:00:00', 'token2');

INSERT INTO users (name, surname, role, email, password, description, image, created_at, updated_at, remember_token)
VALUES ('Bob', 'Johnson', 'user', 'bobjohnson@example.com', 'password3', 'Bob is a user with experience in web development', 'bobjohnson.jpg', '2022-01-01 12:00:00', '2022-01-01 12:00:00', 'token3');

INSERT INTO users (name, surname, role, email, password, description, image, created_at, updated_at, remember_token)
VALUES ('Sara', 'Williams', 'admin', 'sarawilliams@example.com', 'password4', 'Sara is an admin with experience in project management', 'sarawilliams.jpg', '2022-01-01 12:00:00', '2022-01-01 12:00:00', 'token4');

INSERT INTO users (name, surname, role, email, password, description, image, created_at, updated_at, remember_token)
VALUES ('Mike', 'Brown', 'user', 'mikebrown@example.com', 'password5', 'Mike is a user with experience in graphic design', 'mikebrown.jpg', '2022-01-01 12:00:00', '2022-01-01 12:00:00', 'token5');

-- Posts
INSERT INTO posts (user_id, category_id, title, content, image, created_at, updated_at)
VALUES (1, 1, 'The Future of Technology', 'In this post, we will explore the latest advancements in technology and how they will shape our future.', 'future_of_technology.jpg', '2022-01-01 12:00:00', '2022-01-01 12:00:00');
Note: The user_id and category_id should be the ones you have in the users and categories table respectivaly.