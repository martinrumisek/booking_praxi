-- MySQL Script generated by MySQL Workbench
-- Wed Mar 26 17:13:19 2025
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema booking_praxi
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema booking_praxi
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `booking_praxi` DEFAULT CHARACTER SET utf8 ;
USE `booking_praxi` ;

-- -----------------------------------------------------
-- Table `booking_praxi`.`Type_school`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `booking_praxi`.`Type_school` (
  `type_id` INT NOT NULL AUTO_INCREMENT,
  `type_name` VARCHAR(255) NULL,
  `type_shortcut` VARCHAR(255) NOT NULL,
  `type_description` TEXT NULL,
  `type_create_time` TIMESTAMP NULL,
  `type_edit_time` TIMESTAMP NULL,
  `type_del_time` TIMESTAMP NULL,
  PRIMARY KEY (`type_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `booking_praxi`.`Field_study`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `booking_praxi`.`Field_study` (
  `field_id` INT NOT NULL AUTO_INCREMENT,
  `field_name` VARCHAR(255) NULL,
  `field_shortcut` VARCHAR(255) NOT NULL,
  `field_create_time` TIMESTAMP NULL,
  `field_edit_time` TIMESTAMP NULL,
  `field_del_time` TIMESTAMP NULL,
  `Type_school_type_id` INT NOT NULL,
  PRIMARY KEY (`field_id`),
  INDEX `fk_Field_study_Type_school1_idx` (`Type_school_type_id` ASC) ,
  CONSTRAINT `fk_Field_study_Type_school1`
    FOREIGN KEY (`Type_school_type_id`)
    REFERENCES `booking_praxi`.`Type_school` (`type_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `booking_praxi`.`Class`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `booking_praxi`.`Class` (
  `class_id` INT NOT NULL AUTO_INCREMENT,
  `class_year_graduation` INT NOT NULL,
  `class_class` VARCHAR(255) NOT NULL,
  `class_letter_class` VARCHAR(255) NOT NULL,
  `class_create_time` TIMESTAMP NULL,
  `class_edit_time` TIMESTAMP NULL,
  `class_del_time` TIMESTAMP NULL,
  `Field_study_field_id` INT NOT NULL,
  PRIMARY KEY (`class_id`),
  INDEX `fk_Class_Field_study1_idx` (`Field_study_field_id` ASC) ,
  CONSTRAINT `fk_Class_Field_study1`
    FOREIGN KEY (`Field_study_field_id`)
    REFERENCES `booking_praxi`.`Field_study` (`field_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `booking_praxi`.`User`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `booking_praxi`.`User` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `user_name` VARCHAR(255) NOT NULL,
  `user_surname` VARCHAR(255) NOT NULL,
  `user_date_birthday` DATE NULL,
  `user_job_title` VARCHAR(255) NOT NULL,
  `user_department` VARCHAR(255) NOT NULL,
  `user_mail` VARCHAR(255) NOT NULL,
  `user_phone` VARCHAR(255) NULL,
  `user_role` VARCHAR(255) NOT NULL,
  `user_admin` TINYINT NOT NULL DEFAULT 0,
  `user_spravce` TINYINT NOT NULL DEFAULT 0,
  `user_description` TEXT NULL,
  `user_img` VARCHAR(255) NOT NULL DEFAULT 'fa-regular fa-user',
  `user_create_time` TIMESTAMP NULL,
  `user_edit_time` TIMESTAMP NULL,
  `user_del_time` TIMESTAMP NULL,
  `Class_class_id` INT NULL,
  PRIMARY KEY (`user_id`),
  INDEX `fk_User_Class1_idx` (`Class_class_id` ASC) ,
  CONSTRAINT `fk_User_Class1`
    FOREIGN KEY (`Class_class_id`)
    REFERENCES `booking_praxi`.`Class` (`class_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `booking_praxi`.`Company`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `booking_praxi`.`Company` (
  `company_id` INT NOT NULL AUTO_INCREMENT,
  `company_name` VARCHAR(255) NOT NULL,
  `company_ico` VARCHAR(255) NOT NULL,
  `company_subject` TINYINT NOT NULL,
  `company_legal_form` INT NOT NULL,
  `company_description` TEXT NULL,
  `company_city` VARCHAR(255) NOT NULL,
  `company_agree_document` TINYINT NOT NULL,
  `company_street` VARCHAR(255) NOT NULL,
  `company_post_code` VARCHAR(255) NOT NULL,
  `company_logo` VARCHAR(255) NOT NULL DEFAULT 'fa-solid fa-building',
  `company_register_company` TINYINT NOT NULL DEFAULT 1,
  `company_create_time` TIMESTAMP NULL,
  `company_edit_time` TIMESTAMP NULL,
  `company_del_time` TIMESTAMP NULL,
  PRIMARY KEY (`company_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `booking_praxi`.`Practise`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `booking_praxi`.`Practise` (
  `practise_id` INT NOT NULL AUTO_INCREMENT,
  `practise_name` VARCHAR(255) NOT NULL,
  `practise_description` TEXT NULL,
  `practise_contract_file` VARCHAR(255) NOT NULL,
  `practise_end_new_offer` DATE NOT NULL,
  `practise_create_time` TIMESTAMP NULL,
  `practise_edit_time` TIMESTAMP NULL,
  `practise_del_time` TIMESTAMP NULL,
  PRIMARY KEY (`practise_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `booking_praxi`.`Practise_manager`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `booking_praxi`.`Practise_manager` (
  `manager_id` INT NOT NULL AUTO_INCREMENT,
  `manager_degree_before` VARCHAR(255) NULL,
  `manager_name` VARCHAR(255) NOT NULL,
  `manager_surname` VARCHAR(255) NOT NULL,
  `manager_degree_after` VARCHAR(255) NULL,
  `manager_mail` VARCHAR(255) NOT NULL,
  `manager_phone` VARCHAR(255) NOT NULL,
  `manager_position_works` VARCHAR(255) NULL,
  `manager_create_time` TIMESTAMP NULL,
  `manager_edit_time` TIMESTAMP NULL,
  `manager_del_time` TIMESTAMP NULL,
  `Company_company_id` INT NOT NULL,
  PRIMARY KEY (`manager_id`),
  INDEX `fk_Practise_manager_Company1_idx` (`Company_company_id` ASC) ,
  CONSTRAINT `fk_Practise_manager_Company1`
    FOREIGN KEY (`Company_company_id`)
    REFERENCES `booking_praxi`.`Company` (`company_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `booking_praxi`.`Offer_practise`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `booking_praxi`.`Offer_practise` (
  `offer_id` INT NOT NULL AUTO_INCREMENT,
  `offer_name` VARCHAR(255) NOT NULL,
  `offer_requirements` TEXT NULL,
  `offer_description` TEXT NULL,
  `offer_city` VARCHAR(255) NOT NULL,
  `offer_street` VARCHAR(255) NOT NULL,
  `offer_post_code` VARCHAR(255) NOT NULL,
  `offer_copy_next_year` TINYINT NULL DEFAULT 0,
  `offer_create_time` TIMESTAMP NULL,
  `offer_edit_time` TIMESTAMP NULL,
  `offer_del_time` TIMESTAMP NULL,
  `Practise_practise_id` INT NOT NULL,
  `Practise_manager_manager_id` INT NOT NULL,
  PRIMARY KEY (`offer_id`),
  INDEX `fk_Offer_practise_Practise1_idx` (`Practise_practise_id` ASC) ,
  INDEX `fk_Offer_practise_Practise_manager1_idx` (`Practise_manager_manager_id` ASC) ,
  CONSTRAINT `fk_Offer_practise_Practise1`
    FOREIGN KEY (`Practise_practise_id`)
    REFERENCES `booking_praxi`.`Practise` (`practise_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Offer_practise_Practise_manager1`
    FOREIGN KEY (`Practise_manager_manager_id`)
    REFERENCES `booking_praxi`.`Practise_manager` (`manager_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `booking_praxi`.`Category_skill`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `booking_praxi`.`Category_skill` (
  `category_id` INT NOT NULL AUTO_INCREMENT,
  `category_name` VARCHAR(255) NOT NULL,
  `category_description` TEXT NULL,
  `category_create_time` TIMESTAMP NULL,
  `category_edit_time` TIMESTAMP NULL,
  `category_del_time` TIMESTAMP NULL,
  PRIMARY KEY (`category_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `booking_praxi`.`Skill`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `booking_praxi`.`Skill` (
  `skill_id` INT NOT NULL AUTO_INCREMENT,
  `skill_name` VARCHAR(255) NOT NULL,
  `skill_description` TEXT NULL,
  `skill_create_time` TIMESTAMP NULL,
  `skill_edit_time` TIMESTAMP NULL,
  `skill_del_time` TIMESTAMP NULL,
  `Category_skill_category_id` INT NOT NULL,
  PRIMARY KEY (`skill_id`),
  INDEX `fk_Skill_Category_skill1_idx` (`Category_skill_category_id` ASC) ,
  CONSTRAINT `fk_Skill_Category_skill1`
    FOREIGN KEY (`Category_skill_category_id`)
    REFERENCES `booking_praxi`.`Category_skill` (`category_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `booking_praxi`.`Representative_company`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `booking_praxi`.`Representative_company` (
  `representative_id` INT NOT NULL AUTO_INCREMENT,
  `representative_degree_before` VARCHAR(255) NULL,
  `representative_name` VARCHAR(255) NOT NULL,
  `representative_surname` VARCHAR(255) NOT NULL,
  `representative_degree_after` VARCHAR(255) NULL,
  `representative_mail` VARCHAR(255) NOT NULL,
  `representative_password` VARCHAR(255) NOT NULL,
  `representative_phone` VARCHAR(255) NOT NULL,
  `representative_function` VARCHAR(255) NOT NULL,
  `representative_create_time` TIMESTAMP NULL,
  `representative_edit_time` TIMESTAMP NULL,
  `representative_del_time` TIMESTAMP NULL,
  `Company_company_id` INT NOT NULL,
  PRIMARY KEY (`representative_id`),
  INDEX `fk_Representative_company_Company1_idx` (`Company_company_id` ASC) ,
  CONSTRAINT `fk_Representative_company_Company1`
    FOREIGN KEY (`Company_company_id`)
    REFERENCES `booking_praxi`.`Company` (`company_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `booking_praxi`.`Date_practise`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `booking_praxi`.`Date_practise` (
  `date_id` INT NOT NULL AUTO_INCREMENT,
  `date_date_from` DATE NOT NULL,
  `date_date_to` DATE NOT NULL,
  `date_create_time` TIMESTAMP NULL,
  `date_edit_time` TIMESTAMP NULL,
  `date_del_time` TIMESTAMP NULL,
  `Practise_practise_id` INT NOT NULL,
  PRIMARY KEY (`date_id`),
  INDEX `fk_Date_practise_Practise1_idx` (`Practise_practise_id` ASC) ,
  CONSTRAINT `fk_Date_practise_Practise1`
    FOREIGN KEY (`Practise_practise_id`)
    REFERENCES `booking_praxi`.`Practise` (`practise_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `booking_praxi`.`User_has_Skill`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `booking_praxi`.`User_has_Skill` (
  `user_skill_id` INT NOT NULL AUTO_INCREMENT,
  `User_user_id` INT NOT NULL,
  `Skill_skill_id` INT NOT NULL,
  `user_skill_create_time` TIMESTAMP NULL,
  `user_skill_edit_time` TIMESTAMP NULL,
  `user_skill_del_time` TIMESTAMP NULL,
  INDEX `fk_User_has_Skill_Skill1_idx` (`Skill_skill_id` ASC) ,
  INDEX `fk_User_has_Skill_User1_idx` (`User_user_id` ASC) ,
  PRIMARY KEY (`user_skill_id`),
  CONSTRAINT `fk_User_has_Skill_User1`
    FOREIGN KEY (`User_user_id`)
    REFERENCES `booking_praxi`.`User` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_User_has_Skill_Skill1`
    FOREIGN KEY (`Skill_skill_id`)
    REFERENCES `booking_praxi`.`Skill` (`skill_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `booking_praxi`.`User_has_Offer_practise`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `booking_praxi`.`User_has_Offer_practise` (
  `user_offer_id` INT NOT NULL AUTO_INCREMENT,
  `User_user_id` INT NOT NULL,
  `Offer_practise_offer_id` INT NOT NULL,
  `user_offer_accepted` TINYINT NULL,
  `user_offer_like` TINYINT NOT NULL DEFAULT 0,
  `user_offer_select` TINYINT NOT NULL DEFAULT 0,
  `user_offer_edit_time` TIMESTAMP NULL,
  `user_offer_create_time` TIMESTAMP NULL,
  `user_offer_del_time` TIMESTAMP NULL,
  PRIMARY KEY (`user_offer_id`),
  INDEX `fk_User_has_Offer_practise_Offer_practise1_idx` (`Offer_practise_offer_id` ASC) ,
  INDEX `fk_User_has_Offer_practise_User1_idx` (`User_user_id` ASC) ,
  CONSTRAINT `fk_User_has_Offer_practise_User1`
    FOREIGN KEY (`User_user_id`)
    REFERENCES `booking_praxi`.`User` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_User_has_Offer_practise_Offer_practise1`
    FOREIGN KEY (`Offer_practise_offer_id`)
    REFERENCES `booking_praxi`.`Offer_practise` (`offer_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `booking_praxi`.`Reset_password`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `booking_praxi`.`Reset_password` (
  `reset_id` INT NOT NULL AUTO_INCREMENT,
  `reset_token` VARCHAR(255) NOT NULL,
  `reset_expires_at` DATETIME NOT NULL,
  `reset_create_time` TIMESTAMP NULL,
  `reset_edit_time` TIMESTAMP NULL,
  `reset_use` TINYINT NULL,
  `Representative_company_representative_id` INT NOT NULL,
  `reset_del_time` TIMESTAMP NULL,
  PRIMARY KEY (`reset_id`),
  INDEX `fk_Reset_password_Representative_company1_idx` (`Representative_company_representative_id` ASC) ,
  CONSTRAINT `fk_Reset_password_Representative_company1`
    FOREIGN KEY (`Representative_company_representative_id`)
    REFERENCES `booking_praxi`.`Representative_company` (`representative_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `booking_praxi`.`Class_has_Practise`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `booking_praxi`.`Class_has_Practise` (
  `class_practise_id` INT NOT NULL AUTO_INCREMENT,
  `Class_class_id` INT NOT NULL,
  `Practise_practise_id` INT NOT NULL,
  `class_practise_create_time` TIMESTAMP NULL,
  `class_practise_edit_time` TIMESTAMP NULL,
  `class_practise_del_time` TIMESTAMP NULL,
  `class_practise_create_class` INT NULL,
  INDEX `fk_Class_has_Practise_Practise1_idx` (`Practise_practise_id` ASC) ,
  INDEX `fk_Class_has_Practise_Class1_idx` (`Class_class_id` ASC) ,
  PRIMARY KEY (`class_practise_id`),
  CONSTRAINT `fk_Class_has_Practise_Class1`
    FOREIGN KEY (`Class_class_id`)
    REFERENCES `booking_praxi`.`Class` (`class_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Class_has_Practise_Practise1`
    FOREIGN KEY (`Practise_practise_id`)
    REFERENCES `booking_praxi`.`Practise` (`practise_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `booking_praxi`.`Skill_has_Offer_practise`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `booking_praxi`.`Skill_has_Offer_practise` (
  `skill_offer_id` INT NOT NULL AUTO_INCREMENT,
  `Skill_skill_id` INT NOT NULL,
  `Offer_practise_offer_id` INT NOT NULL,
  `skill_offer_create_time` TIMESTAMP NULL,
  `skill_offer_edit_time` TIMESTAMP NULL,
  `skill_offer_del_time` TIMESTAMP NULL,
  PRIMARY KEY (`skill_offer_id`),
  INDEX `fk_Skill_has_Offer_practise_Offer_practise1_idx` (`Offer_practise_offer_id` ASC) ,
  INDEX `fk_Skill_has_Offer_practise_Skill1_idx` (`Skill_skill_id` ASC) ,
  CONSTRAINT `fk_Skill_has_Offer_practise_Skill1`
    FOREIGN KEY (`Skill_skill_id`)
    REFERENCES `booking_praxi`.`Skill` (`skill_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Skill_has_Offer_practise_Offer_practise1`
    FOREIGN KEY (`Offer_practise_offer_id`)
    REFERENCES `booking_praxi`.`Offer_practise` (`offer_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `booking_praxi`.`Social_link`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `booking_praxi`.`Social_link` (
  `social_id` INT NOT NULL AUTO_INCREMENT,
  `social_name` VARCHAR(255) NOT NULL,
  `social_icon` VARCHAR(255) NOT NULL,
  `social_create_time` TIMESTAMP NULL,
  `social_edit_time` TIMESTAMP NULL,
  `social_del_time` TIMESTAMP NULL,
  PRIMARY KEY (`social_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `booking_praxi`.`Social_link_has_User`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `booking_praxi`.`Social_link_has_User` (
  `user_social_id` INT NOT NULL AUTO_INCREMENT,
  `Social_link_social_id` INT NOT NULL,
  `User_user_id` INT NOT NULL,
  `user_social_url` VARCHAR(255) NOT NULL,
  `user_social_create_time` TIMESTAMP NULL,
  `user_social_edit_time` TIMESTAMP NULL,
  `user_social_del_time` TIMESTAMP NULL,
  INDEX `fk_Social_link_has_User_User1_idx` (`User_user_id` ASC) ,
  INDEX `fk_Social_link_has_User_Social_link1_idx` (`Social_link_social_id` ASC) ,
  PRIMARY KEY (`user_social_id`),
  CONSTRAINT `fk_Social_link_has_User_Social_link1`
    FOREIGN KEY (`Social_link_social_id`)
    REFERENCES `booking_praxi`.`Social_link` (`social_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Social_link_has_User_User1`
    FOREIGN KEY (`User_user_id`)
    REFERENCES `booking_praxi`.`User` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `booking_praxi`.`Log_user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `booking_praxi`.`Log_user` (
  `log_user_id` INT NOT NULL AUTO_INCREMENT,
  `log_user_name` VARCHAR(255) NOT NULL,
  `log_user_ip_adrese` VARCHAR(255) NULL,
  `log_user_create_time` TIMESTAMP NULL,
  `log_user_edit_time` TIMESTAMP NULL,
  `log_user_del_time` TIMESTAMP NULL,
  `User_user_id` INT NOT NULL,
  PRIMARY KEY (`log_user_id`),
  INDEX `fk_Log_user_User1_idx` (`User_user_id` ASC) ,
  CONSTRAINT `fk_Log_user_User1`
    FOREIGN KEY (`User_user_id`)
    REFERENCES `booking_praxi`.`User` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `booking_praxi`.`Log_company`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `booking_praxi`.`Log_company` (
  `log_company_id` INT NOT NULL AUTO_INCREMENT,
  `log_company_name` VARCHAR(255) NOT NULL,
  `log_company_ip_adrese` VARCHAR(255) NULL,
  `log_company_create_time` TIMESTAMP NULL,
  `log_company_edit_time` TIMESTAMP NULL,
  `log_company_del_time` TIMESTAMP NULL,
  `Representative_company_representative_id` INT NOT NULL,
  PRIMARY KEY (`log_company_id`),
  INDEX `fk_Log_company_Representative_company1_idx` (`Representative_company_representative_id` ASC) ,
  CONSTRAINT `fk_Log_company_Representative_company1`
    FOREIGN KEY (`Representative_company_representative_id`)
    REFERENCES `booking_praxi`.`Representative_company` (`representative_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
