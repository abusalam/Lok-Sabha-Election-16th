DELETE FROM `poststatorder`;
INSERT INTO `poststatorder` (`memberparty`, `membno`, `poststat`, `amount`) VALUES
(1, '1', 'MO', '');

ALTER TABLE `environment` ADD `counting_venue` VARCHAR(255) NOT NULL AFTER `apt2_date`, ADD `venue_address` VARCHAR(255) NOT NULL AFTER `counting_venue`;

ALTER TABLE `assembly_party` ADD `RandOrder` INT NOT NULL AFTER `rand_status`;

ALTER TABLE `assembly` ADD `ro_name` VARCHAR(255) NOT NULL AFTER `posted_date`;

SELECT `old_personnel`,personnela.officer_name,personnela.off_desg,booked,`new_personnel` FROM `relpacement_log` join personnela on (relpacement_log.old_personnel=personnela.personcd) where selected=1;

SELECT `old_personnel`,personnela.officer_name,personnela.off_desg,booked,`new_personnel` FROM `replacement_log_pregroup` join personnela on (replacement_log_pregroup.old_personnel=personnela.personcd) where selected=1;

SELECT `old_personnel`,personnela.officer_name,personnela.off_desg,booked,`new_personnel` FROM `relpacement_log_reserve` join personnela on (relpacement_log_reserve.old_personnel=personnela.personcd) where selected=1;

update `replacement_log_pregroup` join personnela on (replacement_log_pregroup.old_personnel=personnela.personcd) set personnela.booked='C';
update `relpacement_log` join personnela on (relpacement_log.old_personnel=personnela.personcd) set personnela.booked='C';
update `relpacement_log_reserve` join personnela on (relpacement_log_reserve.old_personnel=personnela.personcd) set personnela.booked='C';
SELECT `personcd`,`booked`,`selected` FROM `personnela` WHERE booked='C' and selected=1;
