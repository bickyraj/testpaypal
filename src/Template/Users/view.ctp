<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Article Users'), ['controller' => 'ArticleUsers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Article User'), ['controller' => 'ArticleUsers', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Email') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th><?= __('Fname') ?></th>
            <td><?= h($user->fname) ?></td>
        </tr>
        <tr>
            <th><?= __('Lname') ?></th>
            <td><?= h($user->lname) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Article Users') ?></h4>
        <?php if (!empty($user->article_users)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('User Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th><?= __('Status') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->article_users as $articleUsers): ?>
            <tr>
                <td><?= h($articleUsers->id) ?></td>
                <td><?= h($articleUsers->user_id) ?></td>
                <td><?= h($articleUsers->created) ?></td>
                <td><?= h($articleUsers->modified) ?></td>
                <td><?= h($articleUsers->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ArticleUsers', 'action' => 'view', $articleUsers->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ArticleUsers', 'action' => 'edit', $articleUsers->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ArticleUsers', 'action' => 'delete', $articleUsers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $articleUsers->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
