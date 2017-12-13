CREATE DATABASE IF NOT EXISTS  "shopImooc";
USE "shopImooc";
/*管理员表*/
DROP TABLE IF EXISTS "imooc_admin";
CREATE TABLE imooc_admin(
  id tinyint unsigned auto_increment key,
  username varchar(20) not null unique,
  password char(32) not null,
  email varchar(50) not null
);
/*分类表*/
DROP TABLE IF EXISTS imooc_cate;
CREATE TABLE imooc_cate(
  id SMALLINT UNSIGNED AUTO_INCREMENT KEY,
  cName VARCHAR(50) UNIQUE
);
/*商品表*/
DROP TABLE IF EXISTS imooc_pro;
CREATE TABLE imooc_pro(
  id INT UNSIGNED AUTO_INCREMENT KEY ,
  pName VARCHAR(50) NOT NULL  UNIQUE ,
  /*商品货号*/
  pSn VARCHAR(50) NOT NULL ,
  /*商品数量*/
  pNum INT UNSIGNED DEFAULT 1,
  mPrice DECIMAL(10,2) NOT NULL,
  iPrice DECIMAL(10,2) NOT NULL,
  pDesc TEXT,
  pImg VARCHAR(50) NOT NULL ,
  /*商品上架时间*/
  pubTime INT UNSIGNED NOT NULL ,
  /*商品是否在卖*/
  isShow TINYINT(1) DEFAULT 1,
  /*商品是否热卖*/
  isHot TINYINT(1) DEFAULT 0,
  cId SMALLINT UNSIGNED NOT NULL
);
/*用户表*/
DROP TABLE IF EXISTS imooc_user;
CREATE TABLE imooc_user(
  id INT UNSIGNED AUTO_INCREMENT KEY ,
  username VARCHAR(20) NOT NULL UNIQUE ,
  password char(32) not null,
  sex ENUM('男','女','保密') NOT NULL  DEFAULT '保密',
  face VARCHAR(50) NOT NULL ,
  /*注册时间*/
  regTime INT UNSIGNED NOT NULL
);
/*相册表*/
DROP TABLE IF EXISTS imooc_album;
CREATE TABLE imooc_album(
  id INT UNSIGNED AUTO_INCREMENT KEY ,
  pid INT UNSIGNED NOT NULL ,
  albumPath VARCHAR(50) NOT NULL
);


