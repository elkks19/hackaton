-- +goose Up
-- +goose StatementBegin
CREATE TABLE IF NOT EXISTS cursos(
	id INT PRIMARY KEY AUTO_INCREMENT,
	profesor_id INT NOT NULL,

	nombre VARCHAR(255) NOT NULL,
	descripcion TEXT,
	fecha_inicio DATE NOT NULL,
	fecha_fin DATE NOT NULL,

	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	deleted_at TIMESTAMP,

	FOREIGN KEY (profesor_id) REFERENCES usuarios(id)
);
-- +goose StatementEnd

-- +goose Down
-- +goose StatementBegin
DROP TABLE IF EXISTS cursos;
-- +goose StatementEnd
