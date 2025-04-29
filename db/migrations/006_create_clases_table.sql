-- +goose Up
-- +goose StatementBegin
CREATE TABLE IF NOT EXISTS clases(
	id INT PRIMARY KEY AUTO_INCREMENT,
	curso_id INT NOT NULL,
	fecha DATE NOT NULL,
	hora TIME NOT NULL,
	estado ENUM('CANCELADA', 'POSPUESTA', 'SUSPENDIDA', 'REALIZADA') DEFAULT 'REALIZADA',
	
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

	FOREIGN KEY (curso_id) REFERENCES cursos(id)
);
-- +goose StatementEnd

-- +goose Down
-- +goose StatementBegin
DROP TABLE IF EXISTS clases;
-- +goose StatementEnd
