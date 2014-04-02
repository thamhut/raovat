/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50527
Source Host           : localhost:3306
Source Database       : chotam_raovat

Target Server Type    : MYSQL
Target Server Version : 50527
File Encoding         : 65001

Date: 2014-03-25 22:02:46
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for raovat_catgory
-- ----------------------------
DROP TABLE IF EXISTS `raovat_catgory`;
CREATE TABLE `raovat_catgory` (
  `id` int(11) NOT NULL,
  `id_level` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `name1` varchar(255) NOT NULL,
  PRIMARY KEY (`id_level`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for raovat_content
-- ----------------------------
DROP TABLE IF EXISTS `raovat_content`;
CREATE TABLE `raovat_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `img` text,
  `content` text NOT NULL,
  `id_category` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `id_user` int(11) NOT NULL,
  `city` varchar(255) NOT NULL,
  `view` int(11) DEFAULT NULL,
  `lienlac` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=182 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for raovat_linkurl
-- ----------------------------
DROP TABLE IF EXISTS `raovat_linkurl`;
CREATE TABLE `raovat_linkurl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(225) CHARACTER SET utf8 NOT NULL,
  `date` datetime NOT NULL,
  `source` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `id_category` int(11) NOT NULL,
  `url_chil` varchar(225) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for raovat_user
-- ----------------------------
DROP TABLE IF EXISTS `raovat_user`;
CREATE TABLE `raovat_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) CHARACTER SET utf8 NOT NULL,
  `password` varchar(45) CHARACTER SET utf8 NOT NULL,
  `date` datetime NOT NULL,
  `group` mediumint(9) NOT NULL,
  `email` varchar(45) CHARACTER SET utf8 NOT NULL,
  `number_phone` int(11) DEFAULT NULL,
  `fullname` varchar(225) CHARACTER SET utf8 DEFAULT NULL,
  `passwordlost` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Procedure structure for raovatdb_update_view
-- ----------------------------
DROP PROCEDURE IF EXISTS `raovatdb_update_view`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `raovatdb_update_view`(IN `_id` integer)
BEGIN
	DECLARE _view INT DEFAULT 0;
	SELECT `view` INTO _view FROM chotam_raovat.raovat_content WHERE `id` = _id;
	IF _view != 0 THEN
		UPDATE chotam_raovat.raovat_content SET `view` = `view` + 1 WHERE `id` = _id;
	ELSE 
		UPDATE chotam_raovat.raovat_content SET `view` = 1 WHERE `id` = _id;
	END IF;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for raovat_check_login
-- ----------------------------
DROP PROCEDURE IF EXISTS `raovat_check_login`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `raovat_check_login`(IN _username VARCHAR(255), IN _password VARCHAR(255))
BEGIN
	SELECT * FROM chotam_raovat.raovat_user WHERE `username` = _username AND `password` = _password;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for raovat_check_url_insert
-- ----------------------------
DROP PROCEDURE IF EXISTS `raovat_check_url_insert`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `raovat_check_url_insert`(IN `_url` varchar(255))
BEGIN
	DECLARE checkurl INT DEFAULT 0;
	SELECT COUNT(*) INTO checkurl FROM chotam_raovat.raovat_linkurl WHERE url_chil = _url;
	SELECT checkurl;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for raovat_check_user_code_exit
-- ----------------------------
DROP PROCEDURE IF EXISTS `raovat_check_user_code_exit`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `raovat_check_user_code_exit`(IN `_code` varchar(255), IN `_name` varchar(255))
BEGIN
DECLARE _check INT DEFAULT 0;
	SELECT COUNT(*) INTO _check FROM chotam_raovat.raovat_user WHERE `passwordlost` = _code AND `username` = _name;
	SELECT _check;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for raovat_check_user_email_exit
-- ----------------------------
DROP PROCEDURE IF EXISTS `raovat_check_user_email_exit`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `raovat_check_user_email_exit`(IN `_email` varchar(255), IN `_name` varchar(255))
BEGIN
DECLARE _check INT DEFAULT 0;
	SELECT COUNT(*) INTO _check FROM chotam_raovat.raovat_user WHERE email = _email AND username = _name;
	SELECT _check;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for raovat_check_user_exit
-- ----------------------------
DROP PROCEDURE IF EXISTS `raovat_check_user_exit`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `raovat_check_user_exit`(IN `_email` varchar(255), IN `_name` varchar(255))
BEGIN
DECLARE _check INT DEFAULT 0;
	IF(LENGTH(_email)>0) THEN
		SELECT COUNT(*) INTO _check FROM chotam_raovat.raovat_user WHERE email = _email;
	ELSEIF(LENGTH(_name)>0) THEN
		SELECT COUNT(*) INTO _check FROM chotam_raovat.raovat_user WHERE username = _name;
	END IF;
	SELECT _check;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for raovat_delete_content_byid
-- ----------------------------
DROP PROCEDURE IF EXISTS `raovat_delete_content_byid`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `raovat_delete_content_byid`(IN `_id` integer)
BEGIN
	DELETE FROM chotam_raovat.raovat_content WHERE `id` = _id;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for raovat_delete_content_bymonth
-- ----------------------------
DROP PROCEDURE IF EXISTS `raovat_delete_content_bymonth`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `raovat_delete_content_bymonth`(IN `_date` DATE)
BEGIN
	DELETE FROM chotam_raovat.raovat_content WHERE `date` < _date;
	DELETE FROM chotam_raovat.raovat_linkurl WHERE `date` < _date;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for raovat_getall_category
-- ----------------------------
DROP PROCEDURE IF EXISTS `raovat_getall_category`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `raovat_getall_category`()
BEGIN
	SELECT * FROM chotam_raovat.raovat_catgory;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for raovat_getall_content
-- ----------------------------
DROP PROCEDURE IF EXISTS `raovat_getall_content`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `raovat_getall_content`(IN _start integer, IN _numrow integer)
BEGIN
	SET @sql = CONCAT('SELECT B.title, B.id FROM chotam_raovat.raovat_content B ', '');
	SET @sql = CONCAT(@sql, ' ORDER BY B.`date` DESC'); 
	SET @sql = CONCAT(@sql, ' LIMIT ');
	SET @sql = CONCAT(@sql, _start);
	SET @sql = CONCAT(@sql, ', ');
	SET @sql = CONCAT(@sql, _numrow);
	PREPARE stmt FROM @sql;
	EXECUTE stmt;
	DEALLOCATE PREPARE stmt;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for raovat_getcontent_byid
-- ----------------------------
DROP PROCEDURE IF EXISTS `raovat_getcontent_byid`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `raovat_getcontent_byid`(IN `_id` integer)
BEGIN
	DECLARE _view INT DEFAULT 0;
	SELECT A.id, A.title, A.img, A.date, A.city, A.id_user, A.lienlac, A.content, A.id_category, A.`view`
	FROM chotam_raovat.raovat_content A
	WHERE A.id = _id;

	SELECT `view` INTO _view FROM chotam_raovat.raovat_content WHERE `id` = _id;
	IF _view != 0 THEN
		UPDATE chotam_raovat.raovat_content SET `view` = `view` + 1 WHERE `id` = _id;
	ELSE 
		UPDATE chotam_raovat.raovat_content SET `view` = 1 WHERE `id` = _id;
	END IF;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for raovat_getnews_byuser
-- ----------------------------
DROP PROCEDURE IF EXISTS `raovat_getnews_byuser`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `raovat_getnews_byuser`(IN `_iduser` integer, IN `_start`  integer, IN `_numrow`  integer, IN `_cate` integer, IN `_city` integer, IN `_keyword` varchar(45))
BEGIN
	DECLARE _where VARCHAR(255) DEFAULT 'A.id_user = ';
	SET _where = CONCAT(_where, `_iduser`);
	IF(_cate >-1) THEN 
			SET _where = CONCAT(_where, " AND A.`id_category`=",_cate);
		END IF;
		IF(_city >-1) THEN 
			SET _where = CONCAT(_where, " AND A.`city` = ", _city);
		END IF;
    IF LENGTH(_keyword) > 0 THEN
    	SET _where = CONCAT(_where, " AND (A.`title` LIKE '%", _keyword,"%') ");
    END IF;
    SET @sql = CONCAT('SELECT SQL_CALC_FOUND_ROWS A.id, A.city, A.date, A.id_category, A.title, A.`view` FROM chotam_raovat.raovat_content A WHERE ', _where);
    SET @sql = CONCAT(@sql, ' ORDER BY A.date DESC'); 
    SET @sql = CONCAT(@sql, ' LIMIT ');
    SET @sql = CONCAT(@sql, _start);
    SET @sql = CONCAT(@sql, ', ');
    SET @sql = CONCAT(@sql, _numrow);
        
    PREPARE stmt FROM @sql;
		EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
    SELECT FOUND_ROWS() AS num;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for raovat_get_category_byidlevel
-- ----------------------------
DROP PROCEDURE IF EXISTS `raovat_get_category_byidlevel`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `raovat_get_category_byidlevel`(IN `_id` integer, IN `_start`  integer, IN `_numrow`  integer, IN `_city` integer)
BEGIN
	DECLARE idlevel INT DEFAULT -1;
	DECLARE numitem INT DEFAULT 0;
	DECLARE _name1 VARCHAR(45) DEFAULT '';
	DECLARE _name2 VARCHAR(45) DEFAULT '';
	DECLARE _where VARCHAR(255) DEFAULT '';
	
	SELECT A.id INTO idlevel FROM chotam_raovat.raovat_catgory A WHERE A.id_level = _id;
	IF idlevel = 0 THEN
		SELECT A.* FROM chotam_raovat.raovat_catgory A WHERE A.id = _id;
		SET _where = CONCAT(_where, " A.id=",_id);
		IF _city > 0 THEN
			SET _where = CONCAT(_where, " AND B.city=",_city);
			SET @sql = CONCAT('SELECT SQL_CALC_FOUND_ROWS B.title, B.id, B.date, B.city, B.`view`, B.img
			FROM chotam_raovat.raovat_content B INNER JOIN chotam_raovat.raovat_catgory A ON A.id_level=B.id_category WHERE ', _where);
			SET @sql = CONCAT(@sql, ' ORDER BY B.`date` DESC'); 
			SET @sql = CONCAT(@sql, ' LIMIT ');
			SET @sql = CONCAT(@sql, _start);
			SET @sql = CONCAT(@sql, ', ');
			SET @sql = CONCAT(@sql, _numrow);
			PREPARE stmt FROM @sql;
			EXECUTE stmt;
			DEALLOCATE PREPARE stmt;
			/*SELECT SQL_CALC_FOUND_ROWS B.title, B.id, B.date, B.city, B.`view`, B.img
			FROM chotam_raovat.raovat_content B INNER JOIN chotam_raovat.raovat_catgory A ON A.id_level=B.id_category
			WHERE A.id = _id AND B.city=_city ORDER BY B.`date` DESC LIMIT _start, _numrow;*/

			SELECT COUNT(*) INTO numitem FROM chotam_raovat.raovat_content B INNER JOIN chotam_raovat.raovat_catgory A ON A.id_level=B.id_category
			WHERE A.id = _id AND B.city=_city;

		ELSE
			SET @sql = CONCAT('SELECT B.title, B.id, B.date, B.city, B.`view`, B.img 
			FROM chotam_raovat.raovat_content B INNER JOIN chotam_raovat.raovat_catgory A ON A.id_level=B.id_category WHERE ', _where);
			SET @sql = CONCAT(@sql, ' ORDER BY B.`date` DESC'); 
			SET @sql = CONCAT(@sql, ' LIMIT ');
			SET @sql = CONCAT(@sql, _start);
			SET @sql = CONCAT(@sql, ', ');
			SET @sql = CONCAT(@sql, _numrow);
			PREPARE stmt FROM @sql;
			EXECUTE stmt;
			DEALLOCATE PREPARE stmt;/*
			SELECT B.title, B.id, B.date, B.city, B.`view`, B.img 
			FROM chotam_raovat.raovat_content B INNER JOIN chotam_raovat.raovat_catgory A ON A.id_level=B.id_category
			WHERE A.id = _id ORDER BY B.`date` DESC LIMIT _start, _numrow;*/

			SELECT COUNT(*) INTO numitem FROM chotam_raovat.raovat_content B INNER JOIN chotam_raovat.raovat_catgory A ON A.id_level=B.id_category
			WHERE A.id = _id;
		END IF;
		SELECT A.`name` INTO _name1 FROM chotam_raovat.raovat_catgory A WHERE A.id_level = _id;

	ELSEIF idlevel > 0 THEN
		SELECT A.* FROM chotam_raovat.raovat_catgory A WHERE A.id = idlevel;

		SET _where = CONCAT(_where, " B.id_category =",_id);
		IF _city > 0 THEN
			SET _where = CONCAT(_where, " AND B.city=",_city);
			SET @sql = CONCAT('SELECT B.title, B.id, B.date, B.city, B.`view` , B.img
			FROM chotam_raovat.raovat_content B WHERE ', _where);
			SET @sql = CONCAT(@sql, ' ORDER BY B.`date` DESC'); 
			SET @sql = CONCAT(@sql, ' LIMIT ');
			SET @sql = CONCAT(@sql, _start);
			SET @sql = CONCAT(@sql, ', ');
			SET @sql = CONCAT(@sql, _numrow);
			PREPARE stmt FROM @sql;
			EXECUTE stmt;
			DEALLOCATE PREPARE stmt;
			/*SELECT B.title, B.id, B.date, B.city, B.`view` , B.img
			FROM chotam_raovat.raovat_content B
			WHERE B.id_category = _id AND B.city=_city ORDER BY B.`date` DESC LIMIT _start, _numrow;
*/
			SELECT COUNT(*) INTO numitem FROM chotam_raovat.raovat_content B
			WHERE B.id_category = _id AND B.city=_city;
		ELSE
			SET @sql = CONCAT('SELECT B.title, B.id, B.date, B.city, B.`view` , B.img
			FROM chotam_raovat.raovat_content B WHERE ', _where);
			SET @sql = CONCAT(@sql, ' ORDER BY B.`date` DESC'); 
			SET @sql = CONCAT(@sql, ' LIMIT ');
			SET @sql = CONCAT(@sql, _start);
			SET @sql = CONCAT(@sql, ', ');
			SET @sql = CONCAT(@sql, _numrow);
			PREPARE stmt FROM @sql;
			EXECUTE stmt;
			DEALLOCATE PREPARE stmt;
			/*SELECT B.title, B.id, B.date, B.city, B.`view` , B.img
			FROM chotam_raovat.raovat_content B
			WHERE B.id_category = _id ORDER BY B.`date` DESC LIMIT _start, _numrow;
*/
			SELECT COUNT(*) INTO numitem FROM chotam_raovat.raovat_content B
			WHERE B.id_category = _id;
		END IF;
		SELECT A.`name` INTO _name1 FROM chotam_raovat.raovat_catgory A WHERE A.id_level = idlevel;
		SELECT A.`name` INTO _name2 FROM chotam_raovat.raovat_catgory A WHERE A.id_level = _id;
	END IF;
	SELECT CONVERT(_name1 USING utf8) as _name1;
	SELECT CONVERT(_name2 USING utf8) as _name2;
	SELECT numitem;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for raovat_get_info_news
-- ----------------------------
DROP PROCEDURE IF EXISTS `raovat_get_info_news`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `raovat_get_info_news`(IN `_id` integer)
BEGIN
	SELECT A.* FROM chotam_raovat.raovat_content A WHERE id = _id;

	SELECT B.`name` AS cate2, C.`name` AS cate1 FROM chotam_raovat.raovat_catgory B 
	INNER JOIN chotam_raovat.raovat_catgory C ON B.id = C.id_level 
	INNER JOIN chotam_raovat.raovat_content D ON D.id_category = B.id_level
	WHERE D.id = _id;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for raovat_get_info_user
-- ----------------------------
DROP PROCEDURE IF EXISTS `raovat_get_info_user`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `raovat_get_info_user`(IN `_id` integer)
BEGIN
	SELECT * FROM chotam_raovat.raovat_user WHERE id = _id;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for raovat_insert_content
-- ----------------------------
DROP PROCEDURE IF EXISTS `raovat_insert_content`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `raovat_insert_content`(IN `_title` text, IN `_img` text,  IN `_content` text, IN `_iduser` integer, IN `_id_category` integer, IN `_date` varchar(45), IN `_address` varchar(255), IN `_lienlac` varchar(45))
BEGIN
		INSERT INTO chotam_raovat.raovat_content(`title`,`img`,`content`,`id_category`, `date`,`id_user`,`city`,`lienlac`) VALUES(_title, _img, _content, _id_category,_date,_iduser,_address, _lienlac);
		SELECT LAST_INSERT_ID() as idinsert;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for raovat_insert_url
-- ----------------------------
DROP PROCEDURE IF EXISTS `raovat_insert_url`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `raovat_insert_url`(IN `_url`  varchar(225), IN `_url_chil`  varchar(225),  IN `_date`  varchar(45),  IN `_source`  varchar(45) , IN `_cate`  varchar(225),  IN `_content` text, IN `_iduser` integer, IN `_title` text, IN `_img` text,   IN `_address` varchar(255), IN `_lienlac` text)
BEGIN
	DECLARE checkidcate INT DEFAULT 0;
	DECLARE checkurlexit INT DEFAULT 0;

	SELECT A.id_level INTO checkidcate FROM chotam_raovat.raovat_catgory A WHERE A.`name1` = _cate;
	IF checkidcate>0 THEN
		SELECT COUNT(*) INTO checkurlexit FROM chotam_raovat.raovat_linkurl B WHERE B.`url_chil` = _url_chil;
		IF checkurlexit=0 THEN
			INSERT INTO chotam_raovat.raovat_linkurl(`url`,`date`,`source`,`id_category`,`url_chil`) VALUES(_url, _date, _source, checkidcate, _url_chil);
			INSERT INTO chotam_raovat.raovat_content(`title`,`img`, `content`,`id_category`, `date`,`id_user`,`city`,`lienlac`) VALUES(_title, _img, _content, checkidcate,_date,_iduser,_address, _lienlac);
	
		END IF;
	END IF;
SELECT checkidcate;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for raovat_register_account
-- ----------------------------
DROP PROCEDURE IF EXISTS `raovat_register_account`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `raovat_register_account`(IN _username varchar(255), IN _password varchar(255) , IN _email varchar(255) , IN _date Date, IN _group MEDIUMINT)
BEGIN
	INSERT INTO chotam_raovat.raovat_user(`username`, `password`, `date`, `group`, `email`) 
	VALUES(_username, _password , _date, _group, _email);
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for raovat_update_content
-- ----------------------------
DROP PROCEDURE IF EXISTS `raovat_update_content`;
DELIMITER ;;
CREATE DEFINER=`chotam`@`localhost` PROCEDURE `raovat_update_content`(IN `_id` integer, IN `_title` text, IN `_img` text,  IN `_content` text, IN `_iduser` integer, IN `_id_category` integer, IN `_date` varchar(45), IN `_address` varchar(255), IN `_lienlac` varchar(45))
BEGIN
	DECLARE _idcontent INT DEFAULT 0;
	SELECT COUNT(*) INTO _idcontent FROM chotam_raovat.raovat_content A WHERE A.id = _id;
	IF _idcontent = 0 THEN
		INSERT INTO chotam_raovat.raovat_content(`title`,`img`,`content`,`id_category`, `date`,`id_user`,`city`,`lienlac`) VALUES(CONVERT(_title USING utf8), _img, CONVERT(_content USING utf8), _id_category,_date,_iduser,_address, _lienlac);
	ELSE
		UPDATE chotam_raovat.raovat_content 
		SET `title` = CONVERT(_title USING utf8), `img` = _img, `content` = CONVERT(_content USING utf8), `id_category` = _id_category, `date` = _date,`id_user` = _iduser,`city` = _address,`lienlac` = _lienlac
		WHERE `id` = _id;
	END IF;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for raovat_update_info
-- ----------------------------
DROP PROCEDURE IF EXISTS `raovat_update_info`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `raovat_update_info`(IN `_username` varchar(255),IN `_email` varchar(255), IN _id integer)
BEGIN
	UPDATE chotam_raovat.raovat_user SET `username`=_username, `email`=_email WHERE id = _id;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for raovat_update_lostpass
-- ----------------------------
DROP PROCEDURE IF EXISTS `raovat_update_lostpass`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `raovat_update_lostpass`(IN `_name` varchar(255), IN `_pass` varchar(255))
BEGIN
	UPDATE chotam_raovat.raovat_user SET `passwordlost`=_pass WHERE `username` = _name;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for raovat_update_pass
-- ----------------------------
DROP PROCEDURE IF EXISTS `raovat_update_pass`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `raovat_update_pass`(IN `_pass` varchar(255), IN _id integer)
BEGIN
	UPDATE chotam_raovat.raovat_user SET `password`=_pass WHERE id = _id;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for raovat_update_pass_by_namecode
-- ----------------------------
DROP PROCEDURE IF EXISTS `raovat_update_pass_by_namecode`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `raovat_update_pass_by_namecode`(IN `_name` varchar(255), IN `_pass` varchar(255))
BEGIN
	UPDATE chotam_raovat.raovat_user SET `password`=_pass, `passwordlost`='' WHERE `username` = _name;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for update_cate
-- ----------------------------
DROP PROCEDURE IF EXISTS `update_cate`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_cate`(IN `_name` varchar(45), IN `_id` integer, IN `_name1` varchar(45))
BEGIN
	UPDATE chotam_raovat.raovat_catgory SET `name`=_name, `name1`=_name1 WHERE id_level=_id;
	#INSERT INTO chotam_raovat.raovat_catgory_copy(`id`,`name`,`name1`) VALUES(_id, _name, _name1);
END
;;
DELIMITER ;
