Create table if  'posts' (
'id' int(11) not null AUTO_INCREMENT,
'body' text not null,
'date_added' date not null,
'added_by' varchar(255) not null,
'user_posted_to' varchar(255) not null,
primary key('id')
)