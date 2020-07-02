CREATE DATABASE IF NOT EXISTS laravel_master;
USE laravel_master;

CREATE TABLE IF NOT EXISTS users(
id int(255) auto_increment not null,
role varchar(20),
name varchar(100),
surname varchar(200),
nick varchar(100),
email varchar(255),
password varchar(255),
image varchar(255),
create_at datetime,
updated_at datetime,
remember_token varchar(255),
CONSTRAINT pk_users PRIMARY KEY(id)
)ENGINE=InnoDb;

INSERT INTO users VALUES(NULL,'user','Jonathan','Garcia','Proton','proton@gmail.com','123456' ,NULL,CURTIME(),CURTIME(),NULL);
INSERT INTO users VALUES(NULL,'user','Jose','Escobar','Josh','josh@gmail.com','123456' ,NULL,CURTIME(),CURTIME(),NULL);
INSERT INTO users VALUES(NULL,'user','Alex','Jarquin','Jarmar','jarmar@gmail.com','123456' ,NULL,CURTIME(),CURTIME(),NULL);

CREATE TABLE IF NOT EXISTS images(
id int(255) auto_increment not null,
user_id int(255),
image_path varchar(255),
description text,
create_at datetime,
updated_at datetime,
CONSTRAINT pk_images PRIMARY KEY(id),
CONSTRAINT fk_images_users FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE=InnoDb;

INSERT INTO images VALUES(NULL,1,'test1.jpg','descripcion de test1',CURTIME(),CURTIME());
INSERT INTO images VALUES(NULL,2,'test2.jpg','descripcion de test2',CURTIME(),CURTIME());
INSERT INTO images VALUES(NULL,1,'test-play.jpg','descripcion de play',CURTIME(),CURTIME());
INSERT INTO images VALUES(NULL,3,'test3.jpg','descripcion de test3',CURTIME(),CURTIME());

CREATE TABLE IF NOT EXISTS comments(
id int(255) auto_increment not null,
user_id int(255),
image_id int(255),
content text,
create_at datetime,
updated_at datetime,
CONSTRAINT pk_comments PRIMARY KEY(id),
CONSTRAINT fk_comments_users FOREIGN KEY(user_id) REFERENCES users(id),
CONSTRAINT fk_comments_images FOREIGN KEY(image_id) REFERENCES images(id)
)ENGINE=InnoDb;

INSERT INTO comments VALUES(NULL,1,1,'cemntario a la imagen 1',CURTIME(),CURTIME());
INSERT INTO comments VALUES(NULL,1,3,'cemntario a la imagen 3',CURTIME(),CURTIME());
INSERT INTO comments VALUES(NULL,2,2,'cemntario a la imagen 2 jeje mi foto',CURTIME(),CURTIME());
INSERT INTO comments VALUES(NULL,1,2,'cemntario a la imagen 2 que gay',CURTIME(),CURTIME());

CREATE TABLE IF NOT EXISTS likes(
id int(255) auto_increment not null,
user_id int(255),
image_id int(255),
create_at datetime,
updated_at datetime,
CONSTRAINT pk_likes PRIMARY KEY(id),
CONSTRAINT fk_likes_users FOREIGN KEY(user_id) REFERENCES users(id),
CONSTRAINT fk_likes_images FOREIGN KEY(image_id) REFERENCES images(id)
)ENGINE=InnoDb;

INSERT INTO likes VALUES(NULL,1,1,CURTIME(),CURTIME());
INSERT INTO likes VALUES(NULL,1,3,CURTIME(),CURTIME());
INSERT INTO likes VALUES(NULL,2,2,CURTIME(),CURTIME());
INSERT INTO likes VALUES(NULL,1,2,CURTIME(),CURTIME());