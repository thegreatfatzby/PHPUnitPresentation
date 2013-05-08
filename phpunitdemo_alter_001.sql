use mysql;

drop database if exists phpunitdemo;

create database phpunitdemo;

use phpunitdemo;

create table tinytag (
	id int not null auto_increment primary key,
	url varchar(100) not null
);