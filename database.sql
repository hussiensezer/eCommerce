CREATE DATABASE shop;

USE shop;

CREATE TABLE users(

UserId INT(11) UNSIGNED PRIMARY KEY AUTO_INCREMENT,/*To Idenify User*/
Username VARCHAR(255) NOT NULL, /*UserName To Login*/
Password VARCHAR(255) NOT NULL, /* Password To Login*/
Email VARCHAR(255) NOT NULL,
FullName VARCHAR(255) NOT NULL, /*Full Name in Website*/
GroupId INT(11) DEFAULT 0 , /* Idenify User Group To Check He is User Or Admin*/
TrustStatus INT(11) DEFAULT 0, /*If The Saller Are good And trusted i can give him spaciel Ranked*/
RegStatus INT(11) DEFAULT 0, /*User Approved */
date DATE NOT NULL /* Date The Time User Register */
);

CREATE TABLE categories(
ID INT(11) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
Name VARCHAR(255) UNIQUE NOT NULL,
Description TEXT NOT NULL,
Ordering INT(11) NOT NULL,
Visibility TINYINT DEFAULT 0,
Allow_Comment TINYINT DEFAULT 0,
Allow_Ads TINYINT DEFAULT 0
);

CREATE TABLE items (
Item_Id INT(11) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
Name VARCHAR(255) NOT NULL,
Description TEXT NOT NULL,
Price VARCHAR(255) NOT NULL,
Add_Date DATE NOT NULL,
Country_Made VARCHAR(255) NOT NULL,
Image VARCHAR(255) ,
Status VARCHAR(255) NOT NULL,
Rating SMALLINT ,
Cat_ID INT(11) UNSIGNED,
FOREIGN KEY (Cat_ID) REFERENCES categories (ID),
Member_ID INT(11) UNSIGNED,
FOREIGN KEY (Member_ID) REFERENCES users (UserId)

)
/*
ALTER TABLE `items` DROP FOREIGN KEY `items_ibfk_1`; ALTER TABLE `items` ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`Cat_ID`) REFERENCES `categories`(`ID`) ON DELETE CASCADE ON UPDATE CASCADE; ALTER TABLE `items` DROP FOREIGN KEY `items_ibfk_2`; ALTER TABLE `items` ADD CONSTRAINT `items_ibfk_2` FOREIGN KEY (`Member_ID`) REFERENCES `users`(`UserId`) ON DELETE CASCADE ON UPDATE CASCADE;
*/