<?php

class UserRepository extends DbRepository {

    public function insert($login_id, $password, $nickname) {
        $password = $this->hashPassword($password);
        $now = new DateTime();
        $sql = '
            insert into user(login_id,password,nickname,modified_at,created_at) values(:login_id,:password,:nickname,:modified_at,:created_at)
        ';
        $stmt = $this->execute($sql, [
            ':login_id'     => $login_id,
            ':password'     => $password,
            ':nickname'     => $nickname,
            ':modified_at'  => $now->format('Y-m-d H:i:s'),
            ':created_at'   => $now->format('Y-m-d H:i:s')
        ]);
    }

    public function hashPassword($password) {
        return sha1($password . 'SecretKey');
    }
    
    public function fetchByLoginId($login_id) {
        $sql = 'select * from user where login_id = :login_id';
        return $this->fetch($sql, [':login_id' => $login_id]);
    }

    public function isUniqueLoginId($login_id) {
        $sql = 'select count(id) as count from user where login_id = :login_id';
        $row = $this->fetch($sql, [':login_id' => $login_id]);
        if ($row['count'] === '0') {
            return true;
        }
        return false;
    }

    public function update($data) {
        $sql = 'update user set nickname = :nickname where id = :id';
        $stmt = $this->execute($sql, $data);
    }

    public function fetchById($id) {
        $sql = 'select * from user where id = :id';
        return $this->fetch($sql, [':id' => $id]);
    }

}