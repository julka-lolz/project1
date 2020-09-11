hierbij maak ik een nieuwe db genaamd project1 net twee tabellen.
create database project1;
use project1;

create table account(
	id int not null,
	email varchar(255) UNIQUE,
	password varchar(255),
	primary key(id) 
);

create table persoon(
	id int NOT null,
    account_id int,
	voornaam varchar(255),
	tussenvoegsel varchar (255),
	achternaam varchar (255),
	username varchar (255),
    primary KEY(id),
	foreign key (account_id) references account(id)
);