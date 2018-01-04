CREATE TABLE `xliaise_forms` (
  `form_id`            SMALLINT(5)  NOT NULL AUTO_INCREMENT,
  `form_send_method`   CHAR(1)      NOT NULL DEFAULT 'e',
  `form_send_to_group` SMALLINT(3)  NOT NULL DEFAULT '0',
  `form_order`         SMALLINT(3)  NOT NULL DEFAULT '0',
  `form_delimiter`     CHAR(1)      NOT NULL DEFAULT 's',
  `form_title`         VARCHAR(255) NOT NULL DEFAULT '',
  `form_submit_text`   VARCHAR(50)  NOT NULL DEFAULT '',
  `form_desc`          TEXT         NOT NULL,
  `form_intro`         TEXT         NOT NULL,
  `form_whereto`       VARCHAR(255) NOT NULL DEFAULT '{SITE_URL}/modules/liaise',
  PRIMARY KEY (`form_id`),
  KEY `form_order` (`form_order`)
);

INSERT INTO `xliaise_forms` VALUES (1, 'e', 0, 1, 'b', 'Send feedback', 'Submit', 'Tell us about your comments for this site.', 'Contact us by filling out this form.', '{SITE_URL}/modules/liaise');

CREATE TABLE `xliaise_formelements` (
  `ele_id`      SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `form_id`     SMALLINT(5)          NOT NULL DEFAULT '0',
  `ele_type`    VARCHAR(10)          NOT NULL DEFAULT '',
  `ele_caption` VARCHAR(255)         NOT NULL DEFAULT '',
  `ele_order`   SMALLINT(2)          NOT NULL DEFAULT '0',
  `ele_req`     TINYINT(1)           NOT NULL DEFAULT '1',
  `ele_value`   TEXT                 NOT NULL,
  `ele_display` TINYINT(1)           NOT NULL DEFAULT '1',
  PRIMARY KEY (`ele_id`),
  KEY `ele_display` (`ele_display`),
  KEY `ele_order` (`ele_order`)
);

INSERT INTO `xliaise_formelements` VALUES (1, 1, 'checkbox', 'What are your hobbies?', 11, 1,
                                           'a:7:{s:13:"I\'m a dreary.";i:1;s:35:"Searching adult contents on the net";i:0;s:66:"Arguing with people about those stupid things on discussion boards";i:0;s:33:"Searching software serial numbers";i:0;s:6:"Speech";i:0;s:34:"Making weapons of mass destruction";i:0;s:10:"{OTHER|30}";i:0;}',
                                           1);
INSERT INTO `xliaise_formelements` VALUES (2, 1, 'text', 'Your name', 0, 1, 'a:3:{i:0;i:30;i:1;i:255;i:2;s:7:"{UNAME}";}', 1);
INSERT INTO `xliaise_formelements` VALUES (3, 1, 'text', 'Email', 1, 1, 'a:3:{i:0;i:30;i:1;i:255;i:2;s:7:"{EMAIL}";}', 1);
INSERT INTO `xliaise_formelements` VALUES (4, 1, 'text', 'Website', 3, 0, 'a:3:{i:0;i:30;i:1;i:255;i:2;s:7:"http://";}', 1);
INSERT INTO `xliaise_formelements` VALUES (5, 1, 'text', 'Company', 4, 0, 'a:3:{i:0;i:30;i:1;i:255;i:2;s:0:"";}', 1);
INSERT INTO `xliaise_formelements` VALUES (6, 1, 'text', 'Location', 5, 0, 'a:3:{i:0;i:30;i:1;i:255;i:2;s:0:"";}', 1);
INSERT INTO `xliaise_formelements` VALUES (7, 1, 'textarea', 'Comments', 6, 1, 'a:3:{i:0;s:0:"";i:1;i:5;i:2;i:35;}', 1);
INSERT INTO `xliaise_formelements` VALUES (8, 1, 'select', 'How are you today?', 7, 0, 'a:3:{i:0;i:1;i:1;i:0;i:2;a:6:{s:6:"Great!";i:0;s:9:"I\'m fine.";i:1;s:6:"So so.";i:0;s:8:"No good.";i:0;s:9:"I\'m sick.";i:0;s:5:"What?";i:0;}}', 1);
INSERT INTO `xliaise_formelements` VALUES (9, 1, 'text', 'Your credit card number', 14, 0, 'a:3:{i:0;i:30;i:1;i:255;i:2;s:15:"Are you crazy!?";}', 1);
INSERT INTO `xliaise_formelements` VALUES (10, 1, 'radio', 'How old are you?', 9, 0, 'a:8:{s:3:"0-9";i:0;s:5:"10-19";i:0;s:5:"20-29";i:0;s:5:"30-39";i:0;s:5:"40-49";i:0;s:5:"50-59";i:0;s:3:"60+";i:0;s:27:"It\'s none of your business.";i:1;}', 1);
INSERT INTO `xliaise_formelements` VALUES (11, 1, 'checkbox', 'foo', 13, 0, 'a:1:{s:3:"bar";i:0;}', 0);
INSERT INTO `xliaise_formelements` VALUES (12, 1, 'select', 'Why did you buy a computer?', 8, 1,
                                           'a:3:{i:0;i:10;i:1;i:1;i:2;a:6:{s:25:"My room is too big for me";i:1;s:25:"I don\'t have a girlfriend";i:0;s:18:"My wife is a biddy";i:0;s:17:"I like spam mails";i:0;s:29:"That makes me look more smart";i:0;s:13:"I just forgot";i:0;}}',
                                           1);
INSERT INTO `xliaise_formelements` VALUES (13, 1, 'radio', 'Gender', 2, 0, 'a:3:{s:4:"Male";i:0;s:6:"Female";i:0;s:15:"I won\'t tell ya";i:1;}', 1);
INSERT INTO `xliaise_formelements` VALUES (14, 1, 'yn', 'Do you believe your government?', 12, 0, 'a:2:{s:4:"_YES";i:1;s:3:"_NO";i:0;}', 1);
INSERT INTO `xliaise_formelements` VALUES (15, 1, 'html', '', 10, 0,
                                           'a:3:{i:0;s:316:"I have no idea what should be placed here. Maybe a chapter from the holy bible? [url=http://www.randomwebsearch.com/cgi-bin/randomWebSearch.pl?mode=generate]Click here[/url] if you have too much time to waste, or [url=http://www.landoverbaptist.org/news0104/ps2.html]get a free PlayStation 2[/url] if you are boring.";i:1;i:10;i:2;i:50;}',
                                           1);

CREATE TABLE `xliaise_forms_archive` (
  `id`           INT(11)                      NOT NULL AUTO_INCREMENT,
  `form_id`      INT(11)                      NOT NULL,
  `form_date`    INT(11)                      NOT NULL,
  `form_message` TEXT COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
);
