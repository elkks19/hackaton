-- +goose Up
-- +goose StatementBegin
CREATE TABLE IF NOT EXISTS roles(
	id INT PRIMARY KEY AUTO_INCREMENT,
	nombre VARCHAR(100) NOT NULL
);
-- +goose StatementEnd

-- +goose StatementBegin
CREATE TABLE IF NOT EXISTS usuarios(
	id INT PRIMARY KEY AUTO_INCREMENT,
	rol_id INT NOT NULL,

	nombres VARCHAR(100) NOT NULL,
	apellidos VARCHAR(100) NOT NULL,
	telefono VARCHAR(8) NOT NULL,
	direccion TEXT NOT NULL,
	ci VARCHAR(10) NOT NULL,
	fecha_nacimiento DATE NOT NULL,

	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	deleted_at TIMESTAMP,

	FOREIGN KEY (rol_id) REFERENCES roles(id)
);
-- +goose StatementEnd

-- +goose Down
-- +goose StatementBegin
DROP TABLE IF EXISTS usuarios;
-- +goose StatementEnd
-- +goose StatementBegin
DROP TABLE IF EXISTS roles;
-- +goose StatementEnd
