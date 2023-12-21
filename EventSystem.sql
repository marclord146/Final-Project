Create Database eventsystem;
Create Table user (
userId int not null  AUTO_INCREMENT,
Name varchar(255) not null,
Email varchar(255) not null,
Address varchar(400),
Phone_No varchar(10),
Password varchar(50) not null,
PRIMARY KEY (userId)
);
Create Table event (
Event_ID int not null auto_increment,
Event_Name varchar(255),
Date date,
Venue varchar(255),
Time varchar(10),
Price decimal(7,2),
Category varchar (255),
Description varchar(600),
Image varchar(50),
Quantity int,
primary key (Event_ID)
);
ALTER TABLE event ADD Promoter varchar(255);
Create table orders(
Order_ID int not null auto_increment,
Order_Cost decimal(7,2),
Order_Status varchar(100),
userId int(11),
Name varchar(255) not null,
Email varchar(255) not null,
Address varchar(400),
Phone_No varchar(10),
Order_Date datetime not null DEFAULT CURRENT_TIMESTAMP,
primary key(Order_ID)
);
Create table order_items(
Item_ID int not null auto_increment,
Order_ID int(11),
Event_ID int(11),
Event_Name varchar(255),
Image varchar(50),
Price decimal(7,2),
userId int(11),
Quantity int,
Name varchar(255),
Order_Date datetime,
primary key(Item_ID)
);

ALTER TABLE order_items ADD QRcode LONGBLOB;










