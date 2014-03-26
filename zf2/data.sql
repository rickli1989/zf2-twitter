SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `rockwell`
--

-- --------------------------------------------------------

--
-- Table structure for table `twitter`
--

CREATE TABLE `twitter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `twitter`
--

INSERT INTO `twitter` (`id`, `text`, `created_at`, `user_id`) VALUES
(1, 'The is for a test, the end~~~~', '2014-03-25 10:34:17', 1),
(2, 'I don''t use Twitter a lot.', '2014-03-25 10:33:59', 1),
(3, 'Here is my linkedin profile http://t.co/o3g0lBXQuU', '2014-03-25 10:33:30', 1),
(4, 'There are some demos using Backbone and RequireJS with CSS3 animations', '2014-03-25 10:32:11', 1),
(5, 'Welcome to my github account https://t.co/iackVxbLR3', '2014-03-25 10:31:38', 1),
(6, 'As a full stack developer, you have to know a bit here and there.', '2014-03-25 10:30:46', 1),
(7, 'Recently working on Backbone, learning Augular, also Node, mongodb, etc', '2014-03-25 10:30:29', 1),
(8, 'Mastering java, javascript, CSS3 as well.', '2014-03-25 10:29:33', 1),
(9, 'Have been working with php for a couple of years using Zend and Symfony', '2014-03-25 10:29:07', 1),
(10, 'My name is Rick, who is current working as a software engineer.', '2014-03-25 10:28:39', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`) VALUES
(1, 'Rick_Li_Yu');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `twitter`
--
ALTER TABLE `twitter`
  ADD CONSTRAINT `twitter_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);