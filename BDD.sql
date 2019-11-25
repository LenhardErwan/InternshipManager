create schema InternshipManager;
SET search_path=InternshipManager;

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
        EXECUTE 'DELETE FROM company WHERE id_company = '||OLD.id_company||'';
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


--Insert values 
-- /!\ UNIQUEMENT POUR TESTER /!\
INSERT INTO account (first_name, last_name, mail, password) VALUES ('admin', 'admin', 'admin@admin.admin', 'd82494f05d6917ba02f7aaa29689ccb444bb73f20380876cb05d1f37537b7892');
SELECT createMember('erwan', 'lenhard', 'melon@data-squad.net', 'f1e11b86d6d82ad3593ab2101792de2a75fccb35cd566fdcbb70fa7eb16bd056', 'NULL', '2000/03/28', 'NULL');
SELECT createMember('jerem', 'castel', 'jeremjrm@data-squad.net', '35daf295f9900ce210ffe802f8fb746298e44a6dd0d4ff524870fd1b4fb49649', 'NULL', 'NULL', 'NULL');
SELECT createCompany('Igor', 'Popovmolotov', 'Igor@bilderberg.org', 'bde8fb5a8c8d89a26ba2fa128ed6c342dd686a9371499d8b90e0767e633e7482', 'NULL','Quick Entertainement');
SELECT createCompany('Giscard', 'Burger', 'giscard@data-squad.net', 'f1201a47a48379e5119094f4ccd7db51aa002fc4ca4e78ffebaa542fe89aa2ef', 'NULL','GiscAgence');
SELECT createMember('Patrick', 'Balkany', 'patrick.balkany@wanadoo.fr', 'e2f14b6c9f37e29161a65b9d69ab82a0e5c145adc8a931cec82d12192a227f86',  '0140635026', '1948/03/16', 'NULL');

INSERT INTO article (id_company, publication_date, title, begin_date, end_date, mission, contact)
    VALUES(5, '2019-11-08 12:26:50.750323+01', 'Equipier', '2020/04/01', '2020/08/31', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
    Maecenas tortor augue, ultrices vitae consectetur sed, egestas ac nunc. Mauris nisi urna, sollicitudin 
    vel magna vitae, molestie imperdiet odio. Sed efficitur lacus pretium nisl laoreet, non gravida ligula 
    molestie. Ut dapibus facilisis molestie. Fusce sit amet ligula interdum quam egestas iaculis. Sed 
    vestibulum iaculis imperdiet. Duis cursus molestie sem, ac tincidunt orci pretium id. Mauris ac felis 
    vel sapien porta lacinia ac non magna. Sed ac erat porta nibh pretium tristique id non ligula. Donec 
    suscipit facilisis aliquam. Aliquam sit amet mauris non orci iaculis venenatis. Etiam sodales accumsan 
    ipsum vehicula porttitor.', 'mail : recrutement@quickEntertainement.fr');

INSERT INTO vote (id_account, id_article, type) VALUES (2, 1, TRUE);
INSERT INTO vote (id_account, id_article, type) VALUES (3, 1, TRUE);
INSERT INTO vote (id_account, id_article, type) VALUES (1, 1, FALSE);