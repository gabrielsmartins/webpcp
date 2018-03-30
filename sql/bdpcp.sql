
DROP DATABASE IF EXISTS bdpcp;
CREATE DATABASE bdpcp;
USE bdpcp;

CREATE TABLE perfil(
	perf_id BIGINT NOT NULL AUTO_INCREMENT,
    perf_desc VARCHAR(200) NOT NULL,
	CONSTRAINT PK_perfil PRIMARY KEY(perf_id),
    CONSTRAINT UNQ_perfil_desc UNIQUE(perf_desc)
);



CREATE TABLE usuario(
       usr_id BIGINT AUTO_INCREMENT NOT NULL,
       usr_perf_id BIGINT NOT NULL,
       usr_nome VARCHAR(200) NOT NULL,
       usr_login VARCHAR(200) NOT NULL,
       usr_pwd VARCHAR(200) NOT NULL,
       usr_ativo BOOLEAN DEFAULT 1 NOT NULL,
       CONSTRAINT PK_usuario PRIMARY KEY(usr_id),
       CONSTRAINT FK_usuario_perfil FOREIGN KEY(usr_perf_id) REFERENCES perfil(perf_id) ON DELETE CASCADE,
       CONSTRAINT UNQ_usuario_nome UNIQUE(usr_nome)
);



CREATE TABLE unidade(
       unid_id BIGINT AUTO_INCREMENT NOT NULL,
       unid_desc VARCHAR(200) NOT NULL,
       unid_sig VARCHAR(10) NOT NULL,
       CONSTRAINT PK_unidade PRIMARY KEY(unid_id),
       CONSTRAINT UNQ_unidade_desc UNIQUE(unid_desc),
       CONSTRAINT UNQ_sig UNIQUE(unid_sig)
);



CREATE TABLE setor(
       setr_id BIGINT AUTO_INCREMENT NOT NULL,
       setr_desc VARCHAR(200) NOT NULL,
       CONSTRAINT PK_setr_id PRIMARY KEY(setr_id),
       CONSTRAINT UNQ_setor_desc UNIQUE(setr_desc)	
);


CREATE TABLE operacao(
       oper_id BIGINT AUTO_INCREMENT NOT NULL,
       oper_desc VARCHAR(200) NOT NULL,
       oper_instr VARCHAR(500) NOT NULL,
       oper_setr_id BIGINT NOT NULL,
       CONSTRAINT PK_oper_id  PRIMARY KEY(oper_id),
       CONSTRAINT FK_operacao_setor FOREIGN KEY(oper_setr_id) REFERENCES setor(setr_id)  ON DELETE CASCADE,
       CONSTRAINT UNQ_operacao_desc UNIQUE(oper_desc)	
);


CREATE TABLE recurso(
       recr_id BIGINT AUTO_INCREMENT NOT NULL,
       recr_desc VARCHAR(200) NOT NULL,
       recr_setr_id BIGINT NOT NULL,
       CONSTRAINT PK_recr_id PRIMARY KEY(recr_id),
       CONSTRAINT FK_recurso_operacao FOREIGN KEY (recr_setr_id) REFERENCES setor(setr_id)  ON DELETE CASCADE,
       CONSTRAINT UNQ_recurso_desc UNIQUE(recr_desc)	
);



CREATE TABLE produto(
       prod_id BIGINT AUTO_INCREMENT NOT NULL,
       prod_cod_intr VARCHAR(500) DEFAULT NULL,
       prod_unid_id BIGINT NOT NULL,
       prod_desc VARCHAR(200) NOT NULL,
       prod_sit VARCHAR(200) NOT NULL,
       prod_peso_kg NUMERIC(15,4) DEFAULT NULL,
       prod_comp_mm NUMERIC(15,4) DEFAULT NULL,
       prod_larg_mm NUMERIC(15,4) DEFAULT NULL,
       prod_alt_mm NUMERIC(15,4) DEFAULT NULL,
       prod_vlr_unit NUMERIC(15,2) NOT NULL,
       prod_lead_time INT NOT NULL,
       prod_qntd_estq NUMERIC(15,4) NOT NULL,
       prod_qntd_min NUMERIC(15,4) NOT NULL,
       prod_tipo VARCHAR(200) NOT NULL,
       CONSTRAINT PK_produto PRIMARY KEY(prod_id),
       CONSTRAINT UNQ_produto_codigo_interno UNIQUE(prod_cod_intr),
       CONSTRAINT FK_produto_unidade FOREIGN KEY(prod_unid_id) REFERENCES unidade(unid_id)  ON DELETE CASCADE,
       CONSTRAINT CHK_produto_situacao CHECK(prod_sit IN('ATIVO','INATIVO','FORA_DE_LINHA'))
);



CREATE TABLE estrutura_produto(
       prod_id BIGINT NOT NULL,
       prod_sub_id BIGINT NOT NULL,
       prod_sub_qntd NUMERIC(15,4) NOT NULL,
       CONSTRAINT PK_estrutura_produto PRIMARY KEY(prod_id,prod_sub_id),
       CONSTRAINT FK_estrutura_produto_produto FOREIGN KEY(prod_id)REFERENCES produto(prod_id)  ON UPDATE CASCADE ON DELETE CASCADE,
       CONSTRAINT FK_estrutura_produto_subproduto FOREIGN KEY(prod_sub_id)REFERENCES produto(prod_id)  ON UPDATE CASCADE ON DELETE CASCADE
);


CREATE TABLE roteiro(
		 rot_prod_id BIGINT NOT NULL,
	     rot_oper_id BIGINT NOT NULL,
	     rot_seq INT NOT NULL,
	     rot_tmp_stp TIME NOT NULL,
	     rot_tmp_prd TIME NOT NULL,
	     rot_tmp_fnl TIME NOT NULL,
		 CONSTRAINT PK_roteiro PRIMARY KEY(rot_prod_id,rot_oper_id,rot_seq),
		 CONSTRAINT FK_roteiro_produto FOREIGN KEY(rot_prod_id) REFERENCES produto(prod_id) ON UPDATE CASCADE ON DELETE CASCADE,
		 CONSTRAINT FK_roteiro_operacao FOREIGN KEY(rot_oper_id) REFERENCES operacao(oper_id) ON UPDATE CASCADE ON DELETE CASCADE
);


CREATE TABLE ordem_producao(
	     ord_id BIGINT AUTO_INCREMENT NOT NULL,
		 ord_prod_id BIGINT NOT NULL,
         ord_prod_qntd NUMERIC(15,2) NOT NULL,
	     ord_dt_emi TIMESTAMP  DEFAULT CURRENT_TIMESTAMP,
	     ord_prazo  DATE NOT NULL,
	     ord_usr_id BIGINT NOT NULL,
	     ord_dt_concl TIMESTAMP ,
	     ord_status VARCHAR(500) NOT NULL DEFAULT 'EMITIDA',
	     CONSTRAINT PK_ordem_producao PRIMARY KEY(ord_prod_id),
	     CONSTRAINT FK_ordem_producao_produto FOREIGN KEY(ord_id) REFERENCES produto(prod_id),
	     CONSTRAINT FK_ordem_producao_usuario FOREIGN KEY(ord_usr_id) REFERENCES usuario(usr_id),
	     CONSTRAINT CHK_ordem_producao_status CHECK(ord_status IN('EMITIDA','INICIADA','ENCERRADA','CANCELADA'))     
);



CREATE TABLE requisicao_material(
	     rm_id BIGINT AUTO_INCREMENT NOT NULL,
	     rm_dt_emi TIMESTAMP  DEFAULT CURRENT_TIMESTAMP,
	     rm_prazo  DATE NOT NULL,
	     rm_usr_id BIGINT NOT NULL,
	     rm_dt_concl TIMESTAMP ,
	     rm_status VARCHAR(500) NOT NULL DEFAULT 'EMITIDA',
	     CONSTRAINT PK_requisicao_material PRIMARY KEY(rm_id),
	     CONSTRAINT FK_requisicao_material_usuario FOREIGN KEY(rm_usr_id) REFERENCES usuario(usr_id),
	     CONSTRAINT CHK_requisicao_material_status CHECK(rm_status IN('EMITIDA','CONCLUIDA PARCIAL','CONCLUIDA TOTAL','CANCELADA'))
	     
);



CREATE TABLE requisicao_material_detalhe(
	     rm_id BIGINT NOT NULL,
	     rm_prod_id BIGINT NOT NULL,
	     rm_prod_qntd NUMERIC(15,2) NOT NULL,
	     CONSTRAINT PK_requisicao_material_detalhe PRIMARY KEY(rm_id,rm_prod_id),
	     CONSTRAINT FK_requisicao_material_detalhe_requisicao FOREIGN KEY(rm_id) REFERENCES requisicao_material(rm_id) ON UPDATE CASCADE ON DELETE CASCADE,
	     CONSTRAINT FK_requisicao_material_detalhe_produto FOREIGN KEY(rm_prod_id) REFERENCES produto(prod_id) ON UPDATE CASCADE ON DELETE CASCADE
);


CREATE TABLE retirada_produto(
	retr_id BIGINT AUTO_INCREMENT NOT NULL,
    retr_dt TIMESTAMP  DEFAULT CURRENT_TIMESTAMP,
    retr_usr_id BIGINT NOT NULL,
    CONSTRAINT PK_retirada_produto PRIMARY KEY(retr_id),
    CONSTRAINT FK_retirada_produto_usuario FOREIGN KEY(retr_usr_id) REFERENCES usuario(usr_id)
);

CREATE TABLE retirada_produto_detalhe(
    retr_id BIGINT NOT NULL,
    retr_prod_id BIGINT NOT NULL,
    retr_prod_qntd NUMERIC(15,2) NOT NULL, 
    CONSTRAINT PK_retirada_produto_detalhe PRIMARY KEY(retr_id,retr_prod_id),
	CONSTRAINT FK_retirada_produto_detalhe_retirada FOREIGN KEY(retr_id) REFERENCES retirada_produto(retr_id) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT FK_retirada_produto_detalhe_produto FOREIGN KEY(retr_prod_id) REFERENCES produto(prod_id) ON UPDATE CASCADE ON DELETE CASCADE
);




SELECT * FROM roteiro;
SELECT * FROM produto;
SELECT * FROM estrutura_produto;
SELECT * FROM setor;
SELECT * FROM operacao;
SELECT * FROM unidade;
SELECT * FROM recurso;
SELECT * FROM requisicao_material;
SELECT * FROM requisicao_material_detalhe;
SELECT * FROM ordem_producao;


INSERT INTO perfil(perf_desc)VALUES('PCP');
INSERT INTO perfil(perf_desc)VALUES('PROGRAMADOR PCP');
INSERT INTO perfil(perf_desc)VALUES('GERENTE PCP');
INSERT INTO perfil(perf_desc)VALUES('PRODUCAO');
INSERT INTO perfil(perf_desc)VALUES('ALMOXARIFADO');
INSERT INTO perfil(perf_desc)VALUES('EXPEDICAO');
INSERT INTO perfil(perf_desc)VALUES('ENGENHARIA');
INSERT INTO perfil(perf_desc)VALUES('ADMINISTRADOR');

INSERT INTO usuario(usr_perf_id,usr_nome,usr_login,usr_pwd)VALUES(1,'PCP - User','admin',MD5('12345'));


INSERT INTO unidade (unid_id, unid_desc, unid_sig) VALUES
(1, 'AMPOLA', 'AMP'),
(2, 'BALDE', 'BAL'),
(3, 'BANDEJA', 'BAN'),
(4, 'BARRA', 'BAR'),
(5, 'BISNAGA', 'BIS'),
(6, 'BLOCO', 'BLO'),
(7, 'BOBINA', 'BOB'),
(8, 'BOMBONA', 'BOM'),
(9, 'CAPSULA', 'CAP'),
(10, 'CARTELA', 'CAR'),
(11, 'CENTO', 'CEN'),
(12, 'CONJUNTO', 'CJ'),
(13, 'CENTIMETRO', 'CM'),
(14, 'CENTIMETRO QUADRADO', 'CM2'),
(15, 'CAIXA', 'CX'),
(16, 'CAIXA COM 2 UNIDADES', 'CX2'),
(17, 'CAIXA COM 3 UNIDADES', 'CX3'),
(18, 'CAIXA COM 5 UNIDADES', 'CX5'),
(19, 'CAIXA COM 10 UNIDADES', 'CX10'),
(20, 'CAIXA COM 15 UNIDADES', 'CX15'),
(21, 'CAIXA COM 20 UNIDADES', 'CX20'),
(22, 'CAIXA COM 25 UNIDADES', 'CX25'),
(23, 'CAIXA COM 50 UNIDADES', 'CX50'),
(24, 'CAIXA COM 100 UNIDADES', 'CX100'),
(25, 'DISPLAY', 'DIS'),
(26, 'DUZIA', 'DUZ'),
(27, 'EMBALAGEM', 'EMB'),
(28, 'FARDO', 'FD'),
(29, 'FOLHA', 'FOL'),
(30, 'FRASCO', 'FRA'),
(31, 'GALÃO', 'GAL'),
(32, 'GARRAFA', 'GF'),
(33, 'GRAMAS', 'G'),
(34, 'JOGO', 'JOG'),
(35, 'QUILOGRAMA', 'KG'),
(36, 'KIT', 'KIT'),
(37, 'LATA', 'LAT'),
(38, 'LITRO', 'LIT'),
(39, 'METRO', 'M'),
(40, 'METRO QUADRADO', 'M2'),
(41, 'METRO CÚBICO', 'M3'),
(42, 'MILHEIRO', 'MIL'),
(43, 'MILILITRO', 'ML'),
(44, 'MEGAWATT HORA', 'MWH'),
(45, 'PACOTE', 'PAC'),
(46, 'PALETE', 'PAL'),
(47, 'PARES', 'PAR'),
(48, 'PEÇA', 'PC'),
(49, 'POTE', 'POT'),
(50, 'QUILATE', 'K'),
(51, 'RESMA', 'RES'),
(52, 'ROLO', 'ROL'),
(53, 'SACO', 'SC'),
(54, 'SACOLA', 'SAC'),
(55, 'TAMBOR', 'TMB'),
(56, 'TANQUE', 'TNQ'),
(57, 'TONELADA', 'TON'),
(58, 'TUBO', 'TB'),
(59, 'UNIDADE', 'UND'),
(60, 'VASILHAME', 'VAS'),
(61, 'VIDRO', 'VID');



INSERT INTO setor (setr_desc) VALUES
('AJUSTAGEM'),
('CORTE A LASER'),
('EMBALAGEM'),
('ESTAMPARIA'),
('FERRAMENTARIA'),
('MONTAGEM'),
('USINAGEM');





