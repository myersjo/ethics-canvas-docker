CREATE DATABASE ethics-canvas;

CREATE TABLE canvas
(
  canvas_id varchar(128) NOT NULL primary key,
  user_id varchar(50) NOT NULL,
  canvas_name varchar(50),
  canvas_date date
);

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
