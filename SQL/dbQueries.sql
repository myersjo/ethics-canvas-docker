SELECT DISTINCT tag_relation.canvas_id as canvas_id 
FROM tag_relation
INNER JOIN tags
ON tag_relation.tag_id=tags.id
WHERE tags.tag_name LIKE '%$query%';

INSERT INTO tags (tag_name) VALUES ('canvas')
ON DUPLICATE KEY UPDATE tag_name = VALUES(tag_name);

INSERT INTO tag_relation(tag_id, canvas_id) VALUES(1, 'KrX3cFqGWE')
ON DUPLICATE KEY UPDATE tag_id=VALUES(tag_id), canvas_id=VALUES(canvas_id);
