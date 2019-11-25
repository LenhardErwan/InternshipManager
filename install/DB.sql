CREATE SCHEMA InternshipManager;

CREATE TABLE account (
    id_account SERIAL NOT NULL,
    first_name VARCHAR(15) NOT NULL,
    last_name VARCHAR(15) NOT NULL,
    mail VARCHAR(80) NOT NULL,
    password VARCHAR(64) NOT NULL,
    phone VARCHAR(15) DEFAULT NULL,

    CONSTRAINT pk_account PRIMARY KEY (id_account),
    CONSTRAINT u_account UNIQUE (mail)
);

CREATE TABLE member (
    id_member INTEGER NOT NULL,
    birth_date Date DEFAULT NULL,
    degrees VARCHAR DEFAULT NULL,
    
    CONSTRAINT pk_member PRIMARY KEY (id_member),
    CONSTRAINT fk_member FOREIGN KEY (id_member) REFERENCES account (id_account) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE company (
    id_company INTEGER NOT NULL,
    social_reason VARCHAR(40) NOT NULL,
    active BOOLEAN DEFAULT FALSE NOT NULL,

    CONSTRAINT pk_company PRIMARY KEY (id_company),
    CONSTRAINT fk_company FOREIGN KEY (id_company) REFERENCES account (id_account) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE article (
    id_article SERIAL NOT NULL,
    id_company INTEGER NOT NULL,
    publication_date TIMESTAMP NOT NULL DEFAULT current_timestamp,
    id_hash VARCHAR(32) NOT NULL,
    title VARCHAR(30) NOT NULL,
    begin_date Date NOT NULL,
    end_date Date NOT NULL,
    mission VARCHAR NOT NULL,
    contact VARCHAR NOT NULL,
    attachment VARCHAR DEFAULT NULL,

    CONSTRAINT pk_article PRIMARY KEY (id_article),
    CONSTRAINT fk_article FOREIGN KEY (id_company) REFERENCES company (id_company) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT u_article UNIQUE (id_hash)
);

CREATE TABLE comment (
    id_admin INTEGER NOT NULL,
    id_article INTEGER NOT NULL,
    text VARCHAR NOT NULL,

    CONSTRAINT pk_comment PRIMARY KEY (id_admin, id_article),
    CONSTRAINT fk_comment_admin FOREIGN KEY (id_admin) REFERENCES account (id_account),
    CONSTRAINT fk_comment_article FOREIGN KEY (id_article) REFERENCES article (id_article) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE vote (
    id_account INTEGER NOT NULL,
    id_article INTEGER NOT NULL,
    type BOOLEAN NOT NULL,

    CONSTRAINT pk_vote PRIMARY KEY (id_account, id_article),
    CONSTRAINT fk_vote_admin FOREIGN KEY (id_account) REFERENCES account (id_account) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_vote_article FOREIGN KEY (id_article) REFERENCES article (id_article) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE OR REPLACE FUNCTION createMember(_first_name varchar, _last_name varchar, _mail varchar, _password varchar, _phone varchar, _birth_date varchar, _degree varchar) RETURNS VOID AS $$
    DECLARE
        id integer;
        phone varchar;
        birth_date varchar;
        degree varchar;
    BEGIN
        IF(_phone = '' OR _phone = 'NULL')
            THEN phone = 'NULL';
            ELSE phone = ''''||_phone||'''';
        END IF;
        IF(_birth_date = '' OR _birth_date = 'NULL')
            THEN birth_date = 'NULL';
            ELSE birth_date = ''''||_birth_date||'''';
        END IF;
        IF(_degree = '' OR _degree = 'NULL')
            THEN degree = 'NULL';
            ELSE degree = ''''||_degree||'''';
        END IF;
        EXECUTE 'INSERT INTO account (first_name, last_name, mail, password, phone)
                     VALUES('''||_first_name||''', '''||_last_name||''', '''||_mail||''', '''||_password||''', '||phone||');';
        SELECT id_account INTO id FROM account WHERE mail = _mail;
        EXECUTE 'INSERT INTO member VALUES ('||id||', '||birth_date||', '||degree||');';
    END; $$
LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION deleteMember() RETURNS trigger AS $$
    BEGIN
        EXECUTE 'DELETE FROM account WHERE id_account = '||OLD.id_member||'';
        RETURN OLD;
    END; $$
LANGUAGE plpgsql;
CREATE TRIGGER delMember AFTER DELETE ON member FOR EACH ROW EXECUTE PROCEDURE deleteMember();


CREATE OR REPLACE FUNCTION createCompany(_first_name varchar, _last_name varchar, _mail varchar, _password varchar, _phone varchar, _social_reason varchar) RETURNS VOID AS $$
    DECLARE
        id integer;
        phone varchar;
    BEGIN
        IF(_phone = '' OR _phone = 'NULL')
            THEN phone = 'NULL';
            ELSE phone = ''''||_phone||'''';
        END IF;
        EXECUTE 'INSERT INTO account (first_name, last_name, mail, password, phone)
                     VALUES('''||_first_name||''', '''||_last_name||''', '''||_mail||''', '''||_password||''', '||phone||');';
        SELECT id_account INTO id FROM account WHERE mail = _mail;
        EXECUTE 'INSERT INTO company VALUES ('||id||', '''||_social_reason||''');';
    END; $$
LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION deleteCompany() RETURNS trigger AS $$
    BEGIN
        EXECUTE 'DELETE FROM company WHERE id_account = '||OLD.id_company||'';
        RETURN OLD;
    END; $$
LANGUAGE plpgsql;
CREATE TRIGGER delCompany AFTER DELETE ON company FOR EACH ROW EXECUTE PROCEDURE deleteCompany();

CREATE OR REPLACE FUNCTION addIdHashArticle() RETURNS trigger AS $$
    DECLARE
        id_hash varchar;
    BEGIN
        id_hash := md5(to_char(NEW.publication_date, 'YYYY-MM-DD-HH24-MI-SS')||NEW.id_company::text);
        NEW.id_hash := id_hash;
        RETURN NEW;
    END; $$
LANGUAGE plpgsql;
CREATE TRIGGER addHashArticle BEFORE INSERT ON article FOR EACH ROW EXECUTE PROCEDURE addIdHashArticle();