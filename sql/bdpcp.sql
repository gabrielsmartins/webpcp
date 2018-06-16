
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
('MONTADOR 1', 6);





INSERT INTO produto (prod_cod_intr, prod_unid_id, prod_desc,prod_sit,prod_peso_kg,prod_comp_mm, prod_larg_mm,prod_alt_mm,prod_vlr_unit,prod_lead_time,prod_qntd_estq, prod_qntd_min, prod_tipo) VALUES
('CHI-500', 59, 'CHAPA ACO INOX 500MM', 'ATIVO', '5.7500', '500.0000', '500.0000', '0.2000', '500.75', 2, '10.0000', '5.0000', 'material'),
('CHI-300', 59, 'CHAPA ACO INOX 300MM', 'ATIVO', '5.5000', '300.0000', '300.0000', '1.5000', '75.25', 5, '20.0000', '10.0000', 'material'),
('CHI-200', 59, 'CHAPA ACO INOX 200MM', 'ATIVO', '2.5000', '200.0000', '200.0000', '0.5000', '25.75', 2, '15.0000', '5.0000', 'material'),
('PTR-500', 59, 'PORTA REFRIGERADOR 500 MM', 'ATIVO', '50.0000', '500.0000', '500.0000', '2000.0000', '25.75', 5, '10.0000', '5.0000', 'produto'),
('RFR-500', 59, 'REFRIGERADOR VERTICAL 500MM', 'ATIVO', '5.0000', '500.0000', '500.0000', '2000.0000', '2750.00', 10, '50.0000', '25.0000', 'produto');





INSERT INTO estrutura_produto (prod_id,prod_sub_id,prod_sub_qntd) VALUES
(4, 1, '5.0000'),
(4, 2, '2.0000'),
(5, 2, '2.0000'),
(5, 4, '1.0000');





INSERT INTO roteiro (rot_prod_id, rot_oper_id, rot_seq,rot_tmp_stp,rot_tmp_prd,rot_tmp_fnl) VALUES
(4, 3, 2, '00:00:00', '02:10:00', '00:00:00'),
(4, 5, 1, '00:00:00', '05:00:00', '00:00:00'),
(5, 3, 1, '00:00:00', '03:00:00', '00:00:00'),
(5, 4, 2, '00:00:00', '01:00:00', '00:00:00'),
(5, 5, 3, '00:30:00', '01:20:00', '00:10:00');



INSERT INTO ordem_producao (ord_prod_id,ord_prod_qntd,ord_dt_emi,ord_prazo,ord_usr_id,ord_dt_concl,ord_status) VALUES
(4, '2.00', '2018-05-13 20:09:21', '2018-05-30', 1, NULL, 'EMITIDA');



INSERT INTO programacao (prog_ord_id,prog_seq,prog_tmp_tot,prog_rot_prod_id,prog_rot_oper_id,prog_rot_seq,prog_rec_id) VALUES
(1, 1, '10:00:00', 4, 5, 1, 5),
(1, 2, '04:20:00', 4, 3, 2, 4);






INSERT INTO requisicao_material (rm_id, rm_dt_emi, rm_prazo, rm_usr_id, rm_dt_concl, rm_status) VALUES
(1, '2018-05-19 11:13:47', '2018-05-31', 1, NULL, 'EMITIDA'),
(2, '2018-05-19 11:14:42', '2018-06-08', 1, NULL, 'EMITIDA');


INSERT INTO requisicao_material_detalhe (rm_det_id, rm_id, rm_prod_id, rm_prod_qntd) VALUES
(1, 1, 1, '5.00'),
(2, 1, 2, '3.00'),
(3, 1, 3, '10.00'),
(4, 2, 2, '5.00'),
(5, 2, 3, '7.00');


/*
INSERT INTO recebimento_material (receb_id, receb_dt, receb_usr_id) VALUES
(1, '2018-05-18 22:00:00', 1),
(2, '2018-05-18 22:00:00', 1),
(3, '2018-05-18 22:00:00', 1),
(4, '2018-05-18 22:00:00', 1);



INSERT INTO recebimento_material_detalhe (receb_id,receb_rm_det_id,receb_prod_qntd) VALUES
(1, 1, '3.00'),
(2, 1, '3.00'),
(2, 2, '2.00'),
(3, 1, '3.00'),
(3, 2, '2.00'),
(3, 3, '7.00'),
(4, 4, '2.00');
*/




