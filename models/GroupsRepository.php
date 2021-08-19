<?php

class GroupsRepository extends DbRepository {

    public function groupsFollowing($id) {
        $sql = 'select g.group_id,g.title
            from groups g
            left join group_user u
            on g.group_id = u.group_id
            where u.user_id = :user_id
        ';
        return $this->fetchAll($sql, [':user_id' => $id]);
    }

    public function allGroups($id) {
        $sql = 'select f.title,f.group_id,f.follower_count,
	        case when c.group_id is null then "0" else "1" end as following
	    from (
		    select g.group_id,g.title,count(gu.group_id) follower_count
		    from groups g
		    left join group_user gu
		    on g.group_id = gu.group_id
		    group by g.group_id) f
	    left join (
		    select group_id from group_user where user_id = :id
	    ) c
	    on f.group_id = c.group_id
        ';
        return $this->fetchAll($sql, [':id' => $id]); 
    }

    public function insert($title) {
        $sql = 'insert into groups (title) select (:title)';
        $stmt = $this->execute($sql, [':title' => $title]);
    }

}