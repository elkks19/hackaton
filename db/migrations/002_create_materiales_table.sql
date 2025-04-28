-- +goose Up
-- +goose StatementBegin
CREATE TABLE IF NOT EXISTS tipos_materiales(
	id INT PRIMARY KEY AUTO_INCREMENT,
	nombre VARCHAR(50) NOT NULL
);
-- +goose StatementEnd

-- +goose StatementBegin
CREATE TABLE IF NOT EXISTS materiales(
	id INT PRIMARY KEY AUTO_INCREMENT,
	tipo_id INT NOT NULL,
	nombre VARCHAR(100) NOT NULL,
	descripcion TEXT,

	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	deleted_at TIMESTAMP NULL,

	FOREIGN KEY (tipo_id) REFERENCES tipos_materiales(id)
);
-- +goose StatementEnd

-- +goose Down
-- +goose StatementBegin
DROP TABLE IF EXISTS materiales;
-- +goose StatementEnd
-- +goose StatementBegin
DROP TABLE IF EXISTS tipos_materiales;
-- +goose StatementEnd
