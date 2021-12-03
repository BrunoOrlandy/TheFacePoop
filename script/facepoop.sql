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
	image_id INT,
	is_active BOOLEAN,
	CONSTRAINT fk_image FOREIGN KEY (image_id) REFERENCES images(image_id)
);


CREATE TABLE friendships(
	id SERIAL PRIMARY KEY,
	user_to_id int NOT NULL,
	user_id int NOT NULL,
	request_date DATE NOT NULL,
	acceptance_date DATE,
	block_date DATE,
	FOREIGN KEY (user_id) REFERENCES users (user_id)
);

--propriedade TEXT 'variable unlimited length'
CREATE TABLE comments(
	comment_id SERIAL PRIMARY KEY,
	user_id INT,
	text TEXT,
	inclusion_date DATE NOT NULL,
	CONSTRAINT fk_users FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE images(
	image_id SERIAL PRIMARY KEY,
	file BYTEA
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