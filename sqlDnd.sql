-- Users Table: Store login credentials and basic user information
CREATE TABLE Users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Campaigns Table: Store campaign data
CREATE TABLE Campaigns (
    campaign_id INT PRIMARY KEY AUTO_INCREMENT,
    campaign_name VARCHAR(255) NOT NULL,
    description TEXT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES Users(user_id)
);

-- CampaignOwnerships Junction Table: Manages ownership of campaigns by users
CREATE TABLE CampaignOwnerships (
    ownership_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    campaign_id INT,
    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    FOREIGN KEY (campaign_id) REFERENCES Campaigns(campaign_id),
    UNIQUE(user_id, campaign_id)
);

-- CampaignParticipations Junction Table: Manages which characters are part of which campaigns
CREATE TABLE CampaignParticipations (
    participation_id INT PRIMARY KEY AUTO_INCREMENT,
    character_id INT,
    campaign_id INT,
    FOREIGN KEY (character_id) REFERENCES Characters(character_id),
    FOREIGN KEY (campaign_id) REFERENCES Campaigns(campaign_id),
    UNIQUE(character_id, campaign_id)
);

-- Characters Table: Store DnD character details
CREATE TABLE Characters (
    character_id INT PRIMARY KEY AUTO_INCREMENT,
    character_name VARCHAR(255) NOT NULL,
    age INT,
    backstory TEXT,
    country_id INT,
    FOREIGN KEY (country_id) REFERENCES Countries(country_id)
);

-- Countries Table: Store list of countries
CREATE TABLE Countries (
    country_id INT PRIMARY KEY AUTO_INCREMENT,
    country_name VARCHAR(255) NOT NULL UNIQUE
);

-- Citizenship Junction Table: Manages the many-to-one relationship between characters and countries
CREATE TABLE Citizenship (
    citizenship_id INT PRIMARY KEY AUTO_INCREMENT,
    character_id INT,
    country_id INT,
    FOREIGN KEY (character_id) REFERENCES Characters(character_id),
    FOREIGN KEY (country_id) REFERENCES Countries(country_id),
    UNIQUE(character_id, country_id)
);

-- MagicTypes Table: Store list of magic types
CREATE TABLE MagicTypes (
    magic_type_id INT PRIMARY KEY AUTO_INCREMENT,
    magic_name VARCHAR(255) UNIQUE NOT NULL
);

-- MagicTrainings Junction Table: Manages many-to-many relationships between characters and magic types
CREATE TABLE MagicTrainings (
    training_id INT PRIMARY KEY AUTO_INCREMENT,
    character_id INT,
    magic_type_id INT,
    FOREIGN KEY (character_id) REFERENCES Characters(character_id),
    FOREIGN KEY (magic_type_id) REFERENCES MagicTypes(magic_type_id),
    UNIQUE(character_id, magic_type_id)
);

-- Relationships Junction Table: Manages family relationships between characters
CREATE TABLE Relationships (
    relationship_id INT PRIMARY KEY AUTO_INCREMENT,
    character_id INT,
    relative_id INT,
    relationship_type VARCHAR(100),  -- E.g., 'parent', 'sibling', 'spouse'
    FOREIGN KEY (character_id) REFERENCES Characters(character_id),
    FOREIGN KEY (relative_id) REFERENCES Characters(character_id),
    UNIQUE(character_id, relative_id)
);

-- Backstories Table: Store detailed backstories for characters
CREATE TABLE Backstories (
    backstory_id INT PRIMARY KEY AUTO_INCREMENT,
    character_id INT UNIQUE,
    backstory TEXT,
    FOREIGN KEY (character_id) REFERENCES Characters(character_id)
);

-- Indexes for Optimization (optional but recommended)
CREATE INDEX idx_user_campaigns ON CampaignOwnerships (user_id, campaign_id);
CREATE INDEX idx_campaign_participation ON CampaignParticipations (character_id, campaign_id);
CREATE INDEX idx_character_country ON Citizenship (character_id, country_id);
CREATE INDEX idx_character_magic ON MagicTrainings (character_id, magic_type_id);
CREATE INDEX idx_character_relationship ON Relationships (character_id, relative_id);
