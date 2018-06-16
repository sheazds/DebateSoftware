-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2018 at 11:16 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `attempt1`
--

-- --------------------------------------------------------

--
-- Drops all the tables from the database.
--

DROP TABLE IF EXISTS `ballot_team`;
DROP TABLE IF EXISTS `pairing_team`;
DROP TABLE IF EXISTS `judge_pairing`;
DROP TABLE IF EXISTS `ballot_speaker_scores`;
DROP TABLE IF EXISTS `ballot_round`;
DROP TABLE IF EXISTS `scratches`;
DROP TABLE IF EXISTS `speaker`;
DROP TABLE IF EXISTS `team`;
DROP TABLE IF EXISTS `judge`;
DROP TABLE IF EXISTS `ballot`;
DROP TABLE IF EXISTS `pairing`;
DROP TABLE IF EXISTS `round`;
DROP TABLE IF EXISTS `room`;
DROP TABLE IF EXISTS `pairing_preference`;
DROP TABLE IF EXISTS `school`;
DROP TABLE IF EXISTS `region`;

--
-- Table structure for table `ballot`
-- Connects the ballots to the rooms in which the debate took place.
--

CREATE TABLE `ballot` (
  `ballot_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ballot_round`
-- Associates each ballot with a round.
--

CREATE TABLE `ballot_round` (
  `ballot_id` int(11) NOT NULL,
  `round_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ballot_speaker_scores`
-- Associates the individual score for each speaker with the ballot.
--

CREATE TABLE `ballot_speaker_scores` (
  `ballot_id` int(11) NOT NULL,
  `speaker_id` int(11) NOT NULL,
  `organization/structure` int(3)NOT NULL,
  `evidence/analysis` int(3) NOT NULL,
  `rebuttal/clash` int(3) NOT NULL,
  `delivery/etiquette` int(3) NOT NULL ,
  `questioning/responding` int(3) NOT NULL ,
  `comments` varchar(300)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ballot_team`
-- Associates each ballot with a team
--

CREATE TABLE `ballot_team` (
  `ballot_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `judge`
-- The information that a judge has.
--

CREATE TABLE `judge` (
  `judge_id` int(11) NOT NULL,
  `judge_first_name` varchar(20) NOT NULL,
  `judge_last_name` varchar(20) NOT NULL,
  `rank` int(11) DEFAULT NULL,
  `school_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `judge_pairing`
-- Connects each judge with the pairing that they will oversee
--

CREATE TABLE `judge_pairing` (
  `pairing_id` int(11) NOT NULL,
  `judge_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pairing`
-- The group of two teams that will be debating and where
--

CREATE TABLE `pairing` (
  `pairing_id` int(11) NOT NULL,
  `priority` int(11) DEFAULT NULL,
  `round_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `match_gov_team_id` int(11) NOT NULL,
  `match_opp_team_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pairing_preference`
-- The information about how teams will be paired together.
--

CREATE TABLE `pairing_preference` (
  `pp_id` int(11) NOT NULL,
  `pp_name` varchar(20) NOT NULL,
  `custom_bracket_size` int(11) DEFAULT NULL,
  `reseed_pullout` char(1) DEFAULT NULL,
  `matching_type` varchar(20) DEFAULT NULL,
  `max_allowed_govt_assignments` int(20) DEFAULT NULL,
  `random_room_assignment` char(1) DEFAULT NULL,
  `bracket_type` varchar(20) NOT NULL,
  `same_school` char(1),
  `same_region` char(1),
  `pullup_only_once` char(1),
  `previously_paired` char(1),
  `pullout_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- Table structure for table `pairing_team`
-- Associates each team with a pairing

CREATE TABLE `pairing_team` (
  `pairing_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `region`
-- The region information
--

CREATE TABLE `region` (
  `region_id` int(11) NOT NULL,
  `region_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `room`
-- The room information
--

CREATE TABLE `room` (
  `room_id` int(11) NOT NULL,
  `room_name` varchar(20) NOT NULL,
  `room_priority` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `round`
-- The round information
--

CREATE TABLE `round` (
  `round_id` int(11) NOT NULL,
  `round_name` varchar(20) DEFAULT NULL,
  `pp_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `school`
-- School information
--

CREATE TABLE `school` (
  `school_id` int(11) NOT NULL,
  `school_name` varchar(20) NOT NULL,
  `region_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `scratches`
-- Scratches are a relationship between judges and speakers indicating a potential conflict of interests
--

CREATE TABLE `scratches` (
  `judge_id` int(11) NOT NULL,
  `speaker_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `speaker`
-- Speaker information
--

CREATE TABLE `speaker` (
  `speaker_id` int(11) NOT NULL,
  `speaker_first_name` varchar(20) NOT NULL,
  `speaker_last_name` varchar(20) NOT NULL,
  `rank` int(11) DEFAULT NULL,
  `school_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `team`
-- Team information
--

CREATE TABLE `team` (
  `team_id` int(11) NOT NULL,
  `team_name` varchar(20) DEFAULT NULL,
  `school_id` int(11) NOT NULL,
  `team_rank` int(11) DEFAULT 0,
  `num_times_opp` int(11) DEFAULT 0,
  `num_times_gov` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `result` (
  `result_id` int(11) NOT NULL,
  `ballot_id` int(11) NOT NULL,
  `match_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `team_points` int(11) NOT NULL,
  `team_score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `judge_ballot` (
  `judge_id` int(11) NOT NULL,
  `pairing_id` int(11) NOT NULL,
  `ballot_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Indexes for dumped tables
-- This section adds all the primary keys
--

--
-- Indexes for table `ballot`
--
ALTER TABLE `result`
  ADD PRIMARY KEY (`result_id`),
  ADD KEY (`ballot_id`),
  ADD KEY (`team_id`);

ALTER TABLE `ballot`
  ADD PRIMARY KEY (`ballot_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `ballot_round`
--
ALTER TABLE `ballot_round`
  ADD PRIMARY KEY (`ballot_id`,`round_id`),
  ADD KEY `round_id` (`round_id`);

--
-- Indexes for table `ballot_speaker_scores`
--
ALTER TABLE `ballot_speaker_scores`
  ADD KEY `ballot_id` (`ballot_id`),
  ADD KEY `speaker_id` (`speaker_id`);

--
-- Indexes for table `ballot_team`
--
ALTER TABLE `ballot_team`
  ADD PRIMARY KEY (`ballot_id`,`team_id`),
  ADD KEY `team_id` (`team_id`);

--
-- Indexes for table `judge`
--
ALTER TABLE `judge`
  ADD PRIMARY KEY (`judge_id`),
  ADD KEY `school_id` (`school_id`);

--
-- Indexes for table `judge_pairing`
--
ALTER TABLE `judge_pairing`
  ADD KEY `judge_id` (`judge_id`),
  ADD KEY `pairing_id` (`pairing_id`);

--
-- Indexes for table `pairing`
--
ALTER TABLE `pairing`
  ADD PRIMARY KEY (`pairing_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `round_id` (`round_id`);

--
-- Indexes for table `pairing_preference`
--
ALTER TABLE `pairing_preference`
  ADD PRIMARY KEY (`pp_id`),
  ADD UNIQUE KEY `pp_name` (`pp_name`);

--
-- Indexes for table `pairing_team`
--
ALTER TABLE `pairing_team`
  ADD PRIMARY KEY (`pairing_id`,`team_id`),
  ADD KEY `team_id` (`team_id`);

--
-- Indexes for table `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`region_id`),
  ADD UNIQUE KEY `region_name` (`region_name`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`),
  ADD UNIQUE KEY `room_name` (`room_name`);

--
-- Indexes for table `round`
--
ALTER TABLE `round`
  ADD PRIMARY KEY (`round_id`),
  ADD UNIQUE KEY `round_name` (`round_name`),
  ADD KEY `pp_id` (`pp_id`);

--
-- Indexes for table `school`
--
ALTER TABLE `school`
  ADD PRIMARY KEY (`school_id`),
  ADD KEY `region_id` (`region_id`);

--
-- Indexes for table `scratches`
--
ALTER TABLE `scratches`
  ADD PRIMARY KEY (`judge_id`,`speaker_id`),
  ADD KEY `speaker_id` (`speaker_id`);

--
-- Indexes for table `speaker`
--
ALTER TABLE `speaker`
  ADD PRIMARY KEY (`speaker_id`),
  ADD KEY `school_id` (`school_id`),
  ADD KEY `team_id` (`team_id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`team_id`),
  ADD UNIQUE KEY `team_name` (`team_name`),
  ADD KEY `school_id` (`school_id`);


--
-- Indexes for table `judge_ballot`
--
ALTER TABLE `judge_ballot`
  ADD PRIMARY KEY (`judge_id`,`pairing_id`, `ballot_id`),
  ADD KEY `judge_id` (`judge_id`),
  ADD KEY `pairing_id` (`pairing_id`),
  ADD KEY `ballot_id` (`ballot_id`);

--
-- AUTO_INCREMENT for dumped tables
-- Adds all the auto-increment to the needed primary keys
--

--
-- AUTO_INCREMENT for table `ballot`
--
ALTER TABLE `result`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ballot`
  MODIFY `ballot_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `judge`
--
ALTER TABLE `judge`
  MODIFY `judge_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pairing`
--
ALTER TABLE `pairing`
  MODIFY `pairing_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pairing_preference`
--
ALTER TABLE `pairing_preference`
  MODIFY `pp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `region`
--
ALTER TABLE `region`
  MODIFY `region_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `round`
--
ALTER TABLE `round`
  MODIFY `round_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `school`
--
ALTER TABLE `school`
  MODIFY `school_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `speaker`
--
ALTER TABLE `speaker`
  MODIFY `speaker_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `team_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
-- Adds all the foreign key constraints for the tables.
--

--
-- Constraints for table `ballot`
--
ALTER TABLE `result`
  ADD CONSTRAINT `foreign_key_ballot` FOREIGN KEY (`ballot_id`) REFERENCES `ballot` (`ballot_id`),
  ADD CONSTRAINT `foreign_key_team` FOREIGN KEY (`team_id`) REFERENCES `team` (`team_id`);

ALTER TABLE `ballot`
  ADD CONSTRAINT `ballot_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`);

--
-- Constraints for table `ballot_round`
--
ALTER TABLE `ballot_round`
  ADD CONSTRAINT `ballot_round_ibfk_1` FOREIGN KEY (`ballot_id`) REFERENCES `ballot` (`ballot_id`),
  ADD CONSTRAINT `ballot_round_ibfk_2` FOREIGN KEY (`round_id`) REFERENCES `round` (`round_id`);

--
-- Constraints for table `ballot_speaker_scores`
--
ALTER TABLE `ballot_speaker_scores`
  ADD CONSTRAINT `ballot_speaker_scores_ibfk_1` FOREIGN KEY (`ballot_id`) REFERENCES `ballot` (`ballot_id`),
  ADD CONSTRAINT `ballot_speaker_scores_ibfk_2` FOREIGN KEY (`speaker_id`) REFERENCES `speaker` (`speaker_id`);

--
-- Constraints for table `ballot_team`
--
ALTER TABLE `ballot_team`
  ADD CONSTRAINT `ballot_team_ibfk_1` FOREIGN KEY (`ballot_id`) REFERENCES `ballot` (`ballot_id`),
  ADD CONSTRAINT `ballot_team_ibfk_2` FOREIGN KEY (`team_id`) REFERENCES `team` (`team_id`);

--
-- Constraints for table `judge`
--
ALTER TABLE `judge`
  ADD CONSTRAINT `judge_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `school` (`school_id`);

--
-- Constraints for table `judge_pairing`
--
ALTER TABLE `judge_pairing`
  ADD CONSTRAINT `judge_pairing_ibfk_1` FOREIGN KEY (`judge_id`) REFERENCES `judge` (`judge_id`),
  ADD CONSTRAINT `judge_pairing_ibfk_2` FOREIGN KEY (`pairing_id`) REFERENCES `pairing` (`pairing_id`);

--
-- Constraints for table `pairing`
--
ALTER TABLE `pairing`
  ADD CONSTRAINT `pairing_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`),
  ADD CONSTRAINT `pairing_ibfk_2` FOREIGN KEY (`round_id`) REFERENCES `round` (`round_id`);

--
-- Constraints for table `pairing_team`
--
ALTER TABLE `pairing_team`
  ADD CONSTRAINT `pairing_team_ibfk_1` FOREIGN KEY (`pairing_id`) REFERENCES `pairing` (`pairing_id`),
  ADD CONSTRAINT `pairing_team_ibfk_2` FOREIGN KEY (`team_id`) REFERENCES `team` (`team_id`);

--
-- Constraints for table `round`
--
ALTER TABLE `round`
  ADD CONSTRAINT `round_ibfk_1` FOREIGN KEY (`pp_id`) REFERENCES `pairing_preference` (`pp_id`);

--
-- Constraints for table `school`
--
ALTER TABLE `school`
  ADD CONSTRAINT `school_ibfk_1` FOREIGN KEY (`region_id`) REFERENCES `region` (`region_id`);

--
-- Constraints for table `scratches`
--
ALTER TABLE `scratches`
  ADD CONSTRAINT `scratches_ibfk_1` FOREIGN KEY (`judge_id`) REFERENCES `judge` (`judge_id`),
  ADD CONSTRAINT `scratches_ibfk_2` FOREIGN KEY (`speaker_id`) REFERENCES `speaker` (`speaker_id`);

--
-- Constraints for table `speaker`
--
ALTER TABLE `speaker`
  ADD CONSTRAINT `speaker_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `school` (`school_id`),
  ADD CONSTRAINT `speaker_ibfk_2` FOREIGN KEY (`team_id`) REFERENCES `team` (`team_id`);

--
-- Constraints for table `team`
--
ALTER TABLE `team`
  ADD CONSTRAINT `team_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `school` (`school_id`);

--
-- Constraints for table `judge_ballot`
--
ALTER TABLE `judge_ballot`
  ADD CONSTRAINT `judge_ballot_ibfk_1` FOREIGN KEY (`judge_id`) REFERENCES `judge` (`judge_id`),
  ADD CONSTRAINT `judge_ballot_ibfk_2` FOREIGN KEY (`pairing_id`) REFERENCES `pairing` (`pairing_id`),
  ADD CONSTRAINT `judge_ballot_ibfk_3` FOREIGN KEY (`ballot_id`) REFERENCES `ballot_speaker_scores` (`ballot_id`);


COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
