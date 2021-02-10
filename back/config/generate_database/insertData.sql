USE octopus;


#user to log
INSERT INTO user (username, roles, password) VALUES ("admin",'["ROLE_USER"]',"$argon2i$v=19$m=16,t=2,p=1$MEZTOGJDMmNQM2VEOHNUVQ$syuI5YGrVZC84oE8uThZWg");

#table_plongee (nom)
INSERT INTO tableplongee (nom) VALUES ("Bullman"),
("MN90");

#Profondeur (profondeur,correspond_id)
INSERT INTO profondeur (profondeur,correspond_id) VALUES (12,1),
(15,1),
(18,1),
(21,1),
(24,1),
(27,1),
(30,1),
(33,1),
(36,1),
(39,1),
(42,1),
(45,1),
(48,1),
(51,1),
(54,1),
(57,1),
(6,2),
(8,2),
(10,2),
(12,2),
(15,2),
(18,2),
(20,2),
(22,2),
(25,2),
(28,2),
(30,2),
(32,2),
(35,2),
(38,2),
(40,2),
(42,2),
(45,2),
(48,2),
(50,2),
(52,2),
(55,2),
(58,2),
(60,2);

#Temps (esta_id,temps,palier15,palier12,palier9,palier6,palier3)
INSERT INTO temps (esta_id,temps,palier15,palier12,palier9,palier6,palier3) VALUES (1,125,0,0,0,0,1),
(2,75,0,0,0,0,1),
(2,90,0,0,0,0,7),
(3,51,0,0,0,0,1),
(3,70,0,0,0,0,11),
(4,35,0,0,0,0,1),
(4,50,0,0,0,0,8),
(4,60,0,0,0,0,16),
(5,25,0,0,0,0,1),
(5,35,0,0,0,0,4),
(5,40,0,0,0,0,8),
(5,50,0,0,0,0,17),
(5,60,0,0,0,4,24),
(6,20,0,0,0,0,1),
(6,30,0,0,0,0,5),
(6,35,0,0,0,0,10),
(6,40,0,0,0,2,13),
(6,45,0,0,0,3,18),
(6,50,0,0,0,6,22),
(7,17,0,0,0,0,1),
(7,25,0,0,0,0,5),
(7,30,0,0,0,2,7),
(7,35,0,0,0,3,14),
(7,40,0,0,0,5,17),
(7,45,0,0,0,9,23),
(8,14,0,0,0,0,1),
(8,20,0,0,0,0,4),
(8,25,0,0,0,2,7),
(8,30,0,0,0,4,11),
(8,35,0,0,0,6,17),
(8,40,0,0,2,8,23),
(9,12,0,0,0,0,1),
(9,20,0,0,0,2,5),
(9,25,0,0,0,4,9),
(9,30,0,0,2,5,15),
(9,35,0,0,2,8,23),
(10,10,0,0,0,0,1),
(10,15,0,0,0,0,4),
(10,20,0,0,0,3,7),
(10,25,0,0,2,4,12),
(10,30,0,0,3,7,18),
(10,35,0,0,5,9,28),
(11,9,0,0,0,0,1),
(11,12,0,0,0,0,4),
(11,15,0,0,0,1,5),
(11,18,0,0,0,4,6),
(11,21,0,0,2,4,10),
(11,24,0,0,3,6,16),
(11,27,0,0,4,7,19),
(12,12,0,0,0,0,5),
(12,15,0,0,0,3,5),
(12,18,0,0,2,4,9),
(12,21,0,0,3,5,13),
(12,24,0,0,4,6,18),
(13,9,0,0,0,0,3),
(13,12,0,0,0,2,5),
(13,15,0,0,0,4,6),
(13,18,0,0,3,4,10),
(13,21,0,0,4,6,16),
(14,9,0,0,0,0,4),
(14,12,0,0,0,3,6),
(14,15,0,0,2,4,8),
(14,18,0,0,4,5,13),
(14,21,0,3,4,7,18),
(15,9,0,0,0,1,5),
(15,12,0,0,1,4,6),
(15,15,0,0,3,4,10),
(15,18,0,1,3,6,17),
(16,9,0,0,0,2,5),
(16,12,0,0,2,4,8),
(16,15,0,1,4,5,11),
(16,18,0,3,4,7,18),
(17,75,0,0,0,0,0),
(17,105,0,0,0,0,0),
(17,135,0,0,0,0,0),
(18,30,0,0,0,0,0),
(18,60,0,0,0,0,0),
(18,90,0,0,0,0,0),
(18,135,0,0,0,0,0),
(19,30,0,0,0,0,0),
(19,60,0,0,0,0,0),
(19,90,0,0,0,0,0),
(19,105,0,0,0,0,0),
(19,135,0,0,0,0,0),
(20,45,0,0,0,0,0),
(20,55,0,0,0,0,0),
(20,65,0,0,0,0,0),
(20,80,0,0,0,0,0),
(20,90,0,0,0,0,0),
(20,105,0,0,0,0,0),
(20,120,0,0,0,0,0),
(20,140,0,0,0,0,2),
(21,20,0,0,0,0,0),
(21,30,0,0,0,0,0),
(21,40,0,0,0,0,0),
(21,50,0,0,0,0,0),
(21,60,0,0,0,0,0),
(21,70,0,0,0,0,0),
(21,80,0,0,0,0,2),
(21,85,0,0,0,0,4),
(21,90,0,0,0,0,6),
(22,20,0,0,0,0,0),
(22,30,0,0,0,0,0),
(22,40,0,0,0,0,0),
(22,50,0,0,0,0,0),
(22,55,0,0,0,0,1),
(22,60,0,0,0,0,5),
(22,65,0,0,0,0,8),
(22,70,0,0,0,0,11),
(22,75,0,0,0,0,14),
(23,20,0,0,0,0,0),
(23,25,0,0,0,0,0),
(23,30,0,0,0,0,0),
(23,35,0,0,0,0,0),
(23,40,0,0,0,0,1),
(23,45,0,0,0,0,4),
(23,50,0,0,0,0,9),
(23,55,0,0,0,0,13),
(23,60,0,0,0,0,0),
(24,15,0,0,0,0,0),
(24,20,0,0,0,0,0),
(24,25,0,0,0,0,0),
(24,30,0,0,0,0,0),
(24,35,0,0,0,0,0),
(24,40,0,0,0,0,2),
(24,45,0,0,0,0,7),
(24,50,0,0,0,0,12),
(24,55,0,0,0,0,16),
(24,60,0,0,0,0,20),
(25,15,0,0,0,0,0),
(25,20,0,0,0,0,0),
(25,25,0,0,0,0,1),
(25,30,0,0,0,0,2),
(25,35,0,0,0,0,5),
(25,40,0,0,0,0,10),
(25,45,0,0,0,0,16),
(25,50,0,0,0,0,21),
(25,55,0,0,0,0,27),
(25,60,0,0,0,0,32),
(26,15,0,0,0,0,0),
(26,20,0,0,0,0,1),
(26,25,0,0,0,0,2),
(26,30,0,0,0,0,6),
(26,35,0,0,0,0,12),
(26,40,0,0,0,0,19),
(26,45,0,0,0,0,25),
(26,50,0,0,0,0,32),
(26,55,0,0,0,2,36),
(27,10,0,0,0,0,0),
(27,15,0,0,0,0,1),
(27,20,0,0,0,0,2),
(27,25,0,0,0,0,4),
(27,30,0,0,0,0,9),
(27,35,0,0,0,0,17),
(27,40,0,0,0,0,24),
(27,45,0,0,0,1,31),
(27,50,0,0,0,3,36),
(28,10,0,0,0,0,0),
(28,15,0,0,0,0,1),
(28,20,0,0,0,0,3),
(28,25,0,0,0,0,6),
(28,30,0,0,0,0,14),
(28,35,0,0,0,0,22),
(28,40,0,0,0,1,29),
(29,10,0,0,0,0,0),
(29,15,0,0,0,0,2),
(29,20,0,0,0,0,5),
(29,25,0,0,0,0,11),
(29,30,0,0,0,1,20),
(29,35,0,0,0,2,27),
(29,40,0,0,0,5,34),
(30,5,0,0,0,0,0),
(30,10,0,0,0,0,1),
(30,15,0,0,0,0,4),
(30,20,0,0,0,1,8),
(30,25,0,0,0,2,16),
(30,30,0,0,0,4,24),
(30,35,0,0,0,8,33),
(31,5,0,0,0,0,0),
(31,10,0,0,0,0,2),
(31,15,0,0,0,0,4),
(31,20,0,0,0,1,9),
(31,25,0,0,0,3,19),
(31,30,0,0,0,6,28),
(31,35,0,0,0,11,35),
(32,5,0,0,0,0,0),
(32,10,0,0,0,0,2),
(32,15,0,0,0,1,5),
(32,20,0,0,0,3,12),
(32,25,0,0,0,5,22),
(32,30,0,0,0,9,31),
(32,35,0,0,0,15,37),
(33,5,0,0,0,0,0),
(33,10,0,0,0,0,3),
(33,15,0,0,0,2,6),
(33,20,0,0,0,4,15),
(33,25,0,0,0,7,25),
(33,30,0,0,0,12,35),
(33,35,0,0,1,18,40),
(34,5,0,0,0,0,0),
(34,10,0,0,0,0,4),
(34,15,0,0,0,2,7),
(34,20,0,0,0,3,19),
(34,25,0,0,0,8,30),
(34,30,0,0,1,14,37),
(34,35,0,0,3,20,44),
(35,5,0,0,0,0,1),
(35,10,0,0,0,1,4),
(35,15,0,0,0,3,9),
(35,20,0,0,0,6,22),
(35,25,0,0,1,9,32),
(35,30,0,0,2,15,39),
(35,35,0,0,5,22,45),
(36,5,0,0,0,0,1),
(36,10,0,0,0,1,4),
(36,15,0,0,0,3,10),
(36,20,0,0,1,6,23),
(36,25,0,0,2,9,34),
(36,30,0,0,4,15,41),
(36,35,0,0,6,22,47),
(37,5,0,0,0,0,1),
(37,10,0,0,0,1,5),
(37,15,0,0,0,2,13),
(37,20,0,0,1,6,27),
(37,25,0,0,3,11,37),
(37,30,0,0,6,18,44),
(38,5,0,0,0,0,2),
(38,10,0,0,0,2,5),
(38,15,0,0,1,4,16),
(38,20,0,0,2,7,30),
(38,25,0,0,4,13,40),
(39,5,0,0,0,0,2),
(39,10,0,0,0,2,6),
(39,15,0,0,1,4,19),
(39,20,0,0,3,8,32);