--hieronder geven we aan dat we project1 gaan gebruiken.
use project1;
--hieronder maken we 4 tabellen aan.
create table users(
	id int auto_increment,
	username varchar(255) not null unique,
	created_at datetime,
	updated_at datetime,
	primary key(id)
);

create table authors(
	id int auto_increment,
	first_name varchar(255) not null,
	last_name varchar(255) not null,
	created_at datetime not null,
	updated_at datetime not null,
	primary key(id)
);

create table books(
	id int auto_increment,
	title varchar(255) not null,
	author_id int not null,
	publishing_year varchar(255) not null,
	genre varchar(255) not null,
	created_at datetime not null,
	updated_at datetime not null,
	primary key(id),
	foreign key(author_id) references authors(id)
);

create table favourites(
	id int auto_increment,
	user_id int not null,
	book_id int not null,
	created_at datetime not null,
	updated_at datetime not null,
	primary key(id),
	foreign key(user_id) references users(id),
	foreign key(book_id) references books(id)
);