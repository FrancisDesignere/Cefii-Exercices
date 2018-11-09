-- MySQL Workbench Forward Engineering
-- -----------------------------------------------------
-- Table `crm_category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm_category` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(50) NOT NULL,
  `description` VARCHAR(150) NULL,
  PRIMARY KEY (`id_category`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `crm_personne`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm_personne` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `fk_id_category` INT NOT NULL DEFAULT 1,
  `nom` VARCHAR(100) NOT NULL,
  `prenom` VARCHAR(100) NULL,
  `adresse` VARCHAR(300) NULL,
  `code_postal` VARCHAR(5) NULL,
  `ville` VARCHAR(100) NULL,
  `commentaire` VARCHAR(45) NULL,
  PRIMARY KEY (`id_personne`),
  CONSTRAINT `fk_crm_personne_crm_category`
    FOREIGN KEY (`fk_id_category`)
    REFERENCES `crm_category` (`id_category`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Creation de la vue client 
-- -----------------------------------------------------
CREATE VIEW `crm_client` AS
    SELECT 
        `c`.`nom` AS `categorie`,
        `p`.`id` AS `id`,
        `p`.`nom` AS `nom`,
        `p`.`prenom` AS `prenom`,
        `p`.`adresse` AS `adresse`,
        `p`.`code_postal` AS `code_postal`,
        `p`.`ville` AS `ville`,
        `p`.`commentaire` AS `commentaire`
    FROM
        (`crm_personne` `p`
        JOIN `crm_category` `c` ON ((`p`.`fk_id_category` = `c`.`id`)))
    WHERE
        (`p`.`fk_id_category` > 1)
    ORDER BY `c`.`id`
-- -----------------------------------------------------
-- Creation de la vue prospect
-- -----------------------------------------------------
CREATE VIEW `crm_prospect` AS
    SELECT 
        `crm_personne`.`id` AS `id`,
        `crm_personne`.`fk_id_category` AS `fk_id_category`,
        `crm_personne`.`nom` AS `nom`,
        `crm_personne`.`prenom` AS `prenom`,
        `crm_personne`.`adresse` AS `adresse`,
        `crm_personne`.`code_postal` AS `code_postal`,
        `crm_personne`.`ville` AS `ville`,
        `crm_personne`.`commentaire` AS `commentaire`
    FROM
        `crm_personne`
    WHERE
        (`crm_personne`.`fk_id_category` = 1);



-- -----------------------------------------------------
-- peuplement des données (catégories) initiales 
-- -----------------------------------------------------
INSERT INTO `crm_category` (`nom`, `description`) VALUES ('prospect', 'la personne n\'est pas encore cliente');
INSERT INTO `crm_category` (`nom`, `description`) VALUES ('client essayeur', 'le client n\'est pour l\'instant venu qu\'une fois');
INSERT INTO `crm_category` (`nom`, `description`) VALUES ('client occasionel', 'client ne venant qu\'une fois par trimestre');
INSERT INTO `crm_category` (`nom`, `description`) VALUES ('client régulier', 'client fidèle venant au moins une fois par mois');
INSERT INTO `crm_category` (`nom`, `description`) VALUES ('client inactif', 'client non actif depuis au moins six mois');
INSERT INTO `crm_category` (`nom`, `description`) VALUES ('client abandoniste', 'client non venu depuis au moins un an');

-- -----------------------------------------------------
-- + un premier client pour test
-- -----------------------------------------------------
INSERT INTO `crm_personne` (`fk_id_category`, `nom`, `prenom`, `adresse`, `code_postal`, `ville`, `commentaire`)
    VALUES ('4', 'Désignère', 'Francis', '45, rue de Franceville', '93220', 'Gagny', 'très bon client ;-)');
INSERT INTO `crm_personne` (`fk_id_category`, `nom`, `prenom`, `adresse`, `code_postal`, `ville`, `commentaire`) 
    VALUES ('1', 'Toto', 'tutu', '', '', '', 'dommage..');
