#商家
drop table if exists nlsm_business;
create table nlsm_business(
	id int(10) unsigned not null auto_increment primary key comment '主键',
	users   varchar(32) not null default '' comment '登录帐号',
	pwd     varchar(32) not null default '' comment '登录密码',
	tel     varchar(32) not null default '' comment '手机-注册',
	email   varchar(32) not null default '' comment '邮箱-注册',
	name	varchar(255) not null default '' comment '商家名称',
	pic     text not null comment '头像',
	qrcode  text not null comment '商铺收款二维码',	
	qrcode  text not null comment '商铺收款二维码',
	shareholder_code text not null comment '邀请股东二维码',
	from_code  text not null comment '从筹收款二维码',
	nature state tinyint(10) unsigned not null default 0 comment '状态,0=个体,1=企业',
	license text not null comment '营业执照',
	other_info text not null comment '其他信息',
	publitime int(11) unsigned not null default 0 comment '注册时间',
	power tinyint(10) unsigned not null default 0 comment '权限,0=普通管理员',
	state tinyint(10) unsigned not null default 0 comment '状态,0=正常,1=禁止',
	key key_users(users),
	key key_tel(tel),
	key key_email(email)
)ENGINE=MyISAM DEFAULT CHARSET='utf8';


#后台设置
drop table if exists nlsm_setconfig;
create table nlsm_setconfig(
	id int(10) unsigned not null auto_increment primary key comment '主键',	
	iterm varchar(32) not null default '' comment '配置项-查询依据标识',
	msginfo text not null comment '配置内容',
	state tinyint(10) unsigned not null default 0 comment '状态,0=启用,1=停止',
	key key_iterm(iterm)
)ENGINE=InnoDB DEFAULT CHARSET='utf8';