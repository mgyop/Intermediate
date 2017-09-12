day  1
/**************************************常量表**********************************************/
      APP_PATH     ---  应用文件application的目录
      FRAMEWORK_PATH    ---  Framework的目录
      TOOLS_PATH   ---  Tools的目录
      CONFIG_PATH  ---  配置文件的目录
      ROOT_PATH    ---  网站根目录
      CONTROLLER_PATH  ---  Controller的目录
      VIEW_PATH    ---   View的目录
      PUBLIC_PATH  ---   Public的目录
      UPLOADS_PATH ---  Uploads的目录

/********操作记录*********/

//数据库创建  mmsys

create database if not exists mmsys default charset utf8;

//member 员工表
 create table member(
  member_id int unsigned auto_increment primary key,
  username varchar(100) not null default '' comment '员工名字',
  password char(32) not null comment '密码',
  realname varchar(50) not null default '' comment '真实姓名',
  sex tinyint unsigned not null default 0 comment '0 女 1 男 3 保密',
  telephone varchar(11) not null default '' comment '联系电话',
  group_id tinyint unsigned not null default 0 comment '所属部门id',
  last_login int not null default 0 comment '最后登录时间',
  last_loginip bigint unsigned not null default 0 comment '最后登录ip',
  is_admin tinyint not null default 0 comment '是否管理员 1 是 0 否',
  photo varchar(200) not null default '' comment '头像'
 )engine=innodb default charset=utf8;
//member表 增加一个缩略图字段
 alter table member add column thumb_photo varchar(200) not null default '' comment '缩略图';

//插入一条管理员
insert into member values (null,'admin',md5('admin'),'admin',1,'15756877647',2,0,0,1,'photo');
后台 :
   1 LoginController.class.php // 登录控制器

   1 MemberController.class.php // 员工控制器

   2 MemberModel.class.php     // 会员模型

//创建部门表
create table `group`(
  `group_id` int unsigned not null auto_increment primary key,
  `name` varchar(50) not null default '' comment '部门名称'
)engine=innodb default charset=utf8;

insert into `group` values(null,'上层部门'),(null,'财务部'),(null,'人事部'),(null,'市场部'),(null,'采购部'),(null,'策划部'),(null,'洗脚部'),(null,'洗剪吹部');
<<<<<<< HEAD
=======

//前台登陆表


SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '会员id',
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '密码',
  `realname` varchar(30) NOT NULL COMMENT '名字',
  `sex` tinyint(4) DEFAULT NULL COMMENT '性别',
  `telephone` varchar(11) NOT NULL COMMENT '电话',
  `remark` varchar(50) DEFAULT NULL COMMENT '备注',
  `money` decimal(9,2) NOT NULL COMMENT '余额',
  `is_vip` tinyint NOT NULL COMMENT '是否vip 1 是',
  `photo` varchar(150) NOT NULL COMMENT '头像',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

//user 增加一个缩略图字段
 alter table user add column thumb_photo varchar(200) not null default '' comment '缩略图';
-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'admin', '21232f297a57a5a743894a0e4a801fc3', '刘亦菲', '1', '1234545232', '明星', '10000.00', '1', '');




//创建美发套餐表

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for plans
-- ----------------------------
DROP TABLE IF EXISTS `plans`;
CREATE TABLE `plans` (
  `plan_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '预约id',
  `name` varchar(30) NOT NULL COMMENT '套餐名字',
  `des` text COMMENT '套餐描述',
  `money` decimal(5,2) unsigned NOT NULL COMMENT '套餐金额',
  `status` tinyint(5) NOT NULL COMMENT '状态',
  PRIMARY KEY (`plan_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of plans
-- ----------------------------
INSERT INTO `plans` VALUES ('1', '夏日', '靓丽动感', '188.88', '1');
>>>>>>> 415f1d4415e6b899069d4d2366c66b50abddeeb8
