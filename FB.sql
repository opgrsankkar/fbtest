CREATE TABLE USERS(USER_ID NUMERIC(20) PRIMARY KEY,
	PASSWORD VARCHAR(25),
	EMAIL VARCHAR(25) UNIQUE,
	FNAME VARCHAR(25),
	LNAME VARCHAR(25),
	DOB DATE);

CREATE TABLE POST(POST_ID NUMERIC(20) PRIMARY KEY,
	USER_ID NUMERIC(20),
	ADD_DATE DATETIME,
	CONTENT VARCHAR(1000),
	VIEWERSHIP VARCHAR(25),FOREIGN KEY (USER_ID) REFERENCES USERS (USER_ID));

CREATE TABLE EVENTS(EVENT_ID NUMERIC(20) PRIMARY KEY,
	USER_ID NUMERIC(20),
    EVENT_NAME VARCHAR(100),
	ADD_DATE DATETIME,
	START_DATE DATETIME,
	END_DATE DATETIME,
    EVENT_DESC VARCHAR(1000),
	VIEWERSHIP VARCHAR(25),FOREIGN KEY (USER_ID) REFERENCES USERS (USER_ID));

CREATE TABLE PHOTOS(PHOTO_ID NUMERIC(20) PRIMARY KEY,
	POST_ID NUMERIC(20),
	USER_ID NUMERIC(20),
	ADD_DATE DATETIME,
	LINK VARCHAR(40),
	VIEWERSHIP VARCHAR(25),FOREIGN KEY (USER_ID) REFERENCES USERS(USER_ID),FOREIGN KEY (POST_ID) REFERENCES POST(POST_ID));

CREATE TABLE SHOUT(SHOUT_ID NUMERIC(20) PRIMARY KEY AUTO_INCREMENT,
	USER_ID NUMERIC(20),
	CONTENT VARCHAR(25),
	DATES DATE,FOREIGN KEY (USER_ID) REFERENCES USERS(USER_ID));

CREATE TABLE ATTENDS(USER_ID NUMERIC(20) PRIMARY KEY ,
	EVENT_ID NUMERIC(20) PRIMARY KEY ,
	RSVP VARCHAR(20),FOREIGN KEY (USER_ID) REFERENCES USERS(USER_ID),FOREIGN KEY (EVENT_ID)REFERENCES EVENT(EVENT_ID));

CREATE TABLE PHOTO_LIKE (USER_ID NUMERIC(20) PRIMARY KEY ,
	PHOTO_ID NUMERIC(20) PRIMARY KEY ,
	DATEP DATE,FOREIGN KEY (USER_ID) REFERENCES USERS(USER_ID),FOREIGN KEY (PHOTO_ID) REFERENCES PHOTO(PHOTO_ID));

CREATE TABLE POST_LIKE (USER_ID NUMERIC(20) PRIMAR KEY ,
	POST_ID NUMERIC(20) PRIMARY KEY,
	DATE DATE,FOREIGN KEY (USER_ID) REFERENCES USERS(USER_ID),FOREIGN KEY (POST_ID)REFERENCES POST(POST_ID));

CREATE TABLE PHOTO_TAG(USER_ID NUMERIC(20) PRIMARY KEY ,
	PHOTO_ID NUMERIC(20) PRIMARY KEY,FOREIGN KEY (PHOTO_ID)REFERENCES PHOTO(PHOTO_ID),FOREIGN KEY (USER_ID) REFERENCES USERS(USER_ID));

CREATE TABLE POST_TAG(USER_ID NUMERIC(20) PRIMARY KEY ,
	POST_ID NUMERIC(20) PRIMARY KEY REFERENCES POST,FOREIGN KEY (USER_ID) REFERENCES USERS(USER_ID));

CREATE TABLE FRIENDS(USER_ID1 NUMERIC(20),
	USER_ID2 NUMERIC(20),
	REQUEST_DATE DATETIME,
	ACCEPT_DATE DATETIME,
	PRIMARY KEY (USER_ID1,USER_ID2),
	FOREIGN KEY (USER_ID1) REFERENCES USERS(USER_ID),
	FOREIGN KEY (USER_ID2) REFERENCES USERS(USER_ID));