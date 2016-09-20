<div class="page-header"><h3>Verify Trainers</h3></div>
<p>These trainers need their certification verified.</p>

<div class="row wrapper"><div class="col-lg-12">
    <table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Date Registered</th>
            <th> </th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($trainers)) { ?>
            <?php foreach($trainers as $r) { ?>
            <tr>
                <td><?php echo $r->id; ?></td>
                <td><?php echo $r->full_name; ?></td>
                <td><?php echo $r->created_at; ?></td>
                <td><a href="<?php echo admin_url('dashboard/view_trainer/'.md5($r->id)); ?>">View</a></td>
            </tr>
            <?php } ?>
        <?php } else { ?>
            <tr><td colspan="20">There is no trainers to certify.</td></tr>
        <?php } ?>
    </tbody>
    </table>
    
</div></div>
    