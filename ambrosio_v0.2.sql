alter table localizaciones add visible boolean default true;
alter table grupo add visible boolean default true;

insert into configuracion(variable,valor) values('seccion_crearincidencia_login', 'usuario');
insert into configuracion(variable,valor) values('seccion_incidencias_login', 'usuario');
insert into configuracion(variable,valor) values('seccion_usuarios_login', 'admin');
