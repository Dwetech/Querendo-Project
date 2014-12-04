-- --------------------------------------------------------
-- Host:                         192.168.2.104
-- Server version:               5.5.38-0ubuntu0.14.04.1 - (Ubuntu)
-- Server OS:                    debian-linux-gnu
-- HeidiSQL Version:             8.3.0.4796
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table querendo.admin_balance
DROP TABLE IF EXISTS `admin_balance`;
CREATE TABLE IF NOT EXISTS `admin_balance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `milestone_id` int(11) DEFAULT NULL,
  `fee_taken_from` int(11) DEFAULT NULL,
  `fee_percent` int(11) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table querendo.admin_balance: ~0 rows (approximately)
DELETE FROM `admin_balance`;
/*!40000 ALTER TABLE `admin_balance` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_balance` ENABLE KEYS */;


-- Dumping structure for table querendo.admin_user
DROP TABLE IF EXISTS `admin_user`;
CREATE TABLE IF NOT EXISTS `admin_user` (
  `user_id` int(100) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table querendo.admin_user: ~1 rows (approximately)
DELETE FROM `admin_user`;
/*!40000 ALTER TABLE `admin_user` DISABLE KEYS */;
INSERT INTO `admin_user` (`user_id`, `email`, `password`) VALUES
	(1, 'admin@admin.com', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e');
/*!40000 ALTER TABLE `admin_user` ENABLE KEYS */;


-- Dumping structure for table querendo.balance
DROP TABLE IF EXISTS `balance`;
CREATE TABLE IF NOT EXISTS `balance` (
  `balance_id` int(100) NOT NULL AUTO_INCREMENT,
  `user_id` int(100) NOT NULL,
  `amount` varchar(50) NOT NULL,
  `currentBalance` varchar(50) NOT NULL,
  `type` enum('credit','debit') NOT NULL,
  `description` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`balance_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table querendo.balance: ~1 rows (approximately)
DELETE FROM `balance`;
/*!40000 ALTER TABLE `balance` DISABLE KEYS */;
INSERT INTO `balance` (`balance_id`, `user_id`, `amount`, `currentBalance`, `type`, `description`, `created`) VALUES
	(1, 1, '5000', '5000', 'credit', 'Initial Manual Balance', '2014-07-17 16:39:18');
/*!40000 ALTER TABLE `balance` ENABLE KEYS */;


-- Dumping structure for table querendo.bids
DROP TABLE IF EXISTS `bids`;
CREATE TABLE IF NOT EXISTS `bids` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `bid_amount` float DEFAULT NULL,
  `delivery_time` int(11) DEFAULT NULL,
  `milestone_request` float DEFAULT NULL,
  `product_image` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `proposal_text` text,
  `status` enum('Awarded','Regular','Waiting','Completed') CHARACTER SET latin1 DEFAULT NULL,
  `product_condition` enum('New','Used','Any') CHARACTER SET latin1 DEFAULT NULL,
  `create_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- Dumping data for table querendo.bids: ~10 rows (approximately)
DELETE FROM `bids`;
/*!40000 ALTER TABLE `bids` DISABLE KEYS */;
INSERT INTO `bids` (`id`, `product_id`, `user_id`, `bid_amount`, `delivery_time`, `milestone_request`, `product_image`, `proposal_text`, `status`, `product_condition`, `create_date`) VALUES
	(1, 1, 4, 10, 2, NULL, NULL, 'test\n', 'Regular', 'New', '2014-08-07 18:29:44'),
	(2, 13, 6, 50, 1, NULL, 'tbkX0kpu.jpg', 'Nothing', 'Awarded', 'New', '2014-08-07 18:37:10'),
	(5, 16, 3, 130, 1, NULL, 'OB8e47PX.jpg', 'asdf asdf.', 'Completed', 'New', '2014-08-07 19:23:24'),
	(6, 16, 1, 112, 1, NULL, 'KiGG52Qe.jpg', 'You will get paid : $104.5 USD', 'Regular', 'New', '2014-08-09 15:30:41'),
	(7, 17, 3, 112, 2, NULL, 'T95c0KUA.jpg', 'This is what i do', 'Completed', 'New', '2014-08-09 15:46:45'),
	(8, 17, 1, 110, 3, NULL, 'llsx96Fy.jpg', 'You will get paid : $95 USD', 'Regular', 'New', '2014-08-09 15:48:07'),
	(9, 18, 1, 1088, 4, NULL, '70W6epz0.jpg', 'You will get paid : $1043.1 USD', 'Regular', 'New', '2014-08-09 16:01:30'),
	(10, 18, 6, 1090, 2, NULL, '3HFdU8j5.jpg', 'asdf asdf asdf.', 'Completed', 'New', '2014-08-09 16:01:57'),
	(11, 3, 1, 10, 2, NULL, 'bhdyhhnB.jpg', 'You will get paid : $9.5 USD', 'Regular', 'New', '2014-08-09 17:28:57'),
	(12, 3, 3, 8, 2, NULL, '2zlGwcP4.jpg', ' You will get paid : $7.6 USD', 'Completed', 'New', '2014-08-09 17:29:28');
/*!40000 ALTER TABLE `bids` ENABLE KEYS */;


-- Dumping structure for table querendo.country
DROP TABLE IF EXISTS `country`;
CREATE TABLE IF NOT EXISTS `country` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `iso_code_2` varchar(2) NOT NULL,
  `iso_code_3` varchar(3) NOT NULL,
  `address_format` text NOT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=MyISAM AUTO_INCREMENT=240 DEFAULT CHARSET=utf8;

-- Dumping data for table querendo.country: 237 rows
DELETE FROM `country`;
/*!40000 ALTER TABLE `country` DISABLE KEYS */;
INSERT INTO `country` (`country_id`, `name`, `iso_code_2`, `iso_code_3`, `address_format`) VALUES
	(1, 'Afghanistan', 'AF', 'AFG', ''),
	(2, 'Albania', 'AL', 'ALB', ''),
	(3, 'Algeria', 'DZ', 'DZA', ''),
	(4, 'American Samoa', 'AS', 'ASM', ''),
	(5, 'Andorra', 'AD', 'AND', ''),
	(6, 'Angola', 'AO', 'AGO', ''),
	(7, 'Anguilla', 'AI', 'AIA', ''),
	(8, 'Antarctica', 'AQ', 'ATA', ''),
	(9, 'Antigua and Barbuda', 'AG', 'ATG', ''),
	(10, 'Argentina', 'AR', 'ARG', ''),
	(11, 'Armenia', 'AM', 'ARM', ''),
	(12, 'Aruba', 'AW', 'ABW', ''),
	(13, 'Australia', 'AU', 'AUS', ''),
	(14, 'Austria', 'AT', 'AUT', ''),
	(15, 'Azerbaijan', 'AZ', 'AZE', ''),
	(16, 'Bahamas', 'BS', 'BHS', ''),
	(17, 'Bahrain', 'BH', 'BHR', ''),
	(18, 'Bangladesh', 'BD', 'BGD', ''),
	(19, 'Barbados', 'BB', 'BRB', ''),
	(20, 'Belarus', 'BY', 'BLR', ''),
	(21, 'Belgium', 'BE', 'BEL', ''),
	(22, 'Belize', 'BZ', 'BLZ', ''),
	(23, 'Benin', 'BJ', 'BEN', ''),
	(24, 'Bermuda', 'BM', 'BMU', ''),
	(25, 'Bhutan', 'BT', 'BTN', ''),
	(26, 'Bolivia', 'BO', 'BOL', ''),
	(27, 'Bosnia and Herzegowina', 'BA', 'BIH', ''),
	(28, 'Botswana', 'BW', 'BWA', ''),
	(29, 'Bouvet Island', 'BV', 'BVT', ''),
	(30, 'Brazil', 'BR', 'BRA', ''),
	(31, 'British Indian Ocean Territory', 'IO', 'IOT', ''),
	(32, 'Brunei Darussalam', 'BN', 'BRN', ''),
	(33, 'Bulgaria', 'BG', 'BGR', ''),
	(34, 'Burkina Faso', 'BF', 'BFA', ''),
	(35, 'Burundi', 'BI', 'BDI', ''),
	(36, 'Cambodia', 'KH', 'KHM', ''),
	(37, 'Cameroon', 'CM', 'CMR', ''),
	(38, 'Canada', 'CA', 'CAN', ''),
	(39, 'Cape Verde', 'CV', 'CPV', ''),
	(40, 'Cayman Islands', 'KY', 'CYM', ''),
	(41, 'Central African Republic', 'CF', 'CAF', ''),
	(42, 'Chad', 'TD', 'TCD', ''),
	(43, 'Chile', 'CL', 'CHL', ''),
	(44, 'China', 'CN', 'CHN', ''),
	(45, 'Christmas Island', 'CX', 'CXR', ''),
	(46, 'Cocos (Keeling) Islands', 'CC', 'CCK', ''),
	(47, 'Colombia', 'CO', 'COL', ''),
	(48, 'Comoros', 'KM', 'COM', ''),
	(49, 'Congo', 'CG', 'COG', ''),
	(50, 'Cook Islands', 'CK', 'COK', ''),
	(51, 'Costa Rica', 'CR', 'CRI', ''),
	(53, 'Croatia', 'HR', 'HRV', ''),
	(54, 'Cuba', 'CU', 'CUB', ''),
	(55, 'Cyprus', 'CY', 'CYP', ''),
	(56, 'Czech Republic', 'CZ', 'CZE', ''),
	(57, 'Denmark', 'DK', 'DNK', ''),
	(58, 'Djibouti', 'DJ', 'DJI', ''),
	(59, 'Dominica', 'DM', 'DMA', ''),
	(60, 'Dominican Republic', 'DO', 'DOM', ''),
	(61, 'East Timor', 'TP', 'TMP', ''),
	(62, 'Ecuador', 'EC', 'ECU', ''),
	(63, 'Egypt', 'EG', 'EGY', ''),
	(64, 'El Salvador', 'SV', 'SLV', ''),
	(65, 'Equatorial Guinea', 'GQ', 'GNQ', ''),
	(66, 'Eritrea', 'ER', 'ERI', ''),
	(67, 'Estonia', 'EE', 'EST', ''),
	(68, 'Ethiopia', 'ET', 'ETH', ''),
	(69, 'Falkland Islands (Malvinas)', 'FK', 'FLK', ''),
	(70, 'Faroe Islands', 'FO', 'FRO', ''),
	(71, 'Fiji', 'FJ', 'FJI', ''),
	(72, 'Finland', 'FI', 'FIN', ''),
	(73, 'France', 'FR', 'FRA', ''),
	(74, 'France, Metropolitan', 'FX', 'FXX', ''),
	(75, 'French Guiana', 'GF', 'GUF', ''),
	(76, 'French Polynesia', 'PF', 'PYF', ''),
	(77, 'French Southern Territories', 'TF', 'ATF', ''),
	(78, 'Gabon', 'GA', 'GAB', ''),
	(79, 'Gambia', 'GM', 'GMB', ''),
	(80, 'Georgia', 'GE', 'GEO', ''),
	(81, 'Germany', 'DE', 'DEU', ''),
	(82, 'Ghana', 'GH', 'GHA', ''),
	(83, 'Gibraltar', 'GI', 'GIB', ''),
	(84, 'Greece', 'GR', 'GRC', ''),
	(85, 'Greenland', 'GL', 'GRL', ''),
	(86, 'Grenada', 'GD', 'GRD', ''),
	(87, 'Guadeloupe', 'GP', 'GLP', ''),
	(88, 'Guam', 'GU', 'GUM', ''),
	(89, 'Guatemala', 'GT', 'GTM', ''),
	(90, 'Guinea', 'GN', 'GIN', ''),
	(91, 'Guinea-bissau', 'GW', 'GNB', ''),
	(92, 'Guyana', 'GY', 'GUY', ''),
	(93, 'Haiti', 'HT', 'HTI', ''),
	(94, 'Heard and Mc Donald Islands', 'HM', 'HMD', ''),
	(95, 'Honduras', 'HN', 'HND', ''),
	(96, 'Hong Kong', 'HK', 'HKG', ''),
	(97, 'Hungary', 'HU', 'HUN', ''),
	(98, 'Iceland', 'IS', 'ISL', ''),
	(99, 'India', 'IN', 'IND', ''),
	(100, 'Indonesia', 'ID', 'IDN', ''),
	(101, 'Iran (Islamic Republic of)', 'IR', 'IRN', ''),
	(102, 'Iraq', 'IQ', 'IRQ', ''),
	(103, 'Ireland', 'IE', 'IRL', ''),
	(104, 'Israel', 'IL', 'ISR', ''),
	(105, 'Italy', 'IT', 'ITA', ''),
	(106, 'Jamaica', 'JM', 'JAM', ''),
	(107, 'Japan', 'JP', 'JPN', ''),
	(108, 'Jordan', 'JO', 'JOR', ''),
	(109, 'Kazakhstan', 'KZ', 'KAZ', ''),
	(110, 'Kenya', 'KE', 'KEN', ''),
	(111, 'Kiribati', 'KI', 'KIR', ''),
	(112, 'Korea Democratic People&#039;s Republic Of (North Korea)', 'KP', 'PRK', ''),
	(113, 'Korea, Republic of', 'KR', 'KOR', ''),
	(114, 'Kuwait', 'KW', 'KWT', ''),
	(115, 'Kyrgyzstan', 'KG', 'KGZ', ''),
	(117, 'Latvia', 'LV', 'LVA', ''),
	(118, 'Lebanon', 'LB', 'LBN', ''),
	(119, 'Lesotho', 'LS', 'LSO', ''),
	(120, 'Liberia', 'LR', 'LBR', ''),
	(121, 'Libyan Arab Jamahiriya', 'LY', 'LBY', ''),
	(122, 'Liechtenstein', 'LI', 'LIE', ''),
	(123, 'Lithuania', 'LT', 'LTU', ''),
	(124, 'Luxembourg', 'LU', 'LUX', ''),
	(125, 'Macau', 'MO', 'MAC', ''),
	(126, 'Macedonia, The Former Yugoslav Republic of', 'MK', 'MKD', ''),
	(127, 'Madagascar', 'MG', 'MDG', ''),
	(128, 'Malawi', 'MW', 'MWI', ''),
	(129, 'Malaysia', 'MY', 'MYS', ''),
	(130, 'Maldives', 'MV', 'MDV', ''),
	(131, 'Mali', 'ML', 'MLI', ''),
	(132, 'Malta', 'MT', 'MLT', ''),
	(133, 'Marshall Islands', 'MH', 'MHL', ''),
	(134, 'Martinique', 'MQ', 'MTQ', ''),
	(135, 'Mauritania', 'MR', 'MRT', ''),
	(136, 'Mauritius', 'MU', 'MUS', ''),
	(137, 'Mayotte', 'YT', 'MYT', ''),
	(138, 'Mexico', 'MX', 'MEX', ''),
	(139, 'Micronesia, Federated States of', 'FM', 'FSM', ''),
	(140, 'Moldova, Republic of', 'MD', 'MDA', ''),
	(141, 'Monaco', 'MC', 'MCO', ''),
	(142, 'Mongolia', 'MN', 'MNG', ''),
	(143, 'Montserrat', 'MS', 'MSR', ''),
	(144, 'Morocco', 'MA', 'MAR', ''),
	(145, 'Mozambique', 'MZ', 'MOZ', ''),
	(146, 'Myanmar', 'MM', 'MMR', ''),
	(147, 'Namibia', 'NA', 'NAM', ''),
	(148, 'Nauru', 'NR', 'NRU', ''),
	(149, 'Nepal', 'NP', 'NPL', ''),
	(150, 'Netherlands', 'NL', 'NLD', ''),
	(151, 'Netherlands Antilles', 'AN', 'ANT', ''),
	(152, 'New Caledonia', 'NC', 'NCL', ''),
	(153, 'New Zealand', 'NZ', 'NZL', ''),
	(154, 'Nicaragua', 'NI', 'NIC', ''),
	(155, 'Niger', 'NE', 'NER', ''),
	(156, 'Nigeria', 'NG', 'NGA', ''),
	(157, 'Niue', 'NU', 'NIU', ''),
	(158, 'Norfolk Island', 'NF', 'NFK', ''),
	(159, 'Northern Mariana Islands', 'MP', 'MNP', ''),
	(160, 'Norway', 'NO', 'NOR', ''),
	(161, 'Oman', 'OM', 'OMN', ''),
	(162, 'Pakistan', 'PK', 'PAK', ''),
	(163, 'Palau', 'PW', 'PLW', ''),
	(164, 'Panama', 'PA', 'PAN', ''),
	(165, 'Papua New Guinea', 'PG', 'PNG', ''),
	(166, 'Paraguay', 'PY', 'PRY', ''),
	(167, 'Peru', 'PE', 'PER', ''),
	(168, 'Philippines', 'PH', 'PHL', ''),
	(169, 'Pitcairn', 'PN', 'PCN', ''),
	(170, 'Poland', 'PL', 'POL', ''),
	(171, 'Portugal', 'PT', 'PRT', ''),
	(172, 'Puerto Rico', 'PR', 'PRI', ''),
	(173, 'Qatar', 'QA', 'QAT', ''),
	(174, 'Reunion', 'RE', 'REU', ''),
	(175, 'Romania', 'RO', 'ROM', ''),
	(176, 'Russian Federation', 'RU', 'RUS', ''),
	(177, 'Rwanda', 'RW', 'RWA', ''),
	(178, 'Saint Kitts and Nevis', 'KN', 'KNA', ''),
	(179, 'Saint Lucia', 'LC', 'LCA', ''),
	(180, 'Saint Vincent and the Grenadines', 'VC', 'VCT', ''),
	(181, 'Samoa', 'WS', 'WSM', ''),
	(182, 'San Marino', 'SM', 'SMR', ''),
	(183, 'Sao Tome and Principe', 'ST', 'STP', ''),
	(184, 'Saudi Arabia', 'SA', 'SAU', ''),
	(185, 'Senegal', 'SN', 'SEN', ''),
	(186, 'Seychelles', 'SC', 'SYC', ''),
	(187, 'Sierra Leone', 'SL', 'SLE', ''),
	(188, 'Singapore', 'SG', 'SGP', ''),
	(189, 'Slovakia (Slovak Republic)', 'SK', 'SVK', ''),
	(190, 'Slovenia', 'SI', 'SVN', ''),
	(191, 'Solomon Islands', 'SB', 'SLB', ''),
	(192, 'Somalia', 'SO', 'SOM', ''),
	(193, 'South Africa', 'ZA', 'ZAF', ''),
	(194, 'South Georgia and the South Sandwich Islands', 'GS', 'SGS', ''),
	(195, 'Spain', 'ES', 'ESP', ''),
	(196, 'Sri Lanka', 'LK', 'LKA', ''),
	(197, 'St. Helena', 'SH', 'SHN', ''),
	(198, 'St. Pierre and Miquelon', 'PM', 'SPM', ''),
	(199, 'Sudan', 'SD', 'SDN', ''),
	(200, 'Suriname', 'SR', 'SUR', ''),
	(201, 'Svalbard and Jan Mayen Islands', 'SJ', 'SJM', ''),
	(202, 'Swaziland', 'SZ', 'SWZ', ''),
	(203, 'Sweden', 'SE', 'SWE', ''),
	(204, 'Switzerland', 'CH', 'CHE', ''),
	(205, 'Syrian Arab Republic', 'SY', 'SYR', ''),
	(206, 'Taiwan', 'TW', 'TWN', ''),
	(207, 'Tajikistan', 'TJ', 'TJK', ''),
	(208, 'Tanzania, United Republic of', 'TZ', 'TZA', ''),
	(209, 'Thailand', 'TH', 'THA', ''),
	(210, 'Togo', 'TG', 'TGO', ''),
	(211, 'Tokelau', 'TK', 'TKL', ''),
	(212, 'Tonga', 'TO', 'TON', ''),
	(213, 'Trinidad and Tobago', 'TT', 'TTO', ''),
	(214, 'Tunisia', 'TN', 'TUN', ''),
	(215, 'Turkey', 'TR', 'TUR', ''),
	(216, 'Turkmenistan', 'TM', 'TKM', ''),
	(217, 'Turks and Caicos Islands', 'TC', 'TCA', ''),
	(218, 'Tuvalu', 'TV', 'TUV', ''),
	(219, 'Uganda', 'UG', 'UGA', ''),
	(220, 'Ukraine', 'UA', 'UKR', ''),
	(221, 'United Arab Emirates', 'AE', 'ARE', ''),
	(222, 'United Kingdom', 'GB', 'GBR', ''),
	(223, 'United States', 'US', 'USA', '{firstname} {lastname}\r\n{company}\r\n{address_1}\r\n{address_2}\r\n{city}, {zone} {postcode}\r\n{country}'),
	(224, 'United States Minor Outlying Islands', 'UM', 'UMI', ''),
	(225, 'Uruguay', 'UY', 'URY', ''),
	(226, 'Uzbekistan', 'UZ', 'UZB', ''),
	(227, 'Vanuatu', 'VU', 'VUT', ''),
	(228, 'Vatican City State (Holy See)', 'VA', 'VAT', ''),
	(229, 'Venezuela', 'VE', 'VEN', ''),
	(230, 'Viet Nam', 'VN', 'VNM', ''),
	(231, 'Virgin Islands (British)', 'VG', 'VGB', ''),
	(232, 'Virgin Islands (U.S.)', 'VI', 'VIR', ''),
	(233, 'Wallis and Futuna Islands', 'WF', 'WLF', ''),
	(234, 'Western Sahara', 'EH', 'ESH', ''),
	(235, 'Yemen', 'YE', 'YEM', ''),
	(236, 'Yugoslavia', 'YU', 'YUG', ''),
	(237, 'Zaire', 'ZR', 'ZAR', ''),
	(238, 'Zambia', 'ZM', 'ZMB', ''),
	(239, 'Zimbabwe', 'ZW', 'ZWE', '');
/*!40000 ALTER TABLE `country` ENABLE KEYS */;


-- Dumping structure for table querendo.invoice
DROP TABLE IF EXISTS `invoice`;
CREATE TABLE IF NOT EXISTS `invoice` (
  `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `payment` float NOT NULL DEFAULT '0',
  `status` enum('paid','unpaid') NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`invoice_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table querendo.invoice: ~2 rows (approximately)
DELETE FROM `invoice`;
/*!40000 ALTER TABLE `invoice` DISABLE KEYS */;
INSERT INTO `invoice` (`invoice_id`, `product_id`, `user_id`, `payment`, `status`, `create_date`) VALUES
	(1, 18, 6, 54.5, 'unpaid', '2014-08-09 14:57:39'),
	(2, 3, 3, 0.4, 'unpaid', '2014-08-09 15:13:08');
/*!40000 ALTER TABLE `invoice` ENABLE KEYS */;


-- Dumping structure for table querendo.message
DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `thread_id` int(11) NOT NULL DEFAULT '0',
  `message` text,
  `from_id` int(11) DEFAULT NULL,
  `status` enum('read','unread') CHARACTER SET latin1 DEFAULT NULL,
  `create_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table querendo.message: ~0 rows (approximately)
DELETE FROM `message`;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
/*!40000 ALTER TABLE `message` ENABLE KEYS */;


-- Dumping structure for table querendo.milestone
DROP TABLE IF EXISTS `milestone`;
CREATE TABLE IF NOT EXISTS `milestone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT '0',
  `from_id` int(11) DEFAULT '0',
  `to_id` int(11) DEFAULT '0',
  `initiated_by` int(11) DEFAULT '0',
  `amount` float(24,2) DEFAULT '0.00',
  `description` varchar(250) DEFAULT '0',
  `status` enum('requested','released','accepted','cancelled','pending') NOT NULL COMMENT 'requested=when bidder has requested a milestone, released=when product owner has confirmed the money to be given to the owner, accepted=when product owner has just accepted the bidder milestone request but have not released yet, cancelled=when bidder or site admin has cancelled the milestone(product owner can''t cancel the milestone directly), pending=when product owner has requested for cancel of an accpeted milestone',
  `create_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table querendo.milestone: ~1 rows (approximately)
DELETE FROM `milestone`;
/*!40000 ALTER TABLE `milestone` DISABLE KEYS */;
INSERT INTO `milestone` (`id`, `product_id`, `from_id`, `to_id`, `initiated_by`, `amount`, `description`, `status`, `create_date`) VALUES
	(1, 13, 3, 6, 6, 50.00, 'Bid Accepted and Confirmed', 'requested', '2014-08-07 18:37:30');
/*!40000 ALTER TABLE `milestone` ENABLE KEYS */;


-- Dumping structure for table querendo.payments
DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `txn_id` varchar(50) NOT NULL DEFAULT '0',
  `item_name` varchar(50) NOT NULL DEFAULT '0',
  `item_number` int(11) NOT NULL DEFAULT '0',
  `mc_gross` varchar(50) NOT NULL DEFAULT '0',
  `mc_currency` varchar(50) NOT NULL DEFAULT '0',
  `payment_status` varchar(50) NOT NULL DEFAULT '0',
  `mc_fee` varchar(50) NOT NULL DEFAULT '0',
  `first_name` varchar(50) NOT NULL DEFAULT '0',
  `last_name` varchar(50) NOT NULL DEFAULT '0',
  `address_street` varchar(50) NOT NULL DEFAULT '0',
  `address_zip` varchar(50) NOT NULL DEFAULT '0',
  `address_country_code` varchar(50) NOT NULL DEFAULT '0',
  `address_name` varchar(50) NOT NULL DEFAULT '0',
  `address_country` varchar(50) NOT NULL DEFAULT '0',
  `address_city` varchar(50) NOT NULL DEFAULT '0',
  `address_state` varchar(50) NOT NULL DEFAULT '0',
  `receiver_email` varchar(50) NOT NULL DEFAULT '0',
  `payer_email` varchar(50) NOT NULL DEFAULT '0',
  `payment_date` varchar(50) NOT NULL DEFAULT '0',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='store all the payment informations.';

-- Dumping data for table querendo.payments: ~0 rows (approximately)
DELETE FROM `payments`;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;


-- Dumping structure for table querendo.payment_log
DROP TABLE IF EXISTS `payment_log`;
CREATE TABLE IF NOT EXISTS `payment_log` (
  `payment_log_id` int(100) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `txn_id` varchar(50) NOT NULL DEFAULT '0',
  `item_name` varchar(100) NOT NULL DEFAULT '0',
  `item_number` int(100) NOT NULL DEFAULT '0',
  `mc_gross` varchar(50) NOT NULL DEFAULT '0',
  `mc_currency` varchar(100) NOT NULL DEFAULT '0',
  `payment_status` varchar(100) NOT NULL DEFAULT '0',
  `mc_fee` varchar(100) NOT NULL DEFAULT '0',
  `first_name` varchar(100) NOT NULL DEFAULT '0',
  `last_name` varchar(100) NOT NULL DEFAULT '0',
  `address_street` varchar(100) NOT NULL DEFAULT '0',
  `address_zip` varchar(100) NOT NULL DEFAULT '0',
  `address_country_code` varchar(100) NOT NULL DEFAULT '0',
  `address_name` varchar(100) NOT NULL DEFAULT '0',
  `address_country` varchar(100) NOT NULL DEFAULT '0',
  `address_city` varchar(100) NOT NULL DEFAULT '0',
  `address_state` varchar(100) NOT NULL DEFAULT '0',
  `receiver_email` varchar(100) NOT NULL DEFAULT '0',
  `payer_email` varchar(100) NOT NULL DEFAULT '0',
  `payment_date` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`payment_log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table querendo.payment_log: ~0 rows (approximately)
DELETE FROM `payment_log`;
/*!40000 ALTER TABLE `payment_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_log` ENABLE KEYS */;


-- Dumping structure for table querendo.product
DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `status` enum('running','awarded','processing','expired','cancel','completed','waiting') CHARACTER SET latin1 NOT NULL COMMENT 'Waiting=product submitter has chosen the bid and waiting for bidder approval||running=user can bid on the product|| awarded=tow side handshaking done||beforePayment=awarded but not paid||processing=awarded but not completed||expired=product time end||caccel=product cancelled by user||completed=all done',
  `transaction_status` enum('payment_sent','payment_received','product_sent','product_received','none') NOT NULL DEFAULT 'none',
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `category_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `shipping_method` varchar(50) NOT NULL DEFAULT '',
  `shipping_cost` float NOT NULL,
  `product_condition` enum('New','Used','Any') CHARACTER SET latin1 NOT NULL,
  `product_photo` varchar(255) CHARACTER SET latin1 NOT NULL,
  `budget_type` enum('fixed','range') NOT NULL,
  `fixed_budget` varchar(100) NOT NULL,
  `min_budget` float NOT NULL,
  `max_budget` float NOT NULL,
  `activity` enum('1','0') CHARACTER SET latin1 NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `complete_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- Dumping data for table querendo.product: ~11 rows (approximately)
DELETE FROM `product`;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` (`product_id`, `user_id`, `status`, `transaction_status`, `name`, `category_id`, `description`, `shipping_method`, `shipping_cost`, `product_condition`, `product_photo`, `budget_type`, `fixed_budget`, `min_budget`, `max_budget`, `activity`, `create_date`, `complete_date`) VALUES
	(1, 1, 'running', 'none', 'Arial Khesh', 19, 'But those who disbelieve say, "The Hour will not come to us." Say, "Yes, by my Lord, it will surely come to you. [ Allah is] the Knower of the unseen." Not absent from Him is an atom\'s weight within the heavens or within the earth or [what is] smaller than that or greater, except that it is in a clear register -', 'I want it shipped to me', 0, 'Any', 'tF8NW53O.jpg', 'fixed', '11', 0, 0, '1', '2014-07-17 16:49:01', '0000-00-00 00:00:00'),
	(2, 1, 'running', 'none', 'Kheshe Gelo', 3, 'But those who disbelieve say, "The Hour will not come to us." Say, "Yes, by my Lord, it will surely come to you. [ Allah is] the Knower of the unseen." Not absent from Him is an atom\'s weight within the heavens or within the earth or [what is] smaller than that or greater, except that it is in a clear register -', 'I want it shipped to me', 0, 'New', 'TLHhuooW.jpg', 'fixed', '11', 0, 0, '1', '2014-07-17 16:49:23', '0000-00-00 00:00:00'),
	(3, 6, 'completed', 'product_received', 'Lumia 930', 3, 'I would like to take this moment to thank everyone who participated to help raise awareness about our families in Gaza. It’s difficult for the people in Gaza to show you their gratitude. But on behalf of them, i’d like to thank you all from the bottom of my heart! Thank you for telling your friends, sharing posts, donating, praying etc.. I want you to know that you’re playing a serious role during this sensitive time. The amount of people who know the truth about the Palestin', 'I want it shipped to me', 0, 'Used', 'RUjinUHK.jpg', 'fixed', '11', 0, 0, '1', '2014-07-19 11:59:19', '2014-08-09 18:13:08'),
	(10, 3, 'running', 'none', 'Haier LE58F3281 58-Inch ', 28, 'asdf sdfs dagdsf gdf gdg df', 'I want it shipped to me', 0, 'Used', '', 'fixed', '300', 0, 0, '1', '2014-07-19 15:44:58', '0000-00-00 00:00:00'),
	(11, 3, 'running', 'none', 'Distant Early Warnings', 10, '"The 21st Century Belongs to Canada"\r\n\r\nOn a per capita basis, Canada has more world-class science-fiction writers than any country on Earth. Collected here are the best recent works by Hugo Award winners Spider Robinson, Robert J. Sawyer, and Robert Charles Wilson, Hugo nominees Paddy Forde, James Alan Gardner, Nalo Hopkinson, and Peter Watts, and Aurora Award winners Julie E. Czerneda and Karl Schroeder - 14 advance reports of wonders and dangers yet to come.', 'I want it shipped to me', 0, 'New', '', 'fixed', '20', 0, 0, '1', '2014-07-19 15:49:18', '0000-00-00 00:00:00'),
	(12, 3, 'running', 'none', 'The Maze', 102, 'A witty young Raptor named Booj teams up with bookish Jason and feisty Gwen to search for a reclusive Raptor named Odon. But their search is a harrowing one. The legend of Odon is that long ago he left Dinotopia\'s society of humans and dinosaurs to live as a hermit. The only way to find Odon is to negotiate a dangerous underground maze. No matter the challenge, however, Booj, Jason, and Gwen are determined to find Odon because he is said to be a magnificent healer, and Gwen\'s father has been infected with a deadly disease that Dinotopia doctors do not know how to cure. Will the three friends be able to get through the maze? And, if they do, will they be able to convince a recluse like Odon to help them? Its a life-and-death challenge and a thrilling tale in this amazing world of Dinotopia', 'I want it shipped to me', 0, 'Used', '', 'fixed', '20', 0, 0, '1', '2014-07-19 15:50:20', '0000-00-00 00:00:00'),
	(13, 3, 'awarded', 'none', 'Batman', 104, 'When District Attorney Harvey Dent\'s face was forever deformed by a vial of acid, his mind was also fractured and the maniacal Two-Face was born. In \'Batman - Faces\', the demented schizophrenic, enraged by his own isolation and alienation, attempts to create a country of deformed men. Taking over a small Caribbean island and forcing plastic surgeons to perform unholy operations, Two-Face begins to create an army in his own image. But when a simple blackmail investigation leads Batman to discover his former ally\'s mad scheme, Two-Face\'s pursuit of power is quickly ended.', 'I want it shipped to me', 0, 'New', '', 'fixed', '50', 0, 0, '1', '2014-07-19 15:51:32', '2014-08-07 18:37:30'),
	(14, 7, 'running', 'none', 'asdfds f ', 28, 'fda sdfsdfsadf saf sd', 'I can pick it up', 0, 'Used', '', 'fixed', '1700', 0, 0, '1', '2014-08-07 15:08:19', '0000-00-00 00:00:00'),
	(16, 6, 'completed', 'product_received', 'Asdf', 10, 'asdf sadf asdf.', 'I can pick it up', 0, 'New', 'HEzK99BG.jpg', 'fixed', '140', 0, 0, '1', '2014-08-07 19:19:04', '2014-08-09 15:35:13'),
	(17, 6, 'completed', 'product_received', 'Nam', 10, 'Details', 'I want it shipped to me', 0, 'New', '0niBH2QX.jpg', 'fixed', '120', 0, 0, '1', '2014-08-09 15:36:41', '2014-08-09 15:53:11'),
	(18, 3, 'completed', 'payment_received', 'What The...', 10, 'asdf', 'I want it shipped to me', 0, 'New', '3giw8yix.jpg', 'fixed', '1100', 0, 0, '1', '2014-08-09 16:00:44', '2014-08-09 16:05:36');
/*!40000 ALTER TABLE `product` ENABLE KEYS */;


-- Dumping structure for table querendo.product_category
DROP TABLE IF EXISTS `product_category`;
CREATE TABLE IF NOT EXISTS `product_category` (
  `cat_id` int(100) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) DEFAULT NULL,
  `cat_name` varchar(100) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `level` int(2) NOT NULL,
  PRIMARY KEY (`cat_id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=latin1;

-- Dumping data for table querendo.product_category: ~102 rows (approximately)
DELETE FROM `product_category`;
/*!40000 ALTER TABLE `product_category` DISABLE KEYS */;
INSERT INTO `product_category` (`cat_id`, `url`, `cat_name`, `parent_id`, `level`) VALUES
	(1, 'books-and-audible', 'Books & Audible', 0, 1),
	(2, 'movies-music-and-games', 'Movies, Music & Games', 0, 1),
	(3, 'electronics-and-computers', 'Electronics & Computers', 0, 1),
	(4, 'home-garden-and-tools', 'Home, Garden & Tools', 0, 1),
	(5, 'beauty-health-and-grocery', 'Beauty, Health & Grocery', 0, 1),
	(6, 'toys-kids-and-baby', 'Toys, Kids & Baby', 0, 1),
	(7, 'clothing-shoes-and-jewelry', 'Clothing, Shoes & Jewelry', 0, 1),
	(8, 'sports-and-outdoors', 'Sports & Outdoors', 0, 1),
	(9, 'automotive-and-industrial', 'Automotive & Industrial', 0, 1),
	(10, 'books', 'Books', 1, 2),
	(11, 'children-s-books', 'Children\'s Books', 1, 2),
	(12, 'textbooks', 'Textbooks', 1, 2),
	(13, 'magazines', 'Magazines', 1, 2),
	(14, 'sell-us-your-books', 'Sell Us Your Books', 1, 2),
	(15, 'audible-membership', 'Audible Membership', 1, 2),
	(16, 'audible-audiobooks-and-more', 'Audible Audiobooks & More', 1, 2),
	(17, 'whispersync-for-voice', 'Whispersync for Voice', 1, 2),
	(18, 'movies-and-tv', 'Movies & TV', 2, 2),
	(19, 'blu-ray', 'Blu-ray', 2, 2),
	(21, 'cds-and-vinyl', 'CDs & Vinyl', 2, 2),
	(22, 'digital-music', 'Digital Music', 2, 2),
	(23, 'musical-instruments', 'Musical Instruments', 2, 2),
	(24, 'video-games', 'Video Games', 2, 2),
	(25, 'digital-games', 'Digital Games', 2, 2),
	(26, 'entertainment-collectibles', 'Entertainment Collectibles', 2, 2),
	(27, 'trade-in-movies-music-and-games', 'Trade In Movies, Music & Games', 2, 2),
	(28, 'tv-and-video', 'TV & Video', 3, 2),
	(29, 'automotive-parts-and-accessories', 'Automotive Parts & Accessories', 9, 2),
	(30, 'automotive-tools-and-equipment', 'Automotive Tools & Equipment', 9, 2),
	(31, 'car-vehicle-electronics-and-gps', 'Car/Vehicle Electronics & GPS', 9, 2),
	(32, 'tires-and-wheels', 'Tires & Wheels', 9, 2),
	(33, 'motorcycle-and-powersports', 'Motorcycle & Powersports', 9, 2),
	(34, 'industrial-supplies', 'Industrial Supplies', 9, 2),
	(35, 'lab-and-scientific', 'Lab & Scientific', 9, 2),
	(36, 'janitorial', 'Janitorial', 9, 2),
	(37, 'safety', 'Safety', 9, 2),
	(38, 'exercise-and-fitness', 'Exercise & Fitness', 8, 2),
	(39, 'hunting-and-fishing', 'Hunting & Fishing', 8, 2),
	(40, 'athletic-clothing', 'Athletic Clothing', 8, 2),
	(41, 'boating-and-water-sports', 'Boating & Water Sports', 8, 2),
	(42, 'team-sports', 'Team Sports', 8, 2),
	(43, 'fan-shop', 'Fan Shop', 8, 2),
	(44, 'sports-collectibles', 'Sports Collectibles', 8, 2),
	(45, 'golf', 'Golf', 8, 2),
	(46, 'all-sports-and-outdoors', 'All Sports & Outdoors', 8, 2),
	(47, 'outdoor-gear', 'Outdoor Gear', 8, 2),
	(48, 'outdoor-clothing', 'Outdoor Clothing', 8, 2),
	(49, 'cycling', 'Cycling', 8, 2),
	(50, 'action-sports', 'Action Sports', 8, 2),
	(51, 'women', 'Women', 7, 2),
	(52, 'men', 'Men', 7, 2),
	(53, 'girls', 'Girls', 7, 2),
	(54, 'boys', 'Boys', 7, 2),
	(55, 'baby', 'Baby', 7, 2),
	(56, 'luggage', 'Luggage', 7, 2),
	(57, 'toys-and-games', 'Toys & Games', 6, 2),
	(58, 'video-games-for-kids', 'Video Games for Kids', 6, 2),
	(59, 'baby-registry', 'Baby Registry', 6, 2),
	(60, 'kids-birthdays', 'Kids’ Birthdays', 6, 2),
	(61, 'for-girls', 'For Girls', 6, 2),
	(62, 'for-boys', 'For Boys', 6, 2),
	(63, 'for-baby', 'For Baby', 6, 2),
	(64, 'all-beauty', 'All Beauty', 5, 2),
	(65, 'luxury-beauty', 'Luxury Beauty', 5, 2),
	(66, 'men-s-grooming', 'Men’s Grooming', 5, 2),
	(67, 'health-household-and-baby-care', 'Health, Household & Baby Care', 5, 2),
	(68, 'grocery-and-gourmet-food', 'Grocery & Gourmet Food', 5, 2),
	(69, 'natural-and-organic', 'Natural & Organic', 5, 2),
	(70, 'gourmet-gifts', 'Gourmet Gifts', 5, 2),
	(71, 'wine', 'Wine', 5, 2),
	(72, 'kitchen-and-dining', 'Kitchen & Dining', 4, 2),
	(73, 'furniture-and-d-cor', 'Furniture & Décor', 4, 2),
	(74, 'bedding-and-bath', 'Bedding & Bath', 4, 2),
	(75, 'appliances', 'Appliances', 4, 2),
	(76, 'patio-lawn-and-garden', 'Patio, Lawn & Garden', 4, 2),
	(77, 'fine-art', 'Fine Art', 4, 2),
	(78, 'arts-crafts-and-sewing', 'Arts, Crafts & Sewing', 4, 2),
	(79, 'pet-supplies', 'Pet Supplies', 4, 2),
	(80, 'wedding-registry', 'Wedding Registry', 4, 2),
	(81, 'home-improvement', 'Home Improvement', 4, 2),
	(82, 'power-and-hand-tools', 'Power & Hand Tools', 4, 2),
	(83, 'lamps-and-light-fixtures', 'Lamps & Light Fixtures', 4, 2),
	(84, 'kitchen-and-bath-fixtures', 'Kitchen & Bath Fixtures', 4, 2),
	(85, 'hardware', 'Hardware', 4, 2),
	(86, 'home-automation', 'Home Automation', 4, 2),
	(87, 'home-audio-and-theater', 'Home Audio & Theater', 3, 2),
	(88, 'camera-photo-and-video', 'Camera, Photo & Video', 3, 2),
	(89, 'cell-phones-and-accessories', 'Cell Phones & Accessories', 3, 2),
	(90, 'mp3-players-and-portable-speakers', 'MP3 Players & Portable Speakers', 3, 2),
	(91, 'car-electronics-and-gps', 'Car Electronics & GPS', 3, 2),
	(92, 'electronics-accessories', 'Electronics Accessories', 3, 2),
	(93, 'wearable-technology', 'Wearable Technology', 3, 2),
	(94, 'laptops-and-tablets', 'Laptops & Tablets', 3, 2),
	(95, 'desktops-and-monitors', 'Desktops & Monitors', 3, 2),
	(96, 'computer-accessories-and-peripherals', 'Computer Accessories & Peripherals', 3, 2),
	(97, 'computer-parts-and-components', 'Computer Parts & Components', 3, 2),
	(98, 'software', 'Software', 3, 2),
	(99, 'printers-and-ink', 'Printers & Ink', 3, 2),
	(100, 'office-and-school-supplies', 'Office & School Supplies', 3, 2),
	(101, 'trade-in-your-electronics', 'Trade In Your Electronics', 3, 2),
	(102, 'oldbooks', 'oldBooks', 10, 3),
	(104, 'drama', 'drama', 102, 4);
/*!40000 ALTER TABLE `product_category` ENABLE KEYS */;


-- Dumping structure for table querendo.product_category_list
DROP TABLE IF EXISTS `product_category_list`;
CREATE TABLE IF NOT EXISTS `product_category_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL DEFAULT '0',
  `product_category_id` int(11) NOT NULL DEFAULT '0',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

-- Dumping data for table querendo.product_category_list: ~44 rows (approximately)
DELETE FROM `product_category_list`;
/*!40000 ALTER TABLE `product_category_list` DISABLE KEYS */;
INSERT INTO `product_category_list` (`id`, `product_id`, `product_category_id`, `create_date`) VALUES
	(1, 1, 19, '2014-07-17 16:49:01'),
	(2, 1, 18, '2014-07-17 16:49:02'),
	(3, 1, 16, '2014-07-17 16:49:02'),
	(4, 1, 2, '2014-07-17 16:49:02'),
	(5, 2, 3, '2014-07-17 16:49:23'),
	(6, 3, 7, '2014-07-19 11:59:19'),
	(7, 3, 3, '2014-07-19 13:10:54'),
	(8, 4, 1, '2014-07-19 14:41:14'),
	(9, 5, 10, '2014-07-19 14:41:39'),
	(10, 5, 1, '2014-07-19 14:41:39'),
	(11, 6, 2, '2014-07-19 14:42:00'),
	(12, 7, 18, '2014-07-19 14:42:23'),
	(13, 7, 2, '2014-07-19 14:42:23'),
	(14, 8, 12, '2014-07-19 14:42:47'),
	(15, 8, 1, '2014-07-19 14:42:47'),
	(16, 9, 25, '2014-07-19 14:43:10'),
	(17, 9, 2, '2014-07-19 14:43:10'),
	(18, 10, 28, '2014-07-19 15:44:58'),
	(19, 10, 3, '2014-07-19 15:44:58'),
	(20, 11, 10, '2014-07-19 15:49:19'),
	(21, 11, 1, '2014-07-19 15:49:19'),
	(22, 12, 102, '2014-07-19 15:50:20'),
	(23, 12, 10, '2014-07-19 15:50:20'),
	(24, 12, 1, '2014-07-19 15:50:20'),
	(25, 13, 104, '2014-07-19 15:51:32'),
	(26, 13, 102, '2014-07-19 15:51:32'),
	(27, 13, 10, '2014-07-19 15:51:32'),
	(28, 13, 1, '2014-07-19 15:51:32'),
	(29, 14, 28, '2014-08-07 15:08:19'),
	(30, 14, 3, '2014-08-07 15:08:19'),
	(31, 15, 10, '2014-08-07 19:18:28'),
	(32, 15, 1, '2014-08-07 19:18:28'),
	(33, 15, 10, '2014-08-07 19:18:39'),
	(34, 15, 1, '2014-08-07 19:18:39'),
	(35, 16, 10, '2014-08-07 19:19:04'),
	(36, 16, 1, '2014-08-07 19:19:04'),
	(37, 16, 10, '2014-08-07 19:22:58'),
	(38, 16, 1, '2014-08-07 19:22:58'),
	(39, 17, 10, '2014-08-09 15:36:41'),
	(40, 17, 1, '2014-08-09 15:36:41'),
	(41, 18, 10, '2014-08-09 16:00:44'),
	(42, 18, 1, '2014-08-09 16:00:44'),
	(43, 18, 10, '2014-08-09 16:00:56'),
	(44, 18, 1, '2014-08-09 16:00:56');
/*!40000 ALTER TABLE `product_category_list` ENABLE KEYS */;


-- Dumping structure for table querendo.review
DROP TABLE IF EXISTS `review`;
CREATE TABLE IF NOT EXISTS `review` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `from_id` int(11) DEFAULT NULL,
  `message` text CHARACTER SET utf8,
  `rating` float DEFAULT NULL,
  `type` enum('buyer','seller') DEFAULT NULL,
  `create_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Dumping data for table querendo.review: ~8 rows (approximately)
DELETE FROM `review`;
/*!40000 ALTER TABLE `review` DISABLE KEYS */;
INSERT INTO `review` (`id`, `product_id`, `user_id`, `from_id`, `message`, `rating`, `type`, `create_date`) VALUES
	(1, 16, 3, 6, 'vua', 1, 'seller', '2014-08-09 15:35:32'),
	(2, 16, 6, 3, 'valo', 5, 'buyer', '2014-08-09 15:35:41'),
	(3, 17, 3, 6, 'hmm', 3, 'seller', '2014-08-09 15:53:22'),
	(4, 17, 6, 3, 'asdf', 5, 'buyer', '2014-08-09 15:53:32'),
	(5, 18, 3, 6, 'valo', 5, 'buyer', '2014-08-09 16:05:57'),
	(6, 18, 6, 3, 'valo', 5, 'seller', '2014-08-09 16:06:06'),
	(7, 3, 3, 6, 'asdf', 4, 'seller', '2014-08-09 18:13:54'),
	(8, 3, 6, 3, 'asdf', 5, 'buyer', '2014-08-09 18:14:01');
/*!40000 ALTER TABLE `review` ENABLE KEYS */;


-- Dumping structure for table querendo.settings
DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  `key` varchar(255) CHARACTER SET latin1 NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Dumping data for table querendo.settings: 9 rows
DELETE FROM `settings`;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` (`id`, `type`, `key`, `name`, `value`) VALUES
	(2, 'website', 'keyword', 'Website Keyword', 'Querendo'),
	(3, 'website', 'description', 'Website Description', 'Querendo'),
	(4, 'admin', 'admin_email', 'Admin Email', 'admin@admin.com'),
	(8, 'website', 'website_email', 'Website Email', 'admin@admin.com'),
	(6, 'admin', 'admin_lastlogin', NULL, ''),
	(1, 'website', 'website_name', 'Website Name', 'Querendo'),
	(7, 'website', 'copyright', 'Copyright Message', ''),
	(9, 'website', 'paypal_email', 'Paypal Email', 'paypal@admin.com'),
	(10, 'website', 'fee_percent', 'Fee Percent', '5');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;


-- Dumping structure for table querendo.thread
DROP TABLE IF EXISTS `thread`;
CREATE TABLE IF NOT EXISTS `thread` (
  `thread_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL DEFAULT '0',
  `from_id` int(11) DEFAULT '0',
  `to_id` int(11) DEFAULT '0',
  `create_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`thread_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table querendo.thread: ~0 rows (approximately)
DELETE FROM `thread`;
/*!40000 ALTER TABLE `thread` DISABLE KEYS */;
/*!40000 ALTER TABLE `thread` ENABLE KEYS */;


-- Dumping structure for table querendo.timezones
DROP TABLE IF EXISTS `timezones`;
CREATE TABLE IF NOT EXISTS `timezones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(44) DEFAULT NULL,
  `timezone` varchar(30) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;

-- Dumping data for table querendo.timezones: ~100 rows (approximately)
DELETE FROM `timezones`;
/*!40000 ALTER TABLE `timezones` DISABLE KEYS */;
INSERT INTO `timezones` (`id`, `name`, `timezone`, `value`) VALUES
	(1, '(UTC-12:00) International Date Line West', 'Etc/GMT+12', '-12:00'),
	(2, '(UTC-11:00) Coordinated Universal Time-11', 'Etc/GMT+11', '-11:00'),
	(3, '(UTC-10:00) Hawaii', 'Etc/GMT+10', '-10:00'),
	(4, '(UTC-09:00) Alaska', 'America/Anchorage', '-09:00'),
	(5, '(UTC-08:00) Baja California', 'America/Santa_Isabel', '-08:00'),
	(6, '(UTC-08:00) Pacific Time (US & Canada)', 'PST8PDT', '-08:00'),
	(7, '(UTC-07:00) Arizona', 'Etc/GMT+7', '-07:00'),
	(8, '(UTC-07:00) Chihuahua, La Paz, Mazatlan', 'America/Chihuahua', '-07:00'),
	(9, '(UTC-07:00) Mountain Time (US & Canada)', 'MST7MDT', '-07:00'),
	(10, '(UTC-06:00) Central America', 'Etc/GMT+6', '-06:00'),
	(11, '(UTC-06:00) Central Time (US & Canada)', 'CST6CDT', '-06:00'),
	(12, '(UTC-06:00) Guadalajara, Mexico City, Monter', 'America/Mexico_City', '-06:00'),
	(13, '(UTC-06:00) Saskatchewan', 'America/Regina', '-06:00'),
	(14, '(UTC-05:00) Bogota, Lima, Quito', 'Etc/GMT+5', '-05:00'),
	(15, '(UTC-05:00) Eastern Time (US & Canada)', 'EST5EDT', '-05:00'),
	(16, '(UTC-05:00) Indiana (East)', 'America/Indianapolis', '-05:00'),
	(17, '(UTC-04:30) Caracas', 'America/Caracas', '-04:30'),
	(18, '(UTC-04:00) Asuncion', 'America/Asuncion', '-04:00'),
	(19, '(UTC-04:00) Atlantic Time (Canada)', 'America/Halifax', '-04:00'),
	(20, '(UTC-04:00) Cuiaba', 'America/Cuiaba', '-04:00'),
	(21, '(UTC-04:00) Georgetown, La Paz, Manaus, San ', 'Etc/GMT+4', '-04:00'),
	(22, '(UTC-04:00) Santiago', 'America/Santiago', '-04:00'),
	(23, '(UTC-03:30) Newfoundland', 'America/St_Johns', '-03:30'),
	(24, '(UTC-03:00) Brasilia', 'America/Sao_Paulo', '-03:00'),
	(25, '(UTC-03:00) Buenos Aires', 'America/Buenos_Aires', '-03:00'),
	(26, '(UTC-03:00) Cayenne, Fortaleza', 'Etc/GMT+3', '-03:00'),
	(27, '(UTC-03:00) Greenland', 'America/Godthab', '-03:00'),
	(28, '(UTC-03:00) Montevideo', 'America/Montevideo', '-03:00'),
	(29, '(UTC-03:00) Salvador', 'America/Bahia', '-03:00'),
	(30, '(UTC-02:00) Coordinated Universal Time-02', 'Etc/GMT+2', '-02:00'),
	(31, '(UTC-02:00) Mid-Atlantic', 'Etc/GMT+2', '-02:00'),
	(32, '(UTC-01:00) Azores', 'Atlantic/Azore', '-01:00'),
	(33, '(UTC-01:00) Cape Verde Is.', 'Etc/GMT+1', '-01:00'),
	(34, '(UTC) Casablanca', 'Africa/Casablanca', '00:00'),
	(35, '(UTC) Coordinated Universal Time', 'Etc/GMT', '00:00'),
	(36, '(UTC) Dublin, Edinburgh, Lisbon, London', 'Europe/London', '00:00'),
	(37, '(UTC) Monrovia, Reykjavik', 'Atlantic/Reykjavik', '00:00'),
	(38, '(UTC+01:00) Amsterdam, Berlin, Bern, Rome, S', 'Europe/Berlin', '+01:00'),
	(39, '(UTC+01:00) Belgrade, Bratislava, Budapest, ', 'Europe/Budapest', '+01:00'),
	(40, '(UTC+01:00) Brussels, Copenhagen, Madrid, Pa', 'Europe/Paris', '+01:00'),
	(41, '(UTC+01:00) Sarajevo, Skopje, Warsaw, Zagreb', 'Europe/Warsaw', '+01:00'),
	(42, '(UTC+01:00) West Central Africa', 'Etc/GMT-1', '+01:00'),
	(43, '(UTC+01:00) Windhoek', 'Africa/Windhoek', '+01:00'),
	(44, '(UTC+02:00) Athens, Bucharest', 'Europe/Bucharest', '+02:00'),
	(45, '(UTC+02:00) Beirut', 'Asia/Beirut', '+02:00'),
	(46, '(UTC+02:00) Cairo', 'Africa/Cairo', '+02:00'),
	(47, '(UTC+02:00) Damascus', 'Asia/Damascus', '+02:00'),
	(48, '(UTC+02:00) E. Europe', 'Asia/Nicosia', '+02:00'),
	(49, '(UTC+02:00) Harare, Pretoria', 'Africa/Johannesburg', '+02:00'),
	(50, '(UTC+02:00) Helsinki, Kyiv, Riga, Sofia, Tal', 'Europe/Kiev', '+02:00'),
	(51, '(UTC+02:00) Istanbul', 'Europe/Istanbul', '+02:00'),
	(52, '(UTC+02:00) Jerusalem', 'Asia/Jerusalem', '+02:00'),
	(53, '(UTC+03:00) Amman', 'Asia/Amman', '+03:00'),
	(54, '(UTC+03:00) Baghdad', 'Asia/Baghdad', '+03:00'),
	(55, '(UTC+03:00) Kaliningrad, Minsk', 'Europe/Kaliningrad', '+03:00'),
	(56, '(UTC+03:00) Kuwait, Riyadh', 'Asia/Riyadh', '+03:00'),
	(57, '(UTC+03:00) Nairobi', 'Africa/Nairobi', '+03:00'),
	(58, '(UTC+03:30) Tehran', 'Asia/Tehran', '+03:30'),
	(59, '(UTC+04:00) Abu Dhabi, Muscat', 'Asia/Dubai', '+04:00'),
	(60, '(UTC+04:00) Baku', 'Asia/Baku', '+04:00'),
	(61, '(UTC+04:00) Moscow, St. Petersburg, Volgogra', 'Europe/Moscow', '+04:00'),
	(62, '(UTC+04:00) Port Louis', 'Indian/Mauritius', '+04:00'),
	(63, '(UTC+04:00) Tbilisi', 'Asia/Tbilisi', '+04:00'),
	(64, '(UTC+04:00) Yerevan', 'Asia/Yerevan', '+04:00'),
	(65, '(UTC+04:30) Kabul', 'Asia/Kabul', '+04:30'),
	(66, '(UTC+05:00) Islamabad, Karachi', 'Asia/Karachi', '+05:00'),
	(67, '(UTC+05:00) Tashkent', 'Etc/GMT-5', '+05:00'),
	(68, '(UTC+05:30) Chennai, Kolkata, Mumbai, New De', 'Asia/Calcutta', '+05:30'),
	(69, '(UTC+05:30) Sri Jayawardenepura', 'Asia/Colombo', '+05:30'),
	(70, '(UTC+05:45) Kathmandu', 'Asia/Katmandu', '+05:45'),
	(71, '(UTC+06:00) Astana', 'Etc/GMT-6', '+06:00'),
	(72, '(UTC+06:00) Dhaka', 'Asia/Dhaka', '+06:00'),
	(73, '(UTC+06:00) Ekaterinburg', 'Asia/Yekaterinburg', '+06:00'),
	(74, '(UTC+06:30) Yangon (Rangoon)', 'Asia/Rangoon', '+06:30'),
	(75, '(UTC+07:00) Bangkok, Hanoi, Jakarta', 'Asia/Bangkok', '+07:00'),
	(76, '(UTC+07:00) Novosibirsk', 'Asia/Novosibirsk', '+07:00'),
	(77, '(UTC+08:00) Beijing, Chongqing, Hong Kong, U', 'Asia/Shanghai', '+08:00'),
	(78, '(UTC+08:00) Krasnoyarsk', 'Asia/Krasnoyarsk', '+08:00'),
	(79, '(UTC+08:00) Kuala Lumpur, Singapore', 'Etc/GMT-8', '+08:00'),
	(80, '(UTC+08:00) Perth', 'Australia/Perth', '+08:00'),
	(81, '(UTC+08:00) Taipei', 'Asia/Taipei', '+08:00'),
	(82, '(UTC+08:00) Ulaanbaatar', 'Asia/Ulaanbaatar', '+08:00'),
	(83, '(UTC+09:00) Irkutsk', 'Asia/Irkutsk', '+09:00'),
	(84, '(UTC+09:00) Osaka, Sapporo, Tokyo', 'Etc/GMT-9', '+09:00'),
	(85, '(UTC+09:00) Seoul', 'Asia/Seoul', '+09:00'),
	(86, '(UTC+09:30) Adelaide', 'Australia/Adelaide', '+09:30'),
	(87, '(UTC+09:30) Darwin', 'Australia/Darwin', '+09:30'),
	(88, '(UTC+10:00) Brisbane', 'Australia/Brisbane', '+10:00'),
	(89, '(UTC+10:00) Canberra, Melbourne, Sydney', 'Australia/Sydney', '+10:00'),
	(90, '(UTC+10:00) Guam, Port Moresby', 'Etc/GMT-10', '+10:00'),
	(91, '(UTC+10:00) Hobart', 'Australia/Hobart', '+10:00'),
	(92, '(UTC+10:00) Yakutsk', 'Asia/Yakutsk', '+10:00'),
	(93, '(UTC+11:00) Solomon Is., New Caledonia', 'Etc/GMT-11', '+11:00'),
	(94, '(UTC+11:00) Vladivostok', 'Asia/Vladivostok', '+11:00'),
	(95, '(UTC+12:00) Auckland, Wellington', 'Pacific/Auckland', '+12:00'),
	(96, '(UTC+12:00) Coordinated Universal Time+12', 'Etc/GMT-12', '+12:00'),
	(97, '(UTC+12:00) Fiji', 'Pacific/Fiji', '+12:00'),
	(98, '(UTC+12:00) Magadan', 'Asia/Magadan', '+12:00'),
	(99, '(UTC+13:00) Nuku\'alofa', 'Etc/GMT-13', '+13:00'),
	(100, '(UTC+13:00) Samoa', 'Pacific/Apia', '+13:00');
/*!40000 ALTER TABLE `timezones` ENABLE KEYS */;


-- Dumping structure for table querendo.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) NOT NULL DEFAULT '',
  `balance` float DEFAULT NULL,
  `balance_status` enum('active','inactive') CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(100) CHARACTER SET latin1 NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `city` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `state` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `postal_code` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `country` int(3) DEFAULT NULL,
  `timezone` int(11) DEFAULT NULL,
  `company` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `password` varchar(255) CHARACTER SET latin1 NOT NULL,
  `profile_pic` varchar(255) CHARACTER SET latin1 NOT NULL,
  `member_since` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `contact_address` varchar(255) CHARACTER SET latin1 NOT NULL,
  `contact_number` varchar(100) CHARACTER SET latin1 NOT NULL,
  `shipping_address` varchar(255) CHARACTER SET latin1 NOT NULL,
  `about` text,
  `fax` varchar(100) CHARACTER SET latin1 NOT NULL,
  `buyer_review` double NOT NULL,
  `buyer_review_count` double NOT NULL,
  `seller_review` double NOT NULL,
  `seller_review_count` double NOT NULL,
  `email_verify` varchar(255) CHARACTER SET latin1 NOT NULL,
  `forgotPassword` varchar(100) CHARACTER SET latin1 NOT NULL,
  `fb_login` enum('0','1') CHARACTER SET latin1 NOT NULL,
  `status` enum('1','0') CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Dumping data for table querendo.user: ~6 rows (approximately)
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `user_name`, `balance`, `balance_status`, `email`, `first_name`, `last_name`, `city`, `state`, `postal_code`, `country`, `timezone`, `company`, `password`, `profile_pic`, `member_since`, `contact_address`, `contact_number`, `shipping_address`, `about`, `fax`, `buyer_review`, `buyer_review_count`, `seller_review`, `seller_review_count`, `email_verify`, `forgotPassword`, `fb_login`, `status`) VALUES
	(1, 'rafi', 5000, NULL, 'me@rafi.pro', 'Faozul', 'Tarafder', '', '', '', 101, 54, '', '', 'Sc15TmPQ.jpg', '2014-07-17 16:38:38', '', '', 'Dhaka', '....................', '', 0, 0, 0, 0, '1', '', '1', '1'),
	(3, 'amieami', 0, NULL, 'ridwanul.hafiz@gmail.com', NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', '', '2014-07-19 11:17:54', '', '', '', NULL, '', 5, 1, 2.6666666666667, 3, '1', '', '0', '1'),
	(4, 'aajahid', 0, NULL, 'abdullah_al_jahid@yahoo.com', 'Abdullah', 'Jahid', NULL, NULL, NULL, NULL, NULL, NULL, '', 'LAsEV4mi.jpg', '2014-07-19 11:29:30', '', '', '', 'Winner of Basis Freelancer Award 2011. Working hard with all latest web technology to develop Custom web application and API.', '', 0, 0, 0, 0, '1', '', '1', '1'),
	(6, 'rafi_ccj', 0, NULL, 'rafi@dwetech.com', '', '', '', '', '', 11, 54, '', '685f188e4f25af63603dc5b579b31090f459381a242bf7002c8a8e8ea322a4ef', '', '2014-07-19 11:42:16', '', '', '', '', '', 5, 3, 5, 1, '1', '', '0', '1'),
	(7, 'jahid', 0, NULL, 'abdullah.al.jahid@gmail.com', '', '', '', '', '', 0, 72, '', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'bSF5J3nK.jpg', '2014-07-21 12:12:46', '', '', '', '', '', 0, 0, 0, 0, '1', '', '0', '1'),
	(8, 'suvo', 0, NULL, 'me@suvo.me', 'আমি', 'কেউ নাহ', NULL, NULL, NULL, NULL, NULL, NULL, '', '7vvQsN6T.jpg', '2014-08-02 12:03:53', '', '', '', 'সংবিধিবদ্ধ সতর্কীকরণঃ আওয়ামিলীগ সবার জন্য ক্ষতিকর ।\nকোন আওয়ামীলীগ অথবা ১৪ গুষ্টিতে কোন আম্লিগ আছে , ধর্মনিরপেক্ষ , নাস্তিক , বুদ্ধিকম পাবলিক  আমারে এ্যাড দেওনের কখা চিন্তাও করবা না ........\n\n__________________________________________________\n\n\n\n\nযে আমারে চেনে তার কাছে আমি অনেক কিছু , যে আমরে চেনে না তার কাছে আমি কেউ নাহ....\n\nসাধাসিধে, জীবন নিয়ে কোন অভিযোগ নেই। কেউ কেমন আছি জানতে চাইলে খুব খুশি মনেই বলতে পারি -- ভালো আছি :)\n\nআমি খুব বেশি সাধারণ টাইপ ... নিজেকে এবং নিজের প্রতিভা গুলা লুকায় রাখতে ই বেশি পছন্দ করি....\n\nপছন্দ করি হাটা হাটি করতে ... অনেক রাত জাগতে...\n\nআমি মহা ভয়াবহ , কঠিন ফাউল টাইপ ছাত্র ...... তয় আমার মেলা বুদ্ধি .....\nবুদ্ধির জ্বালায় রাইতে ঠিক মতন ঘুমাইতে পারি নাহ...\n\nতার পরেও আমি আর দশ টা মানুষের মত ই মানুষ । খাই দাই, ঘুমাই, বাথরুমে যাই.......কেম্পাস এ যাই, ক্লাস করি.......পরীক্ষাতে ফেল করি......নিজেকে নিয়ে কিছু লেখার নাই\nযদিও অনেক কিছু লিখে ফেলছি ⊙▂⊙\n\n\n...........___\n........../`.,-\\......... _.____\n..........|_c..\'}........|-|......|._\n.___.....)_._/.........|.|......|...|\n[___].../..`\\______.\'|.|......|_,\'\n|..^|../..\\_______/).|-|___|\n|....|./....../......._:::_))_(___\n|....|/`-._/____..|___________|\n`-;_|\\________.`\\.\'||"""""""""||\n.....|.`#####|__|\'||.........||\n......\\.._....._,{~-_}|.........||\n....._).......(...{-__}|.........||\n..../______`\\..|_,__).........||', '', 0, 0, 0, 0, '1', '', '1', '1');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;


-- Dumping structure for table querendo.withdraw_request
DROP TABLE IF EXISTS `withdraw_request`;
CREATE TABLE IF NOT EXISTS `withdraw_request` (
  `withdraw_id` int(100) NOT NULL AUTO_INCREMENT,
  `user_id` int(100) NOT NULL DEFAULT '0',
  `status` enum('pending','success','hold','cancel') DEFAULT NULL,
  `amount` varchar(100) DEFAULT NULL,
  `method` varchar(100) DEFAULT NULL,
  `details` text,
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`withdraw_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table querendo.withdraw_request: ~0 rows (approximately)
DELETE FROM `withdraw_request`;
/*!40000 ALTER TABLE `withdraw_request` DISABLE KEYS */;
/*!40000 ALTER TABLE `withdraw_request` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
