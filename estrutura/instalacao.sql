CREATE TABLE plugins.protocolodepart (
    sequencial integer PRIMARY KEY,
    coddepto   integer not null
);

CREATE SEQUENCE plugins.protocolodepart_sequencial_seq; 

CREATE TABLE plugins.protocolodepartdepartamentos (
    sequencial integer PRIMARY KEY,
    protocolodepart integer not null,
    coddepto integer not null
);

CREATE SEQUENCE plugins.protocolodepartdepartamentos_sequencial_seq; 

ALTER TABLE ONLY plugins.protocolodepartdepartamentos
    ADD CONSTRAINT plugins_protocolodepartdepartamentos_protocolodepart_fk FOREIGN KEY (protocolodepart) REFERENCES plugins.protocolodepart(sequencial) MATCH FULL DEFERRABLE;
