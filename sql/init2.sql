-- Création de tables pour les utilisateurs et les détails liés

CREATE TABLE Gender (
    genderID serial PRIMARY KEY,
    genderName varchar(20)
);

CREATE TABLE Address (
    addressID serial PRIMARY KEY,
    street varchar(255),
    city varchar(100),
    postalCode char(10),
    postalAddress varchar(255)
);

CREATE TABLE User (
    userID serial PRIMARY KEY,
    mail varchar(255) UNIQUE,
    username varchar(100),
    firstName varchar(100),
    lastName varchar(100),
    nickname varchar(50),
    phoneNumber varchar(50),
    birthDate Date,
    consent Boolean,
    lastConnection Date,
    genderID int REFERENCES Gender(genderID),
    addressID int REFERENCES Address(addressID)
);

CREATE TABLE Admin (
    adminID serial PRIMARY KEY,
    mail varchar(255) UNIQUE,
    username varchar(100),
    password varchar(255),
    userID int REFERENCES User(userID)
);

CREATE TABLE Lang (
    langID serial PRIMARY KEY,
    langName varchar(50),
    langFlag varchar(255)
);

CREATE TABLE Client (
    clientID serial PRIMARY KEY,
    isBlocked Boolean,
    creationDate Date,
    userID int REFERENCES User(userID)
);

CREATE TABLE Owner (
    ownerID serial PRIMARY KEY,
    identityCard varchar(100),
    userID int REFERENCES User(userID)
);

CREATE TABLE Config (
    configID serial PRIMARY KEY,
    label varchar(100),
    value varchar(1000)
);

-- Tables pour les catégories, les types et les éléments liés

CREATE TABLE Category (
    categoryID serial PRIMARY KEY,
    label varchar(30)
);

CREATE TABLE Type (
    typeID serial PRIMARY KEY,
    label varchar(20)
);

CREATE TABLE Arrangement (
    arrangementID serial PRIMARY KEY,
    src varchar(255),
    typeID int REFERENCES Type(typeID)
);

CREATE TABLE Activity (
    activityID serial PRIMARY KEY,
    label varchar(20),
    activityCost float,
    perimeter varchar(20)
);

CREATE TABLE Service (
    serviceID serial PRIMARY KEY,
    label varchar(50)
);

CREATE TABLE Housing (
    housingID serial PRIMARY KEY,
    title varchar(100),
    shortDesc varchar(255),
    longDesc varchar(1000),
    priceECL float,
    priceNCI float,
    nbRoom integer,
    nbSimplified integer,
    nbDoubleBed integer,
    longitude float,
    latitude float,
    isOnline Boolean,
    beginDate Date,
    endDate Date,
    creationDate Date,
    ownerID int REFERENCES Owner(ownerID),
    categoryID int REFERENCES Category(categoryID),
    typeID int REFERENCES Type(typeID)
);

-- Relations entre les utilisateurs, les logements et les activités

CREATE TABLE Paycard (
    paycardID serial PRIMARY KEY,
    cardNumber varchar(50),
    cardName varchar(50),
    CVC varchar(4),
    clientID int REFERENCES Client(clientID)
);

CREATE TABLE Review (
    reviewID serial PRIMARY KEY,
    note float,
    comm varchar(3000),
    creationDate Date,
    isReported Boolean,
    clientID int REFERENCES Client(clientID),
    housingID int REFERENCES Housing(housingID)
);

CREATE TABLE Image (
    imageID serial PRIMARY KEY,
    src varchar(255),
    housingID int REFERENCES Housing(housingID)
);

CREATE TABLE Reservation (
    reservationID serial PRIMARY KEY,
    beginDate Date,
    endDate Date,
    serviceCharge float,
    touristicTax float,
    status varchar(20),
    clientID int REFERENCES Client(clientID),
    housingID int REFERENCES Housing(housingID)
);

CREATE TABLE PaymentMethod (
    methodID serial PRIMARY KEY,
    label varchar(50)
);

-- Relations entre les tables de réservation, les services et les activités

CREATE TABLE has_for_lang (
    userID int REFERENCES User(userID),
    langID int REFERENCES Lang(langID),
    PRIMARY KEY(userID, langID)
);

CREATE TABLE has_for_paycard (
    clientID int REFERENCES Client(clientID),
    paycardID int REFERENCES Paycard(paycardID),
    PRIMARY KEY(clientID, paycardID)
);

CREATE TABLE has_for_activity (
    housingID int REFERENCES Housing(housingID),
    activityID int REFERENCES Activity(activityID),
    PRIMARY KEY(housingID, activityID)
);

CREATE TABLE has_for_service (
    housingID int REFERENCES Housing(housingID),
    serviceID int REFERENCES Service(serviceID),
    PRIMARY KEY(housingID, serviceID)
);

CREATE TABLE has_for_method (
    reservationID
