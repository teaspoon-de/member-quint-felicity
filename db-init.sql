-- DATABASE INITIALIZATION SCRIPT FOR QUINT-FELICITY.DE

CREATE DATABASE IF NOT EXISTS quint_felicity
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

CREATE USER IF NOT EXISTS 'www_quint_felicity'@'%'
    IDENTIFIED BY 'YqDW4k6EMKp1lBS8IatiP0lh2Mruvohe';

GRANT ALL PRIVILEGES ON quint_felicity.* TO 'www_quint_felicity'@'%';
FLUSH PRIVILEGES;

USE quint_felicity;

-- global metadata table
CREATE TABLE IF NOT EXISTS site_meta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    key_name VARCHAR(255) UNIQUE NOT NULL,
    value_text TEXT NULL,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);



-- TABLES

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    name VARCHAR(255) NULL,
    email VARCHAR(255) NULL,
    password VARCHAR(255) NOT NULL,
    instrument VARCHAR(255) NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS privileges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS user_privileges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    privilege_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE,
    FOREIGN KEY (privilege_id) REFERENCES privileges(id)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    uri VARCHAR(255) NOT NULL,
    title VARCHAR(255) NULL,
    description TEXT NULL,
    alt VARCHAR(255) NULL,
    taken_at DATETIME NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('show', 'rehearsal', 'other') NOT NULL,
    title VARCHAR(255) NOT NULL,
    description VARCHAR(255) NULL,
    location VARCHAR(255) NULL,
    notes TEXT NULL,
    date_begin DATETIME NOT NULL,
    date_end DATETIME NULL,
    public_entry DATETIME NULL,
    deadline DATETIME NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS blogposts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    cover_id INT NULL,
    content TEXT NULL,
    last_edit DATETIME DEFAULT CURRENT_TIMESTAMP,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cover_id) REFERENCES images(id)
);

CREATE TABLE IF NOT EXISTS event_blogpost (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    blogpost_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id),
    FOREIGN KEY (blogpost_id) REFERENCES blogposts(id)
);

CREATE TABLE IF NOT EXISTS event_registration (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    user_id INT NOT NULL,
    status ENUM('yes', 'no', 'maybe') NOT NULL,
    last_edit DATETIME DEFAULT CURRENT_TIMESTAMP,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id)
        ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS songs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NULL,
    artists VARCHAR(255) NULL,
    cover_url VARCHAR(255) NULL,
    duration INT NULL,
    spotify_id VARCHAR(255) NULL,
    /*('C', 'Db', 'D', 'Eb', 'E', 'F', 'F#', 'G', 'Ab', 'A', 'Bb', 'B')*/
    original_key_maj INT DEFAULT -1,
    is_major BOOLEAN NULL,
    transposed_by INT DEFAULT 0,
    status ENUM('red', 'orange', 'green') DEFAULT 'red',
    notes TEXT NULL,
    added_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS song_transitions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    from_id INT NOT NULL,
    to_id INT NOT NULL,
    description TEXT NULL,
    status ENUM('red', 'orange', 'green') DEFAULT 'red',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (from_id) REFERENCES songs(id)
        ON DELETE CASCADE,
    FOREIGN KEY (to_id) REFERENCES songs(id)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS setlists (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    event_id INT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS setlist_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('song', 'transition', 'note') NOT NULL,
    setlist_id INT NOT NULL,
    position INT NOT NULL,
    song_id INT NULL,
    transition_id INT NULL,
    text TEXT NULL,
    status ENUM('red', 'orange', 'green') DEFAULT 'red',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (setlist_id) REFERENCES setlists(id)
        ON DELETE CASCADE,
    FOREIGN KEY (song_id) REFERENCES songs(id),
    FOREIGN KEY (transition_id) REFERENCES song_transitions(id)
);

CREATE TABLE IF NOT EXISTS event_setlist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    setlist_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id)
        ON DELETE CASCADE,
    FOREIGN KEY (setlist_id) REFERENCES setlists(id)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS rehearsal_songs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    song_id INT NOT NULL,
    notes TEXT NULL,
    position INT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id)
        ON DELETE CASCADE,
    FOREIGN KEY (song_id) REFERENCES songs(id)
        ON DELETE CASCADE
);