-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Wersja serwera:               5.7.20-0ubuntu0.16.04.1 - (Ubuntu)
-- Serwer OS:                    Linux
-- HeidiSQL Wersja:              9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Zrzut struktury tabela quizengine.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` varchar(50) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `parentuid` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli quizengine.categories: ~2 rows (około)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`id`, `uid`, `name`, `parentuid`) VALUES
	(1, 'category550737a6d367f', 'Słówka', '0'),
	(2, 'category550737dd2c5eb', 'Język angielski', '0');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

-- Zrzut struktury tabela quizengine.questions
CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `quizuid` varchar(50) NOT NULL DEFAULT '',
  `question` varchar(1000) NOT NULL DEFAULT '',
  `answer` varchar(1000) NOT NULL DEFAULT '',
  `answertype` varchar(50) NOT NULL DEFAULT '',
  `timelimt` int(10) NOT NULL DEFAULT '0',
  `sequence` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=188 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli quizengine.questions: ~149 rows (około)
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` (`id`, `quizuid`, `question`, `answer`, `answertype`, `timelimt`, `sequence`) VALUES
	(1, 'quiz5504321244cd1', 'el pan', 'chleb', 'radio', 0, 1),
	(2, 'quiz5504321244cd1', 'la leche', 'mleko', 'text', 0, 2),
	(3, 'quiz5504321244cd1', 'la cafe', 'kawa', 'text', 0, 3),
	(5, 'quiz55043754b53d5', 'Ewa', 'Kopacz', 'radio', 0, 6),
	(7, 'quiz55045d1ed7c27', '1920', 'bitwa Warszawska', 'radio', 0, 10),
	(8, 'quiz55045d1ed7c27', '1939', 'wybuch II wojny światowej', 'radio', 0, 11),
	(17, 'quiz55043754b53d5', 'Donald', 'Tusk', 'radio', 0, 7),
	(19, 'quiz55043754b53d5', 'Bronisław', 'Komorowski', 'radio', 0, 8),
	(20, 'quiz55043754b53d5', 'Vaclav', 'Klaus', 'radio', 0, 9),
	(21, 'quiz55043754b53d5', 'Stanisław', 'Żelichowski', 'radio', 0, 4),
	(22, 'quiz55043754b53d5', 'Małgorzata', 'Kidawa-Błońska', 'radio', 0, 5),
	(23, 'quiz55043754b53d5', 'David', 'Cameron', 'text', 0, 10),
	(24, 'quiz55043754b53d5', 'Angela', 'Merkel', 'radio', 0, 11),
	(25, 'quiz55043754b53d5', 'Silvio', 'Berlusconi', 'radio', 0, 2),
	(26, 'quiz55043754b53d5', 'Petro', 'Poroszenko', 'radio', 0, 3),
	(27, 'quiz55043754b53d5', 'Antonis', 'Samaras', 'radio', 0, 12),
	(29, 'quiz55043754b53d5', 'Arsenij', 'Jaceniuk', 'radio', 0, 1),
	(30, 'quiz55046d619ee39', 'bread', 'chleb', 'radio', 0, 1),
	(32, 'quiz55045d1ed7c27', '1410', 'bitwa pod Grunwaldem', 'radio', 0, 8),
	(34, 'quiz55045d1ed7c27', '1864', 'powstanie styczniowe', 'radio', 0, 9),
	(35, 'quiz5504321244cd1', 'la merluza', 'morszczuk', 'text', 0, 4),
	(36, 'quiz550584c2bca4d', 'trout', 'pstrąg', 'radio', 0, 3),
	(37, 'quiz550584c2bca4d', 'scattered', 'rozprowadzone', 'radio', 0, 4),
	(38, 'quiz550584c2bca4d', 'to squirm', 'zmienić swój kurs', 'radio', 0, 5),
	(39, 'quiz550584c2bca4d', 'in full swing', 'w pełni, na pełnym gazie', 'radio', 0, 6),
	(40, 'quiz550584c2bca4d', 'to cope with', 'sprostać', 'radio', 0, 7),
	(41, 'quiz550584c2bca4d', 'to set off', 'odpalać', 'radio', 0, 8),
	(42, 'quiz550584c2bca4d', 'to defy', 'opierać się', 'radio', 0, 9),
	(43, 'quiz550584c2bca4d', 'to twirl', 'to spin', 'radio', 0, 10),
	(44, 'quiz550584c2bca4d', 'to flip', 'to toss', 'radio', 0, 11),
	(45, 'quiz550584c2bca4d', 'inspire awe', 'powodować zdziwienie', 'radio', 0, 12),
	(46, 'quiz550584c2bca4d', 'faint-hearted', 'nielubiący ryzyka', 'radio', 0, 13),
	(47, 'quiz550584c2bca4d', 'stardom', 'sława', 'radio', 0, 14),
	(48, 'quiz550584c2bca4d', 'persistence', 'wytrwałość', 'radio', 0, 15),
	(49, 'quiz550584c2bca4d', 'at stake', 'at risk', 'radio', 0, 16),
	(50, 'quiz550584c2bca4d', 'notorious', 'osławiony', 'radio', 0, 17),
	(51, 'quiz550584c2bca4d', 'dress code', 'zasady ubioru', 'radio', 0, 18),
	(52, 'quiz550584c2bca4d', 'to cause a stir', 'to create a lot of attention', 'radio', 0, 19),
	(53, 'quiz550584c2bca4d', 'to comprise of', 'składać się z', 'radio', 0, 20),
	(54, 'quiz550584c2bca4d', 'prestigious', 'very important', 'radio', 0, 21),
	(55, 'quiz550584c2bca4d', 'to appal', 'to disgust', 'radio', 0, 22),
	(56, 'quiz550584c2bca4d', 'willpower', 'siła woli', 'radio', 0, 23),
	(57, 'quiz550584c2bca4d', 'twist', 'turn quickly', 'radio', 0, 24),
	(58, 'quiz550584c2bca4d', 'on a whim', 'pod wpływem impulsu', 'radio', 0, 25),
	(59, 'quiz550584c2bca4d', 'nooks and crannies', 'little corners', 'radio', 0, 26),
	(60, 'quiz550584c2bca4d', 'hearty meal', 'obfity posiłek', 'radio', 0, 27),
	(61, 'quiz550584c2bca4d', 'bizarre', 'weird', 'radio', 0, 28),
	(62, 'quiz550584c2bca4d', 'set alight', 'set on fire', 'radio', 0, 29),
	(63, 'quiz550584c2bca4d', 'pick out', 'wybrać', 'radio', 0, 30),
	(64, 'quiz550584c2bca4d', 'reluctantly', 'niechętnie', 'radio', 0, 31),
	(65, 'quiz550584c2bca4d', 'embrace', 'objąć/przyjąć z radością', 'radio', 0, 32),
	(66, 'quiz550584c2bca4d', 'to shake off fears', 'get rid of fears', 'radio', 0, 33),
	(67, 'quiz550584c2bca4d', 'dismantle', 'rozłożyć', 'radio', 0, 34),
	(68, 'quiz550584c2bca4d', 'makeshift', 'prowizoryczny', 'radio', 0, 35),
	(69, 'quiz550584c2bca4d', 'catwalk', 'runway', 'radio', 0, 36),
	(70, 'quiz550584c2bca4d', 'lifelike', 'realistic', 'radio', 0, 37),
	(71, 'quiz550584c2bca4d', 'brief look', 'glimpse', 'radio', 0, 38),
	(72, 'quiz550584c2bca4d', 'to top', 'osiągnąć najwyższe miejsce', 'radio', 0, 39),
	(73, 'quiz550584c2bca4d', 'grumpy (opp.)', 'cheerful', 'radio', 0, 40),
	(74, 'quiz550584c2bca4d', 'star-studded cast', 'gwiazdorska obsada', 'radio', 0, 41),
	(75, 'quiz550584c2bca4d', 'virtual', 'simulated', 'radio', 0, 42),
	(76, 'quiz550584c2bca4d', 'decour', 'wystrój', 'radio', 0, 43),
	(77, 'quiz550584c2bca4d', 'cramped (opp.)', 'spacious', 'radio', 0, 44),
	(78, 'quiz550584c2bca4d', 'keep a straight face', 'have a poker face', 'radio', 0, 45),
	(79, 'quiz550584c2bca4d', 'aches and pains', 'feelings of discomfort in body', 'radio', 0, 46),
	(80, 'quiz550584c2bca4d', 'juggler', 'żongler', 'radio', 0, 47),
	(81, 'quiz550584c2bca4d', 'stilt walker', 'chodzący na szczudłach', 'radio', 0, 48),
	(82, 'quiz550584c2bca4d', 'ringmaster', 'reżyser programu cyrkowego', 'radio', 0, 49),
	(83, 'quiz550584c2bca4d', 'tightrope walker', 'linoskoczek', 'radio', 0, 50),
	(84, 'quiz550584c2bca4d', 'purposely', 'intentionally/deliberately', 'radio', 0, 51),
	(85, 'quiz550584c2bca4d', 'serve a purpose', 'have a reason', 'radio', 0, 52),
	(86, 'quiz550584c2bca4d', 'sidekick', 'helper', 'radio', 0, 53),
	(87, 'quiz550584c2bca4d', 'lead role', 'główna rola', 'radio', 0, 54),
	(88, 'quiz550584c2bca4d', 'thoroughly', 'całkowicie', 'radio', 0, 55),
	(89, 'quiz550584c2bca4d', 'superb', 'wspaniały/wyborowy', 'radio', 0, 56),
	(90, 'quiz550584c2bca4d', 'to tile', 'pokryć dachówkami', 'radio', 0, 57),
	(91, 'quiz550584c2bca4d', 'sanitation', 'urządzenia sanitarne', 'radio', 0, 58),
	(92, 'quiz550584c2bca4d', 'rough (f.e. rough number of festivalgoers)', 'not exact', 'radio', 0, 59),
	(93, 'quiz5504321244cd1', 'la manzana', 'jabłko', 'radio', 0, 5),
	(94, 'quiz5504321244cd1', 'el tomate', 'pomidor', 'radio', 0, 6),
	(95, 'quiz5504321244cd1', 'la cerveza', 'piwo', 'radio', 0, 7),
	(96, 'quiz55045d1ed7c27', '1989', 'upadek komunizmu w Polsce', 'radio', 0, 15),
	(97, 'quiz55045d1ed7c27', '1980', 'strajk "Solidarności"', 'radio', 0, 14),
	(98, 'quiz55045d1ed7c27', '1945', 'koniec II wojny światowej', 'radio', 0, 12),
	(99, 'quiz550584c2bca4d', 'justified', 'uzasadniony', 'radio', 0, 60),
	(100, 'quiz550584c2bca4d', 'keyboard', 'klawiatura', 'text', 0, 1),
	(101, 'quiz550584c2bca4d', 'mouse', 'mysz', 'text', 0, 2),
	(102, 'quiz5509e3aa64bd4', '23+67=', '90', 'text', 0, 1),
	(103, 'quiz5509e3aa64bd4', '34+90=', '124', 'text', 0, 2),
	(104, 'quiz5509e3aa64bd4', '34-70 =', '-36', 'text', 0, 3),
	(105, 'quiz5509e3aa64bd4', '56+80=', '136', 'text', 0, 4),
	(125, 'quiz5509f24e63035', 'siempre', 'zawsze', 'text', 0, 1),
	(126, 'quiz5509f24e63035', 'cada poco', 'co chwilę', 'text', 0, 2),
	(127, 'quiz5509f24e63035', 'a menudo', 'często', 'text', 0, 3),
	(128, 'quiz5509f24e63035', 'diariamente', 'codziennie', 'radio', 0, 4),
	(129, 'quiz5509f24e63035', 'todas las semanas', 'co tydzień', 'radio', 0, 5),
	(130, 'quiz5509f24e63035', 'a veces', 'czasami', 'text', 0, 6),
	(131, 'quiz5509f24e63035', 'una vez a la semana', 'raz w tygodniu', 'radio', 0, 7),
	(132, 'quiz5509f24e63035', 'de vez', 'od czasu do czasu', 'radio', 0, 8),
	(133, 'quiz5509f24e63035', 'raramente', 'rzadko', 'text', 0, 9),
	(134, 'quiz5509f24e63035', 'casi nunca', 'prawie nigdy', 'radio', 0, 10),
	(135, 'quiz5509f24e63035', 'nunca', 'nigdy', 'radio', 0, 11),
	(137, 'quiz5509f510f2ac3', 'buscar', 'szukać', 'text', 0, 1),
	(138, 'quiz5509f510f2ac3', 'esperar', 'czekać', 'radio', 0, 2),
	(139, 'quiz5509f510f2ac3', 'pagar', 'płacić', 'text', 0, 3),
	(140, 'quiz5509f510f2ac3', 'volver', 'wracać', 'text', 0, 4),
	(141, 'quiz5509f510f2ac3', 'salir', 'wyjeżdżać', 'text', 0, 5),
	(142, 'quiz5509f510f2ac3', 'andar', 'iść', 'text', 0, 6),
	(143, 'quiz5509f510f2ac3', 'subir', 'wchodzić', 'text', 0, 7),
	(144, 'quiz5509f510f2ac3', 'bajar', 'schodzić', 'text', 0, 8),
	(145, 'quiz5509f510f2ac3', 'encender', 'włączać', 'text', 0, 9),
	(146, 'quiz5509f510f2ac3', 'enviar', 'wysyłać', 'text', 0, 10),
	(147, 'quiz5509f510f2ac3', 'firmar', 'podpisywać', 'text', 0, 11),
	(148, 'quiz5509f510f2ac3', 'abrir', 'otwierać', 'text', 0, 12),
	(149, 'quiz5509f510f2ac3', 'cerrar', 'zamykać', 'text', 0, 13),
	(150, 'quiz5509f510f2ac3', 'conducir', 'prowadzić', 'text', 0, 14),
	(151, 'quiz5509f510f2ac3', 'vestirse', 'ubierać się', 'text', 0, 15),
	(152, 'quiz5509f510f2ac3', 'partir', 'odjeżdżać', 'text', 0, 16),
	(153, 'quiz5509f510f2ac3', 'llegar', 'przyjeżdżać', 'text', 0, 17),
	(156, 'quiz55045d1ed7c27', '966', 'chrzest Polski', 'radio', 0, 1),
	(157, 'quiz55045d1ed7c27', '1000', 'zjazd Gnieźnieński', 'radio', 0, 2),
	(158, 'quiz55045d1ed7c27', '1138', 'rozbicie dzielnicowe', 'radio', 0, 4),
	(159, 'quiz55045d1ed7c27', '1025', 'koronacja Bolesława Chrobrego', 'radio', 0, 3),
	(160, 'quiz55045d1ed7c27', '1320', 'koronacja Władysława Łokietka', 'radio', 0, 5),
	(161, 'quiz55045d1ed7c27', '1970', 'starcie stoczniowców z wojskiem w Gdynii', 'radio', 0, 13),
	(162, 'quiz55045d1ed7c27', '2000', 'nowe Tysiąclecie', 'radio', 0, 16),
	(163, 'quiz55043754b53d5', 'Radosław', 'Sikorski', 'radio', 0, 13),
	(164, 'quiz55045d1ed7c27', '1364', 'utworzenie Akademii Krakowskiej', 'radio', 0, 6),
	(165, 'quiz55045d1ed7c27', '1374', 'przywilej Koszycki', 'radio', 0, 7),
	(166, 'quiz550e29ccf3a8b', 'Warszawa', 'Polska', 'radio', 0, 1),
	(167, 'quiz550e29ccf3a8b', 'Budapeszt', 'Węgry', 'text', 0, 2),
	(168, 'quiz550e29ccf3a8b', 'Berlin', 'Niemcy', 'text', 0, 5),
	(169, 'quiz550e29ccf3a8b', 'Londyn', 'Wielka Brytania', 'radio', 0, 3),
	(170, 'quiz550e29ccf3a8b', 'Paryż', 'Francja', 'radio', 0, 4),
	(171, 'quiz550e29ccf3a8b', 'Rzym', 'Włochy', 'radio', 0, 6),
	(172, 'quiz550e29ccf3a8b', 'Kijów', 'Ukraina', 'radio', 0, 7),
	(173, 'quiz550e29ccf3a8b', 'Sarajewo', 'Bośnia i Hercegowina', 'radio', 0, 8),
	(174, 'quiz550e29ccf3a8b', 'Skopje', 'Macedonia', 'radio', 0, 9),
	(176, 'quiz550e29ccf3a8b', 'Madryt', 'Hiszpania', 'text', 0, 10),
	(177, 'quiz550e29ccf3a8b', 'Mińsk', 'Białoruś', 'radio', 0, 11),
	(178, 'quiz550e29ccf3a8b', 'Ryga', 'Łotwa', 'radio', 0, 12),
	(179, 'quiz550e29ccf3a8b', 'Talinn', 'Estonia', 'radio', 0, 13),
	(180, 'quiz550e29ccf3a8b', 'Wilno', 'Litwa', 'radio', 0, 15),
	(181, 'quiz550e29ccf3a8b', 'Moskwa', 'Rosja', 'radio', 0, 16),
	(182, 'quiz550e29ccf3a8b', 'Sztokholm', 'Szwecja', 'radio', 0, 17),
	(183, 'quiz550e29ccf3a8b', 'Helsinki', 'Finlandia', 'radio', 0, 18),
	(184, 'quiz550e29ccf3a8b', 'Oslo', 'Norwegia', 'radio', 0, 19),
	(186, 'quiz550e29ccf3a8b', 'Ateny', 'Grecja', 'text', 0, 14),
	(187, 'quiz550e29ccf3a8b', 'Bukareszt', 'Rumunia', 'text', 0, 20);
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;

-- Zrzut struktury tabela quizengine.quizes
CREATE TABLE IF NOT EXISTS `quizes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `quizuid` varchar(50) NOT NULL DEFAULT '',
  `owneruid` varchar(50) NOT NULL DEFAULT '',
  `name` varchar(200) NOT NULL DEFAULT '',
  `categoryuid` varchar(50) NOT NULL DEFAULT '',
  `permission` enum('PRI','RES','SEL','PUB') NOT NULL DEFAULT 'PRI',
  `modes` varchar(10) NOT NULL DEFAULT '111',
  `pictureurl` varchar(512) NOT NULL DEFAULT '',
  `addeddate` varchar(50) NOT NULL DEFAULT '',
  `addedhour` varchar(50) NOT NULL DEFAULT '',
  `timesdone` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli quizengine.quizes: ~10 rows (około)
/*!40000 ALTER TABLE `quizes` DISABLE KEYS */;
INSERT INTO `quizes` (`id`, `quizuid`, `owneruid`, `name`, `categoryuid`, `permission`, `modes`, `pictureurl`, `addeddate`, `addedhour`, `timesdone`) VALUES
	(19, 'quiz5504321244cd1', 'user54ec0ed11d3bc', 'Palabras - la comida y la bebida', '', 'PUB', '111', 'http://www.monografias.com/trabajos76/comida-bebida-patogenos-especificos-obesidad/image011.jpg', '14.03.15', '14:05:22', 15),
	(20, 'quiz55043754b53d5', 'user54ec0ed11d3bc', 'Europejscy politycy - imona i nazwiska', '', 'PUB', '101', 'http://www.praca.pl/pressroom/poradniki/350x200/keynote1.png', '14.03.15', '14:27:48', 5),
	(21, 'quiz55045d1ed7c27', 'user54ec0ed11d3bc', 'Daty historyczne', '', 'PUB', '111', 'http://share.nanjing-school.com/8humanities/files/2015/08/history-image-1dh81eg.jpg', '14.03.15', '17:09:02', 8),
	(22, 'quiz55046d619ee39', 'user54eb2e2ed528f', 'Quiz1', '', 'PRI', '111', '', '14.03.15', '18:18:25', 0),
	(23, 'quiz550584c2bca4d', 'user54ec0ed11d3bc', 'Words - Matura Prime Time B2+ module 4', '', 'PUB', '111', 'https://assets.merriam-webster.com/mw/images/video/vid-video-play-lg/video-how-a-word-gets-into-the-dicionary-1149@1x.jpg', '15.03.15', '14:10:26', 3),
	(24, 'quiz5509e3aa64bd4', 'user54ec0ed11d3bc', 'Prosta arytmetyka', '', 'PUB', '010', 'https://devcentral.f5.com/weblogs/images/devcentral_f5_com/weblogs/Joe/WindowsLiveWriter/PowerShellABCsAisforArithmeticOperators_CEC8/math%20symbols_2.jpg', '18.03.2015', '21:44:26', 2),
	(26, 'quiz5509f24e63035', 'user54ec0ed11d3bc', 'Español - frecuencia', '', 'PUB', '111', 'http://www.liberatutalento.com/wp-content/uploads/2014/12/tiempo.jpg', '18.03.2015', '22:46:54', 5),
	(27, 'quiz5509f510f2ac3', 'user54ec0ed11d3bc', 'Español - verbos (acciones)', '', 'PUB', '111', 'https://s-media-cache-ak0.pinimg.com/originals/8c/ba/cb/8cbacbc4fe418e392a73d7b1f830dc2d.png', '18.03.2015', '22:58:40', 3),
	(28, 'quiz550e29ccf3a8b', 'user54ec0ed11d3bc', 'Stolice Europy', '', 'PUB', '111', 'http://upload.wikimedia.org/wikipedia/commons/0/0e/Europe_countries_map_en_2.png', '22.03.2015', '03:32:45', 6),
	(29, 'quiz550f158db5e1b', 'user54ec0ed11d3bc', '12345678901234567890 12345678901234567890 12345678901234567890 12345678901234567890 12345678901234567890', '', 'PRI', '111', '', '22.03.2015', '20:18:37', 0);
/*!40000 ALTER TABLE `quizes` ENABLE KEYS */;

-- Zrzut struktury tabela quizengine.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `useruid` varchar(20) NOT NULL DEFAULT '',
  `username` varchar(255) NOT NULL DEFAULT '',
  `nameandsurname` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `profilepicture` varchar(255) NOT NULL DEFAULT 'none',
  `email` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli quizengine.users: ~5 rows (około)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `useruid`, `username`, `nameandsurname`, `password`, `profilepicture`, `email`) VALUES
	(4, 'user54eb2e2ed528f', 'XavierIks', 'Ksawery Iksiński', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'none', 'xavier1234@gmail.com'),
	(9, 'user550f45c024a70', 'edfsdf', 'sdfsdf', '961b6dd3ede3cb8ecbaacbd68de040cd78eb2ed5889130cceb4c49268ea4d506', 'none', 'mu@');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
