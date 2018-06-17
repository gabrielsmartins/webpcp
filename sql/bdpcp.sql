
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
       CONSTRAINT UNQ_usuario_login UNIQUE(usr_login)
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
	     ord_dt_concl TIMESTAMP NULL DEFAULT NULL ,
	     ord_status VARCHAR(500) NOT NULL DEFAULT 'EMITIDA',
	     CONSTRAINT PK_ordem_producao PRIMARY KEY(ord_id),
	     CONSTRAINT FK_ordem_producao_produto FOREIGN KEY(ord_id) REFERENCES produto(prod_id),
	     CONSTRAINT FK_ordem_producao_usuario FOREIGN KEY(ord_usr_id) REFERENCES usuario(usr_id),
	     CONSTRAINT CHK_ordem_producao_status CHECK(ord_status IN('EMITIDA','INICIADA','ENCERRADA','CANCELADA'))     
);




CREATE TABLE programacao(
			 prog_ord_id BIGINT NOT NULL,
             prog_seq BIGINT NOT NULL,
             prog_tmp_tot TIME NOT NULL,
             prog_rot_prod_id BIGINT NOT NULL,
             prog_rot_oper_id BIGINT NOT NULL,
             prog_rot_seq INT NOT NULL,
             prog_rec_id BIGINT NOT NULL,
             prog_qntd_prod NUMERIC(15,4) DEFAULT 0.0,
             CONSTRAINT PK_programacao PRIMARY KEY(prog_ord_id,prog_seq),
			 CONSTRAINT FK_programacao_ordem FOREIGN KEY(prog_ord_id) REFERENCES ordem_producao(ord_id),
             CONSTRAINT FK_programacao_roteiro FOREIGN KEY(prog_rot_prod_id,prog_rot_oper_id,prog_rot_seq) REFERENCES roteiro(rot_prod_id,rot_oper_id,rot_seq),
             CONSTRAINT FK_programacao_recurso FOREIGN KEY(prog_rec_id) REFERENCES recurso(recr_id)
);





CREATE TABLE apontamento(
			 apont_id BIGINT NOT NULL AUTO_INCREMENT,
             apont_prog_ord_id BIGINT NOT NULL,
			 apont_prog_seq BIGINT NOT NULL,
             apont_tipo VARCHAR(50) NOT NULL,
             apont_qntd DOUBLE NOT NULL,
             apont_dt_ini DATETIME NOT NULL,
             apont_dt_fim DATETIME NOT NULL,
             apont_deb_estq BOOLEAN DEFAULT 1 NOT NULL,
             CONSTRAINT PK_apontamento PRIMARY KEY(apont_id),
             CONSTRAINT FK_apontamento_programacao FOREIGN KEY(apont_prog_ord_id,apont_prog_seq) REFERENCES programacao(prog_ord_id,prog_seq),
			 CONSTRAINT CHK_apontamento_tipo CHECK(apont_tipo IN('PRODUCAO','MANUTENCAO','PARADA','DESCARTE'))    
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
         rm_det_id BIGINT AUTO_INCREMENT NOT NULL,
	     rm_id BIGINT NOT NULL,
	     rm_prod_id BIGINT NOT NULL,
	     rm_prod_qntd NUMERIC(15,2) NOT NULL,
         CONSTRAINT PRIMARY KEY(rm_det_id),
	     CONSTRAINT UNQ_requisicao_material_detalhe UNIQUE(rm_id,rm_prod_id),
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


CREATE TABLE recebimento_material(
	receb_id BIGINT AUTO_INCREMENT NOT NULL,
    receb_dt TIMESTAMP  DEFAULT CURRENT_TIMESTAMP,
    receb_usr_id BIGINT NOT NULL,
    CONSTRAINT PK_recebimento_produto PRIMARY KEY(receb_id),
    CONSTRAINT FK_recebimento_produto_usuario FOREIGN KEY(receb_usr_id) REFERENCES usuario(usr_id)
);


CREATE TABLE recebimento_material_detalhe(
    receb_id BIGINT NOT NULL,
    receb_rm_det_id BIGINT NOT NULL,
    receb_prod_qntd NUMERIC(15,2) NOT NULL, 
    CONSTRAINT PK_recebimento_produto_detalhe PRIMARY KEY(receb_id,receb_rm_det_id),
	CONSTRAINT FK_recebimento_produto_detalhe_retirada FOREIGN KEY(receb_id) REFERENCES recebimento_material(receb_id) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT FK_recebimento_produto_detalhe_requisicao_detalhe FOREIGN KEY(receb_rm_det_id) REFERENCES requisicao_material_detalhe(rm_det_id) ON UPDATE CASCADE ON DELETE CASCADE
);







SELECT * FROM usuario;
SELECT * FROM roteiro;
SELECT * FROM produto;
SELECT * FROM estrutura_produto;
SELECT * FROM setor;
SELECT * FROM operacao;
SELECT * FROM unidade;
SELECT * FROM recurso;
SELECT * FROM requisicao_material;
SELECT * FROM requisicao_material_detalhe;
SELECT * FROM retirada_produto;
SELECT * FROM retirada_produto_detalhe;
SELECT * FROM recebimento_material;
SELECT * FROM recebimento_material_detalhe;
SELECT * FROM ordem_producao;
SELECT * FROM programacao;
SELECT * FROM apontamento;


INSERT INTO perfil(perf_desc)VALUES('PCP');
INSERT INTO perfil(perf_desc)VALUES('PRODUCAO');
INSERT INTO perfil(perf_desc)VALUES('ALMOXARIFADO');
INSERT INTO perfil(perf_desc)VALUES('EXPEDICAO');
INSERT INTO perfil(perf_desc)VALUES('ENGENHARIA');
INSERT INTO perfil(perf_desc)VALUES('ADMINISTRADOR');


INSERT INTO usuario(usr_perf_id,usr_nome,usr_login,usr_pwd)VALUES(1,'PCP','pcp',MD5('12345'));
INSERT INTO usuario(usr_perf_id,usr_nome,usr_login,usr_pwd)VALUES(2,'PRODUCAO','producao',MD5('12345'));
INSERT INTO usuario(usr_perf_id,usr_nome,usr_login,usr_pwd)VALUES(3,'ALMOXARIFADO','almoxarifado',MD5('12345'));
INSERT INTO usuario(usr_perf_id,usr_nome,usr_login,usr_pwd)VALUES(4,'EXPEDICAO','expedicao',MD5('12345'));
INSERT INTO usuario(usr_perf_id,usr_nome,usr_login,usr_pwd)VALUES(5,'ENGENHARIA','engenharia',MD5('12345'));
INSERT INTO usuario(usr_perf_id,usr_nome,usr_login,usr_pwd)VALUES(6,'ADMIN','admin',MD5('12345'));







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
('USINAGEM'),
('PINTURA');



INSERT INTO operacao (oper_desc, oper_instr, oper_setr_id) VALUES
('TORNEAR', 'TORNEAR CONFORME DESENHO', 7),
('DOBRAR', 'DOBRAR CONFORME DESENHO', 4),
('MONTAR', 'MONTAR', 6),
('EMBALAR', 'EMBALAR', 3),
('CORTE A LASER', 'Cortar conforme desenho', 2),
('PINTAR', 'PINTAR CONFORME ESPECIFICAÇÃO', 8);



INSERT INTO recurso (recr_desc,recr_setr_id) VALUES
('TORNO HORIZONTAL', 7),
('PRENSA 500T', 4),
('PRENSA 1000T', 4),
('OPERADOR 1', 6),
('MÁQUINA 1', 2),
('MÁQUINA 2', 2),
('MONTADOR 1', 6),
('EMBALADOR', 3);





INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (1,'CHI-200-20',59,'CHAPA DE ACO INOX (#20) 200MM X 200MM','ATIVO',0.5000,200.0000,200.0000,0.8000,75.25,2,20.0000,10.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (2,'CHI-300-20',59,'CHAPA DE ACO INOX (#20) 300MM X 300MM','ATIVO',0.6000,300.0000,300.0000,0.8000,95.75,3,16.0000,5.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (3,'CHI-400-20',59,'CHAPA DE ACO INOX (#20) 400MM X 400MM','INATIVO',0.7000,400.0000,400.0000,0.8000,125.50,4,20.0000,10.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (4,'CHI-500-20',59,'CHAPA DE ACO INOX (#20) 500MM X 500MM','ATIVO',0.8000,500.0000,500.0000,0.8000,150.00,5,19.0000,15.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (5,'CHI-600-20',59,'CHAPA DE ACO INOX (#20) 600MM X 600MM','FORA_DE_LINHA',0.9000,600.0000,600.0000,0.8000,165.10,7,30.0000,20.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (6,'CHI-700-20',59,'CHAPA DE ACO INOX (#20) 700MM X 700MM','ATIVO',1.0000,700.0000,700.0000,0.8000,175.50,6,15.0000,5.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (7,'CHA-200-20',59,'CHAPA DE ALUMINIO (#20) 200MM X 200MM','ATIVO',0.5000,200.0000,200.0000,0.8000,82.77,2,20.0000,10.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (8,'CHA-300-20',59,'CHAPA DE ALUMINIO (#20) 300MM X 300MM','INATIVO',0.6000,300.0000,300.0000,0.8000,105.32,3,20.0000,5.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (9,'CHA-400-20',59,'CHAPA DE ALUMINIO (#20) 400MM X 400MM','ATIVO',0.7000,400.0000,400.0000,0.8000,138.05,4,20.0000,10.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (10,'CHA-500-20',59,'CHAPA DE ALUMINIO (#20) 500MM X 500MM','ATIVO',0.8000,500.0000,500.0000,0.8000,165.00,5,25.0000,15.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (11,'CHA-600-20',59,'CHAPA DE ALUMINIO (#20) 600MM X 600MM','FORA_DE_LINHA',0.9000,600.0000,600.0000,0.8000,181.61,7,30.0000,20.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (12,'CHA-700-20',59,'CHAPA DE ALUMINIO (#20) 700MM X 700MM','ATIVO',1.0000,700.0000,700.0000,0.8000,193.05,6,15.0000,5.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (13,'TBI-1/2-200-1.5',59,'TUBO ACO INOX 1/2\" X 200MM X 1,5MM\"','ATIVO',0.3000,200.0000,12.7000,12.7000,45.15,2,14.0000,11.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (14,'TBI-1/2-300-1.5',59,'TUBO ACO INOX 1/2\" X 300MM X 1,5MM\"','INATIVO',0.4000,300.0000,12.7000,12.7000,57.45,3,10.0000,11.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (15,'TBI-1/2-400-1.5',59,'TUBO ACO INOX 1/2\" X 400MM X 1,5MM\"','ATIVO',0.5000,400.0000,12.7000,12.7000,75.30,4,14.0000,11.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (16,'TBI-1/2-500-1.5',59,'TUBO ACO INOX 1/2\" X 500MM X 1,5MM\"','ATIVO',0.6000,500.0000,12.7000,12.7000,90.00,5,11.0000,13.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (17,'TBI-1/2-600-1.5',59,'TUBO ACO INOX 1/2\" X 600MM X 1,5MM\"','FORA_DE_LINHA',0.7000,600.0000,12.7000,12.7000,99.06,7,21.0000,16.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (18,'TBI-1/2-700-1.5',59,'TUBO ACO INOX 1/2\" X 700MM X 1,5MM\"','ATIVO',0.8000,700.0000,12.7000,12.7000,105.30,6,10.5000,8.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (19,'TBA-1/2-200-1.5',59,'TUBO ALUMINIO 1/2\" X 200MM X 1,5MM\"','ATIVO',0.2400,200.0000,12.7000,12.7000,45.15,2,14.0000,11.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (20,'TBA-1/2-300-1.5',59,'TUBO ALUMINIO 1/2\" X 300MM X 1,5MM\"','INATIVO',0.3200,300.0000,12.7000,12.7000,57.45,3,14.0000,11.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (21,'TBA-1/2-400-1.5',59,'TUBO ALUMINIO 1/2\" X 400MM X 1,5MM\"','ATIVO',0.4000,400.0000,12.7000,12.7000,75.30,4,14.0000,11.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (22,'TBA-1/2-500-1.5',59,'TUBO ALUMINIO 1/2\" X 500MM X 1,5MM\"','ATIVO',0.4800,500.0000,12.7000,12.7000,90.00,5,17.0000,13.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (23,'TBA-1/2-600-1.5',59,'TUBO ALUMINIO 1/2\" X 600MM X 1,5MM\"','FORA_DE_LINHA',0.5600,600.0000,12.7000,12.7000,99.06,7,21.0000,16.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (24,'TBA-1/2-700-1.5',59,'TUBO ALUMINIO 1/2\" X 700MM X 1,5MM\"','ATIVO',0.6400,700.0000,12.7000,12.7000,105.30,6,10.5000,8.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (25,'PRFS-1/2-50',59,'PARAFUSO SEXTADO 1/2\"\"\" X 50MM\"','ATIVO',0.1200,50.0000,12.7000,12.7000,0.10,2,50.0000,35.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (26,'PRFS-1/2-75',59,'PARAFUSO SEXTADO 1/2\"\"\" X 75MM\"','INATIVO',0.1600,75.0000,12.7000,12.7000,0.15,3,100.0000,70.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (27,'PRFS-1/2-100',59,'PARAFUSO SEXTADO 1/2\"\"\" X 100MM\"','ATIVO',0.2000,100.0000,12.7000,12.7000,0.20,4,125.0000,87.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (28,'PRFS-1/2-125',59,'PARAFUSO SEXTADO 1/2\"\"\" X 125MM\"','ATIVO',0.2400,125.0000,12.7000,12.7000,0.25,5,150.0000,105.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (29,'PRFS-1/2-150',59,'PARAFUSO SEXTADO 1/2\"\"\" X 150MM\"','FORA_DE_LINHA',0.2800,150.0000,12.7000,12.7000,0.30,7,200.0000,140.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (30,'PRFS-1/2-200',59,'PARAFUSO SEXTADO 1/2\"\"\" X 200MM\"','ATIVO',0.3200,200.0000,12.7000,12.7000,0.35,6,250.0000,175.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (31,'FRRC-1/2-1/4-500',59,'FERRO CHATO 1/2\" X 1/4\"\" X 500MM\"','ATIVO',0.5000,500.0000,12.7000,6.3500,1.25,2,25.0000,17.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (32,'FRRC-1/2-1/4-600',59,'FERRO CHATO 1/2\" X 1/4\"\" X 600MM\"','INATIVO',0.6000,600.0000,12.7000,6.3500,2.25,3,50.0000,35.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (33,'FRRC-1/2-1/4-700',59,'FERRO CHATO 1/2\" X 1/4\"\" X 700MM\"','ATIVO',0.7000,700.0000,12.7000,6.3500,3.25,4,62.0000,43.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (34,'FRRC-1/2-1/4-800',59,'FERRO CHATO 1/2\" X 1/4\"\" X 800MM\"','ATIVO',0.8000,800.0000,12.7000,6.3500,4.25,5,75.0000,52.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (35,'FRRC-1/2-1/4-900',59,'FERRO CHATO 1/2\" X 1/4\"\" X 900MM\"','FORA_DE_LINHA',0.9000,900.0000,12.7000,6.3500,5.25,7,100.0000,70.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (36,'FRRC-1/2-1/4-1000',59,'FERRO CHATO 1/2\" X 1/4\"\" X 1000MM\"','ATIVO',1.0000,1000.0000,12.7000,6.3500,6.25,6,125.0000,87.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (37,'CNT-1/2-1/8-500',59,'CANTONEIRA 1/2\" X 1/8\"\" 500MM\"','ATIVO',0.5000,500.0000,12.7000,3.2000,1.40,3,20.0000,14.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (38,'CNT-1/2-1/8-600',59,'CANTONEIRA 1/2\" X 1/8\"\" 600MM\"','INATIVO',0.6000,600.0000,12.7000,3.2000,2.45,4,40.0000,28.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (39,'CNT-1/2-1/8-700',59,'CANTONEIRA 1/2\" X 1/8\"\" 700MM\"','ATIVO',0.7000,700.0000,12.7000,3.2000,3.50,4,49.0000,34.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (40,'CNT-1/2-1/8-800',59,'CANTONEIRA 1/2\" X 1/8\"\" 800MM\"','ATIVO',0.8000,800.0000,12.7000,3.2000,4.65,5,60.0000,42.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (41,'CNT-1/2-1/8-900',59,'CANTONEIRA 1/2\" X 1/8\"\" 900MM\"','FORA_DE_LINHA',0.9000,900.0000,12.7000,3.2000,5.75,7,80.0000,56.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (42,'CNT-1/2-1/8-1000',59,'CANTONEIRA 1/2\" X 1/8\"\" 1000MM\"','ATIVO',1.0000,1000.0000,12.7000,3.2000,6.85,7,100.0000,70.0000,'material');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (43,'MI-300',59,'MESA INOX TUBULAR 300MM','ATIVO',5.5000,300.0000,300.0000,300.0000,500.50,2,10.0000,20.0000,'produto');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (44,'MI-500',59,'MESA INOX TUBULAR 500MM','ATIVO',20.0000,500.0000,500.0000,1000.0000,75.50,5,20.0000,10.0000,'produto');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (45,'PTR-500',59,'PORTA REFRIGERADOR RFR-500','ATIVO',10.5000,500.0000,500.0000,50.0000,250.00,5,20.0000,20.0000,'produto');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (46,'RFR-500',59,'REFRIGERADOR VERTICAL 500MM','ATIVO',20.0000,500.0000,500.0000,2000.0000,2500.00,5,20.0000,10.0000,'produto');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (47,'FGI-500',59,'FOGAO ACO INOX 500MM','ATIVO',20.0000,500.0000,500.0000,500.0000,255.50,5,20.0000,7.0000,'produto');
INSERT INTO produto (prod_id,prod_cod_intr,prod_unid_id,prod_desc,prod_sit,prod_peso_kg,prod_comp_mm,prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq,prod_qntd_min,prod_tipo) VALUES (48,'FGI-700',59,'FOGAO ACO INOX 700MM','ATIVO',20.0000,700.0000,700.0000,500.0000,250.00,20,15.0000,5.0000,'produto');



INSERT INTO estrutura_produto (prod_id,prod_sub_id,prod_sub_qntd) VALUES (43,2,2.0000);
INSERT INTO estrutura_produto (prod_id,prod_sub_id,prod_sub_qntd) VALUES (43,14,2.0000);
INSERT INTO estrutura_produto (prod_id,prod_sub_id,prod_sub_qntd) VALUES (44,4,2.0000);
INSERT INTO estrutura_produto (prod_id,prod_sub_id,prod_sub_qntd) VALUES (44,16,2.0000);
INSERT INTO estrutura_produto (prod_id,prod_sub_id,prod_sub_qntd) VALUES (45,4,1.0000);
INSERT INTO estrutura_produto (prod_id,prod_sub_id,prod_sub_qntd) VALUES (45,25,5.0000);
INSERT INTO estrutura_produto (prod_id,prod_sub_id,prod_sub_qntd) VALUES (46,4,3.0000);
INSERT INTO estrutura_produto (prod_id,prod_sub_id,prod_sub_qntd) VALUES (46,45,2.0000);
INSERT INTO estrutura_produto (prod_id,prod_sub_id,prod_sub_qntd) VALUES (47,4,2.0000);
INSERT INTO estrutura_produto (prod_id,prod_sub_id,prod_sub_qntd) VALUES (47,14,1.0000);
INSERT INTO estrutura_produto (prod_id,prod_sub_id,prod_sub_qntd) VALUES (48,6,2.0000);
INSERT INTO estrutura_produto (prod_id,prod_sub_id,prod_sub_qntd) VALUES (48,15,3.0000);




INSERT INTO roteiro (rot_prod_id,rot_oper_id,rot_seq,rot_tmp_stp,rot_tmp_prd,rot_tmp_fnl) VALUES (43,2,2,'00:00:00','00:30:00','00:00:00');
INSERT INTO roteiro (rot_prod_id,rot_oper_id,rot_seq,rot_tmp_stp,rot_tmp_prd,rot_tmp_fnl) VALUES (43,3,3,'00:00:00','01:30:00','00:00:00');
INSERT INTO roteiro (rot_prod_id,rot_oper_id,rot_seq,rot_tmp_stp,rot_tmp_prd,rot_tmp_fnl) VALUES (43,4,4,'00:00:00','00:30:00','00:00:00');
INSERT INTO roteiro (rot_prod_id,rot_oper_id,rot_seq,rot_tmp_stp,rot_tmp_prd,rot_tmp_fnl) VALUES (43,5,1,'00:00:00','01:30:00','00:00:00');
INSERT INTO roteiro (rot_prod_id,rot_oper_id,rot_seq,rot_tmp_stp,rot_tmp_prd,rot_tmp_fnl) VALUES (44,2,2,'00:00:00','00:10:00','00:00:00');
INSERT INTO roteiro (rot_prod_id,rot_oper_id,rot_seq,rot_tmp_stp,rot_tmp_prd,rot_tmp_fnl) VALUES (44,3,3,'00:00:00','00:20:00','00:00:00');
INSERT INTO roteiro (rot_prod_id,rot_oper_id,rot_seq,rot_tmp_stp,rot_tmp_prd,rot_tmp_fnl) VALUES (44,4,4,'00:00:00','00:15:00','00:00:00');
INSERT INTO roteiro (rot_prod_id,rot_oper_id,rot_seq,rot_tmp_stp,rot_tmp_prd,rot_tmp_fnl) VALUES (44,5,1,'00:00:00','00:30:00','00:00:00');
INSERT INTO roteiro (rot_prod_id,rot_oper_id,rot_seq,rot_tmp_stp,rot_tmp_prd,rot_tmp_fnl) VALUES (45,2,2,'00:00:00','00:20:00','00:00:00');
INSERT INTO roteiro (rot_prod_id,rot_oper_id,rot_seq,rot_tmp_stp,rot_tmp_prd,rot_tmp_fnl) VALUES (45,3,3,'00:00:00','00:10:00','00:00:00');
INSERT INTO roteiro (rot_prod_id,rot_oper_id,rot_seq,rot_tmp_stp,rot_tmp_prd,rot_tmp_fnl) VALUES (45,4,4,'00:00:00','00:15:00','00:00:00');
INSERT INTO roteiro (rot_prod_id,rot_oper_id,rot_seq,rot_tmp_stp,rot_tmp_prd,rot_tmp_fnl) VALUES (45,5,1,'00:00:00','00:30:00','00:00:00');
INSERT INTO roteiro (rot_prod_id,rot_oper_id,rot_seq,rot_tmp_stp,rot_tmp_prd,rot_tmp_fnl) VALUES (46,2,2,'00:00:00','00:30:00','00:00:00');
INSERT INTO roteiro (rot_prod_id,rot_oper_id,rot_seq,rot_tmp_stp,rot_tmp_prd,rot_tmp_fnl) VALUES (46,3,3,'00:00:00','00:40:00','00:00:00');
INSERT INTO roteiro (rot_prod_id,rot_oper_id,rot_seq,rot_tmp_stp,rot_tmp_prd,rot_tmp_fnl) VALUES (46,4,4,'00:00:00','00:20:00','00:00:00');
INSERT INTO roteiro (rot_prod_id,rot_oper_id,rot_seq,rot_tmp_stp,rot_tmp_prd,rot_tmp_fnl) VALUES (46,5,1,'00:00:00','01:00:00','00:00:00');
INSERT INTO roteiro (rot_prod_id,rot_oper_id,rot_seq,rot_tmp_stp,rot_tmp_prd,rot_tmp_fnl) VALUES (47,1,2,'00:00:00','00:30:00','00:00:00');
INSERT INTO roteiro (rot_prod_id,rot_oper_id,rot_seq,rot_tmp_stp,rot_tmp_prd,rot_tmp_fnl) VALUES (47,2,3,'00:00:00','00:20:00','00:00:00');
INSERT INTO roteiro (rot_prod_id,rot_oper_id,rot_seq,rot_tmp_stp,rot_tmp_prd,rot_tmp_fnl) VALUES (47,4,4,'00:00:00','00:10:00','00:00:00');
INSERT INTO roteiro (rot_prod_id,rot_oper_id,rot_seq,rot_tmp_stp,rot_tmp_prd,rot_tmp_fnl) VALUES (47,5,1,'00:00:00','01:30:00','00:00:00');
INSERT INTO roteiro (rot_prod_id,rot_oper_id,rot_seq,rot_tmp_stp,rot_tmp_prd,rot_tmp_fnl) VALUES (48,2,2,'00:00:00','00:35:00','00:00:00');
INSERT INTO roteiro (rot_prod_id,rot_oper_id,rot_seq,rot_tmp_stp,rot_tmp_prd,rot_tmp_fnl) VALUES (48,3,3,'00:00:00','00:45:00','00:00:00');
INSERT INTO roteiro (rot_prod_id,rot_oper_id,rot_seq,rot_tmp_stp,rot_tmp_prd,rot_tmp_fnl) VALUES (48,4,4,'00:00:00','00:25:00','00:00:00');
INSERT INTO roteiro (rot_prod_id,rot_oper_id,rot_seq,rot_tmp_stp,rot_tmp_prd,rot_tmp_fnl) VALUES (48,5,1,'00:00:00','01:35:00','00:00:00');



INSERT INTO ordem_producao (ord_id,ord_prod_id,ord_prod_qntd,ord_dt_emi,ord_prazo,ord_usr_id,ord_dt_concl,ord_status) VALUES (1,43,2.00,'2018-06-17 15:15:49','2018-06-30',6,NULL,'INICIADA');
INSERT INTO ordem_producao (ord_id,ord_prod_id,ord_prod_qntd,ord_dt_emi,ord_prazo,ord_usr_id,ord_dt_concl,ord_status) VALUES (2,44,3.00,'2018-06-17 15:20:20','2018-07-06',6,NULL,'ENCERRADA');
INSERT INTO ordem_producao (ord_id,ord_prod_id,ord_prod_qntd,ord_dt_emi,ord_prazo,ord_usr_id,ord_dt_concl,ord_status) VALUES (3,45,2.00,'2018-06-17 15:25:36','2018-07-05',6,NULL,'EMITIDA');
INSERT INTO ordem_producao (ord_id,ord_prod_id,ord_prod_qntd,ord_dt_emi,ord_prazo,ord_usr_id,ord_dt_concl,ord_status) VALUES (4,46,1.00,'2018-06-17 15:25:48','2018-06-17',6,NULL,'EMITIDA');
INSERT INTO ordem_producao (ord_id,ord_prod_id,ord_prod_qntd,ord_dt_emi,ord_prazo,ord_usr_id,ord_dt_concl,ord_status) VALUES (5,47,4.00,'2018-06-17 15:26:04','2018-07-12',6,NULL,'EMITIDA');
INSERT INTO ordem_producao (ord_id,ord_prod_id,ord_prod_qntd,ord_dt_emi,ord_prazo,ord_usr_id,ord_dt_concl,ord_status) VALUES (6,48,2.00,'2018-06-17 15:26:43','2018-06-28',6,NULL,'EMITIDA');





INSERT INTO programacao (prog_ord_id,prog_seq,prog_tmp_tot,prog_rot_prod_id,prog_rot_oper_id,prog_rot_seq,prog_rec_id,prog_qntd_prod) VALUES (1,1,'03:00:00',43,5,1,5,NULL);
INSERT INTO programacao (prog_ord_id,prog_seq,prog_tmp_tot,prog_rot_prod_id,prog_rot_oper_id,prog_rot_seq,prog_rec_id,prog_qntd_prod) VALUES (1,2,'01:00:00',43,2,2,2,NULL);
INSERT INTO programacao (prog_ord_id,prog_seq,prog_tmp_tot,prog_rot_prod_id,prog_rot_oper_id,prog_rot_seq,prog_rec_id,prog_qntd_prod) VALUES (1,3,'03:00:00',43,3,3,4,NULL);
INSERT INTO programacao (prog_ord_id,prog_seq,prog_tmp_tot,prog_rot_prod_id,prog_rot_oper_id,prog_rot_seq,prog_rec_id,prog_qntd_prod) VALUES (1,4,'01:00:00',43,4,4,8,NULL);
INSERT INTO programacao (prog_ord_id,prog_seq,prog_tmp_tot,prog_rot_prod_id,prog_rot_oper_id,prog_rot_seq,prog_rec_id,prog_qntd_prod) VALUES (2,1,'01:30:00',44,5,1,5,NULL);
INSERT INTO programacao (prog_ord_id,prog_seq,prog_tmp_tot,prog_rot_prod_id,prog_rot_oper_id,prog_rot_seq,prog_rec_id,prog_qntd_prod) VALUES (2,2,'00:30:00',44,2,2,2,NULL);
INSERT INTO programacao (prog_ord_id,prog_seq,prog_tmp_tot,prog_rot_prod_id,prog_rot_oper_id,prog_rot_seq,prog_rec_id,prog_qntd_prod) VALUES (2,3,'01:00:00',44,3,3,4,NULL);
INSERT INTO programacao (prog_ord_id,prog_seq,prog_tmp_tot,prog_rot_prod_id,prog_rot_oper_id,prog_rot_seq,prog_rec_id,prog_qntd_prod) VALUES (2,4,'00:45:00',44,4,4,8,NULL);
INSERT INTO programacao (prog_ord_id,prog_seq,prog_tmp_tot,prog_rot_prod_id,prog_rot_oper_id,prog_rot_seq,prog_rec_id,prog_qntd_prod) VALUES (3,1,'01:00:00',45,5,1,5,NULL);
INSERT INTO programacao (prog_ord_id,prog_seq,prog_tmp_tot,prog_rot_prod_id,prog_rot_oper_id,prog_rot_seq,prog_rec_id,prog_qntd_prod) VALUES (3,2,'00:40:00',45,2,2,2,NULL);
INSERT INTO programacao (prog_ord_id,prog_seq,prog_tmp_tot,prog_rot_prod_id,prog_rot_oper_id,prog_rot_seq,prog_rec_id,prog_qntd_prod) VALUES (3,3,'00:20:00',45,3,3,4,NULL);
INSERT INTO programacao (prog_ord_id,prog_seq,prog_tmp_tot,prog_rot_prod_id,prog_rot_oper_id,prog_rot_seq,prog_rec_id,prog_qntd_prod) VALUES (3,4,'00:30:00',45,4,4,8,NULL);
INSERT INTO programacao (prog_ord_id,prog_seq,prog_tmp_tot,prog_rot_prod_id,prog_rot_oper_id,prog_rot_seq,prog_rec_id,prog_qntd_prod) VALUES (4,1,'01:00:00',46,5,1,5,NULL);
INSERT INTO programacao (prog_ord_id,prog_seq,prog_tmp_tot,prog_rot_prod_id,prog_rot_oper_id,prog_rot_seq,prog_rec_id,prog_qntd_prod) VALUES (4,2,'00:30:00',46,2,2,2,NULL);
INSERT INTO programacao (prog_ord_id,prog_seq,prog_tmp_tot,prog_rot_prod_id,prog_rot_oper_id,prog_rot_seq,prog_rec_id,prog_qntd_prod) VALUES (4,3,'00:40:00',46,3,3,4,NULL);
INSERT INTO programacao (prog_ord_id,prog_seq,prog_tmp_tot,prog_rot_prod_id,prog_rot_oper_id,prog_rot_seq,prog_rec_id,prog_qntd_prod) VALUES (4,4,'00:20:00',46,4,4,8,NULL);
INSERT INTO programacao (prog_ord_id,prog_seq,prog_tmp_tot,prog_rot_prod_id,prog_rot_oper_id,prog_rot_seq,prog_rec_id,prog_qntd_prod) VALUES (5,1,'06:00:00',47,5,1,5,NULL);
INSERT INTO programacao (prog_ord_id,prog_seq,prog_tmp_tot,prog_rot_prod_id,prog_rot_oper_id,prog_rot_seq,prog_rec_id,prog_qntd_prod) VALUES (5,2,'02:00:00',47,1,2,1,NULL);
INSERT INTO programacao (prog_ord_id,prog_seq,prog_tmp_tot,prog_rot_prod_id,prog_rot_oper_id,prog_rot_seq,prog_rec_id,prog_qntd_prod) VALUES (5,3,'01:20:00',47,2,3,2,NULL);
INSERT INTO programacao (prog_ord_id,prog_seq,prog_tmp_tot,prog_rot_prod_id,prog_rot_oper_id,prog_rot_seq,prog_rec_id,prog_qntd_prod) VALUES (5,4,'00:40:00',47,4,4,8,NULL);
INSERT INTO programacao (prog_ord_id,prog_seq,prog_tmp_tot,prog_rot_prod_id,prog_rot_oper_id,prog_rot_seq,prog_rec_id,prog_qntd_prod) VALUES (6,1,'03:10:00',48,5,1,5,NULL);
INSERT INTO programacao (prog_ord_id,prog_seq,prog_tmp_tot,prog_rot_prod_id,prog_rot_oper_id,prog_rot_seq,prog_rec_id,prog_qntd_prod) VALUES (6,2,'01:10:00',48,2,2,3,NULL);
INSERT INTO programacao (prog_ord_id,prog_seq,prog_tmp_tot,prog_rot_prod_id,prog_rot_oper_id,prog_rot_seq,prog_rec_id,prog_qntd_prod) VALUES (6,3,'01:30:00',48,3,3,4,NULL);
INSERT INTO programacao (prog_ord_id,prog_seq,prog_tmp_tot,prog_rot_prod_id,prog_rot_oper_id,prog_rot_seq,prog_rec_id,prog_qntd_prod) VALUES (6,4,'00:50:00',48,4,4,8,NULL);




INSERT INTO apontamento (apont_id,apont_prog_ord_id,apont_prog_seq,apont_tipo,apont_qntd,apont_dt_ini,apont_dt_fim,apont_deb_estq) VALUES (1,1,1,'PRODUCAO',2,'2018-06-27 12:27:03','2018-06-18 12:27:06',1);
INSERT INTO apontamento (apont_id,apont_prog_ord_id,apont_prog_seq,apont_tipo,apont_qntd,apont_dt_ini,apont_dt_fim,apont_deb_estq) VALUES (2,1,1,'DESCARTE',2,'2018-06-17 12:27:25','2018-06-17 15:27:27',1);
INSERT INTO apontamento (apont_id,apont_prog_ord_id,apont_prog_seq,apont_tipo,apont_qntd,apont_dt_ini,apont_dt_fim,apont_deb_estq) VALUES (3,2,1,'PRODUCAO',3,'2018-06-17 12:27:57','2018-06-17 15:27:57',1);
INSERT INTO apontamento (apont_id,apont_prog_ord_id,apont_prog_seq,apont_tipo,apont_qntd,apont_dt_ini,apont_dt_fim,apont_deb_estq) VALUES (4,2,2,'PRODUCAO',3,'2018-06-18 09:28:25','2018-06-18 10:28:25',0);
INSERT INTO apontamento (apont_id,apont_prog_ord_id,apont_prog_seq,apont_tipo,apont_qntd,apont_dt_ini,apont_dt_fim,apont_deb_estq) VALUES (5,2,3,'PRODUCAO',3,'2018-06-17 12:28:52','2018-06-17 13:28:54',1);
INSERT INTO apontamento (apont_id,apont_prog_ord_id,apont_prog_seq,apont_tipo,apont_qntd,apont_dt_ini,apont_dt_fim,apont_deb_estq) VALUES (6,2,4,'PRODUCAO',3,'2018-06-17 12:29:14','2018-06-17 14:29:14',0);


INSERT INTO requisicao_material (rm_id,rm_dt_emi,rm_prazo,rm_usr_id,rm_dt_concl,rm_status) VALUES (1,'2018-06-17 15:37:58','2018-06-29',6,'2018-06-17 12:37:58','CONCLUIDA TOTAL');
INSERT INTO requisicao_material (rm_id,rm_dt_emi,rm_prazo,rm_usr_id,rm_dt_concl,rm_status) VALUES (2,'2018-06-17 15:39:23','2018-07-06',6,'2018-06-17 12:39:23','EMITIDA');
INSERT INTO requisicao_material (rm_id,rm_dt_emi,rm_prazo,rm_usr_id,rm_dt_concl,rm_status) VALUES (3,'2018-06-17 15:39:52','2018-06-28',6,'2018-06-17 12:39:52','CONCLUIDA PARCIAL');


INSERT INTO requisicao_material_detalhe (rm_det_id,rm_id,rm_prod_id,rm_prod_qntd) VALUES (1,1,1,5.00);
INSERT INTO requisicao_material_detalhe (rm_det_id,rm_id,rm_prod_id,rm_prod_qntd) VALUES (2,1,2,5.00);
INSERT INTO requisicao_material_detalhe (rm_det_id,rm_id,rm_prod_id,rm_prod_qntd) VALUES (3,1,3,2.00);
INSERT INTO requisicao_material_detalhe (rm_det_id,rm_id,rm_prod_id,rm_prod_qntd) VALUES (4,1,5,5.00);
INSERT INTO requisicao_material_detalhe (rm_det_id,rm_id,rm_prod_id,rm_prod_qntd) VALUES (5,2,24,2.00);
INSERT INTO requisicao_material_detalhe (rm_det_id,rm_id,rm_prod_id,rm_prod_qntd) VALUES (6,2,21,5.00);
INSERT INTO requisicao_material_detalhe (rm_det_id,rm_id,rm_prod_id,rm_prod_qntd) VALUES (7,2,19,3.00);
INSERT INTO requisicao_material_detalhe (rm_det_id,rm_id,rm_prod_id,rm_prod_qntd) VALUES (8,2,25,2.00);
INSERT INTO requisicao_material_detalhe (rm_det_id,rm_id,rm_prod_id,rm_prod_qntd) VALUES (9,3,32,2.00);
INSERT INTO requisicao_material_detalhe (rm_det_id,rm_id,rm_prod_id,rm_prod_qntd) VALUES (10,3,33,3.00);


INSERT INTO recebimento_material (receb_id,receb_dt,receb_usr_id) VALUES (1,'2018-06-17 00:00:00',6);
INSERT INTO recebimento_material (receb_id,receb_dt,receb_usr_id) VALUES (2,'2018-06-17 00:00:00',6);
INSERT INTO recebimento_material (receb_id,receb_dt,receb_usr_id) VALUES (3,'2018-06-17 00:00:00',6);


INSERT INTO recebimento_material_detalhe (receb_id,receb_rm_det_id,receb_prod_qntd) VALUES (1,1,5.00);
INSERT INTO recebimento_material_detalhe (receb_id,receb_rm_det_id,receb_prod_qntd) VALUES (1,3,2.00);
INSERT INTO recebimento_material_detalhe (receb_id,receb_rm_det_id,receb_prod_qntd) VALUES (2,9,2.00);
INSERT INTO recebimento_material_detalhe (receb_id,receb_rm_det_id,receb_prod_qntd) VALUES (2,10,3.00);
INSERT INTO recebimento_material_detalhe (receb_id,receb_rm_det_id,receb_prod_qntd) VALUES (3,2,5.00);
INSERT INTO recebimento_material_detalhe (receb_id,receb_rm_det_id,receb_prod_qntd) VALUES (3,3,2.00);
INSERT INTO recebimento_material_detalhe (receb_id,receb_rm_det_id,receb_prod_qntd) VALUES (3,4,5.00);



INSERT INTO retirada_produto (retr_id,retr_dt,retr_usr_id) VALUES (1,'2018-06-17 00:00:00',6);
INSERT INTO retirada_produto (retr_id,retr_dt,retr_usr_id) VALUES (2,'2018-06-17 00:00:00',6);


INSERT INTO retirada_produto_detalhe (retr_id,retr_prod_id,retr_prod_qntd) VALUES (1,43,2.00);
INSERT INTO retirada_produto_detalhe (retr_id,retr_prod_id,retr_prod_qntd) VALUES (1,44,10.00);
INSERT INTO retirada_produto_detalhe (retr_id,retr_prod_id,retr_prod_qntd) VALUES (2,46,5.00);
INSERT INTO retirada_produto_detalhe (retr_id,retr_prod_id,retr_prod_qntd) VALUES (2,47,10.00);












