SELECT* FROM users WHERE email LIKE'test@test.co.jp'


SELECT u.id, families_id, first_name, email  FROM users u JOIN wallets w on u.id = w.id;

SELECT * FROM 