create table if not exists 'users' (
	'id' int(11) varchar not null auto_increment,
	'username' varchar(255) not null,
	'first_name' varchar(255) not null,
	'last_name' varchar(255) not null,
	'email' varchar(255) not null,
	'password' varchar(32) not null,
	'sign_up_date' date not null,
	'activated' enum('0' , '1') not null,
	PRIMARY KEY ('id') 
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;