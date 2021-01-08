#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


#------------------------------------------------------------
# Delete database
#------------------------------------------------------------
DROP DATABASE IF EXISTS octopus;
DROP USER IF EXISTS 'pressure'@'localhost';

#DROP USER IF EXISTS 'user_ls'@'localhost'; # Pour les utilisateurs lambda

#------------------------------------------------------------
# Create database
#------------------------------------------------------------
CREATE DATABASE octopus;

#------------------------------------------------------------
# Create user
#------------------------------------------------------------
# Grand manitou
CREATE USER 'pressure'@'localhost' IDENTIFIED BY 'Pressurized0ctopus!';
GRANT ALL PRIVILEGES ON octopus.* TO 'pressure'@'localhost';


FLUSH PRIVILEGES;

USE octopus;


#------------------------------------------------------------
# Table: table_plongee
#------------------------------------------------------------

CREATE TABLE Table_plongee(
        id  Int  Auto_increment  NOT NULL ,
        nom Varchar (50) NOT NULL
	,CONSTRAINT table_plongee_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Profondeur
#------------------------------------------------------------

CREATE TABLE Profondeur(
        id               Int  Auto_increment  NOT NULL ,
        profondeur       TinyINT NOT NULL ,
        id_table_plongee Int NOT NULL
	,CONSTRAINT Profondeur_PK PRIMARY KEY (id)

	,CONSTRAINT Profondeur_table_plongee_FK FOREIGN KEY (id_table_plongee) REFERENCES table_plongee(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Temps
#------------------------------------------------------------

CREATE TABLE Temps(
        id            Int  Auto_increment  NOT NULL ,
        temps         Int NOT NULL ,
        palier15      TinyINT NOT NULL ,
        palier12      TinyINT NOT NULL ,
        palier9       TinyINT NOT NULL ,
        palier6       TinyINT NOT NULL ,
        palier3       TinyINT NOT NULL ,
        id_Profondeur Int NOT NULL
	,CONSTRAINT Temps_PK PRIMARY KEY (id)

	,CONSTRAINT Temps_Profondeur_FK FOREIGN KEY (id_Profondeur) REFERENCES Profondeur(id)
)ENGINE=InnoDB;
