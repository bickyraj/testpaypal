<div class="articles form large-9 medium-8 columns content">
    <?= $this->Form->create($article) ?>
    <fieldset>
        <legend><?= __('Edit Article') ?></legend>
        <?php
            echo $this->Form->input('title',['type'=>'text']);
            echo $this->Form->input('body');
        ?>
    </fieldset>
    <?= $this->Form->submit() ?>
</div>
