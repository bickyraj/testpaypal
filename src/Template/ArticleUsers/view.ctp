<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Article User'), ['action' => 'edit', $articleUser->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Article User'), ['action' => 'delete', $articleUser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $articleUser->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Article Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Article User'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="articleUsers view large-9 medium-8 columns content">
    <h3><?= h($articleUser->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $articleUser->has('user') ? $this->Html->link($articleUser->user->id, ['controller' => 'Users', 'action' => 'view', $articleUser->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($articleUser->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= $this->Number->format($articleUser->status) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($articleUser->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($articleUser->modified) ?></td>
        </tr>
    </table>
</div>
