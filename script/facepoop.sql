CREATE TABLE users(
	user_id SERIAL PRIMARY KEY,
	login VARCHAR(50) NOT NULL,
	first_name VARCHAR(50) NOT NULL,
	last_name VARCHAR(50) NOT NULL,
	email VARCHAR(50) NOT NULL,
	password VARCHAR(50) NOT NULL,
	description VARCHAR(50),
	birthday_date DATE,
	register_date DATE NOT NULL DEFAULT CURRENT_DATE,
	is_active BOOLEAN
);

CREATE TABLE friendships(
	friendship_id SERIAL PRIMARY KEY,
	request_date DATE NOT NULL,
	acceptance_date DATE,
	block_date DATE
);

CREATE TABLE users_friendships(
	friendship_id int NOT NULL,
	user_id int NOT NULL,
	update_date date NOT NULL DEFAULT CURRENT_DATE,
	PRIMARY KEY (friendship_id, user_id),
	FOREIGN KEY (user_id) REFERENCES users (user_id),
	FOREIGN KEY (friendship_id) REFERENCES friendships (friendship_id)
);

--propriedade TEXT 'variable unlimited length'
CREATE TABLE comments(
	comment_id SERIAL PRIMARY KEY,
	user_id INT,
	texto TEXT,
	inclusion_date DATE NOT NULL,
	CONSTRAINT fk_users FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE images(
	image_id SERIAL PRIMARY KEY,
	user_id INT,
	file BYTEA,
	CONSTRAINT fk_users FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE posts(
	post_id SERIAL PRIMARY KEY,
	image_id INT,
	user_id INT NOT NULL,
	comment_id INT,
	text TEXT,
	inclusion_date DATE NOT NULL,
	is_deleted BOOLEAN,
	CONSTRAINT fk_users FOREIGN KEY (user_id) REFERENCES users(user_id),
	CONSTRAINT fk_comment FOREIGN KEY (comment_id) REFERENCES comments(comment_id),
	CONSTRAINT fk_image FOREIGN KEY (image_id) REFERENCES images(image_id)
);

CREATE TABLE reactions(
	reaction_id SERIAL PRIMARY KEY,
	user_id INT,
	post_id INT,
	reaction_value INT,
	inclusion_date DATE NOT NULL,
	CONSTRAINT fk_users FOREIGN KEY (user_id) REFERENCES users(user_id),
	CONSTRAINT fk_post FOREIGN KEY (post_id) REFERENCES posts(post_id)
);