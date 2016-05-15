DROP index subjectIndex;
DROP index placeIndex;
DROP index descriptionIndex; 
CREATE index subjectIndex on images(subject) indextype is ctxsys.context  parameters ('sync (on commit)');
CREATE index placeIndex on images(place) indextype is ctxsys.context  parameters ('sync (on commit)');
CREATE index descriptionIndex on images(description) indextype is ctxsys.context  parameters ('sync (on commit)');
 
alter table images move tablespace c391ware;
alter index C391G9.SYS_C00183410 rebuild tablespace c391ware;

DROP TABLE time_dimension;
CREATE TABLE time_dimension(
time_id date,
year_num    int,
month_num   int,
week_num    int,
PRIMARY KEY(time_id)
);

INSERT INTO time_dimension
SELECT distinct trunc( timing ),
extract(year from timing),
extract(month from timing),
to_char(timing, 'WW') 
FROM images;

DROP VIEW ImageCube;
CREATE VIEW ImageCube AS
Select Owner_Name, Subject, Timing, COUNT(photo_id) AS ImageCount
FROM images
GROUP BY CUBE(Owner_Name, Subject, Timing);

DROP TABLE click_count;
DROP TABLE clicks_per_photo;

CREATE TABLE click_count(
	photo_id	int,
	viewed_by	varchar(24)
);

CREATE TABLE clicks_per_photo(
	photo_id	int,
	total_views	int
);

DROP TABLE temp;
DROP VIEW temp;
