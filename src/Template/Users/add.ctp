<div class="users form large-5 medium-5 columns content">
<?= $this->Form->create($user) ?>
<fieldset>
    <legend><?= __('Add User') ?></legend>
    <?php
        echo $this->Form->input('email');
        echo $this->Form->input('fname');
        echo $this->Form->input('lname');
        echo $this->Form->input('password');
    ?>
    
    <div class="input role">
        <label for="role"><strong>I am </strong></label>
        <select required="required" name="role">
            <option value="1">Author</option>
            <option value="2">Reader</option>
        </select>
    </div>
</fieldset>
<?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>
</div>
