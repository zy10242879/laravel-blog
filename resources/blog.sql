

#此处建表时还未添加具体索引，需要根据情况对表进行索引创建
CREATE TABLE `blog_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '//用户ID',
  `user_name` varchar(50) DEFAULT '' COMMENT '//用户名',
  `user_pass` varchar(255) DEFAULT '' COMMENT '//密码',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name_pass` (`user_name`,`user_pass`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='//管理员';

CREATE TABLE `blog_category` (
  `cate_id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(50) DEFAULT '' COMMENT '//分类名称',
  `cate_title` varchar(255) DEFAULT '' COMMENT '//分类说明',
  `cate_keywords` varchar(255) DEFAULT '' COMMENT '//关键词',
  `cate_dsecription` varchar(255) DEFAULT '' COMMENT '//描述',
  `cate_view` int(11) DEFAULT '0' COMMENT '//查看次数',
  `cate_order` tinyint(4) DEFAULT '0' COMMENT '//排序',
  `cate_pid` int(11) DEFAULT '0' COMMENT '//父级id',
  PRIMARY KEY (`cate_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='//文章分类';