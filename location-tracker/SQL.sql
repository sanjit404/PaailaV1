CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  password VARCHAR(255),
  role ENUM('parent','child'),
  latitude DOUBLE,
  longitude DOUBLE
);
CREATE TABLE parent_child (
  id INT AUTO_INCREMENT PRIMARY KEY,
  parent_id INT,
  child_id INT,
  FOREIGN KEY (parent_id) REFERENCES users(id),
  FOREIGN KEY (child_id) REFERENCES users(id)
);