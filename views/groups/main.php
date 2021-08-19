<?php $this->setLayoutVar('title', '参加しているグループ画面') ?>

<form action="<?php echo $base_url; ?>/" method="post">

<p>参加しているグループ一覧</p>
<br/>

<table border="1">
<tr bgcolor="#45cc5b">
    <th>グループ名</th>
    <th>遷移</th>
</tr>

    <?php foreach ($groups as $group): ?>
        <tr>
        <td>
            <?php echo $group['title']; ?>
        </td>
        <td>
            <a href="<?php echo $base_url; ?>/chat?group_id=<?php echo $group['group_id']; ?>">タイムライン</a>
        </td>
        </tr>
    <?php endforeach; ?>


