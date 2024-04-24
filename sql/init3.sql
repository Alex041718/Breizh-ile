-- Création des tables sans contraintes de clé étrangère pour éviter des problèmes de dépendance circulaire

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

CREATE TABLE Config (
  configID serial PRIMARY KEY,
  label varchar(100),
  value varchar(1000)
);

CREATE TABLE Lang (
  langID serial PRIMARY KEY,
  langName varchar(50),
  langFlag varchar(255)
);

CREATE TABLE User (
  userID serial PRIMARY KEY,
  mail varchar(255) UNIQUE,
  password varchar(255),
  firstName varchar(100),
  nickname varchar(50),
  phoneNumber varchar(50),
  birthDate Date,
  consent Boolean,
  lastConnection Date,
  genderID integer,  -- Clé étrangère ajoutée plus tard
  addressID integer  -- Clé étrangère ajoutée plus tard
);

CREATE TABLE Client (
  clientID serial PRIMARY KEY,
  blocked Boolean,
  userID integer  -- Clé étrangère ajoutée plus tard
);

CREATE TABLE Owner (
  ownerID serial PRIMARY KEY,
  userID integer  -- Clé étrangère ajoutée plus tard
);

CREATE TABLE Paycard (
  paycardID serial PRIMARY KEY,
  cardNumber varchar(50),
  cardName varchar(50),
  CVC varchar(4),
  clientID integer  -- Clé étrangère ajoutée plus tard
);

CREATE TABLE Review (
  reviewID serial PRIMARY KEY,
  note Float,
  comm varchar(3000),
  creationDate Date,
  isReported Boolean,
  clientID integer  -- Clé étrangère ajoutée plus tard
);

CREATE TABLE Activity (
  activityID serial PRIMARY KEY,
  label varchar(200),
  perimeter varchar(20)
);

CREATE TABLE Service (
  serviceID serial PRIMARY KEY,
  label
