-- Création de la table `Gender`
CREATE TABLE Gender (
    genderID serial PRIMARY KEY,
    genderName varchar(20)
);

-- Création de la table `Admin`
CREATE TABLE Admin (
    adminID serial PRIMARY KEY,
    mail varchar(255) UNIQUE,
    firstname varchar(100),
    lastname varchar(100),
    nickname varchar(50),
    password varchar(255)
);

-- Création de la table `Lang`
CREATE TABLE Lang (
    langID serial PRIMARY KEY,
    langName varchar(50),
    langFlag varchar(255)
);

-- Création de la table `Paycard`
CREATE TABLE Paycard (
    paycardID serial PRIMARY KEY,
    cardNumber varchar(50),
    ownerName varchar(50),
    CVC varchar(4)
);

-- Création de la table `Client`
CREATE TABLE Client (
    clientID serial PRIMARY KEY,
    mail varchar(255) UNIQUE,
    firstname varchar(100),
    lastname varchar(100),
    nickname varchar(50),
    phoneNumber varchar(50),
    birthDate Date,
    consent Boolean,
    lastConnection Date,
    genderID integer,
    adminID integer,
    FOREIGN KEY (genderID) REFERENCES Gender(genderID),
    FOREIGN KEY (adminID) REFERENCES Admin(adminID)
);

-- Création de la table `User`
CREATE TABLE User (
    userID serial PRIMARY KEY,
    mail varchar(255) UNIQUE,
    firstname varchar(100),
    lastname varchar(100),
    nickname varchar(50),
    phoneNumber varchar(50),
    birthDate Date,
    consent Boolean,
    lastConnection Date,
    genderID integer,
    FOREIGN KEY (genderID) REFERENCES Gender(genderID)
);

-- Création de la table `Owner`
CREATE TABLE Owner (
    ownerID serial PRIMARY KEY,
    identityCard varchar(100)
);

-- Création de la table `Service`
CREATE TABLE Service (
    serviceID serial PRIMARY KEY,
    label varchar(50)
);

-- Création de la table `Activity`
CREATE TABLE Activity (
    activityID serial PRIMARY KEY,
    label varchar(20),
    activityCost float,
    perimeter varchar(20)
);

-- Création de la table `Config`
CREATE TABLE Config (
    configID serial PRIMARY KEY,
    label varchar(100),
    value varchar(1000)
);

-- Création de la table `Address`
CREATE TABLE Address (
    addressID serial PRIMARY KEY,
    street varchar(100),
    city varchar(100),
    postalCode varchar(5),
    postalAddress varchar(255)
);

-- Création de la table `Housing`
CREATE TABLE Housing (
    housingID serial PRIMARY KEY,
    title varchar(100),
    shortDesc varchar(255),
    longDesc varchar(10000),
    priceExcl Float,
    priceIncl Float,
    nbRoom integer,
    nbSleeping integer,
    nbDoubleBed integer,
    nbSimpleBed integer,
    longitude Float,
    latitude Float,
    isOnline Boolean,
    begDate Date,
    endDate Date,
    creationDate Date,
    addressID integer,
    ownerID integer,
    FOREIGN KEY (addressID) REFERENCES Address(addressID),
    FOREIGN KEY (ownerID) REFERENCES Owner(ownerID)
);

-- Création de la table `Category`
CREATE TABLE Category (
    categoryID serial PRIMARY KEY,
    label varchar(30)
);

-- Création de la table `Type`
CREATE TABLE Type (
    typeID serial PRIMARY KEY,
    label varchar(20)
);

-- Création de la table `Arrangement`
CREATE TABLE Arrangement (
    arrangementID serial PRIMARY KEY,
    src varchar(255)
);

-- Création de la table `PaymentMethod`
CREATE TABLE PaymentMethod (
    methodID serial PRIMARY KEY,
    label varchar(50)
);

-- Création de la table `Review`
CREATE TABLE Review (
    reviewID serial PRIMARY KEY,
    note Float,
    comm varchar(3000),
    creationDate Date,
    isReported Boolean,
    clientID integer,
    housingID integer,
    FOREIGN KEY (clientID) REFERENCES Client(clientID),
    FOREIGN KEY (housingID) REFERENCES Housing(housingID)
);

-- Création de la table `Image`
CREATE TABLE Image (
    imageID serial PRIMARY KEY,
    src varchar(255)
);

-- Création de la table `Reservation`
CREATE TABLE Reservation (
    reservationID serial PRIMARY KEY,
    begDate Date,
    endDate Date,
    serviceCharge Float,
    touristTax Float,
    status varchar(20),
    housingID integer,
    methodID integer,
    FOREIGN KEY (housingID) REFERENCES Housing(housingID),
    FOREIGN KEY (methodID) REFERENCES PaymentMethod(methodID)
);

-- Associations many-to-many et autres contraintes

-- Association Client-Paycard
CREATE TABLE Client_Paycard (
    clientID integer,
    paycardID integer,
    PRIMARY KEY (clientID, paycardID),
    FOREIGN KEY (clientID) REFERENCES Client(clientID),
    FOREIGN KEY (paycardID) REFERENCES Paycard(paycardID)
);

-- Association Housing-Activity
CREATE TABLE Housing_Activity (
    housingID integer,
    activityID integer,
    PRIMARY KEY (housingID, activityID),
    FOREIGN KEY (housingID) REFERENCES Housing(housingID),
    FOREIGN KEY (activityID) REFERENCES Activity(activityID)
);

-- Association Housing-Service
CREATE TABLE Housing_Service (
    housingID integer,
    serviceID integer,
    PRIMARY KEY (housingID, serviceID),
    FOREIGN KEY (housingID) REFERENCES Housing(housingID),
    FOREIGN KEY (serviceID) REFERENCES Service(serviceID)
);

-- Association Housing-Type
CREATE TABLE Housing_Type (
    housingID integer,
    typeID integer,
    PRIMARY KEY (housingID, typeID),
    FOREIGN KEY (housingID) REFERENCES Housing(housingID),
    FOREIGN KEY (typeID) REFERENCES Type(typeID)
);

-- Association Housing-Category
CREATE TABLE Housing_Category (
    housingID integer,
    categoryID integer,
    PRIMARY KEY (housingID, categoryID),
    FOREIGN KEY (housingID) REFERENCES Housing(housingID),
    FOREIGN KEY (categoryID) REFERENCES Category(categoryID)
);

-- Association Housing-Arrangement
CREATE TABLE Housing_Arrangement (
    housingID integer,
    arrangementID integer,
    PRIMARY KEY (housingID, arrangementID),
    FOREIGN KEY (housingID) REFERENCES Housing(housingID),
    FOREIGN KEY (arrangementID) REFERENCES Arrangement(arrangementID)
);

-- Association User-Image
CREATE TABLE User_Image (
    userID integer,
    imageID integer,
    PRIMARY KEY (userID, imageID),
    FOREIGN KEY (userID) REFERENCES User(userID),
    FOREIGN KEY (imageID) REFERENCES Image(imageID)
);

-- Association Client-Image
CREATE TABLE Client_Image (
    clientID integer,
    imageID integer,
    PRIMARY KEY (clientID, imageID),
    FOREIGN KEY (clientID) REFERENCES Client(clientID),
    FOREIGN KEY (imageID) REFERENCES Image(imageID)
);

-- Association Lang-User (Langage de l'utilisateur)
CREATE TABLE Lang_User (
    langID integer,
    userID integer,
    PRIMARY KEY (langID, userID),
    FOREIGN KEY (langID) REFERENCES Lang(langID),
    FOREIGN KEY (userID) REFERENCES User(userID)
);
