-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema zadanie_nette
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema zadanie_nette
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `zadanie_nette` DEFAULT CHARACTER SET utf8 ;
USE `zadanie_nette` ;

-- -----------------------------------------------------
-- Table `zadanie_nette`.`Brands`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `zadanie_nette`.`Brands` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `countryCode` VARCHAR(2) NOT NULL,
  `tax` TINYINT(2) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `zadanie_nette`.`Products`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `zadanie_nette`.`Products` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `sku` VARCHAR(64) NOT NULL,
  `ean` VARCHAR(13) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `shortDescription` VARCHAR(512) NOT NULL,
  `fullDescription` VARCHAR(750) NOT NULL,
  `price` DECIMAL(12,5) NOT NULL,
  `stock` INT NOT NULL,
  `Brands_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Products_Brands_idx` (`Brands_id` ASC),
  CONSTRAINT `fk_Products_Brands`
    FOREIGN KEY (`Brands_id`)
    REFERENCES `zadanie_nette`.`Brands` (`id`)
    ON DELETE RESTRICT
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
