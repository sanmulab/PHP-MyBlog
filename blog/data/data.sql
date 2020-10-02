-- 用法: 通过cmd登录数据库, 然后复制此文件所有代码到 cmd 中 回车执行即可
-- 通过 SHOW TABLES; 可以查看是否新建了所有的表.
DROP DATABASE IF EXISTS coding;

CREATE DATABASE IF NOT EXISTS coding DEFAULT CHARACTER SET 'utf8';

USE coding;

-- 分类表

CREATE TABLE coding_category(
    id SMALLINT UNSIGNED NOT NULL KEY AUTO_INCREMENT COMMENT '分类ID,主键且自增',
    category_name VARCHAR(30) NOT NULL COMMENT '分类名称,唯一',
    sort_number SMALLINT UNSIGNED NOT NULL DEFAULT 0  COMMENT '分类排序,数字越大,越靠前',
    created_at INT UNSIGNED NOT NULL COMMENT '分类创建时间',
    updated_at INT UNSIGNED NOT NULL COMMENT '分类更新时间'
) COMMENT '分类表';

-- 管理员角色表

CREATE TABLE coding_admin_role(
	id TINYINT UNSIGNED NOT NULL KEY AUTO_INCREMENT COMMENT '角色ID,主键且自增',
	role_name VARCHAR(30) NOT NULL UNIQUE KEY COMMENT '角色名称,唯一',
	created_at INT UNSIGNED NOT NULL COMMENT '管理员角色创建时间',
    updated_at INT UNSIGNED NOT NULL COMMENT '管理员更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=UTF8 COMMENT '管理员角色表';

INSERT coding_admin_role(role_name,created_at,updated_at) VALUES('普通用户',1597034288,1597034288);
INSERT coding_admin_role(role_name,created_at,updated_at) VALUES('管理员用户',1597034288,1597034288);
INSERT coding_admin_role(role_name,created_at,updated_at) VALUES('超级管理员用户',1597034288,1597034288);

-- 管理员表 : 后台网站

CREATE TABLE coding_admin(
	id SMALLINT UNSIGNED NOT NULL KEY AUTO_INCREMENT COMMENT '管理员ID,主键且自增',
	username VARCHAR(30) NOT NULL UNIQUE COMMENT '管理员用户名,唯一',
	password CHAR(32) NOT NULL COMMENT '管理员密码,MD5',
	nick_name VARCHAR(30) NOT NULL COMMENT '密理员昵称',
	admin_photo VARCHAR(40) NOT NULL COMMENT '管理员头像路径',
	role_id TINYINT UNSIGNED NOT NULL DEFAULT 1 COMMENT '外键,管理员角色ID',
	created_at INT UNSIGNED NOT NULL COMMENT '管理员添加时间',
    updated_at INT UNSIGNED NOT NULL COMMENT '管理员信息更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=UTF8 COMMENT '管理员表';

INSERT coding_admin(username,password,nick_name,admin_photo,role_id,created_at,updated_at) VALUES('admin',MD5('admin'),'三木哥哥','1.png',3,1597034288,1597034288);

-- 文章表

CREATE TABLE coding_article(
	id INT UNSIGNED NOT NULL KEY AUTO_INCREMENT COMMENT '文章ID,主键且自增',
	subject VARCHAR(100) NOT NULL COMMENT '文章标题',
	content MEDIUMTEXT NOT NULL COMMENT '文章正文',
	subject_picture VARCHAR(50) NOT NULL COMMENT '标题图片',
	browse_times INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '浏览次数',
	comment_number INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '评论数量',
    is_online BOOLEAN NOT NULL DEFAULT 1 COMMENT '是否上线,默认为1,即上线,0代表下线',
	category_id SMALLINT UNSIGNED NOT NULL COMMENT '外键,文章分类ID',
	admin_id SMALLINT UNSIGNED NOT NULL COMMENT '外键,管理员ID',
    created_at INT UNSIGNED NOT NULL COMMENT '文章发表时间',
    updated_at INT UNSIGNED NOT NULL COMMENT '文章更新时间'
) COMMENT '文章表';


-- 普通用户表: 前台网站

CREATE TABLE coding_user(
	id MEDIUMINT UNSIGNED NOT NULL KEY AUTO_INCREMENT COMMENT '管理员ID,主键且自增',
	username VARCHAR(30) NOT NULL UNIQUE COMMENT '用户名,唯一',
	password CHAR(32) NOT NULL COMMENT '用户密码,MD5',
	nick_name VARCHAR(30) NOT NULL COMMENT '用户昵称',
	user_photo VARCHAR(40) NOT NULL COMMENT '用户头像路径',
    created_at INT UNSIGNED NOT NULL COMMENT '用户注册时间',
    updated_at INT UNSIGNED NOT NULL COMMENT '用户更新时间'
) COMMENT '普通用户表';

-- 评论表

CREATE TABLE coding_comment(
    id INT UNSIGNED NOT NULL KEY AUTO_INCREMENT COMMENT '评论ID,主键且自增',
    comment TEXT NOT NULL COMMENT '评论内容',
    user_id MEDIUMINT UNSIGNED NOT NULL COMMENT '外键,用户ID',
    article_id INT UNSIGNED NOT NULL COMMENT '外键,文章ID',
    created_at INT UNSIGNED NOT NULL COMMENT '评论发表时间',
    updated_at INT UNSIGNED NOT NULL COMMENT '评论更新时间'
) COMMENT '评论表';