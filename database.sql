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
)