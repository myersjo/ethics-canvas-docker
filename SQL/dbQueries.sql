SELECT DISTINCT tag_relation.canvas_id as canvas_id 
FROM tag_relation
INNER JOIN tags
ON tag_relation.tag_id=tags.id
WHERE tags.tag_name LIKE '%$query%';

