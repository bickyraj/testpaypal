<div class="row">
    <div class="col-md-6 col-sm-6">
    <table class="table table-condensed table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Pubished On</th>
                <th>Author</th>
                <th>View</th>
            </tr>
        </thead>
    
    <?php if(!empty($articleUsers)){ ?>
    <?php foreach($articleUsers as $i) { ?>
    <?php //debug($i); ?>
        <tr>
            <td><?= $i->article->title; ?></td>
            <td><?= $i->article->created->format(date_time_format); ?></td>
            <td><?= $i->user->full_name; ?></td>
            <td><button class="btn btn-primary btn-sm">View</button></td>
        </tr>
    <?php } ?>
    <?php } ?>
    </table>
    </div>
</div>