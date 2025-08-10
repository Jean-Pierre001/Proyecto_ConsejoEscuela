-- --- Categoría 1 ---
INSERT INTO categories (name, description) VALUES ('Primaria', 'Escuelas de nivel primario');
SET @cat1 = LAST_INSERT_ID();

-- Escuela 1 con categoría 1
INSERT INTO schools (schoolName, order_number, category_id, is_disadvantaged, shift, service_code, shared_building, cue_code, address, locality, phone, email)
VALUES ('Escuela 1', 1, @cat1, 0, 'Mañana', 'SC001', NULL, 'CUE001', 'Calle 1', 'Ciudad A', '111111111', 'esc1@example.com');
SET @school1 = LAST_INSERT_ID();

INSERT INTO authorities (school_id, role, name, personal_phone, personal_email)
VALUES (@school1, 'Director', 'Director 1', '3000000001', 'director1@example.com');

-- Escuela 2 con categoría 1
INSERT INTO schools (schoolName, order_number, category_id, is_disadvantaged, shift, service_code, shared_building, cue_code, address, locality, phone, email)
VALUES ('Escuela 2', 2, @cat1, 1, 'Tarde', 'SC002', 'Edificio A', 'CUE002', 'Calle 2', 'Ciudad A', '222222222', 'esc2@example.com');
SET @school2 = LAST_INSERT_ID();

INSERT INTO authorities (school_id, role, name, personal_phone, personal_email)
VALUES (@school2, 'Director', 'Director 2', '3000000002', 'director2@example.com');

-- Escuela 3 con categoría 1
INSERT INTO schools (schoolName, order_number, category_id, is_disadvantaged, shift, service_code, shared_building, cue_code, address, locality, phone, email)
VALUES ('Escuela 3', 3, @cat1, 0, 'Mañana', 'SC003', NULL, 'CUE003', 'Calle 3', 'Ciudad B', '333333333', 'esc3@example.com');
SET @school3 = LAST_INSERT_ID();

INSERT INTO authorities (school_id, role, name, personal_phone, personal_email)
VALUES (@school3, 'Director', 'Director 3', '3000000003', 'director3@example.com');

-- (Agrega más escuelas con @cat1 según necesites, aquí pondré solo 5 para categoría 1)

INSERT INTO schools (schoolName, order_number, category_id, is_disadvantaged, shift, service_code, shared_building, cue_code, address, locality, phone, email)
VALUES ('Escuela 4', 4, @cat1, 0, 'Tarde', 'SC004', NULL, 'CUE004', 'Calle 4', 'Ciudad B', '444444444', 'esc4@example.com');
SET @school4 = LAST_INSERT_ID();

INSERT INTO authorities (school_id, role, name, personal_phone, personal_email)
VALUES (@school4, 'Director', 'Director 4', '3000000004', 'director4@example.com');

INSERT INTO schools (schoolName, order_number, category_id, is_disadvantaged, shift, service_code, shared_building, cue_code, address, locality, phone, email)
VALUES ('Escuela 5', 5, @cat1, 1, 'Mañana', 'SC005', 'Edificio B', 'CUE005', 'Calle 5', 'Ciudad C', '555555555', 'esc5@example.com');
SET @school5 = LAST_INSERT_ID();

INSERT INTO authorities (school_id, role, name, personal_phone, personal_email)
VALUES (@school5, 'Director', 'Director 5', '3000000005', 'director5@example.com');



-- --- Categoría 2 ---
INSERT INTO categories (name, description) VALUES ('Secundaria', 'Escuelas de nivel secundario');
SET @cat2 = LAST_INSERT_ID();

-- Escuelas con categoría 2 (5 escuelas para ejemplo)

INSERT INTO schools (schoolName, order_number, category_id, is_disadvantaged, shift, service_code, shared_building, cue_code, address, locality, phone, email)
VALUES ('Escuela 6', 6, @cat2, 0, 'Mañana', 'SC006', NULL, 'CUE006', 'Calle 6', 'Ciudad C', '666666666', 'esc6@example.com');
SET @school6 = LAST_INSERT_ID();

INSERT INTO authorities (school_id, role, name, personal_phone, personal_email)
VALUES (@school6, 'Director', 'Director 6', '3000000006', 'director6@example.com');

INSERT INTO schools (schoolName, order_number, category_id, is_disadvantaged, shift, service_code, shared_building, cue_code, address, locality, phone, email)
VALUES ('Escuela 7', 7, @cat2, 0, 'Tarde', 'SC007', NULL, 'CUE007', 'Calle 7', 'Ciudad D', '777777777', 'esc7@example.com');
SET @school7 = LAST_INSERT_ID();

INSERT INTO authorities (school_id, role, name, personal_phone, personal_email)
VALUES (@school7, 'Director', 'Director 7', '3000000007', 'director7@example.com');

INSERT INTO schools (schoolName, order_number, category_id, is_disadvantaged, shift, service_code, shared_building, cue_code, address, locality, phone, email)
VALUES ('Escuela 8', 8, @cat2, 1, 'Mañana', 'SC008', 'Edificio C', 'CUE008', 'Calle 8', 'Ciudad D', '888888888', 'esc8@example.com');
SET @school8 = LAST_INSERT_ID();

INSERT INTO authorities (school_id, role, name, personal_phone, personal_email)
VALUES (@school8, 'Director', 'Director 8', '3000000008', 'director8@example.com');

INSERT INTO schools (schoolName, order_number, category_id, is_disadvantaged, shift, service_code, shared_building, cue_code, address, locality, phone, email)
VALUES ('Escuela 9', 9, @cat2, 0, 'Tarde', 'SC009', NULL, 'CUE009', 'Calle 9', 'Ciudad E', '999999999', 'esc9@example.com');
SET @school9 = LAST_INSERT_ID();

INSERT INTO authorities (school_id, role, name, personal_phone, personal_email)
VALUES (@school9, 'Director', 'Director 9', '3000000009', 'director9@example.com');

INSERT INTO schools (schoolName, order_number, category_id, is_disadvantaged, shift, service_code, shared_building, cue_code, address, locality, phone, email)
VALUES ('Escuela 10', 10, @cat2, 0, 'Mañana', 'SC010', NULL, 'CUE010', 'Calle 10', 'Ciudad E', '1010101010', 'esc10@example.com');
SET @school10 = LAST_INSERT_ID();

INSERT INTO authorities (school_id, role, name, personal_phone, personal_email)
VALUES (@school10, 'Director', 'Director 10', '3000000010', 'director10@example.com');


-- --- Categoría 3 ---
INSERT INTO categories (name, description) VALUES ('Especial', 'Escuelas con necesidades especiales');
SET @cat3 = LAST_INSERT_ID();

-- Escuelas con categoría 3 (5 escuelas para ejemplo)

INSERT INTO schools (schoolName, order_number, category_id, is_disadvantaged, shift, service_code, shared_building, cue_code, address, locality, phone, email)
VALUES ('Escuela 11', 11, @cat3, 0, 'Tarde', 'SC011', NULL, 'CUE011', 'Calle 11', 'Ciudad F', '111111222', 'esc11@example.com');
SET @school11 = LAST_INSERT_ID();

INSERT INTO authorities (school_id, role, name, personal_phone, personal_email)
VALUES (@school11, 'Director', 'Director 11', '3000000011', 'director11@example.com');

INSERT INTO schools (schoolName, order_number, category_id, is_disadvantaged, shift, service_code, shared_building, cue_code, address, locality, phone, email)
VALUES ('Escuela 12', 12, @cat3, 1, 'Mañana', 'SC012', 'Edificio D', 'CUE012', 'Calle 12', 'Ciudad F', '222222333', 'esc12@example.com');
SET @school12 = LAST_INSERT_ID();

INSERT INTO authorities (school_id, role, name, personal_phone, personal_email)
VALUES (@school12, 'Director', 'Director 12', '3000000012', 'director12@example.com');

INSERT INTO schools (schoolName, order_number, category_id, is_disadvantaged, shift, service_code, shared_building, cue_code, address, locality, phone, email)
VALUES ('Escuela 13', 13, @cat3, 0, 'Tarde', 'SC013', NULL, 'CUE013', 'Calle 13', 'Ciudad G', '333333444', 'esc13@example.com');
SET @school13 = LAST_INSERT_ID();

INSERT INTO authorities (school_id, role, name, personal_phone, personal_email)
VALUES (@school13, 'Director', 'Director 13', '3000000013', 'director13@example.com');

INSERT INTO schools (schoolName, order_number, category_id, is_disadvantaged, shift, service_code, shared_building, cue_code, address, locality, phone, email)
VALUES ('Escuela 14', 14, @cat3, 0, 'Mañana', 'SC014', NULL, 'CUE014', 'Calle 14', 'Ciudad G', '444444555', 'esc14@example.com');
SET @school14 = LAST_INSERT_ID();

INSERT INTO authorities (school_id, role, name, personal_phone, personal_email)
VALUES (@school14, 'Director', 'Director 14', '3000000014', 'director14@example.com');

INSERT INTO schools (schoolName, order_number, category_id, is_disadvantaged, shift, service_code, shared_building, cue_code, address, locality, phone, email)
VALUES ('Escuela 15', 15, @cat3, 1, 'Tarde', 'SC015', 'Edificio E', 'CUE015', 'Calle 15', 'Ciudad H', '555555666', 'esc15@example.com');
SET @school15 = LAST_INSERT_ID();

INSERT INTO authorities (school_id, role, name, personal_phone, personal_email)
VALUES (@school15, 'Director', 'Director 15', '3000000015', 'director15@example.com');

-- ATENCION!!! ANTES DE HACER EL INSERT SQL EN PHPMYADMIN ELIMINAR LOS ANTERIORES
-- DE LO CONTRARIO TE DARÁ ERROR POR LLAVE PRIMARIA DUPLICADA

