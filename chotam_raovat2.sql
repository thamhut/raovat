-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 30, 2014 at 03:18 PM
-- Server version: 5.1.73-cll
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `chotam_raovat`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`chotam`@`localhost` PROCEDURE `raovatdb_update_view`(IN `_id` integer)
BEGIN
	DECLARE _view INT DEFAULT 0;
	SELECT `view` INTO _view FROM chotam_raovat.raovat_content WHERE `id` = _id;
	IF _view != 0 THEN
		UPDATE chotam_raovat.raovat_content SET `view` = `view` + 1 WHERE `id` = _id;
	ELSE 
		UPDATE chotam_raovat.raovat_content SET `view` = 1 WHERE `id` = _id;
	END IF;
END$$

CREATE DEFINER=`chotam`@`localhost` PROCEDURE `raovat_check_login`(IN _username VARCHAR(255), IN _password VARCHAR(255))
BEGIN
	SELECT * FROM chotam_raovat.raovat_user WHERE `username` = _username AND `password` = _password;
END$$

CREATE DEFINER=`chotam`@`localhost` PROCEDURE `raovat_check_url_insert`(IN `_url` varchar(255))
BEGIN
	DECLARE checkurl INT DEFAULT 0;
	SELECT COUNT(*) INTO checkurl FROM chotam_raovat.raovat_linkurl WHERE url_chil = _url;
	SELECT checkurl;
END$$

CREATE DEFINER=`chotam`@`localhost` PROCEDURE `raovat_check_user_code_exit`(IN `_code` varchar(255), IN `_name` varchar(255))
BEGIN
DECLARE _check INT DEFAULT 0;
	SELECT COUNT(*) INTO _check FROM chotam_raovat.raovat_user WHERE `passwordlost` = _code AND `username` = _name;
	SELECT _check;
END$$

CREATE DEFINER=`chotam`@`localhost` PROCEDURE `raovat_check_user_email_exit`(IN `_email` varchar(255), IN `_name` varchar(255))
BEGIN
DECLARE _check INT DEFAULT 0;
	SELECT COUNT(*) INTO _check FROM chotam_raovat.raovat_user WHERE email = _email AND username = _name;
	SELECT _check;
END$$

CREATE DEFINER=`chotam`@`localhost` PROCEDURE `raovat_check_user_exit`(IN `_email` varchar(255), IN `_name` varchar(255))
BEGIN
DECLARE _check INT DEFAULT 0;
	IF(LENGTH(_email)>0) THEN
		SELECT COUNT(*) INTO _check FROM chotam_raovat.raovat_user WHERE email = _email;
	ELSEIF(LENGTH(_name)>0) THEN
		SELECT COUNT(*) INTO _check FROM chotam_raovat.raovat_user WHERE username = _name;
	END IF;
	SELECT _check;
END$$

CREATE DEFINER=`chotam`@`localhost` PROCEDURE `raovat_delete_content_byid`(IN `_id` integer)
BEGIN
	DELETE FROM chotam_raovat.raovat_content WHERE `id` = _id;

END$$

CREATE DEFINER=`chotam`@`localhost` PROCEDURE `raovat_delete_content_bymonth`(IN `_date` DATE)
BEGIN
	DELETE FROM chotam_raovat.raovat_content WHERE `date` < _date;
	DELETE FROM chotam_raovat.raovat_linkurl WHERE `date` < _date;
END$$

CREATE DEFINER=`chotam`@`localhost` PROCEDURE `raovat_getall_category`()
BEGIN
	SELECT * FROM chotam_raovat.raovat_catgory;
END$$

CREATE DEFINER=`chotam`@`localhost` PROCEDURE `raovat_getall_content`(IN _start integer, IN _numrow integer)
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
END$$

CREATE DEFINER=`chotam`@`localhost` PROCEDURE `raovat_getcontent_byid`(IN `_id` integer)
BEGIN
	DECLARE _view INT DEFAULT 0;
	SELECT CONVERT(A.title USING utf8) AS title, A.img, A.date, A.city, A.id_user, A.lienlac, CONVERT(A.content USING utf8) AS content, A.id_category, A.`view`, A.id
	FROM chotam_raovat.raovat_content A
	WHERE A.id = _id;

	SELECT `view` INTO _view FROM chotam_raovat.raovat_content WHERE `id` = _id;
	IF _view != 0 THEN
		UPDATE chotam_raovat.raovat_content SET `view` = `view` + 1 WHERE `id` = _id;
	ELSE 
		UPDATE chotam_raovat.raovat_content SET `view` = 1 WHERE `id` = _id;
	END IF;
END$$

CREATE DEFINER=`chotam`@`localhost` PROCEDURE `raovat_getnews_byuser`(IN `_iduser` integer, IN `_start`  integer, IN `_numrow`  integer, IN `_cate` integer, IN `_city` integer, IN `_keyword` varchar(45))
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
END$$

CREATE DEFINER=`chotam`@`localhost` PROCEDURE `raovat_get_category_byidlevel`(IN `_id` integer, IN `_start`  integer, IN `_numrow`  integer, IN `_city` integer)
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
END$$

CREATE DEFINER=`chotam`@`localhost` PROCEDURE `raovat_get_info_news`(IN `_id` integer)
BEGIN
	SELECT A.* FROM chotam_raovat.raovat_content A WHERE id = _id;

	SELECT B.`name` AS cate2, C.`name` AS cate1 FROM chotam_raovat.raovat_catgory B 
	INNER JOIN chotam_raovat.raovat_catgory C ON B.id = C.id_level 
	INNER JOIN chotam_raovat.raovat_content D ON D.id_category = B.id_level
	WHERE D.id = _id;
END$$

CREATE DEFINER=`chotam`@`localhost` PROCEDURE `raovat_get_info_user`(IN `_id` integer)
BEGIN
	SELECT * FROM chotam_raovat.raovat_user WHERE id = _id;
END$$

CREATE DEFINER=`chotam`@`localhost` PROCEDURE `raovat_insert_content`(IN `_title` text, IN `_img` text,  IN `_content` text, IN `_iduser` integer, IN `_id_category` integer, IN `_date` varchar(45), IN `_address` varchar(255), IN `_lienlac` varchar(45))
BEGIN
		INSERT INTO chotam_raovat.raovat_content(`title`,`img`,`content`,`id_category`, `date`,`id_user`,`city`,`lienlac`) VALUES(CONVERT(_title USING utf8), _img, CONVERT(_content USING utf8), _id_category,_date,_iduser,_address, _lienlac);
		SELECT LAST_INSERT_ID() as idinsert;
	
END$$

CREATE DEFINER=`chotam`@`localhost` PROCEDURE `raovat_insert_url`(IN `_url`  varchar(225), IN `_url_chil`  varchar(225),  IN `_date`  varchar(45),  IN `_source`  varchar(45) , IN `_cate`  varchar(225),  IN `_content` text, IN `_iduser` integer, IN `_title` text, IN `_img` text,   IN `_address` varchar(255), IN `_lienlac` text)
BEGIN
	DECLARE checkidcate INT DEFAULT 0;
	DECLARE checkurlexit INT DEFAULT 0;

	SELECT A.id_level INTO checkidcate FROM chotam_raovat.raovat_catgory A WHERE A.`name1` = _cate;
	IF checkidcate>0 THEN
		SELECT COUNT(*) INTO checkurlexit FROM chotam_raovat.raovat_linkurl B WHERE B.`url_chil` = _url_chil;
		IF checkurlexit=0 THEN
			INSERT INTO chotam_raovat.raovat_linkurl(`url`,`date`,`source`,`id_category`,`url_chil`) VALUES(_url, _date, _source, checkidcate, _url_chil);
			INSERT INTO chotam_raovat.raovat_content(`title`,`img`, `content`,`id_category`, `date`,`id_user`,`city`,`lienlac`) VALUES(CONVERT(_title USING utf8), _img, CONVERT(_content USING utf8), checkidcate,_date,_iduser,_address, _lienlac);
	
		END IF;
	END IF;
SELECT checkidcate;
END$$

CREATE DEFINER=`chotam`@`localhost` PROCEDURE `raovat_register_account`(IN _username varchar(255), IN _password varchar(255) , IN _email varchar(255) , IN _date Date, IN _group MEDIUMINT)
BEGIN
	INSERT INTO chotam_raovat.raovat_user(`username`, `password`, `date`, `group`, `email`) 
	VALUES(_username, _password , _date, _group, _email);
END$$

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
END$$

CREATE DEFINER=`chotam`@`localhost` PROCEDURE `raovat_update_info`(IN `_username` varchar(255),IN `_email` varchar(255), IN _id integer)
BEGIN
	UPDATE chotam_raovat.raovat_user SET `username`=_username, `email`=_email WHERE id = _id;

END$$

CREATE DEFINER=`chotam`@`localhost` PROCEDURE `raovat_update_lostpass`(IN `_name` varchar(255), IN `_pass` varchar(255))
BEGIN
	UPDATE chotam_raovat.raovat_user SET `passwordlost`=_pass WHERE `username` = _name;
END$$

CREATE DEFINER=`chotam`@`localhost` PROCEDURE `raovat_update_pass`(IN `_pass` varchar(255), IN _id integer)
BEGIN
	UPDATE chotam_raovat.raovat_user SET `password`=_pass WHERE id = _id;

END$$

CREATE DEFINER=`chotam`@`localhost` PROCEDURE `raovat_update_pass_by_namecode`(IN `_name` varchar(255), IN `_pass` varchar(255))
BEGIN
	UPDATE chotam_raovat.raovat_user SET `password`=_pass, `passwordlost`='' WHERE `username` = _name;
END$$

CREATE DEFINER=`chotam`@`localhost` PROCEDURE `update_cate`(IN `_name` varchar(45), IN `_id` integer, IN `_name1` varchar(45))
BEGIN
	UPDATE chotam_raovat.raovat_catgory SET `name`=_name, `name1`=_name1 WHERE id_level=_id;
	#INSERT INTO chotam_raovat.raovat_catgory_copy(`id`,`name`,`name1`) VALUES(_id, _name, _name1);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `raovat_catgory`
--

CREATE TABLE IF NOT EXISTS `raovat_catgory` (
  `id` int(11) NOT NULL,
  `id_level` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `name1` varchar(255) NOT NULL,
  PRIMARY KEY (`id_level`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=98 ;

-- --------------------------------------------------------

--
-- Table structure for table `raovat_content`
--

CREATE TABLE IF NOT EXISTS `raovat_content` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15230 ;

-- --------------------------------------------------------

--
-- Table structure for table `raovat_linkurl`
--

CREATE TABLE IF NOT EXISTS `raovat_linkurl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(225) CHARACTER SET utf8 NOT NULL,
  `date` datetime NOT NULL,
  `source` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `id_category` int(11) NOT NULL,
  `url_chil` varchar(225) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15980 ;

-- --------------------------------------------------------

--
-- Table structure for table `raovat_user`
--

CREATE TABLE IF NOT EXISTS `raovat_user` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
