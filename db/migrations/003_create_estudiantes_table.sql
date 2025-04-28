-- +goose Up
-- +goose StatementBegin
CREATE TABLE IF NOT EXISTS estudiantes(
	id INT PRIMARY KEY AUTO_INCREMENT,
	nombres VARCHAR(100) NOT NULL,
	apellidos VARCHAR(100) NOT NULL,
	ci VARCHAR(10) NOT NULL,
	telefono VARCHAR(8) NOT NULL,

	nombre_tutor VARCHAR(100) NOT NULL,
	telefono_tutor VARCHAR(8) NOT NULL,
	ci_tutor VARCHAR(10),

	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	deleted_at TIMESTAMP NULL
);
-- +goose StatementEnd

-- +goose Down
-- +goose StatementBegin
DROP TABLE IF EXISTS estudiantes;
-- -- +goose StatementEnd
