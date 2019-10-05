CREATE TABLE users(
    id          int(10) NOT NULL AUTO_INCREMENT,
    username    varchar(32) NOT NULL,
    email       varchar(32) NOT NULL,
    password    varchar(191) NOT NULL,

    PRIMARY KEY (id)
);