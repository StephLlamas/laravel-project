CREATE DATABASE IF NOT EXISTS laravel_master;
USE laravel_master;

CREATE TABLE IF NOT EXISTS users(
id              int(255) auto_increment not null,
role            varchar(20),
name            varchar(100),
surname         varchar(200),
nick            varchar(100),
email           varchar(255),
password        varchar(255),
image           varchar(255),
created_at      datetime,
updated_at      datetime,
remember_token  varchar(255),
CONSTRAINT pk_users PRIMARY KEY(id)
)ENGINE=InnoDb,
CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

INSERT INTO users VALUES(NULL, 'user', 'Steph', 'Llamas', 'stephflames', 'steph.flames@hotmail.com', 'stephflames', NULL, CURTIME(), CURTIME(), NULL);
INSERT INTO users VALUES(NULL, 'user', 'Bubu', 'Bubu', 'Bubu', 'Bubu@hotmail.com', 'Bubu', NULL, CURTIME(), CURTIME(), NULL);
INSERT INTO users VALUES(NULL, 'user', 'Cobejo', 'Cobejo', 'Cobejo', 'Cobejo@hotmail.com', 'Cobejo', NULL, CURTIME(), CURTIME(), NULL);

CREATE TABLE IF NOT EXISTS images(
id              int(255) auto_increment not null,
user_id         int(255),
image_path      varchar(255),
description     text,
created_at      datetime,
updated_at      datetime,
CONSTRAINT pk_images PRIMARY KEY(id),
CONSTRAINT fk_images_users FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE=InnoDb,
CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

INSERT INTO images VALUES(NULL, 1, 'test.jpg', 'desc de prueba', CURTIME(), CURTIME());
INSERT INTO images VALUES(NULL, 1, 'prueba.jpg', 'desc de prueba', CURTIME(), CURTIME());
INSERT INTO images VALUES(NULL, 1, 'test2.jpg', 'desc de prueba', CURTIME(), CURTIME());
INSERT INTO images VALUES(NULL, 3, 'prueba2.jpg', 'desc de prueba', CURTIME(), CURTIME());

CREATE TABLE IF NOT EXISTS comments(
id              int(255) auto_increment not null,
user_id         int(255),
image_id        int(255),
content         text,
created_at      datetime,
updated_at      datetime,
CONSTRAINT pk_comments PRIMARY KEY(id),
CONSTRAINT fk_comments_users FOREIGN KEY(user_id) REFERENCES users(id),
CONSTRAINT fk_comments_images FOREIGN KEY(image_id) REFERENCES images(id)
)ENGINE=InnoDb,
CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

INSERT INTO comments VALUES(NULL, 1, 4, 'comentario de prueba', CURTIME(), CURTIME());
INSERT INTO comments VALUES(NULL, 2, 1, 'comentario de prueba', CURTIME(), CURTIME());
INSERT INTO comments VALUES(NULL, 2, 4, 'comentario de prueba', CURTIME(), CURTIME());

CREATE TABLE IF NOT EXISTS likes(
id              int(255) auto_increment not null,
user_id         int(255),
image_id        int(255),
created_at      datetime,
updated_at      datetime,
CONSTRAINT pk_likes PRIMARY KEY(id),
CONSTRAINT fk_likes_users FOREIGN KEY(user_id) REFERENCES users(id),
CONSTRAINT fk_likes_images FOREIGN KEY(image_id) REFERENCES images(id)
)ENGINE=InnoDb,
CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

INSERT INTO likes VALUES(NULL, 1, 4, CURTIME(), CURTIME());
INSERT INTO likes VALUES(NULL, 2, 4, CURTIME(), CURTIME());
INSERT INTO likes VALUES(NULL, 3, 1, CURTIME(), CURTIME());
INSERT INTO likes VALUES(NULL, 3, 2, CURTIME(), CURTIME());
INSERT INTO likes VALUES(NULL, 2, 1, CURTIME(), CURTIME());
