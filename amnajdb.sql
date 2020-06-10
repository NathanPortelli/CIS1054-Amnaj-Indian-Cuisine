CREATE TABLE `allergies` (
  `allergyid` int(3) NOT NULL,
  `allergy` varchar(5) NOT NULL,
  `allergyicon` varchar(100) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `allergies` (`allergyid`, `allergy`, `allergyicon`, `name`) VALUES
(1, '[V]', 'resources/images/allergies/vegallergyicon.png', 'Vegan'),
(2, '[S]', 'resources/images/allergies/spiallergyicon.png', 'Spicy'),
(3, '[L]', 'resources/images/allergies/lacallergyicon.png', 'Lactose'),
(4, '[GF]', 'resources/images/allergies/gluallergyicon.png', 'Gluten'),
(5, '[HF]', 'resources/images/allergies/halallergyicon.png', 'Halal'),
(6, '[N]', 'resources/images/allergies/nutallergyicon.png', 'Nuts'),
(7, '[KF]', 'resources/images/allergies/kosallergyicon.png', 'Kosher');

CREATE TABLE `favourites` (
  `userID` int(3) NOT NULL,
  `dishID` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `favourites` (`userID`, `dishID`) VALUES
(6, 6);

CREATE TABLE `hasallergies` (
  `allerID` int(3) NOT NULL,
  `dishID` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `hasallergies` (`allerID`, `dishID`) VALUES
(1, 1),
(2, 2),
(3, 2),
(2, 3),
(1, 3),
(4, 3),
(5, 4),
(3, 4),
(2, 5),
(5, 5),
(6, 6),
(2, 6),
(2, 7),
(2, 8),
(5, 8),
(2, 9),
(1, 9),
(7, 9),
(6, 10),
(3, 10),
(6, 11),
(3, 11),
(3, 12),
(6, 13),
(3, 13),
(6, 15),
(3, 16),
(6, 16);

CREATE TABLE `menu` (
  `dishid` int(3) NOT NULL,
  `dishtype` int(3) NOT NULL,
  `dishname` varchar(100) NOT NULL,
  `dishdesc` varchar(200) NOT NULL,
  `price` float NOT NULL,
  `dishphoto` varchar(50) NOT NULL,
  `ingredients` varchar(250) NOT NULL,
  `serving` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `menu` (`dishid`, `dishtype`, `dishname`, `dishdesc`, `price`, `dishphoto`, `ingredients`, `serving`) VALUES
(1, 1, 'Vegetable Kofta', 'Fried balls mixed with spices and besan, deep fried till crisp', 9, 'resources/images/dishes/Starter1.png', 'Chopped Carrots, Green Peas, Potatoes, Cauliflower, Green beans, Green Chilli, Cilantro, Red Chili Powder, Garam Masala, Chaat Masala, Besan', 3),
(2, 1, 'Paneer Manchurian', 'Deep fried, crispy paneer cubes, coated with spicy, sour and sweet sauce', 8.5, 'resources/images/dishes/Starter2.png', 'Black Pepper, Pinch of Salt, Paneer, Ginger, Garlic, Green Chili, Red Chili Flakes, Chili Sauce, Celery, Onion, Spring Onion, Soy Sauce, White Vinegar', 1),
(3, 1, 'Vegetable Momos', 'Steamed dumplings filled with vegetables and a spicy dipping sauce on the side', 9, 'resources/images/dishes/Starter3.png', 'Garlic, Onion, Spring Onion, Ginger, Cabbage, Green Bell Pepper, Carrots, Salt, Black Pepper, Soy Sauce', 2),
(4, 1, 'Baked Samosas', 'Baked triangular pastry with lamb filling', 8.75, 'resources/images/dishes/Starter4.png', 'Salt, Butter, Onion, Garlic Cloves, Green Chili Peppers, Ginger, Turmeric, Lamb, Garam Masala, Fresh Lemon Juice', 2),
(5, 2, 'Punjabi Chicken in Thick Gravy', 'Chicken curry in a thick spicy gravy, served on a bed of rice', 14.5, 'resources/images/dishes/MainCourse1.png', 'Vegetable Oil, Ghee (Butter), Chicken Legs, Cumin Seeds, Finely Chopped Onion, Garlic Cloves, Chopped Tomato, Garam Masala, Ground Turmeric, Pinch of Salt, Chilli Pepper, Chopped Cilantro', 8),
(6, 2, 'Indian Shrimp Curry', 'Richly flavoured curry that complements shrimp perfectly, served with rice', 15, 'resources/images/dishes/MainCourse2.png', 'Peanut oil, Onion, Garlic Cloves, Ginger, Cumin, Turmeric, Paprika, Red Chili Powder, Chopped Tomatoes, Coconut Milk, Salt, Peeled Shrimp, Chopped Cilantro, Indian Shrimp Curry', 1),
(7, 2, 'Pork Chops and Cauliflower with Rice', 'Pork Chops in curry, with cauliflower, served on a bed of rice', 18, 'resources/images/dishes/MainCourse3.png', 'Basmati rice, Cauliflower Florets, Pork Chops, Curry Powder, Black Pepper, Chicken Broth, Apple Chutney, Green Onions', 1),
(8, 2, 'Roghan Ghosht (Red Lamb)', 'Curried lamb, in a rich tomato-based sauce', 16, 'resources/images/dishes/MainCourse4.png', 'Cubes of lamb, Yogurt, Vegetable Oil, Cinnamon, Cardamom, Cloves, Bay Leaves, Coriander Leaves, Peppercorns, Finely Chopped Onions, Ginger Paste, Coriander Powder, Cumin Powder, Turmeric Powder, Red Chili, Lamb Stock, Salt, Light Cream', 1),
(9, 2, 'Chole Chickpea Curry', 'Curried vegetable dish made from chickpeas', 13.5, 'resources/images/dishes/MainCourse5.png', 'Thinly Sliced Onions, Chopped Tomatoes, Ginger and Garlic Paste, Vegetable Oil, Bay Leaves, Coriander Leaves, Cloves, Cardamom, Peppercorns, Cumin Powder, Coriander Powder, Chili Powder, Turmeric Powder, Garam Masala, Chickpeas, Salt, Ginger', 3),
(10, 3, 'Kulfi', 'Indian ice cream, served in the shape of a cone', 4.5, 'resources/images/dishes/Dessert1.png', 'Milk, Pistachio Nuts, White Sugar, Saffron Threads, Ground Cardamom', 6),
(11, 3, 'Gulab Jamun', 'Soft sponge balls soaked in syrup', 4.7, 'resources/images/dishes/Dessert2.png', 'Milk, Ghee (Butter), Lemon Juice, Pistachios, Cardamom', 2),
(12, 3, 'Soan Papdi', 'Beautiful flaky, cube-shaped cotton candy like dessert', 3.5, 'resources/images/dishes/Dessert3.png', 'Besan (Flour), Ghee (Butter), Crushed Green Cardamom, Milk, Sugar', 4),
(13, 4, 'Thandai', 'A fresh beverage made with almonds, rose Water mixed with milk, served with rose petals', 3.5, 'resources/images/dishes/Drink1.png', 'Almonds, Rose water, Milk, Rose Petals', 1),
(14, 4, 'Jal Jeera', 'A drink made with mint leaves, lemon juice, black salt and dry cumin seed powder', 3.75, 'resources/images/dishes/Drink3.png', 'Mint Leaves, Lemon Juice, Black Salt, Dry Cumin Seed Powder', 1),
(15, 4, 'Kahwa', 'A hot drink with cardamom, cinnamon sticks and almonds', 4.4, 'resources/images/dishes/Drink2.png', 'Water, Cardamom, Cinnamon Sticks, Almonds', 1),
(16, 4, 'Lassi', 'Refreshing beverage made with churning curd and thickened cream', 3.25, 'resources/images/dishes/Drink4.png', 'Yoghurt, Curd, Spices and Thickened Cream', 1);

CREATE TABLE `opening_hours` (
  `day` varchar(9) NOT NULL,
  `hours` varchar(15) NOT NULL,
  `id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `opening_hours` (`day`, `hours`, `id`) VALUES
('Monday', '10:00 - 22:00', 1),
('Tuesday', '10:00 - 22:00', 2),
('Wednesday', '10:00 - 22:00', 3),
('Thursday', '10:00 - 22:00', 4),
('Friday', '10:00 - 22:00', 5),
('Saturday', '09:00 - 18:00', 6),
('Sunday', '09:00 - 16:00', 7);

CREATE TABLE `restaurant_details` (
  `welcome_message` varchar(200) DEFAULT NULL,
  `address` varchar(200) NOT NULL,
  `email_address` varchar(200) NOT NULL,
  `telephone` varchar(12) NOT NULL,
  `mobile` varchar(12) NOT NULL,
  `ourstory` varchar(1000) NOT NULL,
  `ourpromise` varchar(1000) NOT NULL,
  `id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `restaurant_details` (`welcome_message`, `address`, `email_address`, `telephone`, `mobile`, `ourstory`, `ourpromise`, `id`) VALUES
('Welcome to Amnaj Indian Cuisine\'s online website<br>All you need is just a click away!<br><i>Website is updated on a frequent basis</i>', 'Amnaj Indian Cuisine,Triq Alfred Pirel,Blue Grotto,Qrendi', 'amnajcuisine@gmail.com', '+35621337246', '+35699456293', 'Mr. Baljeet Amnaj was a fisherman from Gujarat who was always fond of his local traditions and more especially the cuisine, and one day wondered, \"Why not introduce other countries to our regional diets and flavours?\" Having a very small capital, he started selling street food in India until he had saved enough money to commit to his dream and open \"Amnaj\'s Indian Cuisine\" in Malta, so that this tiny nation could taste the wonders of Gujarat\'s delicacies too. After 30 years of successful operation, the restaurant was passed down to Amnaj\'s son Faisal, who operates the restaurant to this day.', 'We promise you, our highly esteemed customers, an exceptional service with a smile that will keep you coming back for every new dishes that we introduce to our menu on a seasonal basis, such as the Paneer Manchurian and the well sought after Gulab Jamun.     We promise you, that every item on the menu is prepared in the same fashion as is prepared and served back in Gujarat, thanks to our highly qualified cooks and waiting staff. We also promise you, that our menu will always have something for everyone, whether you\'re seeking healthier alternatives or wanting to abide by a vegetarian diet, as well as for many other dietary and religious restrictions, to ensure that the every person can be well catered with a dish that matches exactly with their expectations.', 1);

CREATE TABLE `team_details` (
  `teamid` int(3) NOT NULL,
  `name` varchar(40) NOT NULL,
  `role` varchar(40) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `photo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `team_details` (`teamid`, `name`, `role`, `description`, `photo`) VALUES
(1, 'Faisal Amnaj', 'Owner', 'When he was younger, he always showed a passion for his father\'s business.  He used to help him with the paperwork, until one day, the restaurant was his to manage. One of his life goals is to continue to develop, expand and grow his father\'s business whilst providing top-notch service to the clients. He is very appreciated by his employees, as they always have words of praise and appreciation about him. He currently takes care of the restaurant\'s finances, accounts, and strives to keep his clients satisfied.', 'resources/images/staffimages/ownerguy.jpg'),
(2, 'Bashir Babu', 'Head Chef', 'He studied in one of the top institutions in India and is a hard working person, because he does his job with a passion. He has 15 years of experience in this role. He has worked for very famous Michelin star restaurants around the globe. He keeps the kitchen under control, whilst ensuring the best quality dishes are prepared by him and his assistant chef. His main responsibility is to ensure that the food bought is fresh and to co-ordinate the other chefs and cook at the restaurant. He is very co-operative towards his boss and always tries to suggest new ideas to the owner to keep this restaurant at its best and always full of customers.', 'resources/images/staffimages/chefguy.jpg'),
(3, 'Rakesh Patel', 'Assistant Chef', 'Patel has graduated from New Delhi University of Fine Arts in Food Preparation and Assistance with a first class honours degree as well as a diploma in Food production. He has 9 years of experience in assisting multiple world famous chefs in their food preparation and has always loved giving a helping hand to people from when he was just a young boy. His main responsibility is to help the head chef and ensure a consistent level of hygiene in the kitchen.  Mr. Patel looks forward to assisting the head chef with any help that he may need whilst assuring that the customer is satisfied with the service provided.', 'resources/images/staffimages/fishguy.jpg'),
(4, 'Ahmed Abioye', 'Head Waiter', 'We found Mr. Abioye in the streets, he does an excellent job with the clients however no one knows anything about him. He keeps to himself and disappears the moment he punches out. He hasn\'t cashed in any of the cheques in years. If anyone has any information about Mr. Abioye\'s past, please call our establishment we are very worried we might be employing a murderer on the run.', 'resources/images/staffimages/waiterguy.jpg');

CREATE TABLE `types` (
  `typeid` int(3) NOT NULL,
  `type` varchar(20) NOT NULL,
  `typeimg` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `types` (`typeid`, `type`, `typeimg`) VALUES
(1, 'Starter', 'resources/images/icons/startericon.png'),
(2, 'Main Course', 'resources/images/icons/mainicon.png'),
(3, 'Dessert', 'resources/images/icons/desserticon.png'),
(4, 'Beverage', 'resources/images/icons/beverageicon.png');

CREATE TABLE `usergroups` (
  `groupID` int(3) NOT NULL,
  `usergroup` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `usergroups` (`groupID`, `usergroup`) VALUES
(1, 'Admin'),
(2, 'User');

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `email` tinytext NOT NULL,
  `pword` longtext NOT NULL,
  `name` varchar(20) NOT NULL,
  `surname` varchar(20) NOT NULL,
  `usergroup` int(3) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`id`, `email`, `pword`, `name`, `surname`, `usergroup`) VALUES
(6, 'smithj@gmail.com', '$2y$10$NlIOsRWe2eS67/jpq4QwbOeMNlV2hS/6SEhXheZzC.plEOXZy1dva', 'John', 'Smith', 1);

ALTER TABLE `allergies`
  ADD PRIMARY KEY (`allergyid`);

ALTER TABLE `favourites`
  ADD KEY `user_fav_fk` (`userID`),
  ADD KEY `dish_fav_fk` (`dishID`);

ALTER TABLE `hasallergies`
  ADD KEY `allergy_fk` (`allerID`),
  ADD KEY `dish_fk` (`dishID`);

ALTER TABLE `menu`
  ADD PRIMARY KEY (`dishid`),
  ADD KEY `dish_type_fk` (`dishtype`);

ALTER TABLE `opening_hours`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `restaurant_details`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `team_details`
  ADD PRIMARY KEY (`teamid`);

ALTER TABLE `types`
  ADD PRIMARY KEY (`typeid`);

ALTER TABLE `usergroups`
  ADD PRIMARY KEY (`groupID`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usergroup_fk` (`usergroup`);

ALTER TABLE `allergies`
  MODIFY `allergyid` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `menu`
  MODIFY `dishid` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `opening_hours`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `restaurant_details`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `team_details`
  MODIFY `teamid` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `types`
  MODIFY `typeid` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `usergroups`
  MODIFY `groupID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `favourites`
  ADD CONSTRAINT `dish_fav_fk` FOREIGN KEY (`dishID`) REFERENCES `menu` (`dishid`),
  ADD CONSTRAINT `user_fav_fk` FOREIGN KEY (`userID`) REFERENCES `users` (`id`);

ALTER TABLE `hasallergies`
  ADD CONSTRAINT `allergy_fk` FOREIGN KEY (`allerID`) REFERENCES `allergies` (`allergyid`),
  ADD CONSTRAINT `dish_fk` FOREIGN KEY (`dishID`) REFERENCES `menu` (`dishid`);

ALTER TABLE `menu`
  ADD CONSTRAINT `dish_type_fk` FOREIGN KEY (`dishtype`) REFERENCES `types` (`typeid`);

ALTER TABLE `users`
  ADD CONSTRAINT `usergroup_fk` FOREIGN KEY (`usergroup`) REFERENCES `usergroups` (`groupID`);