drop database if exists drzavnauprava;
create database drzavnauprava;
use drzavnauprava;
create table zupanija(
    sifra           int not null primary key auto_increment,
    naziv           varchar(100) not null,
    zupan           varchar(50) not null
);

create table opcina(
    sifra           int not null primary key auto_increment,
    zupanija        int not null,
    naziv           varchar(50) not null,
    nacelnik        varchar(50)
);

create table mjesto(
    sifra           int not null primary key auto_increment,
    naziv           varchar(50) not null,
    opcina          int not null,
    brojstanovnika  int not null
);

alter table opcina add foreign key (zupanija) references zupanija(sifra);
alter table mjesto add foreign key (opcina) references opcina(sifra);

describe zupanija;
select * from zupanija;
insert into zupanija (sifra,naziv,zupan) values 
(null,'Osječko-baranjska','Ivan Anušić'),
(null,'Brodsko-posavska','Pero Perić'),
(null,'Vukovarsko-srijemska','Ivan Ivić'),
(null,'Požeško-slavonska','Alojz Tomašević'),
(null,'Virovitičko-podravska','Marko Marković');

describe opcina;
select * from opcina;
insert into opcina (sifra,zupanija,naziv,nacelnik) values
(null,1,'Strizivojna','Josip Jakobović'),
(null,2,'Vrpolje','Zdenko Zmaić'),
(null,3,'Gradište','Marko Damjanović'),
(null,4,'Pleternica','Ante Jozić'),
(null,5,'Slatina','Petar Mišić');

describe mjesto;
select * from mjesto;
insert into mjesto (sifra,naziv,opcina,brojstanovnika) values
(null,'Strizivojna',1,3000),
(null,'Čajkovci',2,1300),
(null,'Gradište',3,2200),
(null,'Gradac',4,1100),
(null,'Donji Meljani',5,700);
