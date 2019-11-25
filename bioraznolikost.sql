drop database if exists bioraznolikost;
create database bioraznolikost;
# c:\xampp\mysql\bin\mysql.exe -uedunova -pedunova --default_character_set=utf8 < C:\Users\Damjan\Documents\GitHub\EDUNOVA\bioraznolikost.sql
use bioraznolikost;

create table taksonom(
    sifra       int not null primary key auto_increment,
    ime         varchar(50),
    prezime     varchar(50)
);

create table istrazivac(
    sifra       int not null primary key auto_increment,
    ime         varchar(50),
    prezime     varchar(50),
    username    varchar(100)
);

create table ugrozenost(
    sifra       int not null primary key auto_increment,
    naziv       char(2)
);

create table vrsta(
    sifra       int not null primary key auto_increment,
    ime         varchar(100),
    istrazivac  int not null,
    ugrozenost  int not null
);

alter table vrsta add foreign key (taksonom) references taksonom(sifra);
alter table vrsta add foreign key (ugrozenost) references ugrozenost(sifra);

alter table vrsta add foreign key (istrazivac) references istrazivac(sifra);

describe taksonom;
select * from taksonom;

insert into taksonom (sifra,ime,prezime) values
(null,'Carl','Linnaeus'),
(null,'Carl','Hermann'),
(null,'Alexandr','Fischer'),
(null,'Charles Lucien','Bonaparte'),
(null,'Heinrich','Kuhl');

insert into taksonom (sifra,prezime) values
(null,'Montagu'),
(null,'Peters'),
(null,'Blasisus');

describe ugrozenost;
select * from ugrozenost;

insert into ugrozenost (sifra,naziv) values
(null,'EX'),
(null,'EW'),
(null,'RE'),
(null,'CR'),
(null,'EN'),
(null,'VU'),
(null,'NT'),
(null,'LC'),
(null,'DD');

describe vrsta;
select * from vrsta;

insert into vrsta (sifra,ime,taksonom,ugrozenost) values
(null,'Spermophilus citelus',1,3),
(null,'Mustela lutreola',1,3),
(null,'Monachus monachus',2,3),
(null,'Castor fiber',1,3),
(null,'Lynx lynx',1,3),
(null,'Rupicapra rupicapra',1,3),
(null,'Talpa cf. europea',1,5),
(null,'Plecotus austriacus',3,5),
(null,'Myotis capaccinii',4,5);

insert into vrsta (sifra,ime,taksonom,ugrozenost) values
(null,'Myotis bechsteinii',5,6),
(null,'Delphinus delphis',1,9),
(null,'Lutra lutra',1,9),
(null,'Nyctalus leisleri',5,7),
(null,'Sciurus vulgaris',1,7),
(null,'Cricetus cricetus',1,7),
(null,'Canis lupus',1,7),
(null,'Ursus arctos',1,7),
(null,'Glis glis',1,8);
