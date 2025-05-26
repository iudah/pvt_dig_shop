create database shop_db;
use shop_db;

create table staff(id int auto_increment primary key,
                   name varchar(255) not null unique,
                   password varchar(255) not null,
                   job enum("manager", "cashier") not null);

create table product(id int auto_increment primary key,
                     name varchar(255) not null unique, 
                     description text,
                     price decimal(10, 2) not null,
                     available_quantity int not null,
                     last_updated timestamp default current_timestamp on update
                         current_timestamp);

create table sales(id int auto_increment primary key, staff_id int not null,
                   sale_time timestamp default current_timestamp,
                   net_price decimal(10, 2) not null,
                   foreign key(staff_id) references staff(id));

create table sale_items(id int auto_increment primary key, sale_id int not null,
                        product_id int not null,
                        price_at_sale decimal(10, 2) not null,
                        quantity int not null,
                        net_price decimal(10, 2) as(quantity *price_at_sale)
                            stored,
                        foreign key(sale_id) references sales(id),
                        foreign key(product_id) references product(id));
                        
insert into staff values(1, "pvt_manager_dummy", "pvt_20010303_i", "manager");
