-- Création de la table Gender
CREATE TABLE Gender (
  genderID serial PRIMARY KEY,
  genderName varchar(20)
);

-- Création de la table Address
CREATE TABLE Address (
  addressID serial PRIMARY KEY,
  street varchar(255),
  city varchar(100),
  postalCode varchar(10),
  postalAddress varchar(255)
);

-- Création de la table Config
CREATE TABLE Config (
  configID serial PRIMARY KEY,
  label varchar(255),
  value varchar(1000)
);

-- Création de la table User
CREATE TABLE User (
  userID serial PRIMARY KEY,
  mail varchar(255) UNIQUE,
  firstName varchar(100),
  lastName varchar(100),
  nickname varchar(50),
  password varchar(255),
  phoneNumber varchar(50),
  birthDate Date,
  consent Boolean,
  lastConnection Date,
  genderID integer REFERENCES Gender(genderID)
);

-- Création de la table Admin
CREATE TABLE Admin (
  adminID serial PRIMARY KEY,
  userID integer REFERENCES User(userID),
  mail varchar(255)
);

-- Création de la table Client
CREATE TABLE Client (
  clientID serial PRIMARY KEY,
  userID integer REFERENCES User(userID),
  blacklist Boolean
);

-- Création de la table Owner
CREATE TABLE Owner (
  ownerID serial PRIMARY KEY,
  userID integer REFERENCES User(userID)
);

-- Création de la table PaymentMethod
CREATE TABLE PaymentMethod (
  methodID serial PRIMARY KEY,
  label varchar(50)
);

-- Création de la table Reservation
CREATE TABLE Reservation (
  reservationID serial PRIMARY KEY,
  beginDate Date,
  endDate Date,
  serviceCharge Float,
  touristTax Float,
  status varchar(20),
  methodID integer REFERENCES PaymentMethod(methodID),
  housingID integer -- Cette colonne sera reliée à Housing plus tard
);

-- Création de la table Housing
CREATE TABLE Housing (
  housingID serial PRIMARY KEY,
  title varchar(100),
  shortDesc varchar(255),
  longDesc varchar(10000),
  priceEC Float,
  priceINC Float,
  nbRoom integer,
  nbBed integer,
  nbBathroom integer,
  longitude Float,
  latitude Float,
  online Boolean,
  beginDate Date,
  endDate Date,
  creationDate Date,
  ownerID integer REFERENCES Owner(ownerID),
  addressID integer REFERENCES Address(addressID)
);

-- Ajout de la contrainte de clé étrangère sur Reservation.housingID
ALTER TABLE Reservation
  ADD CONSTRAINT fk_housing
  FOREIGN KEY (housingID)
  REFERENCES Housing(housingID);

-- Création de la table Category
CREATE TABLE Category (
  categoryID serial PRIMARY KEY,
  label varchar(30)
);

-- Création de la table Type
CREATE TABLE Type (
  typeID serial PRIMARY KEY,
  label varchar(20)
);

-- Création de la table Arrangement
CREATE TABLE Arrangement (
  arrangementID serial PRIMARY KEY,
  src varchar(255)
);

-- Création de la table Service
CREATE TABLE Service (
  serviceID serial PRIMARY KEY,
  label varchar(50),
  housingID integer REFERENCES Housing(housing
