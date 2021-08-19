<?php

class UserController extends Controller {
    
    protected $auth_actions = ['edit', 'logout'];

    public function registerAction() { 
        if ($this->session->isAuthenticated()) {
            return $this->redirect( '/' );
        }
        $login_id = '';
        $password = '';
        $passwordCheck = '';
        $nickname = '';
        $errors = [];

        if ($this->request->isPost()) {
            $token = $this->request->getPost('_token');
            if (!$this->checkCsrfToken('user/register', $token)) {
                return $this->redirect('/user/register');
            }
            $login_id = $this->request->getPost('login_id');
            $password = $this->request->getPost('password');
            $passwordCheck = $this->request->getPost('passwordCheck');
            $nickname = $this->request->getPost('nickname');

            if (!strlen($login_id)) {
                $errors[] = 'メールアドレスを入力してください';
            } else if (!preg_match('/^[0-9a-zA-Z_+\.-]+@[0-9a-zA-Z_\.-]+\.[a-zA-Z]+$/', $login_id)) {
                $errors[] = 'メールアドレスを入力してください';
            } else if (!$this->db_manager->get('User')->isUniqueLoginId($login_id)) {
                $errors[] = 'メールアドレスは既に使用されています';
            }

            if (!strlen($password)) {
                $errors[] = 'パスワードを入力してください';
            } else if (4 > strlen($password) || strlen($password) > 30) {
                $errors[] = 'パスワードは4～30文字以内で入力してください';
            }
            
            if (!strlen($passwordCheck)) {
                $errors[] = 'パスワード再確認を入力してください';
            } else if ($passwordCheck !== $password ) {
                $errors[] = 'パスワードと再確認は一致していません';
            }

            if (!strlen($nickname)) {
                $errors[] = 'ニックネームを入力してください';
            }
            
            if(count($errors) === 0) {
                $this->db_manager->get('User')->insert($login_id, $password, $nickname);
                $this->session->setAuthenticated(true);
                $user = $this->db_manager->get('User')->fetchByLoginId($login_id);
                $this->session->set('user', $user);      
                return $this->redirect('/');
            }
        }
        return $this->render([
            'login_id'      => $login_id,
            'password'      => $password,
            'passwordCheck' => $passwordCheck,
            'nickname'      => $nickname,
            'errors'        => $errors,
            '_token'        => $this->generateCsrfToken('user/register')
        ], 'register');
    }
    
    public function loginAction() {
        //認証済みならHOME画面へ遷移
        if ($this->session->isAuthenticated()) {
            return $this->redirect('/');
        }
        $login_id = '';
        $password = '';
        $errors = [];
        $message = '';

        if (!empty($this->session->get('message'))) {
            $message = $this->session->get('message');
            $this->session->clear();
        }

        if ($this->request->isPost()) {
            $token = $this->request->getPost('_token');
            if (!$this->checkCsrfToken('user/login', $token)) {
                return $this->redirect('/user/login');
            }
            $login_id = $this->request->getPost('login_id');
            $password = $this->request->getPost('password');

            if (!strlen($login_id))
                $errors[] = 'メールアドレスを入力してください';

            if (!strlen($password)) {
                $errors[] = 'パスワードを入力してください';
            }
            
            if (count($errors) === 0) {
                $user_repository = $this->db_manager->get('User');
                $user = $user_repository->fetchByLoginId($login_id); 
                if (!$user || ($user['password'] !== $user_repository->hashPassword($password))) {
                    $errors[] = 'メールアドレスかパスワードが不正です';
                } else {
                    //認証OKなのでホーム画面遷移
                    $this->session->setAuthenticated(true);
                    $this->session->set('user', $user);
                    return $this->redirect('/');
                }
            }
        }
        return $this->render([
            'login_id'  => $login_id,
            'password'  => $password,
            'errors'    => $errors,
            '_token'    => $this->generateCsrfToken('user/login'),
            'message'   => $message
        ]);
    }

    public function editAction() {
        $user = $this->session->get('user');
        if ($this->request->isPost()) {
            $data['id'] = $user['id'];
            $data['nickname'] = $this->request->getPost('nickname');
            
            if (!strlen($data['nickname'])) {
                $errors[] = 'ニックネームを入力してください';
                $user['nickname'] = '';
                return $this->render([
                    'user'   => $user,
                    'errors' => $errors
                ]);
            }
            $this->db_manager->get('User')->update($data);
            $user = $this->db_manager->get('User')->fetchById($user['id']);
            $this->session->set('user', $user);
            return $this->redirect('/');
        }
        return $this->render([
            'user'      => $user,
        ]);
    }

    public function logoutAction() {
        $this->session->clear();
        $this->session->setAuthenticated(false);
        $this->session->set('message','ログアウトしました');
        return $this->redirect('/user/login');
    }
}