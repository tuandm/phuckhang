DROP PROCEDURE IF EXISTS `db_scheme_changes`;
DELIMITER ;;
CREATE PROCEDURE `db_scheme_changes`() BEGIN
	DECLARE TableSchema VARCHAR(64);
	SET @TableSchema  = 'phuckhang';

	IF NOT EXISTS (SELECT * FROM information_schema.columns WHERE table_name = 'pk_sc_user_status' AND column_name = 'status_type' AND table_schema = @TableSchema) THEN
		ALTER TABLE `pk_sc_user_status` ADD COLUMN `status_type` VARCHAR(50) NULL;
	END IF;

	IF NOT EXISTS (SELECT * FROM information_schema.columns WHERE table_name = 'pk_sc_user_status' AND column_name = 'reference_id' AND table_schema = @TableSchema) THEN
		ALTER TABLE `pk_sc_user_status` ADD COLUMN `reference_id` INT(10) NULL;
	END IF;

END;;

DELIMITER ;
CALL db_scheme_changes();
DROP PROCEDURE IF EXISTS `db_scheme_changes`;