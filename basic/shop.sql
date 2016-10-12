DROP TABLE IF EXISTS `shop_admin`;
CREATE TABLE IF NOT EXISTS `shop_admin`(
    `adminid` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键ID',
    `adminuser` VARCHAR(32) NOT NULL DEFAULT '' COMMENT '管理员账号',
    `adminpass` CHAR(32) NOT NULL DEFAULT '' COMMENT '管理员密码',
    `adminemail` VARCHAR(50) NOT NULL DEFAULT '' COMMENT '管理员电子邮箱',
    `logintime` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '登录时间',
    `loginip` BIGINT NOT NULL DEFAULT '0' COMMENT '登录IP',
    `userSession` VARCHAR (64) NOT NULL DEFAULT '' COMMENT '登录session',
    `createtime` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
    PRIMARY KEY(`adminid`),
    UNIQUE shop_admin_adminuser_adminpass(`adminuser`, `adminpass`),
    UNIQUE shop_admin_adminuser_adminemail(`adminuser`, `adminemail`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `shop_admin`(adminuser,adminpass,adminemail,createtime) VALUES('admin', md5('123'), 'shop@imooc.com', UNIX_TIMESTAMP());

DROP TABLE IF EXISTS `shop_user`;
CREATE TABLE IF NOT EXISTS `shop_user`(
    `userId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键ID',
    `username` VARCHAR(32) NOT NULL DEFAULT '',
    `userpass` CHAR(32) NOT NULL DEFAULT '',
    `useremail` VARCHAR(100) NOT NULL DEFAULT '',
    `createtime` INT UNSIGNED NOT NULL DEFAULT '0',
    `openId` CHAR(32) NOT NULL DEFAULT '0',
    UNIQUE shop_user_username_userpass(`username`,`userpass`),
    UNIQUE shop_user_useremail_userpass(`useremail`,`userpass`),
    PRIMARY KEY(`userId`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `shop_profile`;
CREATE TABLE IF NOT EXISTS `shop_profile`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键ID',
    `sex` VARCHAR (3) NOT NULL DEFAULT '' COMMENT '性别',
    `year` VARCHAR (10) NOT NULL DEFAULT '' COMMENT '出生年份',
    `nickname` VARCHAR(32) NOT NULL DEFAULT '' COMMENT '昵称',
    `city` VARCHAR(10) NOT NULL DEFAULT '' COMMENT '市',
    `province` VARCHAR(10) NOT NULL DEFAULT '' COMMENT '省',
    `userId` BIGINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户的ID',
    `createtime` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
    PRIMARY KEY(`id`),
    KEY shop_profile_userId(`userId`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `shop_category`;
CREATE TABLE IF NOT EXISTS `shop_category`(
    `cateId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(32) NOT NULL DEFAULT '',
    `parentId` BIGINT UNSIGNED NOT NULL DEFAULT '0',
    `createtime` INT UNSIGNED NOT NULL DEFAULT '0',
    `sort_order` INT UNSIGNED NOT NULL DEFAULT '0',
    `unit` INT UNSIGNED NOT NULL DEFAULT '0',
    `is_show` INT UNSIGNED NOT NULL DEFAULT '0',
    PRIMARY KEY(`cateId`),
    KEY shop_category_parentid(`parentId`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `shop_product`;
CREATE TABLE IF NOT EXISTS `shop_product`(
    `productId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `cateId` BIGINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类Id',
    `title` VARCHAR(200) NOT NULL DEFAULT '' COMMENT '商品名称',
    `descr` TEXT COMMENT '商品描述',
    `num` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '商品库存',
    `price` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品单价',
    `cover` VARCHAR(200) NOT NULL DEFAULT '' COMMENT '封面图片',
    `pics` TEXT COMMENT '商品图片',
    `issale` ENUM('0','1') NOT NULL DEFAULT '0' COMMENT '是否促销',
    `ishot` ENUM('0','1') NOT NULL DEFAULT '0' COMMENT '是否热卖',
    `istui` ENUM('0','1') NOT NULL DEFAULT '0' COMMENT '是否推荐',
    `saleprice` DECIMAL(10,2)  DEFAULT NULL COMMENT '促销价格',
    `ison` ENUM('0','1') NOT NULL DEFAULT '1' COMMENT '是否上架 0：上架 1：下架',
    `createtime` INT UNSIGNED NOT NULL DEFAULT '0',
    KEY shop_product_cateId(`cateId`),
    KEY shop_product_ison(`ison`)
)ENGINE=InnoDB DEFAULT CHARSET='utf8';

DROP TABLE IF EXISTS `shop_cart`;
CREATE TABLE IF NOT EXISTS `shop_cart`(
    `cartId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `productId` BIGINT UNSIGNED NOT NULL DEFAULT '0',
    `productnum` INT UNSIGNED NOT NULL DEFAULT '0',
    `price` DECIMAL(10,2) NOT NULL DEFAULT '0.00',
    `userId` BIGINT UNSIGNED NOT NULL DEFAULT '0',
    `createtime` INT UNSIGNED NOT NULL DEFAULT '0',
    KEY shop_cart_productid(`productId`),
    KEY shop_cart_userid(`userId`)
)ENGINE=InnoDB DEFAULT CHARSET='utf8';

DROP TABLE IF EXISTS `shop_order`;
CREATE TABLE IF NOT EXISTS `shop_order`(
    `orderId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `userId` BIGINT UNSIGNED NOT NULL DEFAULT '0',
    `addressId` BIGINT UNSIGNED NOT NULL DEFAULT '0',
    `amount` DECIMAL(10,2) NOT NULL DEFAULT '0.00',
    `status` INT UNSIGNED NOT NULL DEFAULT '0',
    `expressId` INT UNSIGNED NOT NULL DEFAULT '0',
    `expressno` VARCHAR(50) NOT NULL DEFAULT '',
    `tradeno` VARCHAR(100) NOT NULL DEFAULT '',
    `tradeext` TEXT,
    `createtime` INT UNSIGNED NOT NULL DEFAULT '0',
    `updatetime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY shop_order_userId(`userId`),
    KEY shop_order_addressId(`addressId`),
    KEY shop_order_expressId(`expressId`)
)ENGINE=InnoDB DEFAULT CHARSET='utf8';


DROP TABLE IF EXISTS `shop_order_detail`;
CREATE TABLE IF NOT EXISTS `shop_order_detail`(
    `detailId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `productId` BIGINT UNSIGNED NOT NULL DEFAULT '0',
    `price` DECIMAL(10,2) NOT NULL DEFAULT '0.00',
    `productnum` INT UNSIGNED NOT NULL DEFAULT '0',
    `orderId` BIGINT UNSIGNED NOT NULL DEFAULT '0',
    `createtime` INT UNSIGNED NOT NULL DEFAULT '0',
    KEY shop_order_detail_productId(`productId`),
    KEY shop_order_detail_orderId(`orderId`)
)ENGINE=InnoDB DEFAULT CHARSET='utf8';



DROP TABLE IF EXISTS `shop_address`;
CREATE TABLE IF NOT EXISTS `shop_address`(
    `addressId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `firstname` VARCHAR(32) NOT NULL DEFAULT '',
    `lastname` VARCHAR(32) NOT NULL DEFAULT '',
    `company` VARCHAR(100) NOT NULL DEFAULT '',
    `address` TEXT,
    `postcode` CHAR(6) NOT NULL DEFAULT '',
    `email` VARCHAR(100) NOT NULL DEFAULT '',
    `telephone` VARCHAR(20) NOT NULL DEFAULT '',
    `userId` BIGINT UNSIGNED NOT NULL DEFAULT '0',
    `createtime` INT UNSIGNED NOT NULL DEFAULT '0',
    KEY shop_address_userId(`userId`)
)ENGINE=InnoDB DEFAULT CHARSET='utf8';