-- +goose Up
-- +goose StatementBegin
CREATE TABLE IF NOT EXISTS estudiantes_curso(
	estudiante_id INT NOT NULL,
	curso_id INT NOT NULL,
	rendimiento VARCHAR(50) DEFAULT 'APROBADO',
	observaciones TEXT
);
-- +goose StatementEnd

-- +goose Down
-- +goose StatementBegin
DROP TABLE IF EXISTS estudiantes_curso;
-- +goose StatementEnd
