-- Drop database if it exists
DROP DATABASE IF EXISTS sqlDnd;
CREATE DATABASE sqlDnd;
USE sqlDnd;

-- Users Table: Store login credentials and basic user information
CREATE TABLE Users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Countries Table: Store list of countries
CREATE TABLE Countries (
    country_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL UNIQUE
);

-- Characters Table: Store DnD character details
CREATE TABLE Characters (
    character_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    age INT,
    country_id INT,  -- Foreign key to Countries table
    FOREIGN KEY (country_id) REFERENCES Countries(country_id)
);

-- Backstories Table: Store detailed backstories for characters
CREATE TABLE Backstories (
    backstory_id INT PRIMARY KEY AUTO_INCREMENT,
    character_id INT UNIQUE,  -- Each character has a unique backstory
    backstory TEXT,
    FOREIGN KEY (character_id) REFERENCES Characters(character_id)
);

-- Campaigns Table: Store campaign data
CREATE TABLE Campaigns (
    campaign_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    created_by INT,  -- Foreign key to Users table
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES Users(user_id)
);

-- Campaign Ownerships Table: Manages which users own which campaigns (many-to-many relationship)
CREATE TABLE CampaignOwnerships (
    ownership_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    campaign_id INT,
    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    FOREIGN KEY (campaign_id) REFERENCES Campaigns(campaign_id),
    UNIQUE(user_id, campaign_id)
);

-- Campaign Participations Table: Manages which characters are part of which campaigns (many-to-many relationship)
CREATE TABLE CampaignParticipations (
    participation_id INT PRIMARY KEY AUTO_INCREMENT,
    character_id INT,
    campaign_id INT,
    FOREIGN KEY (character_id) REFERENCES Characters(character_id),
    FOREIGN KEY (campaign_id) REFERENCES Campaigns(campaign_id),
    UNIQUE(character_id, campaign_id)
);

-- Magic Types Table: Store list of magic types
CREATE TABLE MagicTypes (
    type_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) UNIQUE NOT NULL
);


-- Magic Types Table: Store list of magic types
CREATE TABLE RelationTypes (
    relationtype_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) UNIQUE NOT NULL
);

-- Magic Trainings Table: Manages many-to-many relationships between characters and magic types
CREATE TABLE MagicTrainings (
    training_id INT PRIMARY KEY AUTO_INCREMENT,
    character_id INT,
    magictype_id INT,
    FOREIGN KEY (character_id) REFERENCES Characters(character_id),
    FOREIGN KEY (magictype_id) REFERENCES MagicTypes(magictype_id),
    UNIQUE(character_id, magictype_id)
);

-- Relationships Table: Manages family relationships between characters
CREATE TABLE Relationships (
    relationship_id INT PRIMARY KEY AUTO_INCREMENT,
    character_id INT,
    relative_id INT,
    relationtype_id INT,  -- Refers to the RelationTypes table
    FOREIGN KEY (character_id) REFERENCES Characters(character_id),
    FOREIGN KEY (relative_id) REFERENCES Characters(character_id),
    FOREIGN KEY (relationtype_id) REFERENCES RelationTypes(relationtype_id),  -- New reference
    UNIQUE(character_id, relative_id)
);


INSERT INTO RelationTypes (name)
VALUES
    ('Sibling'), -- 1
    ('Romantic Partner'), -- 2
    ('Friend'); -- 3
    
    
INSERT INTO MagicTypes (name)
VALUES
    ('Fire'), -- 1
    ('Water'), -- 2
    ('Earth'), -- 3
    ('Wind'), -- 4
    ('Shadow'), -- 5
    ('Light'), -- 6
    ('Aether'), -- 7
    ('Pure'), -- 8
    ('Spirit'), -- 9
    ('Antimagic'), -- 10
    ('Lightning'); -- 11
    
-- Inserting characters into the Characters table
INSERT INTO Countries (name)
VALUES
    ('Kaentos'), -- 1
    ('Kholdon'),-- 2
    ('Frescoza'), -- 3
    ('Galacia'), -- 4
    ('Oriah'), -- 5
    ('Yubi'), -- 6
    ('Chiyanyu'), -- 7
    ('Soyaze'), -- 8
    ('Azahara Ard'), -- 9
    ('Shioland'), -- 10
    ('Mushando'); -- 11

INSERT INTO Characters (name, age, country_id)
VALUES
    ('Elenai Cherra', 22, 11), -- 1
    ('Jak Flynn', 23, 1), -- 2
    ('Hao Minori', 32, 7), -- 3
    ('Rin Tol Mayus', 29, 1), -- 4
    ('Mizu Hidora', 35, 10); -- 5
    
    
INSERT INTO MagicTrainings (character_id, magictype_id)
VALUES
	(1, 5),
	(1, 10),
	(3, 2),
	(3, 8),
	(3, 11),
	(4, 1),
	(4, 8),
	(5, 2),
	(5, 8);
    
INSERT INTO Relationships (character_id, relative_id, relationtype_id)
VALUES
	(1, 2, 2),
	(3, 4, 3),
	(4, 5, 3),
	(3, 5, 3);

-- Indexes for optimization
CREATE INDEX idx_user_campaigns ON CampaignOwnerships (user_id, campaign_id);
CREATE INDEX idx_campaign_participation ON CampaignParticipations (character_id, campaign_id);
CREATE INDEX idx_character_country ON Characters (country_id);
CREATE INDEX idx_character_magic ON MagicTrainings (character_id, magictype_id);
CREATE INDEX idx_character_relationship ON Relationships (character_id, relative_id);


