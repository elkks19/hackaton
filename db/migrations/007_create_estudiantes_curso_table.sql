-- +goose Up
-- +goose StatementBegin
CREATE TABLE IF NOT EXISTS estudiantes_curso(
	estudiante_id INT NOT NULL,
	curso_id INT NOT NULL,

	rendimiento VARCHAR(50) DEFAULT 'APROBADO',
	observaciones TEXT,

	PRIMARY KEY (estudiante_id, curso_id),
	FOREIGN KEY (estudiante_id) REFERENCES estudiantes(id),
	FOREIGN KEY (curso_id) REFERENCES cursos(id)
);
-- +goose StatementEnd

-- +goose Down
-- +goose StatementBegin
DROP TABLE IF EXISTS estudiantes_curso;
-- +goose StatementEnd
