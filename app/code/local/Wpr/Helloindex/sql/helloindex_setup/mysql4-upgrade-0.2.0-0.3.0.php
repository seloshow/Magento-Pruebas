<?php 
//die('script de instalación ejecutandose 0.2.0-0.3.0');
$installer = $this;

$installer->startSetup();

$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('blogpost')};
CREATE TABLE {$this->getTable('blogpost')} (
  `blog_id` int(10) unsigned NOT NULL auto_increment,
  `blog_title` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`blog_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup();