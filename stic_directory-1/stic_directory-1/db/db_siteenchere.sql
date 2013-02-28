SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `site_enchere` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `site_enchere` ;

-- -----------------------------------------------------
-- Table `site_enchere`.`produit`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `site_enchere`.`produit` ;

CREATE  TABLE IF NOT EXISTS `site_enchere`.`produit` (
  `idProduit` INT NOT NULL AUTO_INCREMENT ,
  `nomProduit` VARCHAR(45) NULL ,
  `descriptionProduit` TEXT NULL ,
  `photoProduit` VARCHAR(45) NULL ,
  `prixDDProduit` INT UNSIGNED NULL ,
  `prixDVProduit` INT UNSIGNED NULL ,
  `dateDMELProduit` DATETIME NULL ,
  `dateDVProduit` DATETIME NULL ,
  PRIMARY KEY (`idProduit`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `site_enchere`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `site_enchere`.`user` ;

CREATE  TABLE IF NOT EXISTS `site_enchere`.`user` (
  `idUser` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nomUser` VARCHAR(60) NULL ,
  `prenomUser` VARCHAR(60) NULL ,
  `mailUser` VARCHAR(60) NULL ,
  `mdpUser` VARCHAR(45) NULL ,
  `idPhoto` VARCHAR(45) NULL ,
  `produit_idProduit1` INT NOT NULL ,
  PRIMARY KEY (`idUser`) ,
  INDEX `fk_user_produit1_idx` (`produit_idProduit1` ASC) ,
  CONSTRAINT `fk_user_produit1`
    FOREIGN KEY (`produit_idProduit1` )
    REFERENCES `site_enchere`.`produit` (`idProduit` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `site_enchere`.`actualites`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `site_enchere`.`actualites` ;

CREATE  TABLE IF NOT EXISTS `site_enchere`.`actualites` (
  `idActualites` INT NOT NULL AUTO_INCREMENT ,
  `texteActualites` TEXT NULL ,
  `photoActualites` VARCHAR(45) NULL ,
  PRIMARY KEY (`idActualites`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `site_enchere`.`historique`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `site_enchere`.`historique` ;

CREATE  TABLE IF NOT EXISTS `site_enchere`.`historique` (
  `idHistorique` INT NOT NULL ,
  `texteHistorique` TEXT NULL ,
  PRIMARY KEY (`idHistorique`) )
ENGINE = InnoDB;

USE `site_enchere` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
