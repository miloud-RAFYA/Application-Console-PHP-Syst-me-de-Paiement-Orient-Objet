create database SystemePaiementCNS;

USE SystemePaiementCNS;

create table users (
    id int AUTO_INCREMENT primary KEY,
    name varchar(50) not NULL,
    email varchar(50) not null
);

ALTER TABLE users MODIFY name varchar(50) not NULL UNIQUE;

ALTER TABLE users ADD COLUMN password varchar(250) not NULL UNIQUE;
ALTER TABLE users DROP COLUMN password;


create table commandes (
    id int AUTO_INCREMENT primary key,
    montant_total DOUBLE NOT NULL,
    statut varchar(50),
    user_id int not null,
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
);

create table paiements (
    id int auto_increment primary key,
    montant varchar(50),
    statut varchar(50),
    date_paiement DATETIME DEFAULT CURRENT_TIMESTAMP,
    commande_id INT NOT NULL,
    FOREIGN KEY (commande_id) REFERENCES commandes (id) ON DELETE CASCADE
)

CREATE TABLE bank_cards (
    payment_id INT PRIMARY KEY,
    card_number_last4 CHAR(4) NOT NULL,
    card_holder VARCHAR(255) NOT NULL,
    card_type VARCHAR(20) NOT NULL,
    FOREIGN KEY (payment_id) REFERENCES paiements (id)
);

drop table bank_transfers;

CREATE TABLE paypal_accounts (
    payment_id INT PRIMARY KEY,
    paypal_email VARCHAR(255) NOT NULL UNIQUE,
    account_type VARCHAR(20) DEFAULT 'personal',
    FOREIGN KEY (payment_id) REFERENCES paiements (id)
);

CREATE TABLE bank_transfers (
    payment_id INT PRIMARY KEY,
    iban VARCHAR(34) NOT NULL,
    bank_name VARCHAR(255) NOT NULL,
    FOREIGN KEY (payment_id) REFERENCES paiements (id)
);

INSERT INTO
    users (name, email, password)
VALUES (
        'Ali Ben Salah',
        'ali@gmail.com',
        'passAli123'
    ),
    (
        'Sara Mohamed',
        'sara@gmail.com',
        'passSara456'
    ),
    (
        'Youssef Amine',
        'youssef@gmail.com',
        'passYoussef789'
    );

INSERT INTO
    commandes (
        montant_total,
        statut,
        user_id
    )
VALUES (250.00, 'EN_ATTENTE', 1),
    (120.50, 'PAYEE', 2),
    (560.75, 'EN_ATTENTE', 3);

INSERT INTO
    paiements (montant, statut, commande_id)
VALUES ('250.00', 'SUCCESS', 1),
    ('120.50', 'SUCCESS', 2),
    ('560.75', 'FAILED', 3);

INSERT INTO
    bank_cards (
        payment_id,
        card_number_last4,
        card_holder,
        card_type
    )
VALUES (
        1,
        '1234',
        'Ali Ben Salah',
        'VISA'
    );

INSERT INTO
    paypal_accounts (
        payment_id,
        paypal_email,
        account_type
    )
VALUES (
        2,
        'sara.paypal@gmail.com',
        'personal'
    );

INSERT INTO
    bank_transfers (payment_id, iban, bank_name)
VALUES (
        3,
        'FR7630006000011234567890189',
        'BNP Paribas'
    );