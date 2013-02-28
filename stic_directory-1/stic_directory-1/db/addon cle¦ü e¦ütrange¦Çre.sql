SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `site_enchere` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `site_enchere` ;

-- -----------------------------------------------------
-- Table `site_enchere`.`produit`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `site_enchere`.`produit` (
  `idProduit` INT NOT NULL AUTO_INCREMENT ,
  `nomProduit` VARCHAR(45) NULL ,
  `descriptionProduit` TEXT NULL ,
  `photoProduit` VARCHAR(45) NULL ,
  `prixDDProduit` INT UNSIGNED NULL ,
  `prixDVProduit` INT UNSIGNED NULL ,
  `dateDMELProduit` DATETIME NULL ,
  `dateDVProduit` DATETIME NULL ,
  `user_idUser` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`idProduit`) ,
  INDEX `fk_produit_user1_idx` (`user_idUser` ASC) ,
  CONSTRAINT `fk_produit_user1`
    FOREIGN KEY (`user_idUser` )
    REFERENCES `site_enchere`.`user` (`idUser` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `site_enchere` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
