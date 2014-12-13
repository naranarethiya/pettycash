DELIMITER ||
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
END||
DELIMITER ;

DELIMITER ||
CREATE TRIGGER `AI_insert` AFTER INSERT ON `users`
 FOR EACH ROW BEGIN
	BEGIN
	IF(NEW.user_type = 'user') THEN
		insert into balance(uid,amount) value(NEW.uid,'0');
	END IF;
END;||
DELIMITER ;

DELIMITER ||
CREATE TRIGGER `BD_delete` BEFORE DELETE ON `transations_item`
 FOR EACH ROW
	BEGIN
	DECLARE total_amount DOUBLE(8,2) DEFAULT 0;
	DECLARE user_id int DEFAULT 0;
	DECLARE last_tid int DEFAULT 0;
	DECLARE trans_date date;
	DECLARE updated_balance DOUBLE(8,2) DEFAULT 0; 
	DECLARE final_amount DOUBLE(8,2) DEFAULT 0; 
	DECLARE final_balance DOUBLE(8,2) DEFAULT 0;
	DECLARE trans_type varchar(10) DEFAULT '';
	
	select `amount`,`uid`,`type`,`date` from transations where `tid`=OLD.tid into total_amount,user_id,trans_type,trans_date;
	set final_amount=total_amount - OLD.amount;
	
	if(final_amount = 0) THEN 
		insert into transations_deleted select * from transations where tid=OLD.tid;
		DELETE from transations where tid=OLD.tid;
	ELSE
		update transations set `amount`=final_amount where tid = OLD.tid; 
	END IF;
	
	select tid from transations where `date`=trans_date order by tid desc limit 0,1 into last_tid;
	
	insert into transations_item_deleted select * from transations_item where t_item_id=OLD.t_item_id;
	
	if(trans_type = 'expense') THEN
		update balance set `amount`=`amount`+OLD.amount where `uid`=user_id;
	ELSE
		update balance set `amount`=`amount` - OLD.amount where `uid`=user_id;
	END IF;
	
	select amount from balance where `uid`=user_id into updated_balance;
	
	IF(last_tid !='') THEN
		update transations set `balance`=updated_balance where `tid`=last_tid;
	END IF;
	
END||
DELIMITER ;