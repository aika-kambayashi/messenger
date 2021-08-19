<?php

class GroupsController extends Controller {

    protected $auth_actions = ['new', 'repository', 'main'];

    public function mainAction() {
        $user = $this->session->get('user');
        $groups = $this->db_manager->get('Groups')->groupsFollowing($user['id']);

        return $this->render(['groups' => $groups]);

    }

    public function newAction() {
        $title = '';
        $errors = [];

        if ($this->request->isPost()) {
            $title = $this->request->getPost('title');
            if (!strlen($title)) {
                $errors[] = 'グループ名を入力してください';
                return $this->render([
                    'title'  => $title,
                    'errors' => $errors
                ]);
            }
            $this->db_manager->get('Groups')->insert($title);
            return $this->redirect('/groups');
        }
        
        return $this->render([
            'title'  => $title,
            'errors' => $errors
        ]);
    }
    
    public function repositoryAction() {
        $user = $this->session->get('user');
        
        $groups = $this->db_manager->get('Groups')->allGroups($user['id']);
        return $this->render([
            'groups'  =>  $groups,
        ]);
    }

}