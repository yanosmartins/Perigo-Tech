CREATE TABLE usuarios (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(100),
  email VARCHAR(100),
  senha VARCHAR(100),
  nome_mae VARCHAR(100),
  data_nascimento DATE,
  cep VARCHAR(20),
  tipo ENUM('comum','master')
);
