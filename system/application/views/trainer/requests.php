<div class="page-header"><h3>Received Requests</h3></div>

<div class="row wrapper"><div class="col-lg-12">
    
    <div class="table-responsive">
    <table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Training Area</th>
            <th>Training Type</th>
            <th>Training Date</th>
            <th>Time</th>
            <th>Client Name</th>
            <th>Received</th>
            <th>Request Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($requests)) { ?>
            
            <?php foreach($requests as $r) { ?>            
            <?php 
            $status = '';   
            $timeframe = '';          
            switch ($r->req_status) {
			case 1:
				$status = 'Open';
				break;
			case 2:
				$status = 'Accepted';
				break;
			case 3:
				$status = 'Quoted';
				break;
			case 4:
				$status = 'Expired';
				break;
			case 5:
				$status = 'Closed';
				break;
			}
			 
			switch ($r->req_require_time) {
			case 'm':
				$timeframe = 'Morning';
				break;
			case 'd':
				$timeframe = 'Mid day';
				break;
			case 'e':
				$timeframe = 'Evening';
				break;
			}
			?> 
            <tr>
                <td><?php echo $r->req_id; ?></td>
                <td><?php echo $r->req_suburb_name .' ('.$r->req_area_code.')'; ?></td>
                <td><?php echo $r->service_name; ?></td>
                <td><?php echo $r->req_require_date; ?></td> 
                <td><?php echo $timeframe; ?></td>                
                <td><?php echo $r->full_name; ?></td>
                <td><?php echo $r->req_created_at; ?></td>
                <td><?php echo $status; ?></td>
                <td><a href="<?php echo site_url('trainer/request/'.md5($r->req_id)); ?>">View</a></td>
            </tr>
            <?php } ?>
        <?php } else { ?>
            <tr><td colspan="20">There is no received requests.</td></tr>
        <?php } ?>
    </tbody>
    </table>
    </div>
    
    <?php echo $this->pagination->create_links(); ?>
</div></div>
    