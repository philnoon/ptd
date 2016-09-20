<div class="page-header"><h3>Contact form submissions</h3></div>

<div class="row wrapper"><div class="col-lg-12">
    <table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
			<th>Email</th>
            <th>Message</th>
			<th>Date Created</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($contacts)) { ?>
            <?php foreach($contacts as $r) { ?>
            <tr>
                <td><?php echo $r->id; ?></td>
                <td><?php echo $r->name; ?></td>
				<td><?php echo $r->emailaddress; ?></td>
				<td><?php echo $r->message; ?></td>
                <td><?php echo $r->created_at; ?></td>
            </tr>
            <?php } ?>
        <?php } ?>
    </tbody>
    </table>
</div></div>