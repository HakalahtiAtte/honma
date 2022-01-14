DROP DATABASE IF EXISTS n7haat00;

CREATE DATABASE n7haat00

CREATE TABLE IF NOT EXISTS users (
        firstname varchar(50) NOT NULL,
        lastname varchar(50) NOT NULL,
        username varchar(50) NOT NULL,
        password varchar(250) NOT NULL,
        PRIMARY KEY (username)
        )

CREATE TABLE IF NOT EXISTS info(
    username varchar(50) NOT NULL,
    email varchar(100),
    phone varchar(20),
    FOREIGN KEY (username) REFERENCES users(username)
    )