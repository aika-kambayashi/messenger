<?php

class MessengerApplication extends Application {
    //認証されていない場合に遷移するコントローラ名とアクションの配列指定
    
    protected $login_action = ['user', 'login'];

    public function getRootDir() {
        return dirname(__FILE__);
    }

    protected function registerRoutes() {
        return [
            '/'
                => ['controller' => 'groups', 'action' => 'main'],
            '/user/:action'
                => ['controller' => 'user'],
            '/groups'
                => ['controller' => 'groups', 'action' => 'repository'],
            '/groups/:action'
                => ['controller' => 'groups'],
            '/chat'
                => ['controller' => 'chat', 'action' => 'timeline']
        ];
    }

    protected function configure() {
        $this->db_manager->connect('master', [
            'dsn'      => 'mysql:dbname=messenger;host=localhost;charset=utf8',
            'user'     => 'root',
            'password' => '',
        ]);
    }
}
