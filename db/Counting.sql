DELETE FROM `poststatorder`;
INSERT INTO `poststatorder` (`memberparty`, `membno`, `poststat`, `amount`) VALUES
(1, '1', 'MO', '');

ALTER TABLE `environment` ADD `counting_venue` VARCHAR(255) NOT NULL AFTER `apt2_date`, ADD `venue_address` VARCHAR(255) NOT NULL AFTER `counting_venue`;

ALTER TABLE `assembly_party` ADD `RandOrder` INT NOT NULL AFTER `rand_status`;

ALTER TABLE `assembly` ADD `ro_name` VARCHAR(255) NOT NULL AFTER `posted_date`;