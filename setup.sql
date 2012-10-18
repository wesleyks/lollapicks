CREATE DATABASE IF NOT EXISTS lolla_db;
USE lolla_db;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS Venues;
DROP TABLE IF EXISTS Bands;
DROP TABLE IF EXISTS Events;
DROP TABLE IF EXISTS Requests;

CREATE TABLE Venues (
    id INTEGER,
    title VARCHAR(100) NOT NULL,
    sort_order INTEGER,
    latitude DOUBLE(13,10) NOT NULL,
    longitude DOUBLE(13,10) NOT NULL,
    PRIMARY KEY(id)
);
CREATE TABLE Bands (
    id INTEGER,
    title VARCHAR(100),
    big_pic VARCHAR(200),
    small_pic VARCHAR(200),
    bio TEXT,
    fan_count INTEGER,
    PRIMARY KEY(id)
);
CREATE TABLE Events (
    id INTEGER,
    title VARCHAR(100) NOT NULL,
    band_id INTEGER NOT NULL,
    venue_id INTEGER NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(band_id) REFERENCES Bands(id),
    FOREIGN KEY(venue_id) REFERENCES Venues(id)
);
CREATE TABLE Requests (
    event_tag VARCHAR(30),
    band_id INTEGER,
    band_name VARCHAR(100),
    song_title VARCHAR(100),
    request_count INTEGER UNSIGNED,
    PRIMARY KEY(event_tag,band_id,song_title),
    FOREIGN KEY(band_id) REFERENCES Bands(id)
);

SET FOREIGN_KEY_CHECKS = 1;