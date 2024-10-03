-- Create a database for the Rebel Alliance

DROP DATABASE IF EXISTS rebel_alliance;
CREATE DATABASE rebel_alliance;
USE rebel_alliance;

-- Create a table for members
CREATE TABLE members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    species VARCHAR(50),
    `rank` VARCHAR(50),
    home_planet VARCHAR(50)
);

CREATE TABLE skills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT,
	skill VARCHAR(100) NOT NULL
);

-- Insert sample members into the table
INSERT INTO members (name, species, `rank`, home_planet) VALUES
('Mon Mothma', 'Human', 'Leader', 'Chandrila'),
('Leia Organa', 'Human', 'Princess', 'Alderaan'),
('Han Solo', 'Human', 'Captain', 'Corellia'),
('Luke Skywalker', 'Human', 'Jedi Knight', 'Tatooine'),
('Chewbacca', 'Wookiee', 'Co-pilot', 'Kashyyyk'),
('Lando Calrissian', 'Human', 'General', 'Socorro'),
('Admiral Ackbar', 'Mon Calamari', 'Admiral', 'Mon Cala');

INSERT INTO skills (member_id, skill) VALUES
(1, 'Diplomacy'),
(1, 'Leadership'),
(2, 'Combat'),
(2, 'Strategy'),
(2, 'Diplomacy'),
(3, 'Piloting'),
(3, 'Smuggling'),
(3, 'Negotiation'),
(4, 'Force abilities'),
(4, 'Lightsaber combat'),
(5, 'Strength'),
(5, 'Mechanics'),
(5, 'Pilot'),
(6, 'Gambling'),
(6, 'Diplomacy'),
(6, 'Pilot'),
(7, 'Naval tactics'),
(7, 'Strategy');

-- Query to retrieve all members
-- SELECT * FROM members;
-- SELECT * FROM skills;
SELECT * FROM members JOIN skills ON members.id = skills.member_id;