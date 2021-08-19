<?php $this->setLayoutVar('title', 'ログイン') ?>

<form action="<?php echo $base_url; ?>/user/login" method="post">
    <input type="hidden" name="_token" value="<?php echo $this->escape($_token); ?>" />

    <?php if(isset($errors) && count($errors) > 0): ?>
        <?php echo $this->render('errors', ['errors' => $errors]); ?>
    <?php endif; ?>
    <?php if (!empty($message)): ?>
        <div id="message"><?php echo $message; ?></div>
    <?php endif; ?>

    <table>
        <tr>
            <th>ID</th>
            <td><input type="text" class="form-control" name="login_id" value="<?php echo $this->escape($login_id); ?>" /></td>
        </tr>
        <tr>
            <th>パスワード</th>
            <td><input type="password" class="form-control" name="password" value="<?php echo $this->escape($password); ?>" /></td>
        </tr>
        <tr>
            <th></th>
            <td><input type="submit" class="btn" value="ログイン" /></td>
        </tr>
    
    </table>
       
</form>