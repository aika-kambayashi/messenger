<?php $this->setLayoutVar('title', 'グループ一覧画面') ?>

<form action="<?php echo $base_url; ?>/groups" method="post">

<a href="<?php echo $base_url; ?>/groups/new">グループ新規作成</a>
<p>
<table border="1">
<tr bgcolor="#45cc5b">
    <th>グループ</th>
    <th>参加人数</th>
    <th>アクション</th>
</tr>

    <?php foreach ($groups as $group): ?>
        <tr>
        <td>
            <?php echo $group['title']; ?>
        </td>
        <td>
            <?php echo $group['follower_count']; ?>
        </td>
        <td>
            <?php if ($group['following'] == '1'): echo '参加中'; ?>
            <?php else: ?>
                <a href="<?php echo $base_url; ?>/chat?group_id=<?php echo $group['group_id']; ?>">参加する</a>
            <?php endif; ?>
        </td>
        </tr>
    <?php endforeach; ?>
</table>
</p>

