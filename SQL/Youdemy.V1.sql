CREATE TABLE role(
    id_role INT AUTO_INCREMENT PRIMARY KEY,
    role enum('tutor','admin','learner')
);

CREATE TABLE user(
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    second_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    picture VARCHAR(255),
    id_role INT NOT NULL,
    FOREIGN KEY (id_role) REFERENCES role(id_role)
);

CREATE TABLE category(
    id_category INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE course(
    id_course INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    content TEXT NOT NULL,
    picture VARCHAR(250),
    id_category INT NOT NULL,
    id_user INT NOT NULL,
    FOREIGN KEY (id_category) REFERENCES category(id_category),
    FOREIGN KEY (id_user) REFERENCES user(id_user)
);

CREATE TABLE tag(
    id_tag INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE course_tag(
    id_tag INT NOT NULL,
    id_course INT NOT NULL,
    PRIMARY KEY (id_tag, id_course),
    FOREIGN KEY (id_tag) REFERENCES tag(id_tag),
    FOREIGN KEY (id_course) REFERENCES course(id_course)
);

CREATE TABLE enrollement(
    id_course INT NOT NULL,
    id_user INT NOT NULL, 
    PRIMARY KEY (id_course,id_user),
    FOREIGN KEY (id_user) REFERENCES user(id_user),
    FOREIGN KEY (id_course) REFERENCES course(id_course)
);
