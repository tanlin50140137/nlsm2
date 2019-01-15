#后台设置
drop table if exists nlsm_setconfig;
create table nlsm_setconfig(
	id int(10) unsigned not null auto_increment primary key comment '主键',	
	iterm varchar(32) not null default '' comment '配置项-查询依据标识',
	msginfo text not null comment '配置内容',
	state tinyint(10) unsigned not null default 0 comment '状态,0=启用,1=停止',
	key key_iterm(iterm)
)ENGINE=MyISAM DEFAULT CHARSET='utf8';

#用户登录
drop table if exists nlsm_member;
create table nlsm_member(
	id int(10) unsigned not null auto_increment primary key comment '主键',
	sign_id varchar(32) unique not null default '' comment '用户唯一的身份序号',
	pid int(10) unsigned not null default 0 comment '个人PID关联上级 ,0=没有上级',
	bus_pid int(10) unsigned not null default 0 comment '商家bus_id关联上级 ,0=没有上级',
	level_l tinyint(10) unsigned not null default 1 comment '用户等级 ,1=普通会员',
	ref_code varchar(32) not null default '' comment '用户推荐码',
	pid_code varchar(32) not null default '' comment '上级推荐码',
	openid varchar(255) not null default '' comment '微信唯一标识openid',
	buy_id varchar(255) not null default '' comment '支付宝唯一标识',
	username varchar(32) not null default '' comment '用户名',
	nickname varchar(32) not null default '' comment '昵称',
	password varchar(32) not null default '' comment '登录密码',
	point int(11) unsigned not null default 0 comment '积分',
	money decimal(10,2) not null default '0.00' comment '余额',
	sex tinyint(10) unsigned not null default 0 comment '状态,0=保密,1=男,2=女',
	tel     varchar(32) not null default '' comment '手机-注册',
	email   varchar(32) not null default '' comment '邮箱-注册',
	realname varchar(255) not null default '' comment '实名',
	pin_codes varchar(255) not null default '' comment '身份证',
	alipay varchar(32) not null default '' comment '支付宝',
	bank varchar(255) not null default '' comment '开户行',
	account varchar(255) not null default '' comment '帐户',
	pay_pwd varchar(32) not null default '' comment '支付密码',
	pic  varchar(255) not null default '' comment '头像',
	qrcode  varchar(255) not null default '' comment '推广二维码',
	pay_code varchar(255) not null default '' comment '收款二维码',
	remark  text not null comment '备注',
	follow tinyint(10) unsigned not null default 0 comment '是否关注公众号，1是',
	login_ip varchar(16) not null default '' comment '登录IP',
	create_time int(11) unsigned not null default 0 comment '创建时间',
	birthday varchar(255) not null default 0 comment '会员生日',
	bus_id int(11) unsigned not null default 0 comment '商户ID，升级为商户',
	is_state tinyint(1) unsigned not null default '1' comment '用户状态：1正常，2禁用',
	key key_pin_codes(pin_codes),
	key key_ref_code(ref_code),
	key key_pid_code(pid_code),
	key key_openid(openid),
	key key_buy_id(buy_id),
	key key_username(username),
	key key_email(email),
	key key_create_time(create_time)
)ENGINE=MyISAM DEFAULT CHARSET='utf8';
#用户等级
drop table if exists nlsm_member_level;
create table nlsm_member_level(
	id int(10) unsigned not null auto_increment primary key comment '主键',
	name varchar(32) not null default '' comment '等级名称',
	logo  MediumText not null comment '等级LOGO',
	money decimal(10,2) not null default '0' comment '激活金额',
	meet_fire varchar(32) not null default '0' comment '会员激活',
	agent_fire varchar(32) not null default '0' comment '代理激活',
	gold_fire varchar(32) not null default '0' comment '金牌激活',
	profit varchar(32) not null default '0' comment '支付分润',
	bus_fit varchar(32) not null default '0' comment '商家收款折扣额',
	team_gold varchar(32) not null default '0' comment '团队直推金牌收益',
	team_agent varchar(32) not null default '0' comment '团队所有代理收益',
	team_fire varchar(32) not null default '0' comment '团队所有会员收益',
	chief_fire varchar(32) not null default '0' comment '大区总监收益',
	is_state tinyint(1) unsigned not null default '1' comment '用户状态：1正常，2禁用',
	key key_name(name)
)ENGINE=MyISAM DEFAULT CHARSET='utf8';
#推广会员购买等级-购买支付表
drop table if exists nlsm_member_upgrade;
create table nlsm_member_level(
	id int(10) unsigned not null auto_increment primary key comment '主键',
	ordersn varchar(30) not null default '' comment '订单号',
	uid int(10) unsigned not null default 0 comment '用户ID',
	member_level_id int(10) unsigned not null default 0 comment '等级ID',
	amount varchar(32) not null default '' comment '支付金额',
	method varchar(30) not null default '' comment '支付方式,1=支付宝、2=微信支付、3=其他方式',
	higher_level_id varchar(255) not null default '' comment '上级ID',
	zero varchar(255) not null default '' comment '返佣金',
	create_time int(11) unsigned not null default 0 comment '创建时间',
	payment_time int(11) unsigned not null default 0 comment '支付时间',
	pay_status tinyint(10) unsigned not null default 1 comment '状态,1=未支付,2=已支付',
	key key_ordersn(ordersn)
)ENGINE=MyISAM DEFAULT CHARSET='utf8';
#推广会员-上级分佣金表
drop table if exists nlsm_member_log;
create table nlsm_member_log(
	id int(10) unsigned not null auto_increment primary key comment '主键',
	types varchar(255) NOT NULL COMMENT '积分策略标识',
  	uid int(11) NOT NULL COMMENT '用户id',
  	remark text NOT NULL COMMENT '日志内容',
  	create_time int(11) NOT NULL COMMENT '日志写入时间',
  	money decimal(10,2) NOT NULL DEFAULT '0' COMMENT '金额数值',
  	ordersn varchar(30) not null default '' comment '订单号',
  	expenses decimal(10,2) NOT NULL DEFAULT '0' COMMENT '手续费用',
	key key_ordersn(ordersn)
)ENGINE=MyISAM DEFAULT CHARSET='utf8';
#广告图片
drop table if exists nlsm_advert;
create table nlsm_advert(
	id int(10) unsigned not null auto_increment primary key comment '主键',
	imgs  MediumText not null comment '等级LOGO',
	urls varchar(32) not null default '' comment '设置URL',
	alts varchar(32) not null default '' comment '设置图片描述',
	is_state tinyint(1) unsigned not null default '1' comment '用户状态：1正常，2禁用'
)ENGINE=MyISAM DEFAULT CHARSET='utf8';
#商品分类
drop table if exists nlsm_goods_type;
create table nlsm_goods_type(
	id int(10) unsigned not null auto_increment primary key comment '主键',
	pid int(10) unsigned not null default 0 comment 'PID组',
	name varchar(32) not null default '' comment '分类名称',
	logo  MediumText not null comment 'LOGO',
	sork tinyint(1) unsigned not null default 0 comment '分类排序，大数靠前',
	is_state tinyint(1) unsigned not null default '1' comment '用户状态：1正常，2禁用',
	key key_name(name)
)ENGINE=MyISAM DEFAULT CHARSET='utf8';
#商城商品
drop table if exists nlsm_goods;
create table nlsm_goods(
	id int(10) unsigned not null auto_increment primary key comment '主键',
	goods_type_id int(10) unsigned not null default 0 comment '商品分类ID',
	logo varchar(255) not null default '' comment 'LOGO封面图片',
	name varchar(32) not null default '' comment '商品名称',
	unit_Price varchar(32) not null default '' comment '商品单价',
	price varchar(32) not null default '' comment '商品售价',
	coupon varchar(32) not null default '' comment '需要呗尔劵',
	stock varchar(32) not null default '' comment '库存数量',
	volumes varchar(32) not null default '' comment '销售数量',
	amount varchar(32) not null default '' comment '销售金额',
	goods_color_id varchar(255) not null default '' comment '商品颜色关联ID',
	goods_norms_id varchar(255) not null default '' comment '商品规格关联ID',
	unit varchar(32) not null default '' comment '商品单位',
	content MediumText not null comment '商品描述',
	create_time int(11) unsigned not null default 0 comment '创建时间',
	sork tinyint(1) unsigned not null default 0 comment '分类排序，大数靠前',
	is_state tinyint(1) unsigned not null default '1' comment '商品状态：1上架，2下架',
	key key_name(name),
	key key_create_time(create_time)
)ENGINE=MyISAM DEFAULT CHARSET='utf8';
#商品颜色
drop table if exists nlsm_goods_color;
create table nlsm_goods_color(
	id int(10) unsigned not null auto_increment primary key comment '主键',
	pid int(10) unsigned not null default 0 comment 'PID组',
	name varchar(32) not null default '' comment '颜色名称',
	color_val varchar(32) not null default '' comment '颜色值',
	is_state tinyint(1) unsigned not null default '1' comment '用户状态：1正常，2禁止',
	key key_name(name)
)ENGINE=MyISAM DEFAULT CHARSET='utf8';
#商品规格
drop table if exists nlsm_goods_norms;
create table nlsm_goods_norms(
	id int(10) unsigned not null auto_increment primary key comment '主键',
	pid int(10) unsigned not null default 0 comment 'PID组',
	name varchar(32) not null default '' comment '规格名称',
	max_val varchar(32) not null default '' comment '大小值',
	is_state tinyint(1) unsigned not null default '1' comment '用户状态：1正常，2禁止',
	key key_name(name)
)ENGINE=MyISAM DEFAULT CHARSET='utf8';
#收货地址
drop table if exists nlsm_address;
create table nlsm_address(
	id int(10) unsigned not null auto_increment primary key comment '主键',
	uid int(10) unsigned not null default '0' comment '用户ID',
	city varchar(255) not null default '' comment '省市区',
	address text comment '详细地址',
	addrecode varchar(255) not null default '' comment '邮政编码',
	name varchar(255) not null default '' comment '收货人姓名',
	tel varchar(255) not null default '' comment '收货人手机',
	state tinyint(10) unsigned not null default 0 comment '状态,1=默认使用,2=不使用',
	key key_tel(tel),
	key key_name(name)
)ENGINE=MyISAM DEFAULT CHARSET='utf8';
#购物车
drop table if exists nlsm_cart;
create table nlsm_cart(
	id int(10) unsigned not null auto_increment primary key comment '主键',
	uid int(10) unsigned not null default '0' comment '商品ID',
	goods_id int(10) unsigned not null default '0' comment '商品ID',
	goods_color_id int(10) unsigned not null default '0' comment '商品颜色关联ID',
	goods_norms_id int(10) unsigned not null default '0' comment '商品规格关联ID',
	nums tinyint(1) unsigned not null default 0 comment '购买数量',
	state tinyint(10) unsigned not null default 0 comment '状态,1=正常,2=禁止'
)ENGINE=MyISAM DEFAULT CHARSET='utf8';
#商品下单表
drop table if exists nlsm_goods_order;
create table nlsm_goods_order(
	id int(10) unsigned not null auto_increment primary key comment '主键',
	uid int(10) unsigned not null default '0' comment '支付用户',
	ordersn varchar(30) not null default '' comment '订单号',
	goods_name varchar(30) not null default '' comment '商品名称',
	goods_id int(10) unsigned not null default 0 comment '商品ID',
	goods_color_id int(10) unsigned not null default 0 comment '商品颜色关联ID',
	goods_norms_id int(10) unsigned not null default 0 comment '商品规格关联ID',
	address_id int(10) unsigned not null default 0 comment '寄件地址ID',
	nums tinyint(1) unsigned not null default 0 comment '购买数量',
	amount varchar(32) not null default '' comment '支付金额',
	method varchar(30) not null default '' comment '支付方式,1=支付宝、2=微信支付、3=呗尔劵支付',
	notes varchar(255) not null default '' comment '支付备注',
	logisticsorder varchar(255) not null default '' comment '物流订单', 
	logisticsnumber varchar(10) not null default '' comment '物流编号',
	create_time int(11) unsigned not null default 0 comment '创建时间',
	payment_time int(11) unsigned not null default 0 comment '支付时间',
	pay_status tinyint(10) unsigned not null default 1 comment '状态,1=未支付,2=已支付',
	rej_status tinyint(10) unsigned not null default 1 comment '收货状态,1=未发货,2=已发货,3=待收货,4=已收货',
	state tinyint(10) unsigned not null default 1 comment '状态,1=正常,2=取消订单,3=退货',
	key key_ordersn(ordersn)
)ENGINE=MyISAM DEFAULT CHARSET='utf8';
#快递公司编码表
drop table if exists nlsm_express_coding;
create table nlsm_express_coding(
	id int(10) unsigned not null auto_increment primary key comment '主键',
	company varchar(255) not null default '' comment '快递公司名称',
	coding varchar(32) not null default '' comment '编码',
	state tinyint(10) unsigned not null default 1 comment '状态,1=正常,2=禁止'
)ENGINE=MyISAM DEFAULT CHARSET='utf8';

#商家入住信息
drop table if exists nlsm_business;
create table nlsm_business(
	id int(10) unsigned not null auto_increment primary key comment '主键',
	pid int(10) unsigned not null default 0 comment 'PID',
	ref_code varchar(32) not null default '' comment '上级推荐码',
	username varchar(32) not null default '' comment '用户名帐号',
	password varchar(32) not null default '' comment '登录密码',
	types tinyint(10) unsigned not null default 0 comment '类型,1=个休,2=企业',
	license varchar(255) not null default '' comment '营业执照',
	license_name varchar(255) not null default '' comment '营业执照名称',
	unicode varchar(50) not null default '' comment '统一代码',
	card_ID varchar(255) not null default '' comment '身份证',
	money varchar(50) not null default '' comment '余额',
	integral varchar(50) not null default '' comment '积分',
	coupon varchar(50) not null default '' comment '呗尔劵',
	alipay varchar(32) not null default '' comment '支付宝帐号',
	bank_card varchar(32) not null default '' comment '银行卡帐号',
	open_bank varchar(255) not null default '' comment '开户行',
	pay_pwd varchar(32) not null default '' comment '二级支付密码',
	shop_name varchar(32) not null default '' comment '店铺名称',
	shop_as varchar(32) not null default '' comment '店铺简称',
	shop_tel varchar(32) not null default '' comment '联系电话',
	province varchar(32) not null default '' comment '省',
	city varchar(32) not null default '' comment '市',
	plate varchar(32) not null default '' comment '店铺地址门牌',
	industry tinyint(10) unsigned not null default 0 comment '行业,1=餐饮,2=娱乐休闲,3=医疗,4=酒店,5=生活服务,6=美容,7=家装建材,8=培训,9=汽车',
	payment_code text default '' comment '商户收款二维码',
	code_status text default '' comment '商户收款二维码状态',
	state tinyint(10) unsigned not null default 3 comment '状态,1=正常,2=禁止,3=审核中',
	key key_unicode(unicode),
	key key_card_ID(card_ID),
	key key_shop_name(shop_name),
	key key_shop_tel(shop_tel),
	key key_username(username)
)ENGINE=MyISAM DEFAULT CHARSET='utf8';
#商铺信息
drop table if exists nlsm_business_data;
create nlsm_business_data(
	id int(10) unsigned not null auto_increment primary key comment '主键',
	business_id int(10) unsigned not null default 0 comment '商户ID',
	logo varchar(255) not null default '' comment '店铺logo',
	map varchar(255) not null default '' comment '店铺主图',
	picture text default '' comment '店铺环境图片',
	shows text default '' comment '产品展示',
	describe text default '' comment '产品展示'
)ENGINE=MyISAM DEFAULT CHARSET='utf8';