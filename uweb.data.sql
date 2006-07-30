insert into account (name, password) values ('admin', 'saltgurka');

insert into property (type, name) select property_type.id, 'Price' from property_type where property_type.name = 'real';
insert into property (type, name) select property_type.id, 'Weight' from property_type where property_type.name = 'Real';
insert into property (type, name) select property_type.id, 'Comment' from property_type where property_type.name = 'String';

insert into object default values;
insert into object_relation select object_relation.object, '/test', currval('object_id_seq') from object_relation where object_relation.path = '/';
insert into object_property select currval('object_id_seq'), property.id, 'Test' from property where property.name = 'Title';
insert into object_property select currval('object_id_seq'), property.id, 'Test är ett fin-fint objekt' from property where property.name = 'Body';
insert into object_property select currval('object_id_seq'), property.id, '47.11' from property where property.name = 'Price';
insert into object_property select currval('object_id_seq'), property.id, 'Vi gillar tester, de är bra' from property where property.name = 'Comment';

insert into object default values;
insert into object_relation select object_relation.object, '/test/naja', currval('object_id_seq') from object_relation where object_relation.path = '/test';
insert into object_property select currval('object_id_seq'), property.id, 'Naja' from property where property.name = 'Title';
insert into object_property select currval('object_id_seq'), property.id, 'Nuananananan' from property where property.name = 'Body';
insert into object_property select currval('object_id_seq'), property.id, '13.2' from property where property.name = 'Price';
insert into object_property select currval('object_id_seq'), property.id, '2.34' from property where property.name = 'Weight';

insert into object default values;
insert into object_relation select object_relation.object, '/test/hehe', currval('object_id_seq') from object_relation where object_relation.path = '/test';
insert into object_property select currval('object_id_seq'), property.id, 'Hehe (x)' from property where property.name = 'Title';
insert into object_property select currval('object_id_seq'), property.id, 'xyzzy' from property where property.name = 'Body';




insert into object default values;
insert into object_relation select object_relation.object, '/mua', currval('object_id_seq') from object_relation where object_relation.path = '/';
insert into object_property select currval('object_id_seq'), property.id, 'Mua' from property where property.name = 'Title';
insert into object_property select currval('object_id_seq'), property.id, 'Mua är ett fin-fint objekt' from property where property.name = 'Body';
insert into object_property select currval('object_id_seq'), property.id, '47.11' from property where property.name = 'Price';
insert into object_property select currval('object_id_seq'), property.id, 'Vi gillar muaer, de är bra' from property where property.name = 'Comment';

insert into object default values;
insert into object_relation select object_relation.object, '/mua/naja', currval('object_id_seq') from object_relation where object_relation.path = '/mua';
insert into object_property select currval('object_id_seq'), property.id, 'Naja' from property where property.name = 'Title';
insert into object_property select currval('object_id_seq'), property.id, 'Nuananananan' from property where property.name = 'Body';
insert into object_property select currval('object_id_seq'), property.id, '13.2' from property where property.name = 'Price';
insert into object_property select currval('object_id_seq'), property.id, '2.34' from property where property.name = 'Weight';

insert into object default values;
insert into object_relation select object_relation.object, '/mua/hehe', currval('object_id_seq') from object_relation where object_relation.path = '/mua';
insert into object_property select currval('object_id_seq'), property.id, 'Hehe (x)' from property where property.name = 'Title';
insert into object_property select currval('object_id_seq'), property.id, 'xyzzy' from property where property.name = 'Body';

