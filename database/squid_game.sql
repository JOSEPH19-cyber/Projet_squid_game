/* SUPPRIMER LA BASE DE DONNEES SI ELLE EXISTE */
DROP DATABASE IF EXISTS `squid_game`;

/* CREER ET UTILISER LA BASE DE DONNEES */
CREATE DATABASE IF NOT EXISTS `squid_game`;
USE `squid_game`;

/* CREER LA TABLE users */
CREATE TABLE `users`(
    `user_id` INT NOT NULL AUTO_INCREMENT,
    `user_name` VARCHAR(100) NOT NULL,
    `user_email` VARCHAR(255) NOT NULL,
    `user_password` VARCHAR(255) NOT NULL,
    `is_admin` TINYINT(1) NOT NULL DEFAULT 0,
    `registration_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(`user_id`),
    UNIQUE KEY(`user_email`)
)
ENGINE = InnoDB
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;


/* CREER LA TABLE activities */
CREATE TABLE `activities`
(
    `activity_id` INT NOT NULL AUTO_INCREMENT,
    `activity_title` VARCHAR(150) NOT NULL,
    `short_description` VARCHAR(150) NOT NULL,
    `long_description` TEXT NOT NULL,
    `activity_url` VARCHAR(255) NOT NULL,
    `activity_created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `activity_updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`activity_id`)
)
ENGINE = InnoDB
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

/* CREER LA TABLE delices */
CREATE TABLE `delices`
(
    `delice_id` INT NOT NULL AUTO_INCREMENT,
    `delice_type` TINYINT(1) NOT NULL DEFAULT 0,
    `category_type`VARCHAR(50) NOT NULL,
    `delice_url` VARCHAR(255) NOT NULL,
    `delice_items` TEXT NOT NULL,
    `delice_created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `delice_updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`delice_id`)
)
ENGINE = InnoDB
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

/* CREER LA TABLE reservations */
CREATE TABLE `reservations`
(
    `reservation_id` INT NOT NULL AUTO_INCREMENT,
    `full_name` VARCHAR(150) NOT NULL,
    `phone_number` VARCHAR(50) NOT NULL,
    `number` TINYINT NOT NULL,
    PRIMARY KEY(`reservation_id`)
)
ENGINE = InnoDB
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

/* CREER LA TABLE messages */
CREATE TABLE `messages`
(
    `message_id` INT AUTO_INCREMENT,   
    `user_id` INT NOT NULL,                     
    `message` TEXT NOT NULL,                      
    `message_created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(`message_id`),
    CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE
)
ENGINE = InnoDB
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;




/* ENREGISTREMENTS DE DONNEES*/

INSERT INTO `activities`(activity_title, short_description, long_description, activity_url, activity_price)
VALUES

('AUTO TEMPONEUSES', 
'Venez vous amuser et tester vos réflexes sur nos autos tamponneuses !', 
'Montez à bord de nos autos tamponneuses et laissez libre cours à 
votre esprit de compétition dans un environnement sécurisé. 
Que vous soyez en famille ou entre amis, chaque collision promet rires 
et sensations fortes. Nos véhicules sont conçus pour garantir sécurité 
et confort tout en offrant une expérience dynamique. Les enfants comme 
les adultes adoreront se faufiler, esquiver et foncer dans une ambiance 
festive. Ne manquez pas cette attraction incontournable qui allie amusement, 
adrénaline et souvenirs mémorables.',
'assets/images/autotemponeuse.jpg',
'5'),

('Carrousel', 
'Profitez d’un tour enchanté sur notre carrousel coloré et musical !', 
'Laissez-vous emporter par la magie de notre carrousel, idéal pour 
petits et grands. Chaque tour est accompagné de musiques entraînantes 
et de lumières scintillantes qui créent une ambiance féerique. 
Les animaux et véhicules décoratifs transportent les enfants dans 
un univers plein de fantaisie et de rires. Nos installations sont 
sécurisées et régulièrement entretenues pour garantir confort et 
tranquillité. Un incontournable pour une expérience mémorable et des 
photos inoubliables en famille ou entre amis.', 
'assets/images/carousel.jpg',
'5'),

('Toboggan aquatique', 
'Plongez dans l’aventure avec notre toboggan aquatique géant !', 
'Le toboggan aquatique de SQUID GAME promet des sensations fortes
et des éclats de rire pour toute la famille. Avec ses descentesrapides 
et ses virages amusants, il procure une montée d’adrénaline sécurisée. 
Les enfants comme les adultes pourront glisser dans l’eau rafraîchissante 
tout en profitant d’un espace bien conçu et sécurisé. Notre équipe veille 
à l’entretien régulier pour garantir la sécurité et le confort. Une expérience 
aquatique incontournable pour les amateurs de fun et de fraîcheur pendant 
les chaudes journées au parc.', 
'assets/images/toboggan.jpg',
'17'),

('Montagne russe', 
'Vivez des frissons intenses sur notre montagne russe spectaculaire !', 
'La montagne russe de SQUID GAME offre une expérience pleine de sensations 
fortes pour les amateurs de vitesse et d’adrénaline. Avec ses descentes 
vertigineuses, ses virages serrés et ses boucles surprenantes, chaque 
tour est un vrai défi pour le courage. Les sièges confortables et les 
systèmes de sécurité garantissent une aventure à la fois excitante et sûre. 
Que vous soyez débutant ou passionné de roller coasters, cette attraction est 
incontournable. Préparez-vous à crier, rire et partager des souvenirs mémorables 
avec vos amis et votre famille.', 
'assets/images/montagnerusse.jpg',
'20'),

('squid game', 
'Plongez dans l’univers palpitant du Squid Game et relevez tous les défis !', 
'Inspiré de l’univers emblématique du Squid Game, cette attraction vous plonge 
dans une série de défis captivants et ludiques. Les participants devront faire 
preuve d’adresse, de stratégie et de rapidité pour avancer dans les différentes 
épreuves. Chaque jeu est conçu pour garantir sécurité et amusement, tout en 
reproduisant l’ambiance intense de la série. Idéal pour les groupes d’amis ou 
les familles, cette activité promet des rires, des surprises et des souvenirs 
inoubliables. Préparez-vous à tester vos réflexes et votre esprit de compétition !', 
'assets/images/calamar.jpg',
'5'),

('réalité virtuelle', 
'Vivez des aventures immersives grâce à notre expérience de réalité virtuelle.',  
'Plongez dans un monde entièrement virtuel grâce à notre attraction de réalité 
virtuelle. Équipé de casques et de manettes, vous explorerez des environnements 
fascinants, des montagnes russes futuristes aux mondes fantastiques, le tout en 
toute sécurité. Cette activité stimule les sens, la coordination et la curiosité, 
offrant des sensations fortes tout en restant accessible à tous. Idéal pour les 
passionnés de technologies et les amateurs de frissons virtuels, chaque session 
promet immersion totale et souvenirs mémorables. Préparez-vous à franchir les 
frontières de l’imaginaire !', 
'assets/images/realitevirtuelle.jpg',
'20'),

('Vélo', 
'Partez à l’aventure sur nos parcours à vélo adaptés à tous les âges.', 
'Enfourchez nos vélos et parcourez des pistes spécialement conçues pour 
le plaisir et la sécurité de tous. Que vous soyez amateur de balades 
tranquilles ou de parcours plus sportifs, cette activité offre un excellent 
moyen de profiter du parc tout en restant actif. Les itinéraires traversent 
des zones pittoresques et des installations uniques, combinant aventure et détente. 
Chaque vélo est équipé pour assurer confort et sécurité, et nos encadreurs sont 
présents pour guider les participants si nécessaire. Une expérience idéale pour 
les familles, les amis ou les passionnés de cyclisme à la recherche de sensations 
et de découvertes.', 
'assets/images/velo.jpg',
'17'),

('Nage', 
'Plongez et profitez de nos zones de baignade pour tous les âges.', 
'Découvrez nos espaces aquatiques sécurisés et adaptés à tous les niveaux 
de nageurs. Que ce soit pour vous détendre dans une eau calme ou pour 
profiter de jeux et activités aquatiques, chaque moment dans nos zones de 
baignade promet amusement et fraîcheur. Nos installations comprennent des 
bassins variés et des équipements de sécurité pour garantir la tranquillité 
des parents et la sécurité des enfants. Des activités ludiques et éducatives 
sont également proposées pour ceux qui souhaitent apprendre ou perfectionner 
leur technique de nage. Une expérience rafraîchissante et conviviale pour toute 
la famille.', 
'assets/images/nage.jpg',
'10'),

('Grande roue', 
'Admirez le parc depuis les hauteurs avec notre grande roue spectaculaire.', 
'Vivez un moment unique en famille ou entre amis à bord de notre grande roue 
panoramique. Profitez d’une vue imprenable sur tout le parc et ses alentours, 
offrant des instants parfaits pour des photos mémorables. Les cabines sont confortables 
et sécurisées, permettant à tous, petits et grands, de profiter pleinement de cette expérience. 
Chaque rotation vous transporte dans une aventure paisible et captivante, idéale pour se 
détendre tout en admirant le paysage. Une attraction incontournable qui combine plaisir, 
émerveillement et détente pour tous nos visiteurs.', 
'assets/images/granderoue.jpg',
'20'),

('Tyrolienne', 
'Volez au-dessus du parc avec notre tyrolienne sensationnelle.', 
'Préparez-vous à ressentir des frissons et une montée d’adrénaline 
en glissant le long de notre tyrolienne géante. Cette activité vous 
offre une vue spectaculaire sur l’ensemble du parc, tout en procurant 
des sensations uniques de vitesse et de liberté. Les équipements sont 
sûrs et adaptés à tous les âges, encadrés par des professionnels pour 
garantir une expérience sans risque. Que vous soyez amateur de sensations 
fortes ou en quête d’une aventure inoubliable, la tyrolienne promet un moment 
mémorable. C’est l’activité idéale pour ajouter un peu d’excitation et de 
dynamisme à votre visite au parc SQUID GAME.', 
'assets/images/tyrolienne.jpg',
'17');


INSERT INTO `activities`(activity_title, short_description, long_description, activity_url, category)
VALUES

('Parades', 
'Une parade festive animée par des costumes colorés, des chars décorés et de la musique entraînante.', 
'a parade est l’un des moments les plus spectaculaires du parc. Elle réunit danseurs, musiciens et 
artistes vêtus de costumes éclatants qui défilent au rythme d’une musique entraînante. Les chars décorés 
viennent ajouter une touche de magie et d’émerveillement, captivant petits et grands. C’est un spectacle 
vivant où la joie et l’enthousiasme se partagent dans une ambiance conviviale et festive. Accessible à 
tous, la parade est l’occasion parfaite de plonger dans l’univers du parc et de créer des souvenirs inoubliables.', 
'assets/images/parade.jpg', 
0),

('Spectacles sur scène', 
'Des représentations variées mêlant magie, acrobatie, théâtre et danse pour émerveiller toute la famille.', 
'Les spectacles sur scène offrent une expérience artistique et divertissante unique. Au programme : des 
numéros de magie qui surprennent petits et grands, des acrobaties spectaculaires qui défient la gravité, des 
pièces de théâtre captivantes et des danses entraînantes venues de divers horizons. Chaque représentation est 
pensée pour émerveiller, divertir et transporter les spectateurs dans un univers féerique. Ces spectacles sont 
accessibles gratuitement et constituent un moment incontournable pour vivre pleinement l’ambiance du parc, en 
famille ou entre amis.', 
'assets/images/spectacle.jpg', 
0);


INSERT INTO `delices` (category_type, delice_url, delice_items)
VALUES

(
'gastronomie congolaise', 
'assets/images/congolaise3.jpg',
'Poulet Moambe,
Saka-saka (feuilles de manioc),
Liboké de poisson,
Ngulu ya loso (porc grillé),
Fumbwa (feuilles de lianes),
Ndakala (petits poissons séchés),
Makayabu (poisson salé),
Mbika (courge),
Riz à la sauce d’arachide,
Pondu au poisson fumé,
Chikwangue,
Lituma (bananes plantains pilées),
Brochettes à la kinoise,
Fufu,
Makemba (bananes plantain),
Sauce gombo,
Aubergines en sauce,
Viande de chèvre braisée,
Poisson fumé au pili-pili,
Frites de patates douces'),

( 
'gastronomie étrangère', 
'assets/images/etrangere1.jpg', 
'Hamburger,
Pizza,
Tacos,
Shawarma,
Hot-dog,
Fried Chicken,
Spaghetti bolognaise,
Crêpes (salées / sucrées),
Samoussa,
Burrito / Quesadilla');


INSERT INTO `delices` (delice_type, category_type, delice_url, delice_items)
VALUES

(1, 
'bière', 
'assets/images/biere1.jpg', 
'Primus,
Turbo King,
Mützig,
Primus Radler,
Skol,
Nkoyi (blonde, brune, aromatisée),
Tembo,
33 Export,
Beaufort Lager,
Doppel Munich,
Castel Beer,
Heineken'),

(1, 
'sucré', 
'assets/images/sucre1.jpg', 
'Coca-Cola,
Fanta (orange, citron...),
Sprite,
Vital’O,
Maltina,
Evervess,
Top,
D’jino,
World Cola,
XXL Energy'),

(1, 
'jus', 
'assets/images/jus1.jpg', 
'Jus d’orange,
Jus d’ananas,
Jus de fraise,
Jus de mangue,
Jus de raisin,
Jus de pomme,
Jus de malte,
Cocktail de fruits'),

(1, 
'vin', 
'assets/images/vin1.jpg', 
'Moderato Colombard Cuvée Révolutionnaire,
Thomson & Scott Noughty Blanc,
Thomson & Scott Noughty Rose,
Bolle Blanc de Blancs,
Bolle Sparkling Rosé,
Leitz Eins Zwei Zero Riesling,
Goodvines Sauvignon Blanc,
Canter Bianco Dry,
Gruvi Red Blend,
FRE Red Wine Blend'),

(1, 
'eau vive', 
'assets/images/eau_vive.jpg', 
'Swissta,
Canadian pure,
Eden,
Viva,
Aquaviva,
Kin eau,
Cristaline,
Volvic');

/* INDEX */
ALTER TABLE `activities`
ADD COLUMN `activity_price` TINYINT NOT NULL,
ADD COLUMN `category` TINYINT(1) NOT NULL DEFAULT 1,
ADD COLUMN `activity_place` TINYINT NOT NULL DEFAULT 0 CHECK (activity_place <= 20);

ALTER TABLE `reservations`
ADD COLUMN `reservation_date` DATE NOT NULL,
ADD COLUMN `reservation_time` TIME NOT NULL,
ADD COLUMN activity_id INT NOT NULL,
ADD CONSTRAINT fk_reservation_activity
FOREIGN KEY (activity_id) REFERENCES activities(activity_id) ON DELETE CASCADE,
ADD COLUMN `user_id` INT NOT NULL,
ADD CONSTRAINT fk_reservation_user
FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE;

