<?php $this->setLayoutVar('title', 'グループ新規作成画面') ?>

<?php if(isset($errors) && count($errors) > 0): ?>
        <?php echo $this->render('errors', ['errors' => $errors]); ?>
<?php endif; ?>

<form action="<?php echo $base_url; ?>/groups/new" method="post">
    <p>グループ新規作成</p>
        <table border="1">
        <tr>
            <th bgcolor="#45cc5b">グループ名</th>
            <td><input type="text" class="form-control" name="title" /></td>
        </tr>
        </table>
        <input type="submit" class="btn" value="作成" />
    
</form>