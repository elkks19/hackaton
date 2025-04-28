-- +goose Up
-- +goose StatementBegin
CREATE TABLE IF NOT EXISTS asistencia_profesores(
	clase_id INT NOT NULL,
	profesor_id INT NOT NULL,

	PRIMARY KEY(clase_id, profesor_id),
	FOREIGN KEY (clase_id) REFERENCES clases(id),
	FOREIGN KEY (profesor_id) REFERENCES usuarios(id)
);
-- +goose StatementEnd

-- +goose StatementBegin
CREATE TABLE IF NOT EXISTS asistencia_estudiantes(
	clase_id INT NOT NULL,
	estudiante_id INT NOT NULL,

	PRIMARY KEY(clase_id, estudiante_id),
	FOREIGN KEY (clase_id) REFERENCES clases(id),
	FOREIGN KEY (estudiante_id) REFERENCES estudiantes(id)
);
-- +goose StatementEnd

-- +goose Down
-- +goose StatementBegin
DROP TABLE IF EXISTS asistencia_estudiantes;
-- +goose StatementEnd
-- +goose StatementBegin
DROP TABLE IF EXISTS asistencia_profesores;
-- +goose StatementEnd
