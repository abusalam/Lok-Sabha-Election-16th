ALTER TABLE `personnel` DROP FOREIGN KEY `fk_post_stat_cd`; ALTER TABLE `personnel` ADD CONSTRAINT `fk_post_stat_cd` FOREIGN KEY (`poststat`) REFERENCES `poststat`(`post_stat`) ON DELETE RESTRICT ON UPDATE CASCADE;
UPDATE `poststat` SET `post_stat`='PR' WHERE `post_stat`='CS';
UPDATE `poststat` SET `post_stat`='P1' WHERE `post_stat`='CA';

DELETE FROM `poststatorder`;
INSERT INTO `poststatorder` (`memberparty`, `membno`, `poststat`, `amount`) VALUES
(2, '1', 'PR', ''),
(2, '2', 'P1', ''),
(3, '1', 'PR', ''),
(3, '2', 'P2', ''),
(3, '3', 'PA', '');

ALTER TABLE `environment` ADD `counting_venue` VARCHAR(255) NOT NULL AFTER `apt2_date`, ADD `venue_address` VARCHAR(255) NOT NULL AFTER `counting_venue`;

ALTER TABLE `assembly_party` ADD `RandOrder` INT NOT NULL AFTER `rand_status`;

ALTER TABLE `assembly` ADD `ro_name` VARCHAR(255) NOT NULL AFTER `posted_date`;