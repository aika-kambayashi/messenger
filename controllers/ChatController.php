<?php

class ChatController extends Controller {

    protected $auth_actions = ['timeline'];

    public function timelineAction() {
        $user = $this->session->get('user');
        $group['group_id'] = $this->request->getGet('group_id');
        $chat_repository = $this->db_manager->get('Chat');
        //　初めて「参加する」を押した場合
        $following = $chat_repository->checkFollow($group['group_id'],$user['id']);
        if (!$following) {
            $chat_repository->follow($group['group_id'],$user['id']);
        }

        $group['title'] = implode($chat_repository->getTitle($group['group_id']));
        if ($this->request->isPost()) {
            $chats = $this->db_manager->get('Chat')->getModel();
            $keys = array_keys($chats);
            foreach ($keys as $key) {
                $chats[$key] = $this->request->getPost($key);
            }
            $chats['user_id'] = $user['id'];
            $chats['group_id'] = $group['group_id'];
            //　ボタンを押してもチャットメッセージが入力されてない場合
            if (!strlen($this->request->getPost('message'))){
                $errors[] = 'チャットメッセージを入力してください';
                $chats = $chat_repository->timeline($group['group_id']);
                return $this->render([
                    'chats'  => $chats,
                    'group'  => $group,
                    'errors' => $errors
                ]);
            }
            $chat_repository->insert($chats);
            $chats = $chat_repository->timeline($group['group_id']);
            return $this->render([
                'chats'   => $chats,
                'group'   => $group,
            ]);
        } //　まだPOSTしてない場合
        $chats = $chat_repository->timeline($group['group_id']);
        return $this->render([
            'chats'   => $chats,
            'group'   => $group,
        ]);
    }

}