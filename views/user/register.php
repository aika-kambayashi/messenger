<?php $this->setLayoutVar('title', '新規ユーザ登録画面') ?>

<form action="<?php echo $base_url; ?>/user/register" method="post">
    <input type="hidden" name="_token" value="<?php echo $this->escape($_token); ?>" />
    <?php if(isset($errors) && count($errors) > 0): ?>
        <?php echo $this->render('errors', ['errors' => $errors]); ?>
    <?php endif; ?>
    
    <table>
        <tr>
            <th>新規ユーザ登録</th>
        </tr>
        <tr>
            <th>ログインID</th>
            <td><input type="text" class="form-control" name="login_id" value="<?php echo $this->escape($login_id); ?>" /></td>
        </tr>
        <tr>
            <th>パスワード</th>
            <td><input type="password" class="form-control" name="password" value="<?php echo $this->escape($password); ?>" /></td>
        </tr>
        <tr>
            <th>パスワード(再確認)</th>
            <td><input type="password" class="form-control" name="passwordCheck" value="<?php echo $this->escape($passwordCheck); ?>" /></td>
        </tr>
        <tr>
            <th>ニックネーム</th>
            <td><input type="text" class="form-control" name="nickname" value="<?php echo $this->escape($nickname); ?>" /></td>
        </tr>
        <tr>
            <th></th>
            <td><input type="submit" class="btn" value="登録" /></td>
        </tr>
    </table>
        
</form>