create schema InternshipManager;
SET search_path=InternshipManager;

CREATE TABLE account (
    id_user SERIAL NOT NULL,
    first_name VARCHAR(15) NOT NULL,
    last_name VARCHAR(15) NOT NULL,
    mail VARCHAR(80) NOT NULL,
    password VARCHAR(64) NOT NULL,
    phone VARCHAR(15),

    CONSTRAINT pk_account PRIMARY KEY (id_user),
    CONSTRAINT u_account UNIQUE (mail)
);

CREATE TABLE member (
    id_member INTEGER NOT NULL,
    birth_date Date,
    degree VARCHAR,
    
    CONSTRAINT pk_member PRIMARY KEY (id_member),
    CONSTRAINT fk_member FOREIGN KEY (id_member) REFERENCES account (id_user) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE company (
    id_company INTEGER NOT NULL,
    social_reason VARCHAR(40) NOT NULL,
    active BOOLEAN DEFAULT FALSE NOT NULL,

    CONSTRAINT pk_company PRIMARY KEY (id_company),
    CONSTRAINT fk_company FOREIGN KEY (id_company) REFERENCES account (id_user) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE article (
    id_article SERIAL NOT NULL,
    id_company INTEGER NOT NULL,
    publication_date TIMESTAMP NOT NULL DEFAULT current_timestamp,
    title VARCHAR(15) NOT NULL,
    begin_date Date NOT NULL,
    end_date Date NOT NULL,
    mission VARCHAR NOT NULL,
    contact VARCHAR NOT NULL,
    attachment VARCHAR,

    CONSTRAINT pk_article PRIMARY KEY (id_article),
    CONSTRAINT fk_article FOREIGN KEY (id_company) REFERENCES company (id_company)
);

CREATE TABLE hashArticle (
    id_article INTEGER NOT NULL,
    id_hash VARCHAR(32) NOT NULL,

    CONSTRAINT pk_ashArticle PRIMARY KEY (id_article),
    CONSTRAINT fk_ashArticle FOREIGN KEY (id_article) REFERENCES article (id_article) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE comment (
    id_admin INTEGER NOT NULL,
    id_article INTEGER NOT NULL,
    text VARCHAR NOT NULL,

    CONSTRAINT pk_comment PRIMARY KEY (id_admin, id_article),
    CONSTRAINT fk_comment_admin FOREIGN KEY (id_admin) REFERENCES account (id_user),
    CONSTRAINT fk_comment_article FOREIGN KEY (id_article) REFERENCES article (id_article)
);

CREATE TABLE vote (
    id_user INTEGER NOT NULL,
    id_article INTEGER NOT NULL,
    positive BOOLEAN NOT NULL,

    CONSTRAINT pk_vote PRIMARY KEY (id_user, id_article),
    CONSTRAINT fk_vote_admin FOREIGN KEY (id_user) REFERENCES account (id_user),
    CONSTRAINT fk_vote_article FOREIGN KEY (id_article) REFERENCES article (id_article)
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
        SELECT id_user INTO id FROM account WHERE mail = _mail;
        EXECUTE 'INSERT INTO member VALUES ('||id||', '||birth_date||', '||degree||');';
    END; $$
LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION deleteMember() RETURNS trigger AS $$
    BEGIN
        EXECUTE 'DELETE FROM account WHERE id_user = '||OLD.id_member||'';
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
        SELECT id_user INTO id FROM account WHERE mail = _mail;
        EXECUTE 'INSERT INTO company VALUES ('||id||', '''||_social_reason||''');';
    END; $$
LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION deleteCompany() RETURNS trigger AS $$
    BEGIN
        EXECUTE 'DELETE FROM company WHERE id_user = '||OLD.id_member||'';
        RETURN OLD;
    END; $$
LANGUAGE plpgsql;
CREATE TRIGGER delCompany AFTER DELETE ON company FOR EACH ROW EXECUTE PROCEDURE deleteCompany();

CREATE OR REPLACE FUNCTION setMD5() RETURNS trigger AS $$
    BEGIN
        PERFORM FROM hashArticle WHERE id_article = NEW.id_article;

        IF(FOUND) THEN
            EXECUTE 'UPDATE hashArticle SET id_hash = '''||md5(CONCAT(NEW.id_company::text,NEW.publication_date::text))||''' WHERE id_article = '||NEW.id_article||';';
            RETURN NEW;
        ELSE
            INSERT INTO hashArticle VALUES (NEW.id_article, md5(CONCAT(NEW.id_company::text,NEW.publication_date::text)));
            RETURN NEW;
        END IF;
        RETURN NULL;
    END; $$
LANGUAGE plpgsql;
CREATE TRIGGER MD5_article AFTER INSERT OR UPDATE ON article FOR EACH ROW EXECUTE PROCEDURE setMD5();


--Insert values 
-- /!\ UNIQUEMENT POUR TESTER /!\
INSERT INTO account (first_name, last_name, mail, password) VALUES ('admin', 'admin', 'admin@admin.admin', 'admin');
SELECT createMember('erwan', 'lenhard', 'melon@data-squad.net', 'JeSuisLeMeilleur', 'NULL', '2000/03/28', 'NULL');
SELECT createMember('jerem', 'castel', 'jeremjrm@data-squad.net', 'JeCodeAvecMesPieds', 'NULL', 'NULL', 'NULL');
SELECT createCompany('Igor', 'Popovmolotov', 'Igor@bilderberg.org', '12ABC34', 'NULL','Quick Entertainement');
SELECT createCompany('Giscard', 'Burger', 'giscard@data-squad.net', 'DoYouWantAnythingFromMcDonald', 'NULL','GiscAgence');
SELECT createMember('Patrick', 'Balkany', 'patrick.balkany@wanadoo.fr', '$$$Argent$$$',  '0140635026', '1948/03/16', 'NULL');

INSERT INTO article (id_company, title, begin_date, end_date, mission, contact)
    VALUES(5, 'Equipier', '2020/04/01', '2020/08/31', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
    Maecenas tortor augue, ultrices vitae consectetur sed, egestas ac nunc. Mauris nisi urna, sollicitudin 
    vel magna vitae, molestie imperdiet odio. Sed efficitur lacus pretium nisl laoreet, non gravida ligula 
    molestie. Ut dapibus facilisis molestie. Fusce sit amet ligula interdum quam egestas iaculis. Sed 
    vestibulum iaculis imperdiet. Duis cursus molestie sem, ac tincidunt orci pretium id. Mauris ac felis 
    vel sapien porta lacinia ac non magna. Sed ac erat porta nibh pretium tristique id non ligula. Donec 
    suscipit facilisis aliquam. Aliquam sit amet mauris non orci iaculis venenatis. Etiam sodales accumsan 
    ipsum vehicula porttitor.', 'mail : recrutement@quickEntertainement.fr');

INSERT INTO vote (id_user, id_article, positive) VALUES (2, 1, TRUE);
INSERT INTO vote (id_user, id_article, positive) VALUES (3, 1, TRUE);
INSERT INTO vote (id_user, id_article, positive) VALUES (1, 1, FALSE);