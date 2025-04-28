-- +goose Up
-- +goose StatementBegin
CREATE TABLE IF NOT EXISTS inscripciones(
	id INT PRIMARY KEY AUTO_INCREMENT,
	estudiante_id INT NOT NULL,
	fecha DATE NOT NULL DEFAULT CURRENT_DATE,

	tipo_discapacidad VARCHAR(255) NOT NULL,

	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	deleted_at TIMESTAMP,

	FOREIGN KEY (estudiante_id) REFERENCES estudiantes(id)
);
-- +goose StatementEnd

-- +goose StatementBegin
CREATE TABLE IF NOT EXISTS documentos(
	id INT PRIMARY KEY AUTO_INCREMENT,
	inscripcion_id INT NOT NULL,

	url_documento VARCHAR(255) NOT NULL,

	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	deleted_at TIMESTAMP NULL,

	FOREIGN KEY (inscripcion_id) REFERENCES inscripciones(id)
);
-- +goose StatementEnd

-- +goose Down
-- +goose StatementBegin
DROP TABLE IF EXISTS documentos;
-- +goose StatementEnd
-- +goose StatementBegin
DROP TABLE IF EXISTS inscripciones;
-- +goose StatementEnd
