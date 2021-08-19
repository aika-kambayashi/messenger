drop database if exists messenger;
create database messenger default character set utf8;

use messenger;

drop table if exists user;
create table user(
    id int not null primary key auto_increment,
    login_id varchar(255) not null unique,
    password varchar(255) not null default '',
    nickname varchar(255) not null default '',
    modified_at datetime not null default current_timestamp,
    created_at datetime not null default current_timestamp
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists groups;
create table groups(
    group_id int not null primary key auto_increment,
    title varchar(255) not null default '',
    created_at datetime not null default current_timestamp
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists group_user;
create table group_user(
    group_user_id int not null primary key auto_increment,
    group_id int not null,
    user_id int not null,
    unique (group_id, user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists chat;
create table chat(
    chat_id int not null primary key auto_increment,
    group_id int not null,
    user_id int not null,
    message varchar(255) not null default ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;