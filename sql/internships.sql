-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Dec 12, 2018 at 06:26 PM
-- Server version: 5.7.23
-- PHP Version: 7.1.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `internships`
--

-- --------------------------------------------------------

--
-- Table structure for table `coordinators`
--

CREATE TABLE `coordinators` (
  `id` int(8) NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adress` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `province` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postal_code` varchar(255) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` int(10) NOT NULL,
  `user_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employers`
--

CREATE TABLE `employers` (
  `id` int(8) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adress` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `province` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postal_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `id_user` int(8) NOT NULL,
  `uuid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `employers`
--

INSERT INTO `employers` (`id`, `name`, `contact_email`, `adress`, `city`, `province`, `postal_code`, `active`, `id_user`, `uuid`) VALUES
(1, 'Nathan', 'lmao@gmail.com', '600 lmao', 'TerreLmao', 'LMAo', 'J3H 2H8', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `file` text NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `internship_offers`
--

CREATE TABLE `internship_offers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_posted` datetime NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `id_employer` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `internship_offers`
--

INSERT INTO `internship_offers` (`id`, `name`, `date_posted`, `description`, `active`, `id_employer`) VALUES
(2, 'YEET', '2018-11-07 00:00:00', 'ceci est un meme review CLAP CLAP', 1, 1),
(3, 'for the memes', '2018-11-07 20:58:20', 'LMAO T SERIES SUCKS', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `admission_number` int(8) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL,
  `user_id` int(8) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`admission_number`, `name`, `active`, `user_id`, `email`) VALUES
(20, 'steven', 1, 5, ''),
(12345, 'will', 1, 6, 'will@test.com'),
(1463693, 'Nathan Test 123', 1, 3, ''),
(69696969, 'Tekashi 69', 1, 4, ''),
(201463693, 'Nathan Cyr', 0, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `students_internships`
--

CREATE TABLE `students_internships` (
  `student_id` int(8) NOT NULL,
  `internship_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(8) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_type` int(8) NOT NULL COMMENT '''0'' for admin, ''1'' for student, ''2'' for employer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `user_type`) VALUES
(1, 'test@test.com', '098f6bcd4621d373cade4e832627b4f6', 0),
(2, '201463693', '9a8896ebf2e4a99e4b1c0174504c898a', 1),
(3, '1463693', '16d7a4fca7442dda3ad93c9a726597e4', 1),
(4, '69696969', 'cffb9c1f93b6337e59444dbafbd62369', 1),
(5, '20', '6ed61d4b80bb0f81937b32418e98adca', 1),
(6, '12345', '098f6bcd4621d373cade4e832627b4f6', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--

CREATE TABLE `user_types` (
  `id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_types`
--

INSERT INTO `user_types` (`id`, `type`) VALUES
(0, 'coordinator'),
(1, 'student'),
(2, 'employer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `coordinators`
--
ALTER TABLE `coordinators`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `employers`
--
ALTER TABLE `employers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD KEY `fk_students_files` (`student_id`);

--
-- Indexes for table `internship_offers`
--
ALTER TABLE `internship_offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_employer` (`id_employer`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`admission_number`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `students_internships`
--
ALTER TABLE `students_internships`
  ADD KEY `student_id` (`student_id`),
  ADD KEY `internship_id` (`internship_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `user_type` (`user_type`);

--
-- Indexes for table `user_types`
--
ALTER TABLE `user_types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `coordinators`
--
ALTER TABLE `coordinators`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employers`
--
ALTER TABLE `employers`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `internship_offers`
--
ALTER TABLE `internship_offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `coordinators`
--
ALTER TABLE `coordinators`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `employers`
--
ALTER TABLE `employers`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `fk_students_files` FOREIGN KEY (`student_id`) REFERENCES `students` (`admission_number`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `internship_offers`
--
ALTER TABLE `internship_offers`
  ADD CONSTRAINT `fk_id_employer` FOREIGN KEY (`id_employer`) REFERENCES `employers` (`id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `fk_id_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `students_internships`
--
ALTER TABLE `students_internships`
  ADD CONSTRAINT `students_internships_ibfk_1` FOREIGN KEY (`internship_id`) REFERENCES `internship_offers` (`id`),
  ADD CONSTRAINT `students_internships_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`admission_number`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_user_types` FOREIGN KEY (`user_type`) REFERENCES `user_types` (`id`);
