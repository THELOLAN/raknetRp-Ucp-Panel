<?php

$TABLE[] = "CREATE TABLE IF NOT EXISTS ep_blocks (
	block_id int(11) NOT NULL AUTO_INCREMENT,
	block_title varchar(255),
	block_key varchar(255),
	block_content mediumtext,
	block_created int(11),
	block_updated int(11),
	block_use_php tinyint(1) DEFAULT '0',
	block_use_bbcode tinyint(1) DEFAULT '1',
	PRIMARY KEY (block_id),
	UNIQUE KEY block_key (block_key)
);";

$TABLE[] = "CREATE TABLE IF NOT EXISTS ep_pages (
	page_id int(11) NOT NULL AUTO_INCREMENT,
	page_title varchar(255),
	page_key varchar(255),
	page_content mediumtext,
	page_content_cache longtext,
	page_meta_key text,
	page_meta_desc text,
	page_group_access mediumtext,
	page_use_wrapper tinyint(1) NOT NULL DEFAULT '1',
	page_use_php tinyint(1) DEFAULT '0',
	page_use_bbcode tinyint(1) DEFAULT '1',
	page_use_cache tinyint(1) DEFAULT '1',
	page_created int(11),
	page_updated int(11),
	page_cached int(11) DEFAULT '0',
	PRIMARY KEY (page_id),
	UNIQUE KEY page_key (page_key)
);";
