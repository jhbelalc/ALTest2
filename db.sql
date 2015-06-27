CREATE TABLE `hosts` (
  host_id int(8) unsigned NOT NULL auto_increment,
  ip_address varchar(39) NOT NULL default '',
  host_name varchar(128) NOT NULL default '',
  create_date bigint(20) unsigned NOT NULL default '0',
  description varchar(255) default NULL,
  active tinyint(1) unsigned NOT NULL default '1',
  deleted tinyint(1) unsigned NOT NULL default '0',
  last_seen_date bigint(20) unsigned NOT NULL default '0',
  credential_id int(8) unsigned default '0',
  PRIMARY KEY  (host_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `credentials` (
  credential_id int(8) unsigned NOT NULL auto_increment,
  username varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  PRIMARY KEY  (credential_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `hosts` VALUES (1, '192.168.1.1', 'test-one', unix_timestamp(now()), 'Testing Host One', 1, 0, unix_timestamp(now()), 1);
INSERT INTO `hosts` VALUES (2, '192.168.1.2', 'test-two', unix_timestamp(now()), 'Testing Host Two', 1, 0, unix_timestamp(now()), 2);
INSERT INTO `hosts` VALUES (3, '192.168.1.3', 'test-three', unix_timestamp(now()), 'Testing Host Three', 1, 0, unix_timestamp(now()), 0);
INSERT INTO `hosts` VALUES (4, '192.168.1.4', 'test-four', unix_timestamp(now()), 'Testing Host Four', 1, 0, unix_timestamp(now()), 3);

INSERT INTO `credentials` VALUES (1, 'testuser1', 'password');
INSERT INTO `credentials` VALUES (2, 'testuser2', 'password');
INSERT INTO `credentials` VALUES (3, 'testuser3', 'password');