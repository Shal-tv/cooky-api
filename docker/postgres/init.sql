-- Créer l'utilisateur en lecture/écriture
CREATE USER cooky_dev_rw WITH PASSWORD 'theix@56450';
GRANT ALL PRIVILEGES ON DATABASE cooky_dev TO cooky_dev_rw;

-- Créer l'utilisateur en lecture seule
CREATE USER cooky_dev_ro WITH PASSWORD 'theix@56450';
GRANT CONNECT ON DATABASE cooky_dev TO cooky_dev_ro;

-- Se connecter à la base pour donner les permissions sur le schéma
\c cooky_dev

-- Permissions pour l'utilisateur RW
GRANT ALL PRIVILEGES ON SCHEMA public TO cooky_dev_rw;
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO cooky_dev_rw;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO cooky_dev_rw;
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL PRIVILEGES ON TABLES TO cooky_dev_rw;
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL PRIVILEGES ON SEQUENCES TO cooky_dev_rw;

-- Permissions pour l'utilisateur RO
GRANT USAGE ON SCHEMA public TO cooky_dev_ro;
GRANT SELECT ON ALL TABLES IN SCHEMA public TO cooky_dev_ro;
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT SELECT ON TABLES TO cooky_dev_ro;

CREATE TABLE public.api_user
(
    uuid         UUID                    NOT NULL
        CONSTRAINT cooky_user_pk PRIMARY KEY,
    username     TEXT                    NOT NULL
        CONSTRAINT username_unique UNIQUE,
    email        TEXT                    NOT NULL
        CONSTRAINT email_unique UNIQUE,
    password     TEXT                    NOT NULL,
    roles        JSON                    NOT NULL,
    date_created TIMESTAMP DEFAULT NOW() NOT NULL,
    archive      BOOLEAN   DEFAULT FALSE NOT NULL
);

ALTER TABLE api_user
    OWNER TO cooky_dev_rw;

GRANT SELECT ON api_user TO cooky_dev_ro;

INSERT INTO public.api_user (uuid, username, email, password, roles)
VALUES ('019bc0e0-5c82-7be3-b4a7-af00feac3ce0', 'user_super_admin', 'superadmin@test.fr',
        '$2y$13$puQ3Mi6xDnP/MANsnZwhxeMkvLHFCcyX8ouegalFkXarYpyNRUZxW', '[
        "ROLE_SUPER_ADMIN"
    ]');

INSERT INTO public.api_user (uuid, username, email, password, roles)
VALUES ('019bc0e0-8891-7362-8a39-50a48c77affe', 'user_admin', 'admin@test.fr',
        '$2y$13$q5spxP9SRoh0KUkbhMca2Ojoleh7A6B4HnD49nubmgIcFj5IjJnwm', '[
        "ROLE_ADMIN"
    ]');

INSERT INTO public.api_user (uuid, username, email, password, roles)
VALUES ('019bc0e0-c758-7bdd-8402-653236fa7eaf', 'user_test', 'user@test.fr',
        '$2y$13$7hXdHfXb56/GfgstyhVvBOtWKYSkapV/MnrQZCYvuKNz7wOl7HrAC', '[
        "ROLE_USER"
    ]');
