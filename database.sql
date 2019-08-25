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
ALTER TABLE `users` ADD `avatar` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `date`;
CREATE TABLE categories(
ID INT(11) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
Name VARCHAR(255) UNIQUE NOT NULL,
Description TEXT NOT NULL,
Ordering INT(11) NOT NULL,
Visibility TINYINT DEFAULT 0,
Allow_Comment TINYINT DEFAULT 0,
Allow_Ads TINYINT DEFAULT 0
ALTER TABLE `categories` ADD `parent` INT(10) NOT NULL AFTER `Ordering`;
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
Approve TINYINT DEFAULT 0,
Cat_ID INT(11) UNSIGNED,
FOREIGN KEY (Cat_ID) REFERENCES categories (ID) ON DELETE CASCADE ON UPDATE CASCADE,
Member_ID INT(11) UNSIGNED,
FOREIGN KEY (Member_ID) REFERENCES users (UserId) ON DELETE CASCADE ON UPDATE CASCADE
)
ALTER TABLE `items` ADD `tags` VARCHAR(255) NOT NULL AFTER `Member_ID`;

CREATE TABLE comments (
c_id INT(11) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
comment TEXT,
status TINYINT,
comment_date DATE,
item_id INT(11) UNSIGNED,
FOREIGN KEY (item_id) REFERENCES items (Item_Id) ON DELETE CASCADE ON UPDATE CASCADE,
user_id INT(11) UNSIGNED,
FOREIGN KEY (user_id) REFERENCES users (UserId) ON DELETE CASCADE ON UPDATE CASCADE
)
/*
ALTER TABLE `items` DROP FOREIGN KEY `items_ibfk_1`; ALTER TABLE `items` ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`Cat_ID`) REFERENCES `categories`(`ID`) ON DELETE CASCADE ON UPDATE CASCADE; ALTER TABLE `items` DROP FOREIGN KEY `items_ibfk_2`; ALTER TABLE `items` ADD CONSTRAINT `items_ibfk_2` FOREIGN KEY (`Member_ID`) REFERENCES `users`(`UserId`) ON DELETE CASCADE ON UPDATE CASCADE;
*/

/*SELECT items.*, categories.name AS category_name, users.Username FROM items INNER JOIN categories ON categories.ID = items.Cat_ID INNER JOIN users ON users.UserId = items.Member_ID*/