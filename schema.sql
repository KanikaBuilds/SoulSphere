CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content TEXT NOT NULL,
    category VARCHAR(50),
    votes INT DEFAULT 0,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE votes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message_id INT,
    user_ip VARCHAR(45),
    vote_type ENUM('up', 'down'),
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
);
