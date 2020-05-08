<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="si">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title><?php echo $title; ?></title>
  <!-- Bootstrap core CSS-->
  <link href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url(); ?>assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="<?php echo base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="<?php echo base_url(); ?>assets/css/sb-admin.css" rel="stylesheet">
  <!-- Sweet alert-->
  <link href="<?php echo base_url(); ?>assets/css/sweetalert/sweetalert.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link href="<?php echo base_url(); ?>assets/css/admin_custom.css" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
<div class="content-wrapper">
 	<div class="container-fluid">
 	<?php
 		//print_r($school_data);
 		foreach($school_data as $school){
 			echo $census_id = $school->census_id;
 			echo $exam_no = $school->exam_no;
 			echo $school_name = $school->sch_name;
 			echo $address1 = $school->address1;
 			echo $address2 = $school->address2;
 			echo $contact = $school->contact_no;
 			echo $web = $school->web_address;
 			echo $gs_div = $school->gs_division;
 			echo $edu_div->div_name;
 			echo $type = $school->type_name;
 			echo $updated_dt = $school->school_details_upd_dt; 
 		}
 	?>
	 	<div class="row" id="school_item_status_by_censusID">
	 		<div class="col-lg-12">
	 			
	 									<table class="table" id="sch_info_tbl" cellspacing="0" width="">
	 										<thead>
	 											<tr>
	 												<th scope="col" class="col-sm-1"></th>
	 												<th scope="col" class="col-sm-3"></th>
	 											</tr>
	 										</thead>
	 										<tbody>
	 											<tr>
	 												<th scope="row">සංඝණන අංකය</th>
	 												<td style="vertical-align:middle"><?php echo $census_id; ?></td>
	 											</tr>
	 											<tr>
	 												<th scope="row">විභාග අංකය</th>
	 												<td style="vertical-align:middle"><?php echo $exam_no; ?></td>
	 											</tr>
	 											<tr>
	 												<th scope="row">පාසලේ නම</th>
	 												<td style="vertical-align:middle"><?php echo $school_name; ?></td>
	 											</tr>
	 											<tr>
	 												<th scope="row">ලිපිනය</th>
	 												<td style="vertical-align:middle"><?php echo $address1,' ' ,$address2; ?></td>
	 											</tr>
	 											<tr>
	 												<th scope="row">දුරකථන අංකය</th>
	 												<td style="vertical-align:middle"><?php echo $contact; ?></td>
	 											</tr>
	 											<tr>
	 												<th scope="row">වෙබ් ලිපිනය</th>
	 												<td style="vertical-align:middle"><?php echo $web; ?></td>
	 											</tr>
	 											<tr>
	 												<th scope="row">ග්‍රාම නිළධාරී කොට්ඨාසය</th>
	 												<td style="vertical-align:middle"><?php echo $gs_div; ?></td>
	 											</tr>
	 										</tbody>
	 									</table>
	 								
	  		</div> <!-- /col-lg-12 -->
		</div> <!-- /row #school_item_status_by_censusID -->
	</div> <!-- /container-fluid -->
	
