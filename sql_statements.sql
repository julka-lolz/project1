--hierbij maken we een database genaamd project1.
create database project1;
--hierbij geven we aan dat we database project1 gaan gebruiken.
use project1;
--hieronder maken we een tabel account aan.
create table account(
	id int not null AUTO_INCREMENT,
	username varchar(255) not null UNIQUE,
	email varchar(255) not null UNIQUE,
	type int not null,
	password varchar(255) not null,
	created_at date not null,
	updated_at date not null,
	foreign key (type) references usertype(id),
	primary key(id)	
);

-- hieronder maken we een tabel usertype aan.
create table usertype(
	id int not null AUTO_INCREMENT,
	type varchar(255) not null,
	created_at date not null,
	updated_at date not null,
	primary key(id)
);
--hieronder maken we een tabel persoon aan.
create table persoon(
	id int not null AUTO_INCREMENT,
	account_id int,
	voornaam varchar(255) not null,
	tussenvoegsel varchar(255),
	achternaam varchar(255) not null,
	created_at date not null,
	updated_at date not null,
	primary key(id),
	foreign key (account_id) references account(id)
);
--hieronder maken we een admin als gebruiker door zijn gegevens toe te voegen aan de kollomen.
insert into account(id, username, email, type, password, created_at, updated_at)
values(1,'admin1','admin1@google.com',1,'e00cf25ad42683b3df678c61f42c6bda', '2020-10-02', '2020-10-02');
insert into persoon(id,account_id,voornaam,tussenvoegsel,achternaam,created_at, updated_at)
values(1,1,'Julie','','Mak','2020-10-02', '2020-10-02');

