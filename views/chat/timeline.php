<?php $this->setLayoutVar('title', 'タイムライン画面') ?>

<form action="<?php echo $base_url; ?>/chat?group_id=<?php echo $group['group_id']; ?>" method="post">
<?php if(isset($errors) && count($errors) > 0): ?>
        <?php echo $this->render('errors', ['errors' => $errors]); ?>
<?php endif; ?>

<p>グループ名：<?php echo $group['title']; ?><br/></p> 

<p>
    <?php foreach ($chats as $chat): ?>
        <?php echo $this->escape($chat['nickname']); ?>
        <br/>
        <?php echo $this->escape($chat['message']); ?>
        <br/>
        <hr/>
    <?php endforeach; ?>

    <textarea rows="5" cols="70" maxlength="255" name="message"></textarea><br/>
    <input type="submit" class="btn" value="投稿">
</p>
    </form>