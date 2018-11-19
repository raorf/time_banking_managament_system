CREATE TABLE IF NOT EXISTS `TaskImage` (
  `TaskImageID` INT NOT NULL AUTO_INCREMENT,
  `TaskImage` BINARY,
  `TaskID` INT,
  PRIMARY KEY (`TaskImageID`),
  KEY `FK` (`TaskID`)
);

CREATE TABLE IF NOT EXISTS `UserTimeBank` (
  `UserTimeBankID` INT NOT NULL AUTO_INCREMENT,
  `Credit` INT,
  `UserID` INT,
  PRIMARY KEY (`UserTimeBankID`),
  KEY `FK` (`UserID`)
);

CREATE TABLE IF NOT EXISTS `UserSkill` (
  `UserSkillID` INT NOT NULL AUTO_INCREMENT,
  `UserSkill` VARCHAR(255),
  `UserID` INT,
  PRIMARY KEY (`UserSkillID`),
  KEY `FK` (`UserID`)
);

CREATE TABLE IF NOT EXISTS `TaskSkill` (
  `TaskSkillID` INT NOT NULL AUTO_INCREMENT,
  `TaskSkill` VARCHAR(255),
  `TaskID` INT,
  PRIMARY KEY (`TaskSkillID`),
  KEY `FK` (`TaskID`)
);

CREATE TABLE IF NOT EXISTS `Task` (
  `TaskID` INT NOT NULL AUTO_INCREMENT,
  `TaskType` VARCHAR(255),
  `TaskCompleted` BOOLEAN,
  `TaskLocation` VARCHAR(255),
  `TaskCredit` INT,
  PRIMARY KEY (`TaskID`)
);

CREATE TABLE IF NOT EXISTS `User` (
  `UserID` INT NOT NULL AUTO_INCREMENT,
  `UserName` VARCHAR(40),
  `UserEmail` VARCHAR(100),
  `UserPassword` VARCHAR(255),
  `UserCaptcha` VARCHAR(10),
  `UserActive` BOOLEAN,
  PRIMARY KEY (`UserID`)
);

CREATE TABLE IF NOT EXISTS `UserTask` (
  `UserTaskID` INT NOT NULL AUTO_INCREMENT,
  `UserID` INT,
  `TaskID` INT,
  PRIMARY KEY (`UserTaskID`),
  KEY `FK` (`UserID`, `TaskID`)
);