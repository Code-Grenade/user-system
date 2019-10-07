CREATE TABLE users(
    id          int(10) NOT NULL AUTO_INCREMENT,
    username    varchar(32) NOT NULL,
    email       varchar(32) NOT NULL,
    password    varchar(191) NOT NULL,
    avatar      varchar(191) DEFAULT 'http://s3.amazonaws.com/37assets/svn/765-default-avatar.png',

    PRIMARY KEY (id)
);