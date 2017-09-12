day  1
/**************************************常量表**********************************************/
      ROOT_PATH    ---  网站根目录
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
后台 :
   1 LoginController.class.php // 登录控制器

   2 MemberModel.class.php     // 会员模型

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
//插入一条管理员
insert into member values (null,'admin',md5('admin'),'admin',1,'15756877647',2,0,0,1,'photo');