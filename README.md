# Newsletter Signup
This project showcases a form for collecting names and email addresses of users that want to sign up for a newsletter. Users can also view the current list of email records in the database.

It is written in PHP and should only require the mysqli library to function. The database connection strings are configured within config.php.

The following database schema was used:

| Field | Type | Null | Key | Default | Extra |
| ----- | ---- | ---- | --- | ------- | ----- |
| email | varchar(100) | NO | PRI | NULL |
| name | varchar(45) | NO | |NULL |
| date | datetime | NO |  | NULL |

SQL to create the table:
```SQL
CREATE TABLE `submissions` (
  `email` varchar(100) NOT NULL,
  `name` varchar(45) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci
```
