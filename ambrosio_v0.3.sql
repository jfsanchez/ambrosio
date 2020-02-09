alter table incidencia add mac varchar(15) default null;

CREATE TABLE ordenador(
	idordenador integer PRIMARY KEY auto_increment,
	idlocalizacion integer references localizacion(idlocalizacion),
	etiqueta varchar(30) not null,
	boca varchar(50),
	mac varchar(17) not null,
	dns varchar(250) null,
	ip varchar(15) null,
	procesador varchar(75),
	ssd varchar(25),
	hdd varchar(25),
	ram varchar(25),
	fila integer default 0,
	columna integer default 0,
	fuentealimentacion varchar(250),
	fechaInstalacion timestamp default now(),
	fechaMontaje timestamp default now()
);

