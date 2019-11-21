drop database if exists samostan;
create database samostan;
use samostan;
#CHARSET --default_character_set=utf8 

create table svecenik(
    sifra       int not null primary key auto_increment,
    ime         varchar(50),
    prezime     varchar(50),
    posao       int not null,
    nadređeni   int not null
);

create table posao(
    sifra       int not null primary key auto_increment,
    naziv       varchar(50)
);

create table nadređeni(
    sifra       int not null primary key auto_increment,
    ime         varchar(50),
    prezime     varchar(50)
);

alter table svecenik add foreign key (posao) references posao(sifra);
alter table svecenik add foreign key (nadređeni) references nadređeni(sifra);

describe nadređeni;
select * from nadređeni;

insert into nadređeni (sifra,ime,prezime) values
(null,'Ivan','Vukoja'),
(null,'Ante','Mabić'),
(null,'Martin','Brekalo'),
(null,'Stipe','Brkić');

describe posao;
select * from posao;

insert into posao (sifra,naziv) values
(null,'kuhanje'),
(null,'peglanje'),
(null,'pranje'),
(null,'vožnja'),
(null,'vrtlarenje'),
(null,'košnja'),
(null,'hranjenje'),
(null,'organizacija');

describe svecenik;
select * from svecenik;

insert into svecenik (sifra,ime,prezime,posao,nadređeni) values
(null,'Ante','Kunce',1,1),
(null,'Marko','Mabić',5,1),
(null,'Petar','Andrić',6,1),
(null,'Josip','Brekalo',3,2),
(null,'Luka','Modrić',2,2),
(null,'Leonardo','Glavačević',8,3),
(null,'Tomislav','Damjanović',7,3),
(null,'Dragan','Bilobrk',4,4),
(null,'Ivan','Martinović',5,4),
(null,'Marin','Karačić',3,4);

