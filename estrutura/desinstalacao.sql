ALTER TABLE plugins.protocolodepartdepartamentos DROP CONSTRAINT plugins_protocolodepartdepartamentos_protocolodepart_fk;

DROP SEQUENCE plugins.protocolodepart_sequencial_seq;
DROP SEQUENCE plugins.protocolodepartdepartamentos_sequencial_seq;

DROP TABLE plugins.protocolodepart;
DROP TABLE plugins.protocolodepartdepartamentos;
