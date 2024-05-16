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

-- add 3 genders

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
    CVC varchar(300)
);

-- Création de la table `Service`
CREATE TABLE _Service (
    serviceID serial PRIMARY KEY,
    label varchar(50)
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
    postalCode varchar(5),
    postalAddress varchar(255)
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
    creationDate Date,
    imageID BIGINT UNSIGNED, -- Correspond au type `serial` dans Image pour mysql
    genderID BIGINT UNSIGNED, -- Correspond au type `serial` dans Gender pour mysal
    addressID BIGINT UNSIGNED, -- Correspond au type `serial` dans Address pour mysql
    FOREIGN KEY (genderID) REFERENCES _Gender(genderID),
    FOREIGN KEY (addressID) REFERENCES _Address(addressID),
    FOREIGN KEY (imageID) REFERENCES _Image(imageID)
);

-- Création de la table `Owner`
CREATE TABLE _Owner (
    ownerID BIGINT UNSIGNED PRIMARY KEY,
    identityCard varchar(100),
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
    SELECT 
        ownerID,
        mail,
        lastname,
        firstname,
        nickname,
        password,
        phoneNumber,
        birthDate,
        consent,
        lastConnection,
        creationDate,
        imageID,
        genderID,
        addressID,
        identityCard
    FROM _Owner
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
    creationDate Date,
    surfaceInM2 Float,
    typeID BIGINT UNSIGNED, -- Correspond au type `serial` dans Type pour mysql
    categoryID BIGINT UNSIGNED, -- Correspond au type `serial` dans Category pour mysql
    addressID BIGINT UNSIGNED, -- Correspond au type `serial` dans Address pour mysql
    ownerID BIGINT UNSIGNED, -- Correspond au type `serial` dans Owner pour mysql
    FOREIGN KEY (addressID) REFERENCES _Address(addressID),
    FOREIGN KEY (ownerID) REFERENCES _Owner(ownerID),
    FOREIGN Key (typeID) REFERENCES _Type(typeID),
    FOREIGN Key (categoryID) REFERENCES _Category(categoryID)
);

-- Création de la table `Activity`
CREATE TABLE _Activity (
    activityID serial PRIMARY KEY,
    label varchar(20),
    perimeter varchar(20)
);

CREATE TABLE _Has_for_activity (
    housingID BIGINT UNSIGNED, -- Correspond au type `serial` dans Housing pour mysql
    activityID BIGINT UNSIGNED, -- Correspond au type `serial` dans Activity pour mysql
    FOREIGN KEY (housingID) REFERENCES _Housing(housingID),
    FOREIGN KEY (activityID) REFERENCES _Activity(activityID)
);

CREATE TABLE _Has_for_service (
    housingID BIGINT UNSIGNED, -- Correspond au type `serial` dans Housing pour mysql
    serviceID BIGINT UNSIGNED, -- Correspond au type `serial` dans Service pour mysql
    FOREIGN KEY (housingID) REFERENCES _Housing(housingID),
    FOREIGN KEY (serviceID) REFERENCES _Service(serviceID)
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

-- Création de la table `Review`
CREATE TABLE _Review (
    reviewID serial PRIMARY KEY,
    note Float,
    comm varchar(3000),
    creationDate Date,
    isReported Boolean,
    clientID BIGINT UNSIGNED, -- Correspond au type `serial` dans Client pour mysql
    housingID BIGINT UNSIGNED, -- Correspond au type `serial` dans Housing pour mysql
    FOREIGN KEY (clientID) REFERENCES _Client(clientID),
    FOREIGN KEY (housingID) REFERENCES _Housing(housingID)
);

CREATE TABLE _Has_for_payCard (
     clientID BIGINT UNSIGNED, -- Correspond au type `serial` dans Client pour mysql
     payCardID BIGINT UNSIGNED, -- Correspond au type `serial` dans PayCard pour mysql
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
    housingID BIGINT UNSIGNED, -- Correspond au type `serial` dans Housing pour mysql
    payMethodID BIGINT UNSIGNED, -- Correspond au type `serial` dans PaymentMethod pour mysql
    FOREIGN KEY (housingID) REFERENCES _Housing(housingID),
    FOREIGN KEY (payMethodID) REFERENCES _PaymentMethod(payMethodID)
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
