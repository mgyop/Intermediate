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

//这里遇到奇葩的问题,原因是表名为mysql的关键字导致curd都需要注意这个细节

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
  `money` decimal(9,2) NOT NULL default 0.00 COMMENT '余额',
  `is_vip` tinyint NOT NULL default 0 COMMENT '是否vip 1 是',
  `photo` varchar(150) NOT NULL COMMENT '头像',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
//修改vip等级制度
alter table `user` change column is_vip vip tinyint NOT NULL default 0 COMMENT 'vip等级' after money;
//user 增加一个缩略图字段
 alter table user add column thumb_photo varchar(200) not null default '' comment '缩略图';
-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'admin', '21232f297a57a5a743894a0e4a801fc3', '刘亦菲', '1', '1234545232', '明星', '10000.00', '1', '');




//创建美发套餐表

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `plan`;
CREATE TABLE `plan` (
  `plan_id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '预约id',
  `name` varchar(200) NOT NULL COMMENT '套餐名字',
  `des` text COMMENT '套餐描述',
  `money` decimal(9,2) unsigned NOT NULL COMMENT '套餐金额',
  `status` tinyint NOT NULL COMMENT '状态 1 上线',
  PRIMARY KEY (`plan_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of plans
-- ----------------------------
INSERT INTO `plan` VALUES ('1', '夏日', '靓丽动感', '188.88', '1');

DROP TABLE  IF not EXISTS `history`;
//创建history 消费记录表
create table `history`(
  history_id int(8) unsigned not null auto_increment primary key,
  user_id int not null comment '会员id',
  member_id int not null default 0 comment '服务员工id',
  type tinyint unsigned not null default 1 comment '类型 0 充值 1 消费',
  amount decimal(9,2) not null default 0 comment '金额',
  content varchar(50) not null default '' comment '消费内容',
  time int not null default 0 comment '消费时间',
  remainder decimal(9,2) not null comment '余额'
)engine=innodb default charset=utf8;

//member_id添加默认值
alter table `history` modify column member_id int not null default 0 comment '服务员工id';
//创建order预约表
//order 为关键字 注意
create table `order`(
  order_id int unsigned not null auto_increment primary key,
  phone varchar(13) not null default '' comment '电话',
  realname varchar(50) not null default '' comment '真实姓名',
  barber int unsigned not null default 0 comment '美发师的member_id',
  content varchar(200) not null default '' comment '备注',
  date int not null default 0 comment '预约日期',
  status tinyint not null default 0 comment '1 成功 2 失败 3 未处理',
  reply varchar(200) not null default '' comment '回复消息'
)engine=innodb default charset=utf8;


//article 活动表
drop table if exists article;
create table article(
 article_id int unsigned not null auto_increment primary key,
 title varchar(200) not null default '' comment '活动标题',
 content text comment '活动内容',
 start int not null default 0 comment '开始日期',
 end   int not null default 0 comment '结束日期',
 time  int not null default 0 comment '发布时间'
)engine=innodb default charset=utf8;



//代金券sql和数据
SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for code
-- ----------------------------
DROP TABLE IF EXISTS `code`;
CREATE TABLE `code` (
  `code_id` int unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(100) NOT NULL COMMENT '代码',
  `user_id` varchar(50) NOT NULL COMMENT '所属会员',
  `money` int unsigned NOT NULL COMMENT '代金券金额',
  `status` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '1为未使用0为已使用',
  PRIMARY KEY (`code_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

//修改user_id的类型
alter table `code` modify column user_id int unsigned not null comment '所属会员ID';
-- ----------------------------
-- Records of code
-- ----------------------------
INSERT INTO `code` VALUES ('19', 'ID.59b95d587bb47', '黄金会员', '1000', '1');
INSERT INTO `code` VALUES ('7', 'ass', '阿萨啊', '232', '1');
INSERT INTO `code` VALUES ('8', 'ass', '阿萨啊', '232', '1');
INSERT INTO `code` VALUES ('16', '我的速度', '速度', '0', '1');
INSERT INTO `code` VALUES ('18', 'ID.59b958a2eeb4f', '撒大声地', '333', '1');


//预约数据

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for order
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `phone` varchar(11) NOT NULL DEFAULT '' COMMENT '电话',
  `realname` varchar(50) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `barber` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '美发师的member_id',
  `content` varchar(200) NOT NULL DEFAULT '' COMMENT '备注',
  `date` int(11) NOT NULL DEFAULT '3' COMMENT '预约日期',
  `status` tinyint(4) NOT NULL DEFAULT '3' COMMENT '1 成功 2 失败 3 未处理',
  `reply` varchar(200) NOT NULL DEFAULT '' COMMENT '回复消息',
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order
-- ----------------------------
INSERT INTO `order` VALUES ('10', '12123234', '打电话', '1', 'wee', '1505404800', '1', '好的');
INSERT INTO `order` VALUES ('11', '12121111221', '为', '1', '121 ', '1505318400', '1', '');
INSERT INTO `order` VALUES ('14', '112121212', '是', '1', '121', '1506009600', '1', '');
INSERT INTO `order` VALUES ('15', '232112121', '22', '1', '121', '1505491200', '1', '');
INSERT INTO `order` VALUES ('16', '11123131', '所谓', '1', '1212', '1505404800', '3', '');
INSERT INTO `order` VALUES ('17', '12347828321', '为', '1', '121 ', '1506096000', '3', '');
INSERT INTO `order` VALUES ('18', '12347828321', '问问', '1', '问问', '1506009600', '1', '');
INSERT INTO `order` VALUES ('19', '12347828321', '是大神', '1', '12为', '1505491200', '1', '问我');
INSERT INTO `order` VALUES ('21', '12347828321', '是大神', '1', '', '1505404800', '2', '');
INSERT INTO `order` VALUES ('22', '12347828321', '麦克', '1', '是是是', '2017', '3', '');
INSERT INTO `order` VALUES ('23', '12347828321', '过分过分', '1', 'r发', '2017', '3', '');
INSERT INTO `order` VALUES ('24', '12347828321', '过分过分', '1', 'r发', '1505404800', '3', '');
INSERT INTO `order` VALUES ('25', '12323434', '微微', '1', '的士速递', '2017', '3', '');
INSERT INTO `order` VALUES ('26', '12347828321', '实打实地方', '1', '方法地方的', '2017', '3', '');
INSERT INTO `order` VALUES ('27', '23121323', '大幅度', '1', '地方地方', '2017', '3', '');
INSERT INTO `order` VALUES ('28', '12347828321', '辅导费', '1', 'wee', '20170915', '3', '');
INSERT INTO `order` VALUES ('29', '11122323', '大幅度', '1', '大幅度', '2017', '3', '');
INSERT INTO `order` VALUES ('30', '113434656', '速度', '1', '发给', '1506096000', '3', '');
INSERT INTO `order` VALUES ('31', '2323', '是大神', '1', '发', '1505491200', '3', '');
INSERT INTO `order` VALUES ('32', '13246677', '方法', '1', '非凡哥', '1505491200', '3', '');
INSERT INTO `order` VALUES ('33', '222', '撒大声地', '1', '刚刚', '1505491200', '3', '');
INSERT INTO `order` VALUES ('34', '23454665767', '非凡哥', '1', '风高放火', '1505404800', '3', '');
INSERT INTO `order` VALUES ('35', '12433', '就收到货', '1', '发给', '1505491200', '3', '');

//创建充值赠送金额规则表
create table recharge_rule(
   recharge_rule_id int unsigned not null auto_increment primary key,
   amount decimal(9,2) not null default 0 comment '充值金额',
   donation decimal(9,2) not null default 0 comment '赠送金额'
)engine=myisam default charset=utf8;

//会员级别
create table vip(
   vip_id int unsigned auto_increment primary key,
   vipname varchar(50) not null comment '级别名称',
   recharge decimal(9,2) not null default 0 comment '充值金额',
   discount decimal(3,2) not null default 9.9 comment '会员折扣'
)engine=myisam default charset=utf8;














