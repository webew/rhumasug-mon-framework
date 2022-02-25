-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : ven. 25 fév. 2022 à 14:48
-- Version du serveur : 10.5.13-MariaDB
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `rhumasug`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `idCategorie` int(11) NOT NULL AUTO_INCREMENT,
  `libelleCategorie` varchar(255) NOT NULL,
  PRIMARY KEY (`idCategorie`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`idCategorie`, `libelleCategorie`) VALUES
(1, 'Rhums'),
(2, 'Sucres');

-- --------------------------------------------------------

--
-- Structure de la table `contenir`
--

DROP TABLE IF EXISTS `contenir`;
CREATE TABLE IF NOT EXISTS `contenir` (
  `idVente` int(11) NOT NULL,
  `idProduit` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `prixVente` decimal(5,2) NOT NULL,
  PRIMARY KEY (`idVente`,`idProduit`),
  KEY `contenir_produit0_FK` (`idProduit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `idProduit` int(11) NOT NULL AUTO_INCREMENT,
  `libelleProduit` varchar(255) NOT NULL,
  `prixProduit` decimal(5,2) NOT NULL,
  `descriptionProduit` tinytext NOT NULL,
  `idCategorie` int(11) NOT NULL,
  PRIMARY KEY (`idProduit`),
  KEY `produit_categorie_FK` (`idCategorie`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`idProduit`, `libelleProduit`, `prixProduit`, `descriptionProduit`, `idCategorie`) VALUES
(1, 'Rhum 1', '111.10', 'vbdfgh dfhgs dfhsfdghfgh', 1),
(2, 'Rhum 2', '222.20', 'vbdfgh dfhgs dfhsfdghfgh', 1),
(3, 'Sucre 1', '11.10', 'gfhjgdfj dsfhgdsfh dsfhsdf', 2),
(4, 'Sucre 2', '22.20', 'gfhjgdfj dsfhgdsfh dsfhsdf', 2);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `nomUser` varchar(255) NOT NULL,
  `prenomUser` varchar(255) NOT NULL,
  `loginUser` varchar(255) NOT NULL,
  `mdpUser` varchar(255) NOT NULL,
  `emailUser` varchar(255) NOT NULL,
  PRIMARY KEY (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`idUser`, `nomUser`, `prenomUser`, `loginUser`, `mdpUser`, `emailUser`) VALUES
(1, 'TOTO', 'Toto', 'toto', 'toto', 'toto@toto.fr'),
(2, 'TATA', 'Tata', 'tata', '$2y$10$I2xtaOZXY/MKiQGJNTvE6uaRtV.X2lTQs8pRJqVg3HLGgYasPDjMW', 'tata@tata.fr');

-- --------------------------------------------------------

--
-- Structure de la table `vente`
--

DROP TABLE IF EXISTS `vente`;
CREATE TABLE IF NOT EXISTS `vente` (
  `idVente` int(11) NOT NULL AUTO_INCREMENT,
  `dateVente` date NOT NULL,
  `idUser` int(11) NOT NULL,
  `etat` int(11) NOT NULL,
  PRIMARY KEY (`idVente`),
  KEY `vente_user_FK` (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vue_vente_contenir_produits`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `vue_vente_contenir_produits`;
CREATE TABLE IF NOT EXISTS `vue_vente_contenir_produits` (
`idVente` int(11)
,`dateVente` date
,`idUser` int(11)
,`etat` int(11)
,`idProduit` int(11)
,`quantite` int(11)
,`prixVente` decimal(5,2)
);

-- --------------------------------------------------------

--
-- Structure de la vue `vue_vente_contenir_produits`
--
DROP TABLE IF EXISTS `vue_vente_contenir_produits`;

DROP VIEW IF EXISTS `vue_vente_contenir_produits`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vue_vente_contenir_produits`  AS SELECT `vente`.`idVente` AS `idVente`, `vente`.`dateVente` AS `dateVente`, `vente`.`idUser` AS `idUser`, `vente`.`etat` AS `etat`, `contenir`.`idProduit` AS `idProduit`, `contenir`.`quantite` AS `quantite`, `contenir`.`prixVente` AS `prixVente` FROM (`vente` join `contenir` on(`vente`.`idVente` = `contenir`.`idVente`)) ;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `contenir`
--
ALTER TABLE `contenir`
  ADD CONSTRAINT `contenir_produit0_FK` FOREIGN KEY (`idProduit`) REFERENCES `produit` (`idProduit`),
  ADD CONSTRAINT `contenir_vente_FK` FOREIGN KEY (`idVente`) REFERENCES `vente` (`idVente`) ON DELETE CASCADE;

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `produit_categorie_FK` FOREIGN KEY (`idCategorie`) REFERENCES `categorie` (`idCategorie`);

--
-- Contraintes pour la table `vente`
--
ALTER TABLE `vente`
  ADD CONSTRAINT `vente_user_FK` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
