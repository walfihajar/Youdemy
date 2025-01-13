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


INSERT INTO category (id_category, name) VALUES
(1, 'Web Development'),
(2, 'Data Science'),
(3, 'Artificial Intelligence'),
(4, 'Cybersecurity'),
(5, 'Mobile App Development'),
(6, 'Game Development'),
(7, 'Cloud Computing'),
(8, 'Digital Marketing'),
(9, 'Graphic Design'),
(10, 'Photography'),
(11, 'Video Editing'),
(12, 'Music Production'),
(13, 'Cooking'),
(14, 'Language Learning'),
(15, 'Creative Writing'),
(16, 'Entrepreneurship'),
(17, 'Financial Planning'),
(18, 'Personal Development'),
(19, 'Public Speaking'),
(20, 'Project Management'),
(21, 'UI/UX Design'),
(22, 'Blockchain'),
(23, 'Networking'),
(24, 'Ethical Hacking'),
(25, 'Machine Learning'),
(26, 'Deep Learning'),
(27, 'DevOps'),
(28, '3D Modeling'),
(29, 'Animation'),
(30, 'Interior Design'),
(31, 'Architecture'),
(32, 'Fashion Design'),
(33, 'Event Management'),
(34, 'Sports Coaching'),
(35, 'Yoga and Meditation'),
(36, 'Nutrition and Dietetics'),
(37, 'Astronomy'),
(38, 'Biotechnology'),
(39, 'Robotics'),
(40, 'Quantum Computing');


INSERT INTO users (id_user, first_name, second_name, email, password, picture, id_role) VALUES
(1, 'Alice', 'Smith', 'alice.smith@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture1.jpg',1),
(2, 'Bob', 'Johnson', 'bob.johnson@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture2.jpg', 2),
(3, 'Charlie', 'Williams', 'charlie.williams@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture3.jpg', 3),
(4, 'Diana', 'Brown', 'diana.brown@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture4.jpg',3),
(5, 'Ethan', 'Jones', 'ethan.jones@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture5.jpg', 2),
(6, 'Fiona', 'Miller', 'fiona.miller@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture6.jpg', 3),
(7, 'George', 'Taylor', 'george.taylor@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture7.jpg',3),
(8, 'Hannah', 'Anderson', 'hannah.anderson@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture8.jpg', 2),
(9, 'Ian', 'Thomas', 'ian.thomas@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture9.jpg', 3),
(10, 'Jane', 'Jackson', 'jane.jackson@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture10.jpg',3),
(11, 'Kevin', 'White', 'kevin.white@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture11.jpg', 2),
(12, 'Laura', 'Harris', 'laura.harris@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture12.jpg', 3),
(13, 'Michael', 'Martin', 'michael.martin@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture13.jpg',3),
(14, 'Nina', 'Thompson', 'nina.thompson@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture14.jpg', 2),
(15, 'Oliver', 'Garcia', 'oliver.garcia@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture15.jpg', 3),
(16, 'Paula', 'Martinez', 'paula.martinez@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture16.jpg',3),
(17, 'Quinn', 'Robinson', 'quinn.robinson@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture17.jpg', 2),
(18, 'Rachel', 'Clark', 'rachel.clark@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture18.jpg', 3),
(19, 'Samuel', 'Rodriguez', 'samuel.rodriguez@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture19.jpg',3),
(20, 'Tina', 'Lewis', 'tina.lewis@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture20.jpg', 2),
(21, 'Uma', 'Lee', 'uma.lee@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture21.jpg', 3),
(22, 'Victor', 'Walker', 'victor.walker@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture22.jpg',3),
(23, 'Wendy', 'Hall', 'wendy.hall@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture23.jpg', 2),
(24, 'Xander', 'Allen', 'xander.allen@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture24.jpg', 3),
(25, 'Yara', 'Young', 'yara.young@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture25.jpg',3),
(26, 'Zane', 'King', 'zane.king@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture26.jpg', 2),
(27, 'Adam', 'Hill', 'adam.hill@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture27.jpg', 3),
(28, 'Bella', 'Scott', 'bella.scott@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture28.jpg',3),
(29, 'Chris', 'Green', 'chris.green@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture29.jpg', 2),
(30, 'Daisy', 'Adams', 'daisy.adams@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture30.jpg', 3),
(31, 'Edward', 'Baker', 'edward.baker@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture31.jpg',3),
(32, 'Felicity', 'Perez', 'felicity.perez@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture32.jpg', 2),
(33, 'Gavin', 'Rivera', 'gavin.rivera@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture33.jpg', 3),
(34, 'Hailey', 'Campbell', 'hailey.campbell@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture34.jpg',3),
(35, 'Isaac', 'Mitchell', 'isaac.mitchell@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture35.jpg', 2),
(36, 'Julia', 'Carter', 'julia.carter@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture36.jpg', 3),
(37, 'Kyle', 'Phillips', 'kyle.phillips@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture37.jpg',3),
(38, 'Lydia', 'Evans', 'lydia.evans@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture38.jpg', 2),
(39, 'Mason', 'Turner', 'mason.turner@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture39.jpg', 3),
(40, 'Natalie', 'Torres', 'natalie.torres@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture40.jpg',3),
(41, 'Oscar', 'Parker', 'oscar.parker@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture41.jpg', 2),
(42, 'Penelope', 'Collins', 'penelope.collins@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture42.jpg', 3),
(43, 'Quentin', 'Edwards', 'quentin.edwards@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture43.jpg',3),
(44, 'Rebecca', 'Stewart', 'rebecca.stewart@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture44.jpg', 2),
(45, 'Steven', 'Sanchez', 'steven.sanchez@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture45.jpg', 3),
(46, 'Tara', 'Morris', 'tara.morris@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture46.jpg',3),
(47, 'Ursula', 'Rogers', 'ursula.rogers@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture47.jpg', 2),
(48, 'Victor', 'Reed', 'victor.reed@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture48.jpg', 3),
(49, 'Wanda', 'Cook', 'wanda.cook@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture49.jpg',3),
(50, 'Xenia', 'Morgan', 'xenia.morgan@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture50.jpg', 2),
(51, 'Yasmine', 'Bell', 'yasmine.bell@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture51.jpg', 3),
(52, 'Zack', 'Murphy', 'zack.murphy@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture52.jpg',3),
(53, 'Aiden', 'Bailey', 'aiden.bailey@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture53.jpg', 2),
(54, 'Blake', 'River', 'blake.river@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture54.jpg', 3),
(55, 'Cameron', 'Frost', 'cameron.frost@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture55.jpg',3),
(56, 'Daphne', 'Knight', 'daphne.knight@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture56.jpg', 2),
(57, 'Elliot', 'Hale', 'elliot.hale@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture57.jpg', 3),
(58, 'Faith', 'Day', 'faith.day@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture58.jpg',3),
(59, 'Grant', 'West', 'grant.west@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture59.jpg', 2),
(60, 'Zara', 'Wilson', 'zara.wilson@example.com', '$2y$10$Rlvo2GJWEEsut2YTfFGHTOLAGpK3a2PBztaBWtnOQMSXeq6idusrK', 'picture60.jpg', 3);


-- Insertion de 60 cours dans la table `course`
INSERT INTO course (title, description, content, picture, id_category, id_user) VALUES
('Introduction to Web Development', 'Learn the basics of web development.', 'HTML, CSS, JavaScript basics.', 'web_dev.jpg', 1, 2),
('Advanced Web Development', 'Master advanced web development techniques.', 'React, Node.js, and MongoDB.', 'web_dev_advanced.jpg', 1, 5),
('Data Science Fundamentals', 'Learn the basics of data science.', 'Python, Pandas, and Matplotlib.', 'data_science.jpg', 2, 8),
('Machine Learning Basics', 'Introduction to machine learning.', 'Scikit-learn, TensorFlow, and Keras.', 'ml_basics.jpg', 25, 11),
('Cybersecurity Essentials', 'Learn the fundamentals of cybersecurity.', 'Network security, encryption, and firewalls.', 'cybersecurity.jpg', 4, 14),
('Mobile App Development with Flutter', 'Build cross-platform mobile apps.', 'Flutter, Dart, and Firebase.', 'flutter.jpg', 5, 17),
('Game Development with Unity', 'Create games using Unity.', 'C#, Unity Engine, and game physics.', 'unity.jpg', 6, 20),
('Cloud Computing with AWS', 'Learn cloud computing with Amazon Web Services.', 'EC2, S3, and Lambda.', 'aws.jpg', 7, 23),
('Digital Marketing Strategies', 'Master digital marketing techniques.', 'SEO, SEM, and social media marketing.', 'digital_marketing.jpg', 8, 26),
('Graphic Design for Beginners', 'Learn the basics of graphic design.', 'Adobe Photoshop and Illustrator.', 'graphic_design.jpg', 9, 29),
('Photography Basics', 'Learn the fundamentals of photography.', 'Camera settings, composition, and lighting.', 'photography.jpg', 10, 32),
('Video Editing with Premiere Pro', 'Edit videos like a pro.', 'Adobe Premiere Pro basics.', 'premiere_pro.jpg', 11, 35),
('Music Production with Ableton', 'Produce music using Ableton Live.', 'Ableton Live, MIDI, and audio effects.', 'ableton.jpg', 12, 38),
('Cooking Basics', 'Learn the basics of cooking.', 'Knife skills, recipes, and techniques.', 'cooking.jpg', 13, 41),
('Learn Spanish', 'Start speaking Spanish today.', 'Basic vocabulary and grammar.', 'spanish.jpg', 14, 44),
('Creative Writing Workshop', 'Unleash your creativity.', 'Storytelling, character development, and plot.', 'creative_writing.jpg', 15, 47),
('Entrepreneurship 101', 'Start your own business.', 'Business planning, marketing, and finance.', 'entrepreneurship.jpg', 16, 50),
('Financial Planning Basics', 'Manage your finances effectively.', 'Budgeting, saving, and investing.', 'financial_planning.jpg', 17, 53),
('Public Speaking Mastery', 'Become a confident public speaker.', 'Speech writing, delivery, and body language.', 'public_speaking.jpg', 19, 56),
('Project Management Essentials', 'Manage projects like a pro.', 'Agile, Scrum, and project planning.', 'project_management.jpg', 20, 59),
('UI/UX Design Fundamentals', 'Design user-friendly interfaces.', 'Figma, wireframing, and prototyping.', 'ui_ux.jpg', 21, 2),
('Blockchain Basics', 'Understand blockchain technology.', 'Bitcoin, Ethereum, and smart contracts.', 'blockchain.jpg', 22, 5),
('Networking Essentials', 'Learn the basics of computer networking.', 'TCP/IP, DNS, and routing.', 'networking.jpg', 23, 8),
('Ethical Hacking Basics', 'Learn ethical hacking techniques.', 'Penetration testing and vulnerability scanning.', 'ethical_hacking.jpg', 24, 11),
('Deep Learning with Python', 'Master deep learning techniques.', 'Neural networks, TensorFlow, and Keras.', 'deep_learning.jpg', 26, 14),
('DevOps Fundamentals', 'Learn the basics of DevOps.', 'CI/CD, Docker, and Kubernetes.', 'devops.jpg', 27, 17),
('3D Modeling with Blender', 'Create 3D models using Blender.', 'Blender basics and modeling techniques.', 'blender.jpg', 28, 20),
('Animation Basics', 'Learn the fundamentals of animation.', '2D and 3D animation techniques.', 'animation.jpg', 29, 23),
('Interior Design Basics', 'Design beautiful interiors.', 'Space planning, color theory, and materials.', 'interior_design.jpg', 30, 26),
('Architecture Fundamentals', 'Learn the basics of architecture.', 'Design principles and architectural drawing.', 'architecture.jpg', 31, 29),
('Fashion Design Basics', 'Create your own fashion designs.', 'Sketching, pattern making, and sewing.', 'fashion_design.jpg', 32, 32),
('Event Management Essentials', 'Plan and manage successful events.', 'Event planning, budgeting, and logistics.', 'event_management.jpg', 33, 35),
('Sports Coaching Basics', 'Learn the fundamentals of sports coaching.', 'Coaching techniques and athlete development.', 'sports_coaching.jpg', 34, 38),
('Yoga and Meditation', 'Improve your well-being with yoga.', 'Yoga poses, breathing techniques, and meditation.', 'yoga.jpg', 35, 41),
('Nutrition and Dietetics', 'Learn the basics of nutrition.', 'Macronutrients, micronutrients, and diet planning.', 'nutrition.jpg', 36, 44),
('Astronomy Basics', 'Explore the wonders of the universe.', 'Stars, planets, and galaxies.', 'astronomy.jpg', 37, 47),
('Biotechnology Fundamentals', 'Learn the basics of biotechnology.', 'Genetic engineering and bioprocessing.', 'biotechnology.jpg', 38, 50),
('Robotics Basics', 'Build and program robots.', 'Robotics, sensors, and actuators.', 'robotics.jpg', 39, 53),
('Quantum Computing Basics', 'Understand quantum computing.', 'Qubits, quantum gates, and algorithms.', 'quantum_computing.jpg', 40, 56),
('Advanced Data Science', 'Master advanced data science techniques.', 'Machine learning, deep learning, and big data.', 'data_science_advanced.jpg', 2, 59),
('Web Security Essentials', 'Secure your web applications.', 'OWASP Top 10, encryption, and authentication.', 'web_security.jpg', 4, 2),
('Mobile App Security', 'Secure your mobile apps.', 'Android and iOS security best practices.', 'mobile_security.jpg', 5, 5),
('Game Design Principles', 'Design engaging games.', 'Game mechanics, level design, and storytelling.', 'game_design.jpg', 6, 8),
('Cloud Security with AWS', 'Secure your cloud infrastructure.', 'AWS IAM, VPC, and security groups.', 'cloud_security.jpg', 7, 11),
('Social Media Marketing', 'Master social media marketing.', 'Facebook, Instagram, and Twitter marketing.', 'social_media.jpg', 8, 14),
('Advanced Graphic Design', 'Take your design skills to the next level.', 'Advanced Photoshop and Illustrator techniques.', 'graphic_design_advanced.jpg', 9, 17),
('Portrait Photography', 'Master portrait photography.', 'Lighting, posing, and editing.', 'portrait_photography.jpg', 10, 20),
('Advanced Video Editing', 'Edit videos like a pro.', 'Advanced Premiere Pro techniques.', 'video_editing_advanced.jpg', 11, 23),
('Music Theory Basics', 'Learn the fundamentals of music theory.', 'Scales, chords, and rhythm.', 'music_theory.jpg', 12, 26),
('Advanced Cooking Techniques', 'Master advanced cooking techniques.', 'Sous-vide, fermentation, and molecular gastronomy.', 'cooking_advanced.jpg', 13, 29),
('Learn French', 'Start speaking French today.', 'Basic vocabulary and grammar.', 'french.jpg', 14, 32),
('Screenwriting Workshop', 'Write your own screenplay.', 'Story structure, dialogue, and character development.', 'screenwriting.jpg', 15, 35),
('Startup Funding', 'Raise funds for your startup.', 'Venture capital, angel investors, and crowdfunding.', 'startup_funding.jpg', 16, 38),
('Investment Strategies', 'Learn how to invest wisely.', 'Stocks, bonds, and real estate.', 'investment.jpg', 17, 41),
('Advanced Public Speaking', 'Become a master public speaker.', 'Persuasion, storytelling, and audience engagement.', 'public_speaking_advanced.jpg', 19, 44),
('Agile Project Management', 'Manage projects using Agile methodologies.', 'Scrum, Kanban, and sprint planning.', 'agile.jpg', 20, 47),
('Advanced UI/UX Design', 'Design user-friendly interfaces.', 'User research, usability testing, and prototyping.', 'ui_ux_advanced.jpg', 21, 50),
('Blockchain Development', 'Build blockchain applications.', 'Smart contracts, DApps, and Solidity.', 'blockchain_dev.jpg', 22, 53),
('Advanced Networking', 'Master advanced networking techniques.', 'VPNs, firewalls, and network security.', 'networking_advanced.jpg', 23, 56),
('Advanced Ethical Hacking', 'Master ethical hacking techniques.', 'Advanced penetration testing and forensics.', 'ethical_hacking_advanced.jpg', 24, 59);

-- Insertion des inscriptions dans la table `enrollment`
INSERT INTO enrollment (id_course, id_user) VALUES
-- Utilisateur 2 (Bob Johnson)
(1, 2), -- Introduction to Web Development
-- Utilisateur 5 (Ethan Jones)
(2, 5), -- Advanced Web Development
-- Utilisateur 8 (Hannah Anderson)
(3, 8), -- Data Science Fundamentals
-- Utilisateur 11 (Kevin White)
(4, 11), -- Machine Learning Basics
-- Utilisateur 14 (Nina Thompson)
(5, 14), -- Cybersecurity Essentials
-- Utilisateur 17 (Quinn Robinson)
(6, 17), -- Mobile App Development with Flutter
-- Utilisateur 20 (Tina Lewis)
(7, 20), -- Game Development with Unity
-- Utilisateur 23 (Wendy Hall)
(8, 23), -- Cloud Computing with AWS
-- Utilisateur 26 (Zane King)
(9, 26), -- Digital Marketing Strategies
-- Utilisateur 29 (Chris Green)
(10, 29), -- Graphic Design for Beginners
-- Utilisateur 32 (Felicity Perez)
(11, 32), -- Photography Basics
-- Utilisateur 35 (Isaac Mitchell)
(12, 35), -- Video Editing with Premiere Pro
-- Utilisateur 38 (Lydia Evans)
(13, 38), -- Music Production with Ableton
-- Utilisateur 41 (Oscar Parker)
(14, 41), -- Cooking Basics
-- Utilisateur 44 (Rebecca Stewart)
(15, 44), -- Learn Spanish
-- Utilisateur 47 (Ursula Rogers)
(16, 47), -- Creative Writing Workshop
-- Utilisateur 50 (Xenia Morgan)
(17, 50), -- Entrepreneurship 101
-- Utilisateur 53 (Aiden Bailey)
(18, 53), -- Financial Planning Basics
-- Utilisateur 56 (Daphne Knight)
(19, 56), -- Public Speaking Mastery
-- Utilisateur 59 (Grant West)
(20, 59), -- Project Management Essentials
-- Utilisateur 2 (Bob Johnson)
(21, 2), -- UI/UX Design Fundamentals
-- Utilisateur 5 (Ethan Jones)
(22, 5), -- Blockchain Basics
-- Utilisateur 8 (Hannah Anderson)
(23, 8), -- Networking Essentials
-- Utilisateur 11 (Kevin White)
(24, 11), -- Ethical Hacking Basics
-- Utilisateur 14 (Nina Thompson)
(25, 14), -- Deep Learning with Python
-- Utilisateur 17 (Quinn Robinson)
(26, 17), -- DevOps Fundamentals
-- Utilisateur 20 (Tina Lewis)
(27, 20), -- 3D Modeling with Blender
-- Utilisateur 23 (Wendy Hall)
(28, 23), -- Animation Basics
-- Utilisateur 26 (Zane King)
(29, 26), -- Interior Design Basics
-- Utilisateur 29 (Chris Green)
(30, 29), -- Architecture Fundamentals
-- Utilisateur 32 (Felicity Perez)
(31, 32), -- Fashion Design Basics
-- Utilisateur 35 (Isaac Mitchell)
(32, 35), -- Event Management Essentials
-- Utilisateur 38 (Lydia Evans)
(33, 38), -- Sports Coaching Basics
-- Utilisateur 41 (Oscar Parker)
(34, 41), -- Yoga and Meditation
-- Utilisateur 44 (Rebecca Stewart)
(35, 44), -- Nutrition and Dietetics
-- Utilisateur 47 (Ursula Rogers)
(36, 47), -- Astronomy Basics
-- Utilisateur 50 (Xenia Morgan)
(37, 50), -- Biotechnology Fundamentals
-- Utilisateur 53 (Aiden Bailey)
(38, 53), -- Robotics Basics
-- Utilisateur 56 (Daphne Knight)
(39, 56), -- Quantum Computing Basics
-- Utilisateur 59 (Grant West)
(40, 59), -- Advanced Data Science
-- Utilisateur 2 (Bob Johnson)
(41, 2), -- Web Security Essentials
-- Utilisateur 5 (Ethan Jones)
(42, 5), -- Mobile App Security
-- Utilisateur 8 (Hannah Anderson)
(43, 8), -- Game Design Principles
-- Utilisateur 11 (Kevin White)
(44, 11), -- Cloud Security with AWS
-- Utilisateur 14 (Nina Thompson)
(45, 14), -- Social Media Marketing
-- Utilisateur 17 (Quinn Robinson)
(46, 17), -- Advanced Graphic Design
-- Utilisateur 20 (Tina Lewis)
(47, 20), -- Portrait Photography
-- Utilisateur 23 (Wendy Hall)
(48, 23), -- Advanced Video Editing
-- Utilisateur 26 (Zane King)
(49, 26), -- Music Theory Basics
-- Utilisateur 29 (Chris Green)
(50, 29), -- Advanced Cooking Techniques
-- Utilisateur 32 (Felicity Perez)
(51, 32), -- Learn French
-- Utilisateur 35 (Isaac Mitchell)
(52, 35), -- Screenwriting Workshop
-- Utilisateur 38 (Lydia Evans)
(53, 38), -- Startup Funding
-- Utilisateur 41 (Oscar Parker)
(54, 41), -- Investment Strategies
-- Utilisateur 44 (Rebecca Stewart)
(55, 44), -- Advanced Public Speaking
-- Utilisateur 47 (Ursula Rogers)
(56, 47), -- Agile Project Management
-- Utilisateur 50 (Xenia Morgan)
(57, 50), -- Advanced UI/UX Design
-- Utilisateur 53 (Aiden Bailey)
(58, 53), -- Blockchain Development
-- Utilisateur 56 (Daphne Knight)
(59, 56), -- Advanced Networking
-- Utilisateur 59 (Grant West)
(60, 59); -- Advanced Ethical Hacking


-- Insertion des tags dans la table `tag`
INSERT INTO tag (name) VALUES
('Web Development'),
('HTML'),
('CSS'),
('JavaScript'),
('React'),
('Node.js'),
('MongoDB'),
('Data Science'),
('Python'),
('Pandas'),
('Matplotlib'),
('Machine Learning'),
('Scikit-learn'),
('TensorFlow'),
('Keras'),
('Cybersecurity'),
('Network Security'),
('Encryption'),
('Firewalls'),
('Mobile App Development'),
('Flutter'),
('Dart'),
('Firebase'),
('Game Development'),
('Unity'),
('C#'),
('Game Physics'),
('Cloud Computing'),
('AWS'),
('EC2'),
('S3'),
('Lambda'),
('Digital Marketing'),
('SEO'),
('SEM'),
('Social Media Marketing'),
('Graphic Design'),
('Adobe Photoshop'),
('Adobe Illustrator'),
('Photography'),
('Camera Settings'),
('Composition'),
('Lighting'),
('Video Editing'),
('Premiere Pro'),
('Music Production'),
('Ableton Live'),
('MIDI'),
('Audio Effects'),
('Cooking'),
('Knife Skills'),
('Recipes'),
('Techniques'),
('Language Learning'),
('Spanish'),
('Creative Writing'),
('Storytelling'),
('Character Development'),
('Plot'),
('Entrepreneurship'),
('Business Planning'),
('Marketing'),
('Finance'),
('Financial Planning'),
('Budgeting'),
('Saving'),
('Investing'),
('Public Speaking'),
('Speech Writing'),
('Delivery'),
('Body Language'),
('Project Management'),
('Agile'),
('Scrum'),
('UI/UX Design'),
('Figma'),
('Wireframing'),
('Prototyping'),
('Blockchain'),
('Bitcoin'),
('Ethereum'),
('Smart Contracts'),
('Networking'),
('TCP/IP'),
('DNS'),
('Routing'),
('Ethical Hacking'),
('Penetration Testing'),
('Vulnerability Scanning'),
('Deep Learning'),
('Neural Networks'),
('DevOps'),
('CI/CD'),
('Docker'),
('Kubernetes'),
('3D Modeling'),
('Blender'),
('Animation'),
('2D Animation'),
('3D Animation'),
('Interior Design'),
('Space Planning'),
('Color Theory'),
('Materials'),
('Architecture'),
('Design Principles'),
('Architectural Drawing'),
('Fashion Design'),
('Sketching'),
('Pattern Making'),
('Sewing'),
('Event Management'),
('Event Planning'),
('Budgeting'),
('Logistics'),
('Sports Coaching'),
('Coaching Techniques'),
('Athlete Development'),
('Yoga'),
('Meditation'),
('Breathing Techniques'),
('Nutrition'),
('Macronutrients'),
('Micronutrients'),
('Diet Planning'),
('Astronomy'),
('Stars'),
('Planets'),
('Galaxies'),
('Biotechnology'),
('Genetic Engineering'),
('Bioprocessing'),
('Robotics'),
('Sensors'),
('Actuators'),
('Quantum Computing'),
('Qubits'),
('Quantum Gates'),
('Algorithms'),
('Advanced Data Science'),
('Big Data'),
('Web Security'),
('OWASP Top 10'),
('Authentication'),
('Mobile App Security'),
('Android Security'),
('iOS Security'),
('Game Design'),
('Game Mechanics'),
('Level Design'),
('Cloud Security'),
('IAM'),
('VPC'),
('Security Groups'),
('Social Media'),
('Facebook Marketing'),
('Instagram Marketing'),
('Twitter Marketing'),
('Advanced Graphic Design'),
('Advanced Photoshop'),
('Advanced Illustrator'),
('Portrait Photography'),
('Posing'),
('Editing'),
('Advanced Video Editing'),
('Music Theory'),
('Scales'),
('Chords'),
('Rhythm'),
('Advanced Cooking'),
('Sous-vide'),
('Fermentation'),
('Molecular Gastronomy'),
('French'),
('Screenwriting'),
('Startup Funding'),
('Venture Capital'),
('Angel Investors'),
('Crowdfunding'),
('Investment Strategies'),
('Stocks'),
('Bonds'),
('Real Estate'),
('Advanced Public Speaking'),
('Persuasion'),
('Audience Engagement'),
('Agile Project Management'),
('Kanban'),
('Sprint Planning'),
('Advanced UI/UX Design'),
('User Research'),
('Usability Testing'),
('Blockchain Development'),
('DApps'),
('Solidity'),
('Advanced Networking'),
('VPNs'),
('Firewalls'),
('Advanced Ethical Hacking'),
('Forensics');

-- Insertion des associations entre les tags et les cours dans la table `course_tag`
INSERT INTO course_tag (id_course, id_tag) VALUES
-- Introduction to Web Development (id_course = 1)
(1, 1), (1, 2), (1, 3), (1, 4),
-- Advanced Web Development (id_course = 2)
(2, 1), (2, 5), (2, 6), (2, 7),
-- Data Science Fundamentals (id_course = 3)
(3, 8), (3, 9), (3, 10), (3, 11),
-- Machine Learning Basics (id_course = 4)
(4, 12), (4, 13), (4, 14), (4, 15),
-- Cybersecurity Essentials (id_course = 5)
(5, 16), (5, 17), (5, 18), (5, 19),
-- Mobile App Development with Flutter (id_course = 6)
(6, 20), (6, 21), (6, 22), (6, 23),
-- Game Development with Unity (id_course = 7)
(7, 24), (7, 25), (7, 26), (7, 27),
-- Cloud Computing with AWS (id_course = 8)
(8, 28), (8, 29), (8, 30), (8, 31),
-- Digital Marketing Strategies (id_course = 9)
(9, 32), (9, 33), (9, 34), (9, 35),
-- Graphic Design for Beginners (id_course = 10)
(10, 36), (10, 37), (10, 38), (10, 39),
-- Photography Basics (id_course = 11)
(11, 40), (11, 41), (11, 42), (11, 43),
-- Video Editing with Premiere Pro (id_course = 12)
(12, 44), (12, 45), (12, 46), (12, 47),
-- Music Production with Ableton (id_course = 13)
(13, 48), (13, 49), (13, 50), (13, 51),
-- Cooking Basics (id_course = 14)
(14, 52), (14, 53), (14, 54), (14, 55),
-- Learn Spanish (id_course = 15)
(15, 56), (15, 57), (15, 58), (15, 59),
-- Creative Writing Workshop (id_course = 16)
(16, 60), (16, 61), (16, 62), (16, 63),
-- Entrepreneurship 101 (id_course = 17)
(17, 64), (17, 65), (17, 66), (17, 67),
-- Financial Planning Basics (id_course = 18)
(18, 68), (18, 69), (18, 70), (18, 71),
-- Public Speaking Mastery (id_course = 19)
(19, 72), (19, 73), (19, 74), (19, 75),
-- Project Management Essentials (id_course = 20)
(20, 76), (20, 77), (20, 78), (20, 79),
-- UI/UX Design Fundamentals (id_course = 21)
(21, 80), (21, 81), (21, 82), (21, 83),
-- Blockchain Basics (id_course = 22)
(22, 84), (22, 85), (22, 86), (22, 87),
-- Networking Essentials (id_course = 23)
(23, 88), (23, 89), (23, 90), (23, 91),
-- Ethical Hacking Basics (id_course = 24)
(24, 92), (24, 93), (24, 94), (24, 95),
-- Deep Learning with Python (id_course = 25)
(25, 96), (25, 97), (25, 98), (25, 99),
-- DevOps Fundamentals (id_course = 26)
(26, 100), (26, 101), (26, 102), (26, 103),
-- 3D Modeling with Blender (id_course = 27)
(27, 104), (27, 105), (27, 106), (27, 107),
-- Animation Basics (id_course = 28)
(28, 108), (28, 109), (28, 110), (28, 111),
-- Interior Design Basics (id_course = 29)
(29, 112), (29, 113), (29, 114), (29, 115),
-- Architecture Fundamentals (id_course = 30)
(30, 116), (30, 117), (30, 118), (30, 119),
-- Fashion Design Basics (id_course = 31)
(31, 120), (31, 121), (31, 122), (31, 123),
-- Event Management Essentials (id_course = 32)
(32, 124), (32, 125), (32, 126), (32, 127),
-- Sports Coaching Basics (id_course = 33)
(33, 128), (33, 129), (33, 130), (33, 131),
-- Yoga and Meditation (id_course = 34)
(34, 132), (34, 133), (34, 134), (34, 135),
-- Nutrition and Dietetics (id_course = 35)
(35, 136), (35, 137), (35, 138), (35, 139),
-- Astronomy Basics (id_course = 36)
(36, 140), (36, 141), (36, 142), (36, 143),
-- Biotechnology Fundamentals (id_course = 37)
(37, 144), (37, 145), (37, 146), (37, 147),
-- Robotics Basics (id_course = 38)
(38, 148), (38, 149), (38, 150), (38, 151),
-- Quantum Computing Basics (id_course = 39)
(39, 152), (39, 153), (39, 154), (39, 155),
-- Advanced Data Science (id_course = 40)
(40, 156), (40, 157), (40, 158), (40, 159),
-- Web Security Essentials (id_course = 41)
(41, 160), (41, 161), (41, 162), (41, 163),
-- Mobile App Security (id_course = 42)
(42, 164), (42, 165), (42, 166), (42, 167),
-- Game Design Principles (id_course = 43)
(43, 168), (43, 169), (43, 170), (43, 171),
-- Cloud Security with AWS (id_course = 44)
(44, 172), (44, 173), (44, 174), (44, 175),
-- Social Media Marketing (id_course = 45)
(45, 176), (45, 177), (45, 178), (45, 179),
-- Advanced Graphic Design (id_course = 46)
(46, 180), (46, 181), (46, 182), (46, 183),
-- Portrait Photography (id_course = 47)
(47, 184), (47, 185), (47, 186), (47, 187),
-- Advanced Video Editing (id_course = 48)
(48, 188), (48, 189), (48, 190), (48, 191),
-- Music Theory Basics (id_course = 49)
(49, 192), (49, 193), (49, 194), (49, 195),
-- Advanced Cooking Techniques (id_course = 50)
(50, 196), (50, 197), (50, 198), (50, 199),
-- Learn French (id_course = 51)
(51, 200), (51, 174), (51, 175), (51, 176),
-- Screenwriting Workshop (id_course = 52)
(52, 177), (52, 178), (52, 179), (52, 180),
-- Startup Funding (id_course = 53)
(53, 181), (53, 182), (53, 183), (53, 184),
-- Investment Strategies (id_course = 54)
(54, 185), (54, 186), (54, 187), (54, 188),
-- Advanced Public Speaking (id_course = 55)
(55, 189), (55, 190), (55, 191), (55, 192),
-- Agile Project Management (id_course = 56)
(56, 193), (56, 194), (56, 195), (56, 196),
-- Advanced UI/UX Design (id_course = 57)
(57, 197), (57, 198), (57, 199), (57, 200),
-- Blockchain Development (id_course = 58)
(58, 84), (58, 85), (58, 86), (58, 87),
-- Advanced Networking (id_course = 59)
(59, 88), (59, 89), (59, 90), (59, 91),
-- Advanced Ethical Hacking (id_course = 60)
(60, 92), (60, 93), (60, 94), (60, 95);