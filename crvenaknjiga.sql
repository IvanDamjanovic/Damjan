drop database if exists crvenaknjiga;
create database crvenaknjiga default character set utf8;

use crvenaknjiga;

create table istrazivac(
    sifra               int not null primary key auto_increment,
    ime                 varchar(50),
    prezime             varchar(50),
    username            varchar(100),
    institucija         varchar(50),
    vanjskapoveznica    varchar(100),
    taksonom            boolean
);

create table ugrozenost(
    sifra               int not null primary key auto_increment,
    naziv               char(2)
);

create table vrsta(
    sifra               int not null primary key auto_increment,
    ime                 varchar(50),
    kategorija          varchar(50),
    istrazivac          int,
    ugrozenost          int
);

create table istrazivanje(
    vrsta               int not null,
    istrazivac          int not null
);

alter table vrsta add foreign key (istrazivac) references istrazivac(sifra);
alter table vrsta add foreign key (ugrozenost) references ugrozenost(sifra);

alter table istrazivanje add foreign key (vrsta) references vrsta(sifra);
alter table istrazivanje add foreign key (istrazivac) references istrazivac(sifra);

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

describe istrazivac;
select * from istrazivac;
insert into istrazivac (sifra,ime,prezime,username,institucija) values
    (null,'Vlatko','Rožac','vrozac','JUPPKR');

describe vrsta;
select * from vrsta;
insert into vrsta (sifra,ime,ugrozenost) values
    (null,'Spermophilus citelus',3),
    (null,'Mustela lutreola',3),
    (null,'Monachus monachus',3),
    (null,'Castor fiber',3),
    (null,'Lynx lynx',3),
    (null,'Rupicapra rupicapra',3),
    (null,'Talpa cf. europea',5),
    (null,'Plecotus austriacus',5),
    (null,'Myotis capaccinii',5),
    (null,'Myotis bechsteinii',6),
    (null,'Delphinus delphis',9),
    (null,'Lutra lutra',9),
    (null,'Nyctalus leisleri',7),
    (null,'Sciurus vulgaris',7),
    (null,'Cricetus cricetus',7),
    (null,'Canis lupus',7),
    (null,'Ursus arctos',7),
    (null,'Glis glis',8);

update vrsta
set kategorija = 'sisavac' 
where sifra >= 1 and sifra > 18;

