CREATE DATABASE IF NOT EXISTS RealEstate;
USE RealEstate;

CREATE TABLE Property (
    address VARCHAR(50) NOT NULL PRIMARY KEY,
    ownerName VARCHAR(30),
    price INTEGER
);

CREATE TABLE House (
    bedrooms INTEGER,
    bathrooms INTEGER,
    size INTEGER,
    address VARCHAR(50),
    FOREIGN KEY (address) REFERENCES Property(address)
);

CREATE TABLE BusinessProperty (
    type VARCHAR(20),
    size INTEGER,
    address VARCHAR(50),
    FOREIGN KEY (address) REFERENCES Property(address)
);

CREATE TABLE Firm (
    id INTEGER PRIMARY KEY,
    name VARCHAR(30),
    address VARCHAR(50)
);

CREATE TABLE Agent (
    agentId INTEGER PRIMARY KEY,
    name VARCHAR(30),
    phone VARCHAR(12),
    firmId INTEGER NOT NULL,
    dateStarted DATE
);

CREATE TABLE Listings (
    mlsNumber INTEGER PRIMARY KEY,
    address VARCHAR(50) UNIQUE,
    FOREIGN KEY (address) REFERENCES Property(address),
    agentId INTEGER,
    dateListed DATE
);

CREATE TABLE Buyer (
    id INTEGER PRIMARY KEY,
    name VARCHAR(30),
    phone VARCHAR(12),
    propertyType VARCHAR(20),
    bedrooms INTEGER,
    bathrooms INTEGER,
    businessPropertyType VARCHAR(20),
    minimumPreferredPrice INTEGER,
    maximumPreferredPrice INTEGER
);

CREATE TABLE Works_With (
    buyerId INTEGER,
    agentId INTEGER
);

-- Insert Property data with standard addresses and owner names
INSERT INTO Property(address, ownerName, price) VALUES
('123 Main Street', 'John Smith', 69000),
('456 Elm Street', 'Jane Doe', 320000),
('983 Oak Avenue', 'Robert Johnson', 232320),
('237 Pine Street', 'Michael Williams', 450000),
('897 Maple Lane', 'William Brown', 9484000),
('600 Cedar Road', 'David Jones', 3435363),
('756 Birch Road', 'Richard Miller', 353535324),
('902 Walnut Street', 'Charles Davis', 243535),
('874 Cherry Lane', 'Joseph Garcia', 131324),
('123 Willow Drive', 'Thomas Rodriguez', 13242);

-- Insert House data using matching addresses
INSERT INTO House (address, bedrooms, bathrooms, size) VALUES
('123 Main Street', 3, 2, 1500),
('456 Elm Street', 2, 1, 1200),
('983 Oak Avenue', 4, 3, 2000),
('237 Pine Street', 3, 2, 1600),
('897 Maple Lane', 3, 2, 1400);

-- Insert BusinessProperty data using matching addresses
INSERT INTO BusinessProperty (address, type, size) VALUES
('600 Cedar Road', 'Grocery Store', 3000),
('756 Birch Road', 'Gas Station', 2500),
('902 Walnut Street', 'School', 1800),
('874 Cherry Lane', 'Restaurant', 2200),
('123 Willow Drive', 'Office Space', 2000);

-- Insert Firm data with conventional firm names and addresses
INSERT INTO Firm (id, name, address) VALUES
(1, 'Alpha Realty', '123 Corporate Blvd'),
(2, 'Beta Properties', '321 Business Ave'),
(3, 'Gamma Realty', '432 Market Street'),
(4, 'Delta Properties', '764 Commerce Rd'),
(5, 'Epsilon Realty', '902 Enterprise Way');

-- Insert Agent data with common names
INSERT INTO Agent (agentId, name, phone, firmId, dateStarted) VALUES
(101, 'Robert Brown', '123-456-7890', 1, '2015-06-01'),
(102, 'Jane Smith', '098-765-4321', 2, '2016-07-15'),
(103, 'Richard Johnson', '111-123-4567', 3, '2017-08-20'),
(104, 'Samuel Davis', '222-123-4567', 4, '2018-09-25'),
(105, 'Michael Miller', '333-123-4567', 5, '2019-10-30');

-- Insert Buyer data with conventional names and preferences
INSERT INTO Buyer (id, name, phone, propertyType, bedrooms, bathrooms, businessPropertyType, minimumPreferredPrice, maximumPreferredPrice) VALUES
(201, 'Frank Thomas', '444-123-4567', 'House', 3, 2, NULL, 150000, 250000),
(202, 'Bob Williams', '555-123-4567', 'Business Property', NULL, NULL, 'Office Space', 200000, 350000), 
(203, 'John Doe', '777-123-4567', 'House', 2, 1, NULL, 100000, 200000),
(204, 'Ben Carter', '888-123-4567', 'Business Property', NULL, NULL, 'Gas Station', 180000, 300000), 
(205, 'Eric Johnson', '999-123-4567', 'House', 4, 3, NULL, 250000, 400000);

-- Insert Works_With relationships (linking buyers to agents)
INSERT INTO Works_With (buyerId, agentId) VALUES
(201, 101),
(202, 102),
(203, 103),
(204, 104),
(205, 105);

-- Insert Listings data using matching addresses
INSERT INTO Listings (mlsNumber, address, agentId, dateListed) VALUES
(1001, '123 Main Street', 101, '2024-11-10'),
(1002, '456 Elm Street', 102, '2024-11-11'),
(1003, '983 Oak Avenue', 103, '2024-11-12'),
(1004, '237 Pine Street', 104, '2024-11-13'),
(1005, '897 Maple Lane', 105, '2024-11-14'),
(1006, '600 Cedar Road', 101, '2024-11-15'),
(1007, '756 Birch Road', 102, '2024-11-16'),
(1008, '902 Walnut Street', 103, '2024-11-17'),
(1009, '874 Cherry Lane', 104, '2024-11-18'),
(1010, '123 Willow Drive', 105, '2024-11-19');
