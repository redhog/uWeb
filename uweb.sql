drop table account;
drop table object_property;
drop table object_relation;
drop table object;
drop table property_value;
drop table property;
drop table property_type;

create table property_type (
 id serial primary key not null,
 name varchar not null
);

create table property (
 id serial primary key not null,
 "type" integer references property_type(id) not null,
 name varchar not null
);

create table property_value (
 id integer references property(id) not null,
 value varchar not null
);

create table object (
 id serial primary key not null
);

create table object_relation (
 parent integer references object(id) not null,
 "path" varchar not null,
 object integer references object(id) not null
);

create table object_property (
 object integer references object(id) not null,
 property integer references property(id) not null,
 value varchar not null
);

create table account (
 id serial primary key not null,
 name varchar not null,
 password varchar not null
);

insert into property_type (name) values ('String');
insert into property_type (name) values ('Integer');
insert into property_type (name) values ('Real');
insert into property_type (name) values ('Selection');
insert into property_type (name) values ('Boolean');
insert into property_type (name) values ('File');

insert into property (type, name) select property_type.id, 'Title' from property_type where property_type.name = 'String';
insert into property (type, name) select property_type.id, 'Body' from property_type where property_type.name = 'String';
insert into property (type, name) select property_type.id, 'Icon' from property_type where property_type.name = 'File';
insert into property (type, name) select property_type.id, 'Image' from property_type where property_type.name = 'File';
insert into property (type, name) select property_type.id, 'Visible' from property_type where property_type.name = 'Boolean';

insert into object default values;
insert into object_relation select currval('object_id_seq'), '/', currval('object_id_seq');
insert into object_property select currval('object_id_seq'), property.id, 'Home' from property where property.name = 'Title';
