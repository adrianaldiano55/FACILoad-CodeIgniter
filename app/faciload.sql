-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema FACILoad
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema FACILoad
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `FACILoad` DEFAULT CHARACTER SET utf8 ;
USE `FACILoad` ;

-- -----------------------------------------------------
-- Table `FACILoad`.`sections`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `FACILoad`.`sections` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `sec_code` VARCHAR(45) NOT NULL,
  `sec_name` VARCHAR(45) NOT NULL,
  `sec_prog` INT NOT NULL,
  `sec_size` INT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `FACILoad`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `FACILoad`.`users` (
  `id` INT(100) NOT NULL AUTO_INCREMENT,
  `login_id` INT(32) NOT NULL,
  `username` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `hash_password` VARCHAR(100) NOT NULL,
  `role` VARCHAR(45) NOT NULL,
  `login_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `logout_at` DATETIME NULL,
  `sec_id` INT NULL,
  `total_units` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `id_idx` (`sec_id` ASC) VISIBLE,
  CONSTRAINT `sec_id`
    FOREIGN KEY (`sec_id`)
    REFERENCES `FACILoad`.`sections` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `FACILoad`.`programs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `FACILoad`.`programs` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `pro_code` VARCHAR(45) NOT NULL,
  `pro_name` VARCHAR(45) NOT NULL,
  `pro_year` VARCHAR(45) NOT NULL,
  `pro_sem` VARCHAR(45) NOT NULL,
  `status` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `FACILoad`.`subjects`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `FACILoad`.`subjects` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `sub_code` INT NOT NULL,
  `sub_name` VARCHAR(45) NOT NULL,
  `sub_program` INT NOT NULL,
  `sub_sem` VARCHAR(45) NOT NULL,
  `sub_lab_units` INT NOT NULL,
  `sub_lec_units` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `sub_program_idx` (`sub_program` ASC) VISIBLE,
  CONSTRAINT `sub_program`
    FOREIGN KEY (`sub_program`)
    REFERENCES `FACILoad`.`programs` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `FACILoad`.`rooms`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `FACILoad`.`rooms` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `room_code` VARCHAR(45) NOT NULL,
  `room_name` VARCHAR(45) NOT NULL,
  `room_time` VARCHAR(45) NOT NULL,
  `room_type` VARCHAR(45) NOT NULL,
  `room_size` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `FACILoad`.`loads`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `FACILoad`.`loads` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `faculty_id` INT NOT NULL,
  `sub_id` INT NOT NULL,
  `section_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `faculty_id_idx` (`faculty_id` ASC) VISIBLE,
  INDEX `sub_id_idx` (`sub_id` ASC) VISIBLE,
  INDEX `section_id_idx` (`section_id` ASC) VISIBLE,
  CONSTRAINT `loads_faculty_id_fk`
    FOREIGN KEY (`faculty_id`)
    REFERENCES `FACILoad`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `sub_id`
    FOREIGN KEY (`sub_id`)
    REFERENCES `FACILoad`.`subjects` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `section_id`
    FOREIGN KEY (`section_id`)
    REFERENCES `FACILoad`.`sections` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `FACILoad`.`sessions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `FACILoad`.`sessions` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `faculty_id` INT NOT NULL,
  `load_id` INT NOT NULL,
  `room_id` INT NOT NULL,
  `sec_units` INT NOT NULL,
  `ses_day` VARCHAR(45) NOT NULL,
  `ses_start` TIME NOT NULL,
  `ses_end` TIME NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `faculty_id_idx` (`faculty_id` ASC) VISIBLE,
  INDEX `load_id_idx` (`load_id` ASC) VISIBLE,
  INDEX `room_id_idx` (`room_id` ASC) VISIBLE,
  CONSTRAINT `sessions_faculty_id_fk`
    FOREIGN KEY (`faculty_id`)
    REFERENCES `FACILoad`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `load_id`
    FOREIGN KEY (`load_id`)
    REFERENCES `FACILoad`.`loads` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `room_id`
    FOREIGN KEY (`room_id`)
    REFERENCES `FACILoad`.`rooms` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
