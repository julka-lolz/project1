--hierbij maken we een database genaamd project1.
create database project1;
--hierbij geven we aan dat we database project1 gaan gebruiken.
use project1;
--hieronder maken we een tabel account aan.
create table account(
	id int not null,
	email varchar(255) not null UNIQUE,
	password varchar(255) not null,
	primary key(id) 
);
--hieronder maken we een tabel persoon aan.
create table persoon(
	id int not null,
	account_id int,
	voornaam varchar(255) not null,
	tussenvoegsel varchar (255),
	achternaam varchar (255) not null,
	username varchar (255) not null,
	primary KEY(id),
	foreign key (account_id) references account(id)
);