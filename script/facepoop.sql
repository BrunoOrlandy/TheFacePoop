CREATE TABLE usuario(
	usuario_id SERIAL PRIMARY KEY,
	login VARCHAR(50) NOT NULL,
	nome VARCHAR(50) NOT NULL,
	email VARCHAR(50) NOT NULL,
	descricao VARCHAR(50) NOT NULL,
	data_aniversario DATE,
	data_inclusao DATE NOT NULL DEFAULT CURRENT_DATE
);

CREATE TABLE amizade(
	amizade_id SERIAL PRIMARY KEY,
	data_solicitacao DATE NOT NULL,
	data_aceite DATE,
	data_bloqueio DATE
);

CREATE TABLE usuario_amizade(
	amizade_id int NOT NULL,
	usuario_id int NOT NULL,
	data_atualizacao date NOT NULL DEFAULT CURRENT_DATE,
	PRIMARY KEY (amizade_id, usuario_id),
	FOREIGN KEY (usuario_id) REFERENCES usuario (usuario_id),
	FOREIGN KEY (amizade_id) REFERENCES amizade (amizade_id)
);

--propriedade TEXT 'variable unlimited length'
CREATE TABLE comentario(
	comentario_id SERIAL PRIMARY KEY,
	usuario_id INT,
	texto TEXT,
	data_inclusao DATE NOT NULL,
	CONSTRAINT fk_usuario FOREIGN KEY (usuario_id) REFERENCES usuario(usuario_id)
);

CREATE TABLE imagem(
	imagem_id SERIAL PRIMARY KEY,
	usuario_id INT,
	CONSTRAINT fk_usuario FOREIGN KEY (usuario_id) REFERENCES usuario(usuario_id)
);

CREATE TABLE postagem(
	postagem_id SERIAL PRIMARY KEY,
	imagem_id INT,
	usuario_id INT NOT NULL,
	comentario_id INT,
	texto TEXT,
	data_inclusao DATE NOT NULL,
	CONSTRAINT fk_usuario FOREIGN KEY (usuario_id) REFERENCES usuario(usuario_id),
	CONSTRAINT fk_comentario FOREIGN KEY (comentario_id) REFERENCES comentario(comentario_id),
	CONSTRAINT fk_imagem FOREIGN KEY (imagem_id) REFERENCES imagem(imagem_id)
);

CREATE TABLE reacao(
	reacao_id SERIAL PRIMARY KEY,
	usuario_id INT,
	postagem_id INT,
	gostou INT,
	nao_gostou INT,
	espanto INT,
	risada INT,
	tristeza INT,
	raiva INT,
	data_inclusao DATE NOT NULL,
	CONSTRAINT fk_usuario FOREIGN KEY (usuario_id) REFERENCES usuario(usuario_id),
	CONSTRAINT fk_postagem FOREIGN KEY (postagem_id) REFERENCES postagem(postagem_id)
);