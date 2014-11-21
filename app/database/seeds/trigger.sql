DELIMITER //
CREATE TRIGGER `BI_balance` BEFORE INSERT ON `transations`
 FOR EACH ROW BEGIN
	DECLARE available DOUBLE(8,2) DEFAULT 0;
	DECLARE balance DOUBLE(8,2) DEFAULT 0;
	select amount from balance where `uid`=NEW.uid
	into available;
		
		IF(NEW.type = 'expense') THEN
			IF(NEW.amount > available) THEN
					SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Expense can not more than Available balance';
			ELSE
				set balance = available - NEW.amount;
			END IF;
		ELSE
			SET balance = available + NEW.amount;
		END iF;
		
	UPDATE balance SET amount=balance WHERE `uid`=NEW.uid;
	SET NEW.balance=balance;
END//

DELIMITER ;