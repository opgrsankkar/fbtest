CREATE TABLE USERS(USER_ID INTEGER PRIMARY KEY AUTO_INCREMENT,
	PASSWORD VARCHAR(25),
	EMAIL VARCHAR(25) UNIQUE,
	FNAME VARCHAR(25),
	LNAME VARCHAR(25),
	DOB DATE);

CREATE TABLE POST(POST_ID INTEGER PRIMARY KEY AUTO_INCREMENT,
	USER_ID INTEGER,
	DATEP DATE,
	CONTENT VARCHAR(100),
	VIEWERSHIP VARCHAR(25),FOREIGN KEY (USER_ID) REFERENCES USERS (USER_ID));

CREATE TABLE EVENTS(EVENT_ID INTEGER PRIMARY KEY AUTO_INCREMENT,
	USER_ID INTEGER,
    EVENT_NAME VARCHAR(100),
	DATE_OF_EVENT DATE,
	START_DATE DATE,
	END_DATE DATE,
    EVENT_DESC VARCHAR(1000),
	VIEWERSHIP VARCHAR(25),FOREIGN KEY (USER_ID) REFERENCES USERS (USER_ID));

CREATE TABLE PHOTO(PHOTO_ID INTEGER PRIMARY KEY AUTO_INCREMENT,
	USER_ID INTEGER ,
	DATE DATE,
	LINK VARCHAR(25),
	CAPTION VARCHAR(100),
	VIEWERSHIP VARCHAR(25),FOREIGN KEY (USER_ID) REFERENCES USERS(USER_ID));

CREATE TABLE CONTAINS(PHOTO_ID INTEGER PRIMARY KEY,
	POST_ID INTEGER,FOREIGN KEY(POST_ID) REFERENCES POST(POST_ID),FOREIGN KEY(PHOTO_ID) REFERENCES PHOTO(PHOTO_ID));

CREATE TABLE SHOUT(SHOUT_ID INTEGER PRIMARY KEY AUTO_INCREMENT,
	USER_ID INTEGER ,
	CONTENT VARCHAR(25),
	DATES DATE,FOREIGN KEY (USER_ID) REFERENCES USERS(USER_ID));

CREATE TABLE ATTENDS(USER_ID INTEGER PRIMARY KEY ,
	EVENT_ID INTEGER PRIMARY KEY ,
	RSVP VARCHAR(20),FOREIGN KEY (USER_ID) REFERENCES USERS(USER_ID),FOREIGN KEY (EVENT_ID)REFERENCES EVENT(EVENT_ID));

CREATE TABLE PHOTO_LIKE (USER_ID INTEGER PRIMARY KEY ,
	PHOTO_ID INTEGER PRIMARY KEY ,
	DATEP DATE,FOREIGN KEY (USER_ID) REFERENCES USERS(USER_ID),FOREIGN KEY (PHOTO_ID) REFERENCES PHOTO(PHOTO_ID));

CREATE TABLE POST_LIKE (USER_ID INTEGER PRIMAR KEY ,
	POST_ID INTEGER PRIMARY KEY,
	DATE DATE,FOREIGN KEY (USER_ID) REFERENCES USERS(USER_ID),FOREIGN KEY (POST_ID)REFERENCES POST(POST_ID));

CREATE TABLE PHOTO_TAG(USER_ID INTEGER PRIMARY KEY ,
	PHOTO_ID INTEGER PRIMARY KEY,FOREIGN KEY (PHOTO_ID)REFERENCES PHOTO(PHOTO_ID),FOREIGN KEY (USER_ID) REFERENCES USERS(USER_ID));

CREATE TABLE POST_TAG(USER_ID INTEGER PRIMARY KEY ,
	POST_ID INTEGER PRIMARY KEY REFERENCES POST,FOREIGN KEY (USER_ID) REFERENCES USERS(USER_ID));

CREATE TABLE FRIENDS(USER_ID1 INTEGER PRIMARY KEY ,
	USER_ID2 INTEGER PRIMARY KEY ,
	REQUEST_DATE DATE,
	ACCEPT_DATE DATE,FOREIGN KEY (USER_ID1,USER_ID2) REFERENCES USERS(USER_ID));