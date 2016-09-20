<div class="page-header"><h3>Add Media</h3></div>

<div class="row wrapper"><div class="col-lg-12">
	
	<form class="form-horizontal" id="form" method="post" enctype="multipart/form-data">
	
	<div class="form-group">
		<div class="col-xs-12">
			<input type="file" id="mediafile" class="" name="mediafile">
			<span style="margin-top:5px;display:block">JPEG|JPG|PNG|PDF 3MB</span>
		</div>
	</div>
			
	<div class="form-group">
		<div class="col-sm-12">
			<button class="btn btn-default" type="submit" name="submit" value="1">Upload</button>
		</div>
	</div>
	
	</form>
			
</div>
</div>

<div class="row wrapper"><div class="col-lg-12">
	
	<div class="page-header"><h3>Media Library</h3></div>
	
    <table class="table table-bordered">
    <thead>
        <tr>
            <th width="5%">No</th>
			<th width="25%">Copy this Tag</th>
			<th width="40%">Image</th>
			<th width="15%">Date Created</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($media)) { ?>
            <?php foreach($media as $r) { ?>
            <tr>
                <td><?php echo $r->id; ?></td> 
				<td>&lt;img src="<?php echo base_url($r->mediafile); ?>"&gt;</td>
				<td><img src="<?php echo base_url($r->mediafile); ?>" width="120"/></td>
                <td><?php echo $r->created_at; ?></td>
            </tr>
            <?php } ?>
        <?php } ?>
    </tbody>
    </table>
</div></div>