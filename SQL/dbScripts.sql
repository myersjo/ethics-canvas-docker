CREATE DATABASE ethics-canvas;

CREATE TABLE canvas
(
  canvas_id varchar(128) NOT NULL primary key,
  user_id varchar(50) NOT NULL,
  canvas_name varchar(50),
  canvas_date date,
  is_public boolean DEFAULT 0
);
-- set 'is_public boolean DEFAULT' to 0 to be private by default
ALTER TABLE canvas
  ALTER is_public SET DEFAULT 1
;

CREATE TABLE user
(
  username varchar(50) NOT NULL primary key,
  password varchar(512) NOT NULL,
  name varchar(50) NOT NULL,
  salt varchar(512) NOT NULL,
  activated boolean DEFAULT 0
);
-- set 'activated boolean DEFAULT' to 0 to require email activation
ALTER TABLE user
  ALTER activated SET DEFAULT 1
;

CREATE TABLE canvas_json
(
  canvas_id varchar(128) NOT NULL primary key,
  canvas_content JSON
);

CREATE TABLE tags
(
	id int NOT NULL primary key AUTO_INCREMENT,
	tag_name varchar(50) NOT NULL UNIQUE
);

CREATE TABLE tag_relation
(
	tag_id int NOT NULL AUTO_INCREMENT,
	canvas_id varchar(128) NOT NULL,
	PRIMARY KEY(tag_id, canvas_id),
	FOREIGN KEY(tag_id) REFERENCES tags(id),
	FOREIGN KEY(canvas_id) REFERENCES canvas(canvas_id)
);

CREATE TABLE user_canvas_visibility
(
  user_id varchar(50) NOT NULL,
  canvas_id varchar(128) NOT NULL,
  PRIMARY KEY(user_id, canvas_id),
  FOREIGN KEY(user_id) REFERENCES user(username),
  FOREIGN KEY(canvas_id) REFERENCES canvas(id)
);
