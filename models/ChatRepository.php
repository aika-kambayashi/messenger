<?php

class ChatRepository extends DbRepository {

    public function getModel() {
        return [
            'group_id'  => '',
            'user_id'   => '',
            'message'   => ''
        ];
    }

    public function getTitle($group_id) {
        $sql = 'select title from groups where group_id = :group_id';
        return $this->fetch($sql, [':group_id' => $group_id]);
    }

    public function insert($chats) {
        $sql = '
            insert into chat
                (group_id,user_id,message)
            values
                (:group_id, :user_id, :message)
        ';
        $stmt = $this->execute($sql, $chats);
    }

    public function timeline($group_id) {
        $sql = 'select u.nickname,c.message
            from user u
            left join chat c
            on u.id = c.user_id
            where group_id = :group_id
            order by c.chat_id asc;';
        return $this->fetchAll($sql, [':group_id' => $group_id]);
    }

    public function checkFollow($group_id,$user_id) {
        $sql = 'select * from group_user where group_id = :group_id and user_id = :user_id';
        return $this->fetch($sql, [
            ':group_id' => $group_id,
            ':user_id'  => $user_id
        ]);
    }

    public function follow($group_id, $user_id) {
        $sql = 'insert into group_user (group_id, user_id) values (:group_id, :user_id)';
        return $this->execute($sql, [':group_id' => $group_id, ':user_id' => $user_id]);
    }

}