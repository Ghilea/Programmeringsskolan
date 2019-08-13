-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Värd: 127.0.0.1:3306
-- Tid vid skapande: 23 jul 2019 kl 17:12
-- Serverversion: 5.7.24
-- PHP-version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `programmeringsskolan`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `account`
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE IF NOT EXISTS `account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_information_id` int(11) NOT NULL,
  `account_payment_id` int(11) NOT NULL,
  `account_settings_id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `account_information_id` (`account_information_id`),
  KEY `account_setup_id` (`account_settings_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `account`
--

INSERT INTO `account` (`id`, `account_information_id`, `account_payment_id`, `account_settings_id`, `password`, `image`) VALUES
(1, 1, 0, 1, '$2y$10$OQQ2xYEnWRorIN2Ia97.j.1P634.nPCCjqjGpTHZjsSd5y/YiIQ/u', '1_small_558573990.jpg');

-- --------------------------------------------------------

--
-- Tabellstruktur `account_course`
--

DROP TABLE IF EXISTS `account_course`;
CREATE TABLE IF NOT EXISTS `account_course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `education_id` int(11) NOT NULL,
  `education_task` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `education_id` (`education_id`),
  KEY `account_id` (`account_id`),
  KEY `education_task` (`education_task`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `account_information`
--

DROP TABLE IF EXISTS `account_information`;
CREATE TABLE IF NOT EXISTS `account_information` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `yearOfBirth` varchar(12) NOT NULL,
  `system_gender_id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `zipCode` int(5) NOT NULL,
  `phoneNumber` varchar(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `system_gender_id` (`system_gender_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `account_information`
--

INSERT INTO `account_information` (`id`, `firstname`, `lastname`, `yearOfBirth`, `system_gender_id`, `address`, `city`, `zipCode`, `phoneNumber`, `email`) VALUES
(1, 'Dennis', 'Karlsson', '198804301471', 1, 'Högbergsgatan 9', 'Gävle', 80286, '0721524559', 'tougent@gmail.com');

-- --------------------------------------------------------

--
-- Tabellstruktur `account_order`
--

DROP TABLE IF EXISTS `account_order`;
CREATE TABLE IF NOT EXISTS `account_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `system_order_order_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `system_order_order_id` (`system_order_order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `account_payment`
--

DROP TABLE IF EXISTS `account_payment`;
CREATE TABLE IF NOT EXISTS `account_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `system_payment_id` int(11) DEFAULT NULL,
  `status` enum('Obetald','Betald') NOT NULL DEFAULT 'Obetald',
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`),
  KEY `system_payment_id` (`system_payment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `account_payment`
--

INSERT INTO `account_payment` (`id`, `account_id`, `system_payment_id`, `status`, `date`) VALUES
(1, 1, 1, 'Obetald', '2019-06-10'),
(2, 1, 2, 'Betald', '2019-07-21'),
(3, 1, 2, 'Obetald', '2019-07-15');

-- --------------------------------------------------------

--
-- Tabellstruktur `account_settings`
--

DROP TABLE IF EXISTS `account_settings`;
CREATE TABLE IF NOT EXISTS `account_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `system_privilege_id` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `suspended` int(11) DEFAULT NULL,
  `mailReceived` int(11) DEFAULT NULL,
  `profile_image` enum('Visa inte','Visa') NOT NULL,
  `email` enum('Visa inte','Visa') NOT NULL,
  `phoneNumber` enum('Visa inte','Visa') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_privilege_id` (`system_privilege_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `account_settings`
--

INSERT INTO `account_settings` (`id`, `system_privilege_id`, `status`, `suspended`, `mailReceived`, `profile_image`, `email`, `phoneNumber`) VALUES
(1, 5, 1, NULL, NULL, 'Visa inte', 'Visa inte', 'Visa inte');

-- --------------------------------------------------------

--
-- Tabellstruktur `education`
--

DROP TABLE IF EXISTS `education`;
CREATE TABLE IF NOT EXISTS `education` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `difficulty` enum('Lätt','Medel','Svår') NOT NULL,
  `sticked` enum('Inaktiv','Aktiv') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `education`
--

INSERT INTO `education` (`id`, `account_id`, `title`, `content`, `image`, `difficulty`, `sticked`) VALUES
(1, 1, 'C#', 'C# (utläses \"C sharp\") är ett programmeringsspråk ursprungligen utvecklat av Microsoft som en ersättare till C++.', '1_small_367061270.png', 'Medel', 'Inaktiv'),
(2, 1, 'JavaScript', 'Javascript har gått ifrån att vara ett enkelt scriptspråk för små effekter på webben, till att göra mer avancerad frontutveckling.', '2_small_352280213.png', 'Medel', 'Inaktiv'),
(3, 1, 'PHP', 'PHP (\"PHP: Hypertext Preprocessor\", tidigare \"Personal Home Page\") är idag tveklöst det mest populära språket på internet. Det är språket bakom populära CMS och plattformar så som Wordpress, Joomla och Drupal.\r\n\r\nMan räknar med att cirka 80% av alla världens webbplatser använder sig av PHP.', '3_small_1652425528.png', 'Medel', 'Inaktiv'),
(4, 1, 'HTML5', 'HTML (HyperText Markup Language) \"är internet\" enkelt uttryckt.\r\n\r\nDet är med hjälp av HTML som kod struktureras upp och sedan tolkas av webbläsaren för att presentera en webbplats. \r\n\r\nIdag använder sig dock oftast av server side-språk (i de allra flesta fallen) som genererar HTML-kod istället för att koda HTML från grunden för alla en webbplats sidor som man gjorde förr. \r\n\r\nSenaste standarden är HTML5 som tillgängliggör en rad nya API:er och taggar.', '4_small_1160568544.png', 'Lätt', 'Inaktiv'),
(5, 1, 'Java', 'Java är ett objektorienterat programmeringsspråk ursprungligen utvecklat av Sun Microsystems (senare uppköpta av Oracle). Syntaxen lånar mycket från C, C++ och Smalltalk.', '5_small_2050309261.png', 'Svår', 'Inaktiv'),
(6, 1, 'CSS3', 'CSS (Cascading Style Sheets) är det språket som möjliggör design på webben.\r\n\r\nMed CSS så skriver man enkel kod som sedan webbläsaren tolkar som grafik. \r\n\r\nCSS har funnits med nästan ända sedan internets födelse, och har genomgått flera version. Just nu är det CSS3 som är aktuell, och duktiga utvecklare upptäcker hela tiden nya metoder och arbetssätt för att göra webben bättre med hjälp av CSS.', '6_small_1766781351.png', 'Lätt', 'Inaktiv'),
(7, 1, 'C++', 'C++ (\"C plus plus\") är ett programmeringsspråk skapat främst för att programmera emot inbäddade system (så som t.ex. telefonväxlar och rymdsonder). \r\n\r\nProgrammeringsspråket är dock kanske mest känt för att vara extremt snabbt och effektivt, och används därför inom vitt skilda områden, så som t.ex. spelprogrammering. C++ har även används i ett fåtal riktigt stora webbplatser, där kanske den amerikanska dejtingsajten \"OkCupid\" är den mest kända.', '7_small_339427760.png', 'Svår', 'Inaktiv'),
(8, 1, 'Python', '', '8_small_2021776091.jpg', 'Medel', 'Inaktiv'),
(9, 1, 'Introduktion', 'Denna kurs kommer gå igenom mer grundläggande saker om programmeringen för de som är helt ny inom detta område. För dig som redan har förståelse för vad programmering är och lite mer grundläggande förståelse för något av alla de språk som finns kan denna kurs  uteslutas.', '9_small_1025297122.jpg', 'Lätt', 'Aktiv');

-- --------------------------------------------------------

--
-- Tabellstruktur `education_task`
--

DROP TABLE IF EXISTS `education_task`;
CREATE TABLE IF NOT EXISTS `education_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `education_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `difficulty` enum('Lätt','Medel','Svår') NOT NULL,
  `sticked` enum('Inaktiv','Aktiv') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`education_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `education_task`
--

INSERT INTO `education_task` (`id`, `education_id`, `title`, `content`, `image`, `difficulty`, `sticked`) VALUES
(1, 1, '1. Variabel (c#)', 'Vad är en variabel och hur fungerar dessa inom programmeringens värld?\r\n\r\nEn variabel kan liknas som en post-it lapp där du skriver en mening eller ett ord, mer kan post-it lappen inte få plats mer. Om du behöver skriva in en annan mening eller ett ord får du ta en ny post-it lapp eller sudda ut det andra innan du kan skriva något nytt. Med andra ord kan man spara något som kan användas vid ett senare tillfälle, ungefär som komihåg meddelanden.\r\n\r\nInom programmeringen förekommer variabeln i stort sätt hela tiden, och precis som med en post-it lapp kan vi använda flera olika om det skulle behövas. Det meddelande vi vill spara och använda på ett annat ställe vid ett senare tillfälle lägger vi in i variabeln. \r\n\r\nEn variabel behöver alltid heta något, detta för att vi ska kunna skilja dem åt när vi använder dessa. För att förtydliga dessa variabler ännu mera vad för meddelande de kan innehålla använder man en så kallad \"typ\" innan man namnger variabeln. \r\n\r\n[b]De vanligaste typerna som oftast används[/b]\r\n\r\n[b][i]string[/i][/b] \r\nDenna typ som heter string används när vi vill förtydliga om att vi ska ha någon form av text sparad i variabeln. I det hela när du ska spara alla möjliga tecken du ska skriva i texten, bokstäver, nummer, specialtecken som =,?.( etc.\r\n\r\n[i][b]int[/b][/i] \r\nDenna typ som heter int används enbart när vi vill förtydliga om att variabeln enbart sparar nummer (0-9).\r\n\r\n[b][i]bool[/i][/b]\r\nDenna typ som heter bool används enbart när variabeln får spara \"true\" eller \"false\". Detta används främst när vi kontrollerar något som antingen är sant eller falskt.', '', 'Lätt', 'Inaktiv'),
(2, 1, '2. Loopar (c#)', 'Vad är loopar? När använder man det och hur använder man det? Vi kommer gå igenom varje loop noggrant.', '', 'Medel', 'Inaktiv');

-- --------------------------------------------------------

--
-- Tabellstruktur `forum`
--

DROP TABLE IF EXISTS `forum`;
CREATE TABLE IF NOT EXISTS `forum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `system_privilege_id` int(11) NOT NULL,
  `system_color_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_privilege_id` (`system_privilege_id`),
  KEY `forum_color_id` (`system_color_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `forum`
--

INSERT INTO `forum` (`id`, `system_privilege_id`, `system_color_id`, `title`, `content`) VALUES
(1, 1, 2, 'Artiklar och Nyheter', 'Du kan hitta nya som gamla artiklar och nyheter under denna forumdel.'),
(2, 1, 1, 'FAQ - Vanligt ställda frågor', 'Om du behöver hjälp med vanligt förekommande frågor finns allt samlat i denna forumdel.'),
(3, 4, 4, 'Programmeringsspråk', 'Här hittar du Information om de olika programmeringsspråken som vi lär ut.'),
(4, 1, 1, 'Om Programmeringsskolan', 'Få en inblick om oss.'),
(5, 1, 2, 'test', 'test');

-- --------------------------------------------------------

--
-- Tabellstruktur `forum_post`
--

DROP TABLE IF EXISTS `forum_post`;
CREATE TABLE IF NOT EXISTS `forum_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `forum_thread_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `creator` int(11) DEFAULT NULL,
  `locked` int(11) DEFAULT NULL,
  `sticked` int(11) DEFAULT NULL,
  `reported` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`),
  KEY `forum_thread_id` (`forum_thread_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `forum_post`
--

INSERT INTO `forum_post` (`id`, `account_id`, `forum_thread_id`, `title`, `content`, `creator`, `locked`, `sticked`, `reported`, `created`) VALUES
(2, 1, 2, 'hyfj', 'hj', 1, NULL, NULL, NULL, '2019-07-22 21:39:58'),
(3, 1, 3, 'n.k', ',n', 1, NULL, NULL, NULL, '2019-07-23 11:31:58');

-- --------------------------------------------------------

--
-- Tabellstruktur `forum_thread`
--

DROP TABLE IF EXISTS `forum_thread`;
CREATE TABLE IF NOT EXISTS `forum_thread` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `forum_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `forum_post_chain` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `forum_id` (`forum_id`),
  KEY `account_id` (`account_id`),
  KEY `forum_post_chain` (`forum_post_chain`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `forum_thread`
--

INSERT INTO `forum_thread` (`id`, `forum_id`, `account_id`, `forum_post_chain`, `image`) VALUES
(2, 5, 1, 0, NULL),
(3, 5, 1, 0, '3_small_1061995521.jpg');

-- --------------------------------------------------------

--
-- Tabellstruktur `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `sticked` enum('Inaktiv','Aktiv') NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `news`
--

INSERT INTO `news` (`id`, `account_id`, `title`, `content`, `image`, `sticked`, `created`) VALUES
(1, 1, 'Alla kan', 'Vi vet att alla kan lära sig, även du. En intensivutbildning är inte anpassad för alla. \r\n\r\nDärför har vi inga krav krav. Du lär dig efter din egen hastighet. Du betalar heller inget, och inga dolda avgifter tillkommer. Allt för att du ska få ha din glädje och nyfikenhet kvar på att lära dig programmering.\r\n\r\n', '', 'Inaktiv', '2019-07-17 22:20:56'),
(2, 1, 'Ge ditt stöd ', 'Genom ditt stöd kan vi fortsätta erbjuda kurser/aktiviteter helt [b]gratis[/b]. Nu har vi en e-butik där vi säljer produkter som du kan använda eller ge bort som present.\r\n\r\nEfter en avklarad kurs har du grundläggande kunskaper för att börja skapa egna små projekt eller söka dig vidare till att arbeta som  Junior IT-konsult.\r\n\r\nVi på programmeringsskolan har en rad samarbeten med olika företag inom IT-branshen och vid mån och efterfrågan så kan du efter kursen bli erbjuden ett arbete.', '', 'Inaktiv', '2019-07-17 22:20:56'),
(3, 1, 'Lorem Ipsum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eget sodales ipsum. Praesent eu leo convallis, rutrum urna quis, lacinia felis. Donec maximus turpis ac nulla feugiat convallis. Fusce tristique augue nibh, ut dictum sapien consectetur nec. Pellentesque bibendum urna sit amet tellus mollis pretium. Praesent enim urna, mattis non pharetra pulvinar, suscipit quis lacus. Proin tristique metus non nibh vehicula fermentum. Lorem ipsum dolor sit amet, consectetur adipiscing elit.\r\n\r\nEtiam eu gravida diam. Fusce accumsan vel dui eu faucibus. Praesent hendrerit tincidunt urna vel tempor. Praesent laoreet dapibus tellus tincidunt mollis. Pellentesque luctus varius velit, nec finibus massa sollicitudin vel. Vivamus porta mauris sit amet mauris cursus, sed fermentum sem egestas. Aliquam erat volutpat. Sed vulputate ligula lacinia, malesuada augue consequat, malesuada est. Integer scelerisque nulla nibh, eget malesuada odio varius at. Cras sagittis dapibus tortor sit amet interdum. In dictum euismod ligula eget bibendum. Vestibulum quis nibh sit amet dolor eleifend cursus. Ut a ligula vitae dui efficitur porttitor. Duis nisi purus, sodales eu iaculis at, sagittis ac est. Nullam finibus quam nibh, nec aliquet felis congue non. Ut id vulputate augue, et placerat sapien.', '', 'Inaktiv', '2019-07-17 22:20:56'),
(4, 1, 'Neque porro quisquam est qui dolorem ', 'Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis et velit vel sapien consectetur fringilla. Vestibulum sed commodo arcu. Donec mattis id urna et pharetra. Nam eget auctor metus. In neque magna, mattis nec nunc a, luctus porta felis. Etiam iaculis non nisl sed pretium. Aenean id pulvinar eros.\r\n\r\nEtiam scelerisque consequat diam feugiat efficitur. Maecenas condimentum, eros eget luctus consectetur, neque est ornare leo, mollis hendrerit neque sapien quis nulla. Pellentesque vel lacus sit amet magna tempus condimentum non eu metus. Nullam commodo, urna a tempor rutrum, elit leo semper libero, at scelerisque nunc neque vel velit. Mauris at congue elit, vel rhoncus tellus. Proin malesuada non sapien eget laoreet. Suspendisse potenti. Praesent ac lacinia magna, aliquet suscipit ligula. Morbi mattis vel orci at porttitor. Nulla mollis, ex id sagittis rutrum, augue enim finibus odio, et commodo ex odio facilisis sem. Aliquam sollicitudin convallis tellus a facilisis. Proin cursus volutpat velit et convallis. Interdum et malesuada fames ac ante ipsum primis in faucibus.', '', 'Inaktiv', '2019-07-17 22:20:56');

-- --------------------------------------------------------

--
-- Tabellstruktur `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `price` int(11) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `quantity_in_stock` int(11) NOT NULL,
  `quantity_on_order` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `product`
--

INSERT INTO `product` (`id`, `account_id`, `title`, `content`, `price`, `image`, `quantity_in_stock`, `quantity_on_order`) VALUES
(1, 1, 'Komplett näringspulver', 'Tas med 2 tsk juice eller yoghurt. ', 200, '', 0, 0),
(2, 1, 'Arthro Creme', 'Arthro Creme är en kylkräm för behandling av olika ledproblem. Den kylande effekten förstärks av kondroitinsulfat, MSM och glukosaminsulfat, vilka är viktiga ämnen för ledernas välbefinnande.\r\n\r\nKrämen innehåller kondroitinsulfat, MSM och glukosaminsulfat.\r\n\r\nFörvaras oåtkomligt för barn. Läs bruksanvisningen före användning. Endast för utvärtes bruk. Undvik att få cremen i ögonen, på sår och slemhinnor. Rekommenderas inte till barn, gravida eller ammande mödrar. Diabetiker, personer som använder blodförtunnande läkemedel och personer under 18 år ska rådgöra med läkare före användning. Kan framkalla allergisk reaktion på personer som är allergiska mot skaldjur.', 219, '2139932906.jpg', 0, 0),
(3, 1, 'Naturälskaren Vinterblomman 10 ml', 'Uppfriskande och upprensande för bröst, nacke, hals, huvud och ömma muskler. Läggs på huden. ', 99, '', 0, 0),
(4, 1, 'Naturälskaren Vinterblomman 30 ml', 'Uppfriskande och upprensande för bröst, nacke, hals, huvud och ömma muskler. Läggs på huden. ', 215, '', 0, 0),
(5, 1, 'Naturälskaren hudsalva 60 ml', 'Återbalanserar det mesta av irritationer och obalanserad hud.', 99, '', 0, 0),
(6, 1, 'Naturälskaren hud och sololja 150 ml', 'Passar bra och skyddar djupt i sol och solarium. Pigmentökande och ökar hudens motståndskraft. Ger en snabbare solbränna.', 190, '', 0, 0),
(7, 1, 'Naturälskaren hud och sololja 250 ml', 'Passar bra och skyddar djupt i sol och solarium. Pigmentökande och ökar hudens motståndskraft. Ger en snabbare solbränna.', 260, '', 0, 0),
(8, 1, 'Ice Power Plus kylande gel 75 ml', 'Ice Power Plus lämpar sig speciellt väl för ansträngda muskler, ryggsmärtor orsakade av muskelbesvär samt långvariga muskelsmärtor. Den kylande Ice Power Plus gelens MSM effektiverar behandlingsresultatet.', 179, '461055881.jpg', 0, 0),
(9, 1, 'Ice Power kylande gel 150 ml', 'Trygg smärtlindring utan läkemedel\r\nLämpar sig för hela familjen\r\nAktiva substanser: mentol och etanol\r\nKliiniskt bevisad effekt\r\nIce Power kylande gel lämpar sig vid:\r\n\r\nSmärtor i nacke och skuldror\r\nSpänningshuvudvärk\r\nRyggsmärtor orsakade av muskelbesvär\r\nVäxtvärk hos barn\r\nNervsmärtor\r\nÅterhämtning efter ansträngning', 219, '687720342.jpg', 0, 0),
(10, 1, 'T-shirt dam s-xxl', '', 180, '234623434.jpg', 0, 0),
(11, 1, 'T-shirt man s-xxl', '', 180, '3545873884.jpg', 0, 0),
(12, 1, 'T-shirt barn 98-164', '', 150, '4564567454.jpg', 0, 0),
(13, 1, 'Tygpåse - Hitta pulsen', '', 150, '453451112.jpg', 0, 0);

-- --------------------------------------------------------

--
-- Tabellstruktur `product_order`
--

DROP TABLE IF EXISTS `product_order`;
CREATE TABLE IF NOT EXISTS `product_order` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `system_color`
--

DROP TABLE IF EXISTS `system_color`;
CREATE TABLE IF NOT EXISTS `system_color` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `system_color`
--

INSERT INTO `system_color` (`id`, `title`, `color`) VALUES
(1, 'Vit', 'White'),
(2, 'Grön', 'Green'),
(3, 'Orange', 'Orange'),
(4, 'Blå', 'Blue'),
(5, 'Röd', 'Red');

-- --------------------------------------------------------

--
-- Tabellstruktur `system_gender`
--

DROP TABLE IF EXISTS `system_gender`;
CREATE TABLE IF NOT EXISTS `system_gender` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gender` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `system_gender`
--

INSERT INTO `system_gender` (`id`, `gender`) VALUES
(1, 'Man'),
(2, 'Kvinna');

-- --------------------------------------------------------

--
-- Tabellstruktur `system_payment`
--

DROP TABLE IF EXISTS `system_payment`;
CREATE TABLE IF NOT EXISTS `system_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `paymentNumber` varchar(255) NOT NULL,
  `fee` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `system_payment`
--

INSERT INTO `system_payment` (`id`, `title`, `paymentNumber`, `fee`) VALUES
(1, 'Kurser', '4455-44578678', 495),
(2, 'Skolundervisning', '456-45645645', 795);

-- --------------------------------------------------------

--
-- Tabellstruktur `system_privilege`
--

DROP TABLE IF EXISTS `system_privilege`;
CREATE TABLE IF NOT EXISTS `system_privilege` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `system_privilege`
--

INSERT INTO `system_privilege` (`id`, `title`) VALUES
(1, 'Besökare'),
(2, 'Medlem'),
(3, 'Partner'),
(4, 'Moderator'),
(5, 'Admin');

-- --------------------------------------------------------

--
-- Tabellstruktur `system_reservation`
--

DROP TABLE IF EXISTS `system_reservation`;
CREATE TABLE IF NOT EXISTS `system_reservation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `added` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
