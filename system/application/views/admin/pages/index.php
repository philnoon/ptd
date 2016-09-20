<div class="page-header"><h3>Pages</h3></div>

<div class="row wrapper"><div class="col-lg-12">
    <table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
			<th>Edit/Page title</th>
            <th>Content</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($pagecontents)) { ?>
            <?php foreach($pagecontents as $r) { ?>
            <tr>
                <td><?php echo $r->id; ?></td>				
				<td><a href="<?php echo admin_url('pages/edit/'. $r->id); ?>"><?php echo $r->pagename; ?></a></td>				
                <td>
				<div style="max-height:300px; overflow:scroll;">
					<?php echo $r->pagecontent; ?>
				</div>
				</td>
            </tr>
            <?php } ?>
        <?php } ?>
    </tbody>
    </table>
</div></div>
