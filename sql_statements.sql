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
--hieronder maken we een admin als gebruiker door zijn gegevens toe te voegen aan de kollomen.
insert into account(id,email,password)
values(1,'admin1@google.com','e00cf25ad42683b3df678c61f42c6bda');
insert into persoon(id,account_id,voornaam,tussenvoegsel,achternaam,username)
values(1,1,'Julie','','Mak','admin1');

