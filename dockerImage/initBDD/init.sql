-- Suppression du schema si il existe
DROP SCHEMA IF EXISTS db;

-- Création du schema :
CREATE SCHEMA db;

-- Utilisation du schema
USE db;

-- Création de la table 'Migration'
CREATE TABLE _Migration (
    id serial PRIMARY KEY,
    scriptName varchar(255),
    executionDate timestamp DEFAULT CURRENT_TIMESTAMP
);

-- Création de la table `Gender`
CREATE TABLE _Gender (
    genderID serial PRIMARY KEY,
    genderName varchar(20)
);

-- Création de la table `Admin`
CREATE TABLE _Admin (
    adminID serial PRIMARY KEY,
    mail varchar(255) UNIQUE,
    firstname varchar(100),
    lastname varchar(100),
    nickname varchar(50),
    password varchar(255)
);

-- ajout de l'admin
INSERT INTO _Admin (mail, firstname, lastname, nickname, password) VALUES ('admin@gmail.com', 'Benoit', 'Tottereau', 'admin', '$2y$10$O.JEDin2vwFgbA3FQnKMheSSJDhaevnV3m5AXetQP6H7TeLrh9HaK');

-- Création de la table `Lang`
CREATE TABLE _Lang (
    langID serial PRIMARY KEY,
    langName varchar(50),
    langFlag varchar(255)
);

-- Création de la table `PayCard`
CREATE TABLE _PayCard (
    payCardID serial PRIMARY KEY,
    cardNumber varchar(300),
    ownerName varchar(300),
    CVC varchar(300),
    expirationDate varchar(300)
);

-- Création de la table `Config`
CREATE TABLE _Config (
    configID serial PRIMARY KEY,
    label varchar(100),
    value varchar(1000)
);

-- Création de la table `Address`
CREATE TABLE _Address (
    addressID serial PRIMARY KEY,
    city varchar(100),
    postalCode varchar(6),
    postalAddress varchar(255),
    complementAddress varchar(255),
    streetNumber integer,
    country varchar(100)
);

-- Création de la table `Category`
CREATE TABLE _Category (
    categoryID serial PRIMARY KEY,
    label varchar(30)
);

-- Création de la table `Type`
CREATE TABLE _Type (
    typeID serial PRIMARY KEY,
    label varchar(20)
);

-- Création de la table `Image`
CREATE TABLE _Image (
    imageID serial PRIMARY KEY,
    src varchar(255)
);

-- Création de la table `User`
CREATE TABLE _User (
    userID serial PRIMARY KEY,
    mail varchar(255) UNIQUE,
    lastname varchar(100),
    firstname varchar(100),
    nickname varchar(50),
    password varchar(255),
    phoneNumber varchar(50),
    birthDate Date,
    consent Boolean,
    lastConnection Date,
    creationDate timestamp DEFAULT CURRENT_TIMESTAMP,
    imageID BIGINT UNSIGNED, -- Correspond au type `serial` dans Image pour mysql
    genderID BIGINT UNSIGNED, -- Correspond au type `serial` dans Gender pour mysal
    addressID BIGINT UNSIGNED, -- Correspond au type `serial` dans Address pour mysql
    reset_token_hash varchar(64) default null,
    reset_token_expires_at DATETIME default null,
    FOREIGN KEY (genderID) REFERENCES _Gender(genderID),
    FOREIGN KEY (addressID) REFERENCES _Address(addressID),
    FOREIGN KEY (imageID) REFERENCES _Image(imageID)
);

-- Création de la table `Owner`
CREATE TABLE _Owner (
    ownerID BIGINT UNSIGNED PRIMARY KEY,
    isValidated Boolean DEFAULT TRUE,
    identityCardFront varchar(100),
    identityCardBack varchar(100),
    bankDetails varchar(100), -- RIB
    swiftCode varchar(100), -- Code BIC
    IBAN varchar(100), -- Code IBAN
    FOREIGN KEY (ownerID) REFERENCES _User(userID)
);

-- Création de la table `Client`
CREATE TABLE _Client (
    clientID BIGINT UNSIGNED PRIMARY KEY,
    isBlocked Boolean,
    FOREIGN KEY (clientID) REFERENCES _User(userID)
);

-- Création de la view `Owner`
CREATE VIEW Owner AS (
    SELECT * FROM _Owner
    JOIN _User ON _Owner.ownerID = _User.userID
);

-- Création de la view `Client`
CREATE VIEW Client AS (
    SELECT * FROM _Client
    JOIN _User ON _Client.clientID = _User.userID
);

-- Création de la table `Housing`
CREATE TABLE _Housing (
    housingID serial PRIMARY KEY,
    title varchar(255),
    shortDesc varchar(5000),
    longDesc varchar(10000),
    priceExcl Float,
    priceIncl Float,
    nbPerson integer,
    nbRoom integer,
    nbDoubleBed integer,
    nbSimpleBed integer,
    longitude Float,
    latitude Float,
    isOnline Boolean,
    noticeCount integer,
    beginDate Date,
    endDate Date,
    creationDate timestamp DEFAULT CURRENT_TIMESTAMP,
    surfaceInM2 Float,
    typeID BIGINT UNSIGNED, -- Correspond au type `serial` dans Type pour mysql
    categoryID BIGINT UNSIGNED, -- Correspond au type `serial` dans Category pour mysql
    addressID BIGINT UNSIGNED, -- Correspond au type `serial` dans Address pour mysql
    ownerID BIGINT UNSIGNED, -- Correspond au type `serial` dans Owner pour mysql
    imageID BIGINT UNSIGNED, -- Correspond au type `serial` dans Image pour mysql
    FOREIGN KEY (addressID) REFERENCES _Address(addressID),
    FOREIGN KEY (ownerID) REFERENCES _Owner(ownerID),
    FOREIGN Key (typeID) REFERENCES _Type(typeID),
    FOREIGN Key (categoryID) REFERENCES _Category(categoryID),
    FOREIGN Key (imageID) REFERENCES _Image(imageID)
);

-- Création de la table `Activity`
CREATE TABLE _Activity (
    activityID serial PRIMARY KEY,
    label varchar(20)
);

-- Création de la table `Perimeter`
CREATE TABLE _Perimeter (
    perimeterID serial PRIMARY KEY,
    label varchar(20)
);

CREATE TABLE _Has_for_activity (
    housingID BIGINT UNSIGNED, -- Correspond au type `serial` dans Housing pour mysql
    activityID BIGINT UNSIGNED, -- Correspond au type `serial` dans Activity pour mysql
    perimeterID BIGINT UNSIGNED, -- Correspond au type `serial` dans Perimeter pour mysql
    FOREIGN KEY (housingID) REFERENCES _Housing(housingID),
    FOREIGN KEY (activityID) REFERENCES _Activity(activityID),
    FOREIGN KEY (perimeterID) REFERENCES _Perimeter(perimeterID)
);

-- Création de la table `Arrangement`
CREATE TABLE _Arrangement (
    arrangementID serial PRIMARY KEY,
    label varchar(255)
);

CREATE TABLE _Has_for_arrangement (
    housingID BIGINT UNSIGNED, -- Correspond au type `serial` dans Housing pour mysql
    arrangementID BIGINT UNSIGNED, -- Correspond au type `serial` dans Arrangement pour mysql
    FOREIGN KEY (housingID) REFERENCES _Housing(housingID),
    FOREIGN KEY (arrangementID) REFERENCES _Arrangement(arrangementID)
);

CREATE TABLE _Has_for_payCard (
     clientID BIGINT UNSIGNED, -- Correspond au type `serial` dans Client pour mysql
     payCardID BIGINT UNSIGNED, -- Correspond au type `serial` dans PayCard pour mysql
     PRIMARY KEY (clientID, payCardID),
     FOREIGN KEY (clientID) REFERENCES _Client(clientID),
     FOREIGN KEY (payCardID) REFERENCES _PayCard(payCardID)
);

-- Création de la table `PaymentMethod`
CREATE TABLE _PaymentMethod (
    payMethodID serial PRIMARY KEY,
    label varchar(50)
);

-- Création de la table `Reservation`
CREATE TABLE _Reservation (
    reservationID serial PRIMARY KEY,
    beginDate Date,
    endDate Date,
    serviceCharge Float,
    touristTax Float,
    status varchar(20),
    nbPerson integer,
    priceIncl Float,
    creationDate timestamp DEFAULT CURRENT_TIMESTAMP,
    housingID BIGINT UNSIGNED, -- Correspond au type `serial` dans Housing pour mysql
    payMethodID BIGINT UNSIGNED, -- Correspond au type `serial` dans PaymentMethod pour mysql
    clientID BIGINT UNSIGNED, -- Correspond au type `serial` dans Client pour mysql
    FOREIGN KEY (housingID) REFERENCES _Housing(housingID),
    FOREIGN KEY (payMethodID) REFERENCES _PaymentMethod(payMethodID),
    FOREIGN KEY (clientID) REFERENCES _Client(clientID)
);

-- Associations many-to-many et autres contraintes

-- Association Image-Housing
CREATE TABLE _Housing_Image (
    housingID BIGINT UNSIGNED, -- Correspond au type `serial` dans Housing pour mysql
    imageID BIGINT UNSIGNED, -- Correspond au type `serial` dans Image pour mysql
    PRIMARY KEY (housingID, imageID),
    FOREIGN KEY (housingID) REFERENCES _Housing(housingID),
    FOREIGN KEY (imageID) REFERENCES _Image(imageID)
);

-- Association Lang
CREATE TABLE _Lang_User (
    langID BIGINT UNSIGNED, -- Correspond au type `serial` dans Lang pour mysql
    userID BIGINT UNSIGNED, -- Correspond au type `serial` dans Client pour mysql
    PRIMARY KEY (langID, userID),
    FOREIGN KEY (langID) REFERENCES _Lang(langID),
    FOREIGN KEY (userID) REFERENCES _User(userID)
);

CREATE TABLE _User_APIKey (
    userID BIGINT UNSIGNED, -- Correspond au type `serial` dans User pour mysql
    apiKey varchar(64),
    active Boolean,
    superAdmin Boolean,
    FOREIGN KEY (userID) REFERENCES _User(userID)
);