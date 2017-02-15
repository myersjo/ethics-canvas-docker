CREATE DATABASE ethics-canvas;

CREATE TABLE canvas
(
  user_id varchar(50),
  canvas_id varchar(128)
)

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
