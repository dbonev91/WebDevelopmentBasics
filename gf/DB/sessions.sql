create database GFTest;

use GFTest;

create table sessions (
	sessid varchar(32) primary key COLLATE utf8_unicode_ci not null,
	sess_data text COLLATE utf8_unicode_ci,
	valid_until int
);