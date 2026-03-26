<?php
defined('BASEPATH') or exit('No direct script access allowed');
// this page used to edit item
?>
<style type="text/css">
	.imgPrw {
		max-width: 120px;
		max-height: 120px;
		margin-top: 20px;
		margin-bottom: 20px;
	}
</style>
<?php
foreach ($this->session as $user_data) {
	$userid = $user_data['userid'];
	$userrole = $user_data['userrole'];
	$userrole_id = $user_data['userrole_id'];
	if ($userrole_id == 2) {
		$census_id = $user_data['census_id'];
	}
}
?>

<div class="content-wrapper">
	<div class="container-fluid">
		<!-- Breadcrumbs-->
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>user">Dashboard</a></li>
			<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Staff">Staff</a></li>
			<li class="breadcrumb-item active">Update Academic Staff</li>
		</ol>
		<?php
		if (empty($stf_result)) {   ?>
			<div class="alert alert-danger">
				<?php echo 'No records!!!'; ?>
			</div>
		<?php } else { ?>
			<?php foreach ($stf_result as $staff) {
				$title = $staff->title;
				$staff_id = $staff->staff_id;
				$name_with_ini = $staff->name_with_ini;
				$full_name = $staff->full_name;
				$nick_name = $staff->nick_name;
				$census_id = $staff->census_id;
				$school_name = $staff->sch_name;
				$address1 = $staff->stf_address1;
				$address2 = $staff->stf_address2;
				$nic_no = $staff->nic_no;
				if ($staff->dob == '0000-00-00') {
					$dob = '';
				} else {
					$dob = $staff->dob;
				}
				$gender_id = $staff->gender_id;
				$gender_type = $staff->gender_name;
				$civ_id = $staff->civil_status_id;
				$civ_name = $staff->civil_status_type;
				$ethnic_group_id = $staff->ethnic_group_id;
				$ethnic_group = $staff->ethnic_group;
				$religion_id = $staff->religion_id;
				$religion = $staff->religion;
				$phone_home = $staff->phone_home;
				$phone_mobile1 = $staff->phone_mobile1;
				$phone_mobile2 = $staff->phone_mobile2;
				$vehicle_no1 = $staff->vehicle_no1;
				$vehicle_no2 = $staff->vehicle_no2;
				$email = $staff->stf_email;
				$edu_q_id = $staff->edu_q_id;
				$edu_q_name = $staff->edu_q_name;
				$prof_q_id = $staff->prof_q_id;
				$prof_q_description = $staff->prof_q_description;
				$desig_id = $staff->desig_id;
				$desig_name = $staff->desig_type;
				$service_grade_id = $staff->serv_grd_id;
				$service_grade_name = $staff->serv_grd_type;
				$section_id = $staff->section_id;
				$section_name = $staff->section_name;
				//$grade_id = $staff->grade_id;
				//$grade_name = $staff->grade;
				//$class_id = $staff->class_id;
				//$class_name = $staff->class;
				$section_role_id = $staff->sec_role_id;
				$section_role_name = $staff->sec_role_name;
				$stf_type_id = $staff->stf_type_id;
				$stf_type = $staff->stf_type;
				$stf_status_id = $staff->stf_status_id;
				$stf_status = $staff->stf_status;
				if ($staff->first_app_dt == '0000-00-00') {
					$f_app_dt = '';
				} else {
					$f_app_dt = $staff->first_app_dt;
				}
				$app_type_id = $staff->app_type_id;
				$app_type = $staff->app_type;
				$app_subj_id = $staff->app_subj_id;
				$app_subject = $staff->app_subj;

				$app_med_id = $staff->subj_med_id;
				$app_med_type = $staff->subj_med_type;
				if ($staff->start_dt_this_sch == '0000-00-00') {
					$start_dt_this_sch = '';
				} else {
					$start_dt_this_sch = $staff->start_dt_this_sch;
				}
				$stf_no = $staff->stf_no;
				$sal_no = $staff->salary_no;
				//$involved_task_id = $staff->involved_task_id;
				//$involved_task = $staff->inv_task;
				//$extra_curri_id	= $staff->extra_curri_id;
				//$extra_curri_name = $staff->extra_curri_type;
				//$extra_curri_role_id = $staff->ex_cu_role_id;
				//$extra_curri_role_name = $staff->ex_cu_role_name;			 			
				$user_id = $staff->user_id;
				$date_added = $staff->stf_date_added;
				$date_updated = $staff->last_update;
				$is_deleted = $staff->stf_is_deleted;
			}
			?>
			<div class="row">
				<div class="col-lg-12">
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="personal-tab" data-toggle="tab" href="#personal" role="tab"
								aria-controls="home" aria-selected="true"> පෞද්ගලික තොරතුරු </a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="service-tab" data-toggle="tab" href="#service" role="tab"
								aria-controls="service-tab" aria-selected="false">සේවා තොරතුරු</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="school-tab" data-toggle="tab" href="#school" role="tab"
								aria-controls="school-tab" aria-selected="true"> සේවා ස්ථානය</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="task-involved-tab" data-toggle="tab" href="#task-involved" role="tab"
								aria-controls="task-involved-tab" aria-selected="false">ඉටුකරන කාර්යය</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="current-service-details-tab" data-toggle="tab"
								href="#current-service-details" role="tab" aria-controls="current-service-details-tab"
								aria-selected="false">සේවා තත්ත්වය</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="service-grade-history-tab" data-toggle="tab"
								href="#service-grade-history" role="tab" aria-controls="service-grade-history-tab"
								aria-selected="false">සේවා ශ්‍රේණිය </a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile-picture" role="tab"
								aria-controls="profile-tab" aria-selected="false">Photo</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="teaching-classes-tab" data-toggle="tab" href="#teaching-classes"
								role="tab" aria-controls="teaching-classes-tab" aria-selected="true"> පන්ති </a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="extra-curricular-tab" data-toggle="tab" href="#extra-curricular"
								role="tab" aria-controls="extra-curricular-tab" aria-selected="false">විෂය සමගාමී</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="games-tab" data-toggle="tab" href="#games" role="tab"
								aria-controls="games-tab" aria-selected="false">විෂය බාහිර</a>
						</li>
					</ul>
					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="personal-tab">
							<div class="row">
								<div class="col-lg-12">
									<div class="card mb-3" style="border-top: none">
										<div class="card-body">
											<div class="row">
												<div class="col-sm-12">
													<?php
													if (!empty($this->session->flashdata('updateSuccessMsg'))) {
														$message = $this->session->flashdata('updateSuccessMsg');
														echo '<div class="alert alert-success" >' . $message['text'] . '</div>';
													} ?>
													<?php
													if (!empty($this->session->flashdata('updateErrorMsg'))) {
														$message = $this->session->flashdata('updateErrorMsg');
														echo '<div class="alert alert-danger" >' . $message['text'] . '</div>';
													} ?>
												</div>
											</div>
											<div class="row">
												<div class="col-sm-12 my-auto">
													<?php $attributes = array("class" => "form-horizontal", "id" => "update_stf_pers_info_form", "name" => "update_stf_pers_info_form");
													echo form_open("Staff/updateStfPersonalInfo", $attributes);	?>
													<fieldset>
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3">
																	<label for="Name with ini"> Title </label>
																</div>
																<div class="col-lg-5 col-sm-5">
																	<select class="form-control" id="title_select"
																		name="title_select">
																		<option value="<?php echo $title; ?>" selected>
																			<?php echo $title; ?></option>
																		<option value="Ven">Ven.</option>
																		<option value="Mr">Mr.</option>
																		<option value="Miss">Miss.</option>
																		<option value="Mrs">Mrs.</option>
																	</select>
																	<span class="text-danger"
																		id="grade_error"><?php echo form_error('title_select'); ?></span>
																</div>
															</div> <!-- /row -->
														</div> <!-- /form group -->
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3">
																	<?php $staff_id; ?>
																	<label for="Name with ini">මුලකුරු සමඟ නම </label>
																</div>
																<div class="col-lg-5 col-sm-5">
																	<input type="text" class="form-control"
																		id="name_with_ini_txt" name="name_with_ini_txt"
																		value="<?php echo $name_with_ini; ?>" />
																	<span
																		class="text-danger"><?php echo form_error('name_with_ini_txt'); ?></span>
																</div>
															</div> <!-- /row -->
														</div> <!-- /form group -->
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3">
																	<label for="Full name">සම්පූර්ණ නම </label>
																</div>
																<div class="col-lg-5 col-sm-5">
																	<input type="text" class="form-control"
																		id="fullname_txt" name="fullname_txt"
																		value="<?php echo $full_name; ?>" />
																	<span
																		class="text-danger"><?php echo form_error('fullname_txt'); ?></span>
																</div>
															</div> <!-- /row -->
														</div> <!-- /form group -->
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3">
																	<label for="Nick Name">භාවිත නාමය </label>
																</div>
																<div class="col-lg-5 col-sm-5">
																	<input type="text" class="form-control"
																		id="nick_name_txt" name="nick_name_txt"
																		value="<?php echo $nick_name; ?>" />
																	<span
																		class="text-danger"><?php echo form_error('nick_name_txt'); ?></span>
																</div>
															</div> <!-- /row -->
														</div> <!-- /form group -->
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3">
																	<label for="Address">ලිපින පේළිය 1 </label>
																</div>
																<div class="col-lg-5 col-sm-5">
																	<input type="text" class="form-control"
																		id="address1_txt" name="address1_txt"
																		value="<?php echo $address1; ?>" />
																	<span
																		class="text-danger"><?php echo form_error('address1_txt'); ?></span>
																</div>
															</div> <!-- /row -->
														</div> <!-- /form group -->
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3">
																	<label for="Address">ලිපින පේළිය 2</label>
																</div>
																<div class="col-lg-5 col-sm-5">
																	<input type="text" class="form-control"
																		id="address2_txt" name="address2_txt"
																		value="<?php echo $address2; ?>" />
																	<span
																		class="text-danger"><?php echo form_error('address2_txt'); ?></span>
																</div>
															</div> <!-- /row -->
														</div> <!-- /form group -->
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3">
																	<label for="Address"> ජා.හැ.අංකය </label>
																</div>
																<div class="col-lg-5 col-sm-5">
																	<input type="text" class="form-control" id="nic_txt"
																		name="nic_txt" value="<?php echo $nic_no; ?>" />
																	<span
																		class="text-danger"><?php echo form_error('nic_txt'); ?></span>
																</div>
															</div> <!-- /row -->
														</div> <!-- /form group -->
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3">
																	<label for="date of birth"> උපන් දිනය </label>
																</div>
																<div class="col-lg-5 col-sm-5">
																	<input type="text" class="form-control datepicker"
																		id="dob_txt" name="dob_txt"
																		value="<?php echo $dob; ?>" />
																	<span
																		class="text-danger"><?php echo form_error('dob_txt'); ?></span>
																</div>
															</div> <!-- /row -->
														</div> <!-- /form group -->
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3">
																	<label for="address 1"> ආගම </label>
																</div>
																<div class="col-lg-5 col-sm-5">
																	<select class="form-control" id="religion_select"
																		name="religion_select">
																		<option value="<?php echo $religion_id; ?>"
																			selected><?php echo $religion; ?></option>
																		<?php foreach ($this->all_religion as $row) { ?>
																			<!-- from Building controller constructor method -->
																			<option value="<?php echo $row->religion_id; ?>">
																				<?php echo $row->religion; ?></option>
																		<?php } ?>
																	</select>
																	<span
																		class="text-danger"><?php echo form_error('religion_select'); ?></span>
																</div>
															</div> <!-- /row -->
														</div> <!-- /form group -->
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3">
																	<label for="address 2">ජාතිය</label>
																</div>
																<div class="col-lg-5 col-sm-5">
																	<select class="form-control" id="ethnicity_select"
																		name="ethnicity_select">
																		<option value="<?php echo $ethnic_group_id; ?>"
																			selected><?php echo $ethnic_group; ?></option>
																		<?php foreach ($this->all_ethnic_groups as $row) { ?>
																			<!-- from Building controller constructor method -->
																			<option
																				value="<?php echo $row->ethnic_group_id; ?>">
																				<?php echo $row->ethnic_group; ?></option>
																		<?php } ?>
																	</select>
																	<span
																		class="text-danger"><?php echo form_error('ethnicity_select'); ?></span>
																</div>
															</div> <!-- /row -->
														</div> <!-- /form group -->
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3">
																	<label for="Civil Status">ස්ත්‍රී/පුරුෂ භාවය</label>
																</div>
																<div class="col-lg-5 col-sm-5">
																	<select class="form-control" id="gender_select"
																		name="gender_select">
																		<option value="<?php echo $gender_id; ?>" selected>
																			<?php echo $gender_type; ?></option>
																		<?php foreach ($this->all_genders as $row) { ?>
																			<!-- from Building controller constructor method -->
																			<option value="<?php echo $row->gender_id; ?>">
																				<?php echo $row->gender_name; ?></option>
																		<?php } ?>
																	</select>
																	<span
																		class="text-danger"><?php echo form_error('gender_select'); ?></span>
																</div>
															</div> <!-- /row -->
														</div> <!-- /form group -->
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3">
																	<label for="Civil Status">විවාහක/අවිවාහක බව</label>
																</div>
																<div class="col-lg-5 col-sm-5">
																	<select class="form-control" id="civil_status_select"
																		name="civil_status_select">
																		<option value="<?php echo $civ_id; ?>" selected>
																			<?php echo $civ_name; ?></option>
																		<?php foreach ($this->all_civil_status as $row) { ?>
																			<!-- from Building controller constructor method -->
																			<option
																				value="<?php echo $row->civil_status_id; ?>">
																				<?php echo $row->civil_status_type; ?></option>
																		<?php } ?>
																	</select>
																	<span
																		class="text-danger"><?php echo form_error('civil_status_select'); ?></span>
																</div>
															</div> <!-- /row -->
														</div> <!-- /form group -->
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3">
																	<label for="address 2">ජංගම දු.ක. 1 </label>
																</div>
																<div class="col-lg-5 col-sm-5">
																	<input type="text" class="form-control" id="phone1_txt"
																		name="phone1_txt"
																		value="<?php echo $phone_mobile1; ?>" />
																	<span
																		class="text-danger"><?php echo form_error('phone1_txt'); ?></span>
																</div>
															</div> <!-- /row -->
														</div> <!-- /form group -->
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3">
																	<label for="address 2">ජංගම දු.ක. 2</label>
																</div>
																<div class="col-lg-5 col-sm-5">
																	<input type="text" class="form-control" id="phone2_txt"
																		name="phone2_txt"
																		value="<?php echo $phone_mobile2; ?>" />
																	<span
																		class="text-danger"><?php echo form_error('phone2_txt'); ?></span>
																</div>
															</div> <!-- /row -->
														</div> <!-- /form group -->
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3">
																	<label for="address 2">දු.ක. අංකය - නිවස </label>
																</div>
																<div class="col-lg-5 col-sm-5">
																	<input type="text" class="form-control"
																		id="phoneHome_txt" name="phoneHome_txt"
																		value="<?php echo $phone_home; ?>" />
																	<span
																		class="text-danger"><?php echo form_error('phoneHome_txt'); ?></span>
																</div>
															</div> <!-- /row -->
														</div> <!-- /form group -->
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3">
																	<label for="address 2">විද්‍යුත් තැපෑල</label>
																</div>
																<div class="col-lg-5 col-sm-5">
																	<input type="text" class="form-control" id="email_txt"
																		name="email_txt" value="<?php echo $email; ?>" />
																	<span
																		class="text-danger"><?php echo form_error('email_txt'); ?></span>
																</div>
															</div> <!-- /row -->
														</div> <!-- /form group -->
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3">
																	<label for="address 2">ඉහළම අධ්‍යාපන සුදුසුකම්</label>
																</div>
																<div class="col-lg-5 col-sm-5">
																	<select class="form-control" id="high_edu_select"
																		name="high_edu_select">
																		<option value="<?php echo $edu_q_id; ?>" selected>
																			<?php echo $edu_q_name; ?></option>
																		<?php foreach ($this->all_edu_qual as $row) { ?>
																			<!-- from Building controller constructor method -->
																			<option value="<?php echo $row->edu_q_id; ?>">
																				<?php echo $row->edu_q_name; ?></option>
																		<?php } ?>
																	</select>
																	<span
																		class="text-danger"><?php echo form_error('phone2_txt'); ?></span>
																</div>
															</div> <!-- /row -->
														</div> <!-- /form group -->
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3">
																	<label for="address 2">ඉහළම වෘත්තීය සුදුසුකම්</label>
																</div>
																<div class="col-lg-5 col-sm-5">
																	<select class="form-control" id="prof_edu_select"
																		name="prof_edu_select">
																		<option value="<?php echo $prof_q_id; ?>" selected>
																			<?php echo $prof_q_description; ?></option>
																		<?php foreach ($this->all_prof_qual as $row) { ?>
																			<!-- from Building controller constructor method -->
																			<option value="<?php echo $row->prof_q_id; ?>">
																				<?php echo $row->prof_q_description; ?></option>
																		<?php } ?>
																	</select>
																	<span
																		class="text-danger"><?php echo form_error('prof_edu_select'); ?></span>
																</div>
															</div> <!-- /row -->
														</div> <!-- /form group -->
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3">
																	<label for="date added">Date Added</label>
																</div>
																<div class="col-lg-5 col-sm-5">
																	<input type="text" class="form-control"
																		id="dateadded_txt" name="dateadded_txt"
																		value="<?php echo $date_added; ?>"
																		readonly="true" />
																</div>
															</div> <!-- /row -->
														</div> <!-- /form group -->
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3">
																	<label for="date updated">Last Update</label>
																</div>
																<div class="col-lg-5 col-sm-5">
																	<input type="text" class="form-control"
																		id="date_updated" name="date_updated"
																		value="<?php echo $date_updated; ?>"
																		readonly="true" />
																</div>
															</div> <!-- /row -->
														</div> <!-- /form group -->
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3"></div>
																<div class="col-lg-5 col-sm-5">
																	<input type="hidden" name="stf_id_hidden"
																		value="<?php echo $staff_id; ?>" />
																	<!-- // submit button -->
																	<input id="btn_edit_stf_pers_info"
																		name="btn_edit_stf_pers_info" type="submit"
																		class="btn btn-primary mr-2 mt-2" value="Update" />
																	<span name="is_deleted"
																		value="<?php echo $is_deleted; ?>"></span>
																	<a href="<?php echo base_url(); ?>Staff/viewAcademicStaff"
																		id="btn_cancel" name="btn_cancel" type="reset"
																		class="btn btn-success mt-2" value="Cancel"
																		style="margin-top: 10px;">Cancel</a>
																</div>
															</div>
														</div> <!-- /form group -->
													</fieldset>
													<?php echo form_close(); ?>
												</div> <!-- /col-sm-12 -->
											</div> <!-- /row -->
										</div> <!-- /card body -->
									</div> <!-- /card -->
								</div> <!-- / col-lg-8 -->
							</div> <!-- / row -->
						</div> <!-- / personal tab-pane fade -->
						<!-- ----------------------------------------------------------------------------------------------------------------- -->
						<div class="tab-pane fade" id="service" role="tabpanel" aria-labelledby="service-tab">
							<div class="row">
								<div class="col-lg-12 col-sm-12">
									<div class="card mb-3" style="border-top: none">
										<div class="card-body">
											<div class="row">
												<div class="col-sm-12">
													<?php
													if (!empty($this->session->flashdata('servInfoUpdateSuccessMsg'))) {
														$message = $this->session->flashdata('servInfoUpdateSuccessMsg');
														echo '<div class="alert alert-success" >' . $message['text'] . '</div>';
													} ?>
													<?php
													if (!empty($this->session->flashdata('servInfoUpdateErrorMsg'))) {
														$message = $this->session->flashdata('servInfoUpdateErrorMsg');
														echo '<div class="alert alert-danger" >' . $message['text'] . '</div>';
													} ?>
												</div>
											</div>
											<div class="row">
												<div class="col-sm-12 my-auto">
													<?php $attributes = array("class" => "form-horizontal", "id" => "update_stf_serv_info_form", "name" => "update_stf_serv_info_form");
													echo form_open("Staff/updateStfServInfo", $attributes);	?>
													<fieldset>
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3">
																	<label for="Employee Type" class="control-label"> කාර්ය
																		මණ්ඩල වර්ගය </label>
																</div>
																<div class="col-lg-5 col-sm-5">
																	<select class="form-control" id="emp_type_select"
																		name="emp_type_select">
																		<option value="<?php echo $stf_type_id; ?>"
																			selected><?php echo $stf_type; ?></option>
																		<?php foreach ($this->all_stf_types as $row) { ?>
																			<!-- from Building controller constructor method -->
																			<option value="<?php echo $row->stf_type_id; ?>">
																				<?php echo $row->stf_type; ?></option>
																		<?php } ?>
																	</select>
																</div>
															</div> <!-- /row -->
														</div> <!-- /form group -->
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3">
																	<label for="Name with ini">වත්මන් සේවයේ මුල් පත්වීම්
																		දිනය</label>
																</div>
																<div class="col-lg-5 col-sm-5">
																	<input type="text" class="form-control datepicker"
																		id="f_app_dt_txt" name="f_app_dt_txt"
																		value="<?php echo $f_app_dt; ?>" />
																	<span
																		class="text-danger"><?php echo form_error('f_app_dt_txt'); ?></span>
																</div>
															</div> <!-- /row -->
														</div> <!-- /form group -->
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3">
																	<label for="Appointment category" class="control-label">
																		පත්වීම් වර්ගය </label>
																</div>
																<div class="col-lg-5 col-sm-5">
																	<select class="form-control" id="app_type_select"
																		name="app_type_select">
																		<option value="<?php echo $app_type_id; ?>"
																			selected><?php echo $app_type; ?></option>
																		<?php foreach ($this->all_appoint_types as $row) { ?>
																			<!-- from Building controller constructor method -->
																			<option value="<?php echo $row->app_type_id; ?>">
																				<?php echo $row->app_type; ?></option>
																		<?php } ?>
																	</select>
																</div>
															</div> <!-- /row -->
														</div> <!-- /form group -->
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3">
																	<label for="Name with ini">පත්වීම් විෂය</label>
																</div>
																<div class="col-lg-5 col-sm-5">
																	<select class="form-control" id="app_subj_select"
																		name="app_subj_select">
																		<option value="<?php echo $app_subj_id; ?>"
																			selected><?php echo $app_subject; ?></option>
																		<?php foreach ($this->all_appoint_subjects as $row) { ?>
																			<!-- from Staff controller constructor method -->
																			<option value="<?php echo $row->app_subj_id; ?>">
																				<?php echo $row->app_subj; ?></option>
																		<?php } ?>
																	</select>
																	<span
																		class="text-danger"><?php echo form_error('app_subj_select'); ?></span>
																</div>
															</div> <!-- /row -->
														</div> <!-- /form group -->
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3">
																	<label for="guardian telephone" class="control-label">
																		පත්වීම් මාධ්‍යය </label>
																</div>
																<div class="col-lg-5 col-sm-5">
																	<select class="form-control" id="app_medium_select"
																		name="app_medium_select">
																		<option value="<?php echo $app_med_id; ?>" selected>
																			<?php echo $app_med_type; ?></option>
																		<?php foreach ($this->all_subj_medium as $row) { ?>
																			<!-- from Building controller constructor method -->
																			<option value="<?php echo $row->subj_med_id; ?>">
																				<?php echo $row->subj_med_type; ?></option>
																		<?php } ?>
																	</select>
																</div>
															</div> <!-- /row -->
														</div> <!-- /form group -->
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3">
																	<label for="Designation" class="control-label"> පත්වීමේ
																		ස්වභාවය </label>
																</div>
																<div class="col-lg-5 col-sm-5">
																	<select class="form-control" id="stf_status_select"
																		name="stf_status_select">
																		<option value="<?php echo $stf_status_id; ?>"
																			selected><?php echo $stf_status; ?></option>
																		<?php foreach ($this->all_staff_status as $row) { ?>
																			<!-- from Staff controller constructor method -->
																			<option value="<?php echo $row->stf_status_id; ?>">
																				<?php echo $row->stf_status; ?></option>
																		<?php } ?>
																	</select>
																</div>
															</div> <!-- /row -->
														</div> <!-- /form group -->
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3">
																	<label for="service grade" class="control-label"> වත්මන්
																		සේවා ශ්‍රේණිය </label>
																</div>
																<div class="col-lg-5 col-sm-5">
																	<select class="form-control" id="serv_gr_select"
																		name="serv_gr_select">
																		<option value="<?php echo $service_grade_id; ?>"
																			selected><?php echo $service_grade_name; ?>
																		</option>
																		<?php foreach ($this->all_service_grades as $row) { ?>
																			<!-- from Building controller constructor method -->
																			<option value="<?php echo $row->serv_grd_id; ?>">
																				<?php echo $row->serv_grd_type; ?></option>
																		<?php } ?>
																	</select>
																</div>
															</div> <!-- /row -->
														</div> <!-- /form group -->
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3"></div>
																<div class="col-lg-5 col-sm-5">
																	<input type="hidden" name="stf_id_hidden"
																		value="<?php echo $staff_id; ?>" />
																	<!-- submit button -->
																	<input id="btn_edit_stf_serv_info"
																		name="btn_edit_stf_serv_info" type="submit"
																		class="btn btn-primary mr-2 mt-2" value="Update" />
																	<span name="is_deleted"
																		value="<?php echo $is_deleted; ?>"></span>
																	<a href="<?php echo base_url(); ?>Staff/viewAcademicStaff"
																		id="btn_cancel" name="btn_cancel" type="reset"
																		class="btn btn-success mt-2" value="Cancel"
																		style="margin-top: 10px;">Cancel</a>
																</div>
															</div>
														</div> <!-- /form group -->
													</fieldset>
													<?php echo form_close(); ?>
												</div> <!-- /col-lg-12 col-sm-12 -->
											</div> <!-- /row -->
										</div> <!-- /card body -->
									</div> <!-- /card -->
								</div> <!-- / col-lg-8 -->
							</div> <!-- / row -->
						</div> <!-- / tab-pane fade service -->
						<!-- ----------------------------------------------------------------------------------------------------------------- -->
						<div class="tab-pane fade" id="school" role="tabpanel" aria-labelledby="school-tab">
							<div class="row">
								<div class="col-lg-12 col-sm-12">
									<div class="card mb-3" style="border-top: none">
										<div class="card-body">
											<div class="row">
												<div class="col-sm-12">
													<?php
													if (!empty($this->session->flashdata('schInfoUpdateSuccessMsg'))) {
														$message = $this->session->flashdata('schInfoUpdateSuccessMsg');
														echo '<div class="alert alert-success" >' . $message['text'] . '</div>';
													} ?>
													<?php
													if (!empty($this->session->flashdata('schInfoUpdateErrorMsg'))) {
														$message = $this->session->flashdata('schInfoUpdateErrorMsg');
														echo '<div class="alert alert-danger" >' . $message['text'] . '</div>';
													} ?>
												</div>
											</div>
											<div class="row">
												<div class="col-sm-12 my-auto">
													<?php $attributes = array("class" => "form-horizontal", "id" => "update_sch_info_form", "name" => "update_sch_info_form");
													echo form_open("Staff/updateCurrentSchoolInfo", $attributes);	?>
													<fieldset>
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3">
																	<label for="Designation" class="control-label"> පාසල
																	</label>
																</div>
																<div class="col-lg-5 col-sm-5">
																	<select class="form-control" id="school_select"
																		name="school_select">
																		<option value="<?php echo $census_id; ?>" selected>
																			<?php echo $school_name; ?></option>
																		<?php foreach ($this->all_schools as $row) { ?>
																			<!-- from Building controller constructor method -->
																			<option value="<?php echo $row->census_id; ?>">
																				<?php echo $row->sch_name; ?></option>
																		<?php } ?>
																	</select>
																</div>
															</div> <!-- /row -->
														</div> <!-- /form group -->
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3">
																	<label for="staff number"> පාසලේ ගුරු අංකය </label>
																</div>
																<div class="col-lg-5 col-sm-5">
																	<input class="form-control" id="stf_no_txt"
																		name="stf_no_txt" placeholder="Type here"
																		type="text" value="<?php echo $stf_no; ?>" />
																</div>
															</div> <!-- /row -->
														</div> <!-- /form group -->
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3">
																	<label for="staff number"> වැටුප් අංකය </label>
																</div>
																<div class="col-lg-5 col-sm-5">
																	<input class="form-control" id="salary_no_txt"
																		name="salary_no_txt" placeholder="Type here"
																		type="text" value="<?php echo $sal_no; ?>" />
																</div>
															</div> <!-- /row -->
														</div> <!-- /form group -->
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3">
																	<label for="start_this_date" class="control-label"> මෙම
																		පාසලට පත්වූ දිනය </label>
																</div>
																<div class="col-lg-5 col-sm-5">
																	<input class="form-control datepicker"
																		id="start_this_dt_txt" name="start_this_dt_txt"
																		placeholder="---Click here---" type="text"
																		value="<?php echo $start_dt_this_sch; ?>"
																		data-date-end-date="0d" />
																</div>
															</div> <!-- /row -->
														</div> <!-- /form group -->
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3">
																	<label for="Designation" class="control-label"> පාසලේ
																		දරන තනතුර </label>
																</div>
																<div class="col-lg-5 col-sm-5">
																	<select class="form-control" id="desig_select"
																		name="desig_select">
																		<option value="<?php echo $desig_id; ?>" selected>
																			<?php echo $desig_name; ?></option>
																		<?php foreach ($this->all_designations as $row) { ?>
																			<!-- from Building controller constructor method -->
																			<option value="<?php echo $row->desig_id; ?>">
																				<?php echo $row->desig_type; ?></option>
																		<?php } ?>
																	</select>
																</div>
															</div> <!-- /row -->
														</div> <!-- /form group -->
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3">
																	<label for="Section" class="control-label"> අංශය
																	</label>
																</div>
																<div class="col-lg-5 col-sm-5">
																	<select class="form-control" id="section_select"
																		name="section_select">
																		<option value="<?php echo $section_id; ?>" selected>
																			<?php echo $section_name; ?></option>
																		<?php foreach ($this->all_sections as $row) { ?>
																			<!-- from Building controller constructor method -->
																			<option value="<?php echo $row->section_id; ?>">
																				<?php echo $row->section_name; ?></option>
																		<?php } ?>
																	</select>
																</div>
															</div> <!-- /row -->
														</div> <!-- /form group -->
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3">
																	<label for="Section Role" class="control-label"> අංශයේ
																		භූමිකාව </label>
																</div>
																<div class="col-lg-5 col-sm-5">
																	<select class="form-control" id="section_role_select"
																		name="section_role_select">
																		<option value="<?php echo $section_role_id; ?>"
																			selected><?php echo $section_role_name; ?>
																		</option>
																		<?php foreach ($this->all_section_roles as $row) { ?>
																			<!-- from Building controller constructor method -->
																			<option value="<?php echo $row->sec_role_id; ?>">
																				<?php echo $row->sec_role_name; ?></option>
																		<?php } ?>
																	</select>
																</div>
															</div> <!-- /row -->
														</div> <!-- /form group -->
														<div class="form-group">
															<div class="row">
																<div class="col-lg-3 col-sm-3"></div>
																<div class="col-lg-5 col-sm-5">
																	<input type="hidden" name="stf_id_hidden"
																		value="<?php echo $staff_id; ?>" />
																	<!-- submit button -->
																	<input id="btn_edit_stf_school_info"
																		name="btn_edit_stf_school_info" type="submit"
																		class="btn btn-primary mr-2 mt-2" value="Update" />
																	<span name="is_deleted"
																		value="<?php echo $is_deleted; ?>"></span>
																	<a href="<?php echo base_url(); ?>Staff/viewAcademicStaff"
																		id="btn_cancel" name="btn_cancel" type="reset"
																		class="btn btn-success mt-2" value="Cancel"
																		style="margin-top: 10px;">Cancel</a>
																</div>
															</div>
														</div> <!-- /form group -->
													</fieldset>
													<?php echo form_close(); ?>
												</div> <!-- /col-lg-12 col-sm-12 -->
											</div> <!-- /row -->
										</div> <!-- /card body -->
									</div> <!-- /card -->
								</div> <!-- / col-lg-8 -->
							</div> <!-- / row -->
						</div> <!-- / tab-pane fade school -->
						<!-- ----------------------------------------------------------------------------------------------------------------- -->
						<div class="tab-pane fade" id="current-service-details" role="tabpanel"
							aria-labelledby="current-service-details-tab">
							<div class="row">
								<div class="col-lg-12 col-sm-12">
									<div class="card mb-3" style="border-top: none">
										<div class="card-body">
											<div class="row">
												<div class="col-sm-12 my-auto">
													<?php
													if (!empty($this->session->flashdata('serviceStatusMsg'))) {
														$serviceStatusMsg = $this->session->flashdata('serviceStatusMsg');  ?>
														<div class="<?php echo $serviceStatusMsg['class']; ?>">
															<?php echo $serviceStatusMsg['text']; ?></div>
													<?php   } ?>
													<?php
													if (empty($stf_serv_status)) {
														echo '<h4>Not Assigned!!!</h4>';
													} else {
													?>
														<table class="table table-hover" id="service_grade_info_tbl"
															class="table table-striped table-bordered" cellspacing="0" width="">
															<thead>
																<tr>
																	<th scope="col" class="col-sm-4"> තත්ත්වය </th>
																	<th scope="col" class="col-sm-3"> ආයතනය </th>
																	<th scope="col" class="col-sm-1"> දිනය </th>
																	<th scope="col" class="col-sm-1"> කාලය </th>
																	<th scope="col" class="col-sm-3"> වර්ථමාන සේවා තත්ත්වයද?
																	</th>
																</tr>
															</thead>
															<tbody>
																<?php
																foreach ($stf_serv_status as $row) {
																	$stf_serv_status_id = $row->stf_serv_status_id;
																	$status_id = $row->status_id;
																	$institute = $row->institute;
																	$effective_date = $row->effective_date;
																	$period = $row->period;
																	$is_current = $row->is_current;
																	$date_added = $row->date_added;
																	//$date_updated = $now;
																?>
																	<tr id="<?php echo 'tbrow' . $stf_serv_status_id; ?>">
																		<td style="vertical-align:middle">
																			<?php echo $row->service_status; ?></td>
																		<td style="vertical-align:middle">
																			<?php echo $row->institute; ?></td>
																		<td style="vertical-align:middle">
																			<?php echo $row->effective_date; ?></td>
																		<td style="vertical-align:middle">
																			<?php echo $row->period; ?></td>
																		<td style="vertical-align:middle;text-align:center;">
																			<?php echo ($row->is_current == 1) ? "ඔව්" : "නැත"; ?>
																		</td>
																		<td id="td_btn">
																			<a type="button"
																				name="btn_delete_phy_res_status_details"
																				class="btn btn-danger btn-sm btn_delete_service_status"
																				value="Cancel" data-toggle="tooltip"
																				title="Delete this task"
																				data-id="<?php echo $stf_serv_status_id; ?>"><i
																					class="fa fa-trash-o"></i></a>
																		</td>
																	</tr>
															<?php	}
															} ?>
															<tr>
																<td>
																	<button id="btn_add_new_grd_cls_info"
																		name="btn_add_new_serv_status" type="button"
																		class="btn btn-primary btn-sm" value="Add"
																		data-toggle="modal"
																		data-target="#editCurServStatus"><i
																			class="fa fa-plus"></i> Add </button>
																</td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
															</tr>
															</tbody>
														</table>
												</div> <!-- /col-lg-12 col-sm-12 -->
											</div> <!-- /row -->
										</div> <!-- /card body -->
									</div> <!-- /card -->
								</div> <!-- / col-lg-8 -->
							</div> <!-- / row -->
						</div> <!-- / tab-pane fade school -->
						<!-- ----------------------------------------------------------------------------------------------------------------- -->
						<div class="tab-pane fade" id="task-involved" role="tabpanel" aria-labelledby="task-involved-tab">
							<div class="row">
								<div class="col-lg-12 col-sm-12">
									<div class="card mb-3" style="border-top: none">
										<div class="card-body">
											<div class="row">
												<div class="col-sm-12 my-auto">
													<?php
													if (!empty($this->session->flashdata('taskMsg'))) {
														$taskMsg = $this->session->flashdata('taskMsg');  ?>
														<div class="<?php echo $taskMsg['class']; ?>">
															<?php echo $taskMsg['text']; ?></div>
													<?php   } ?>
													<?php if (empty($stf_involved_task)) {
														echo '<h4>Not Assigned!!!</h4>';
													} else {
													?>
														<table class="table table-hover" id="service_grade_info_tbl"
															class="table table-striped table-bordered" cellspacing="0" width="">
															<thead>
																<tr>
																	<th scope="col" class="col-sm-4"> </th>
																	<th scope="col" class="col-sm-4"> කාර්යය </th>
																	<th scope="col" class="col-sm-2"> අංශය </th>
																	<th scope="col" class="col-sm-2"> විෂ්‍යය </th>
																	<th></th>
																</tr>
															</thead>
															<tbody>
																<?php
																foreach ($stf_involved_task as $row) {
																	$stf_inv_task_id = $row->stf_inv_task_id;
																	$involved_task_type_id = $row->involved_task_type_id;
																	$involved_task_id = $row->involved_task_id;
																	$section_id = $row->section_id;
																	$subject_id = $row->subject_id;
																	$date_added = $row->date_added;
																	//$date_updated = $now;
																?>
																	<tr id="<?php echo 'tbrow' . $stf_inv_task_id; ?>">
																		<td style="vertical-align:middle">
																			<?php echo $row->involved_task_type; ?></td>
																		<td style="vertical-align:middle">
																			<?php echo $row->inv_task; ?></td>
																		<td style="vertical-align:middle">
																			<?php echo $row->section_name; ?></td>
																		<td style="vertical-align:middle">
																			<?php echo $row->subject; ?></td>
																		<td id="td_btn">
																			<a type="button"
																				name="btn_delete_phy_res_status_details"
																				class="btn btn-danger btn-sm btn_delete_task"
																				value="Cancel" data-toggle="tooltip"
																				title="Delete this task"
																				data-id="<?php echo $stf_inv_task_id; ?>"><i
																					class="fa fa-trash-o"></i></a>
																		</td>
																	</tr>
															<?php	}
															} ?>
															<tr>
																<td>
																	<button id="btn_add_new_task_info"
																		name="btn_add_new_task_info" type="button"
																		class="btn btn-primary btn-sm" value="Add"
																		data-toggle="modal" data-target="#AssignToTask"><i
																			class="fa fa-plus"></i> Assign </button>
																</td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
															</tr>
															</tbody>
														</table>
												</div> <!-- /col-lg-12 col-sm-12 -->
											</div> <!-- /row -->
										</div> <!-- /card body -->
									</div> <!-- /card -->
								</div> <!-- / col-lg-8 -->
							</div> <!-- / row -->
						</div> <!-- / tab-pane fade task-involved -->
						<!-- ----------------------------------------------------------------------------------------------------------------- -->
						<div class="tab-pane fade" id="service-grade-history" role="tabpanel"
							aria-labelledby="service-grade-history-tab">
							<div class="row">
								<div class="col-lg-12 col-sm-12">
									<div class="card mb-3" style="border-top: none">
										<div class="card-body">
											<div class="row">
												<div class="col-sm-12">
													<?php
													if (!empty($this->session->flashdata('servGrdMsg'))) {
														$servGrdMsg = $this->session->flashdata('servGrdMsg');  ?>
														<div class="<?php echo $servGrdMsg['class']; ?>">
															<?php echo $servGrdMsg['text']; ?></div>
													<?php   } ?>
													<?php if (empty($stf_serv_grd_info)) {
														echo '<h4>Not Assigned!!!</h4>';
													} else {
													?>
														<table class="table table-hover" id="service_grade_info_tbl"
															class="table table-striped table-bordered" cellspacing="0" width="">
															<thead>
																<tr>
																	<th scope="col" class="col-sm-4"> ශ්‍රේණිය </th>
																	<th scope="col" class="col-sm-4"> උසස්වීම ලද දිනය </th>
																	<th scope="col" class="col-sm-2"> වර්ථමාන ශ්‍රේණිය ද?</th>
																	<th scope="col" class="col-sm-2"> </th>
																</tr>
															</thead>
															<tbody>
																<?php
																foreach ($stf_serv_grd_info as $row) {
																	$stf_serv_grd_id = $row->stf_serv_grd_id;
																	$serv_grd_id = $row->serv_grd_id;
																	$serv_grd_type = $row->serv_grd_type;
																	$effective_date = $row->effective_date;
																	$is_current = $row->is_current;
																	$date_added = $row->date_added;

																?>
																	<tr id="<?php echo 'tbrow' . $stf_serv_grd_id; ?>">
																		<td style="vertical-align:middle">
																			<?php echo $serv_grd_type; ?></td>
																		<td style="vertical-align:middle">
																			<?php echo $effective_date; ?></td>
																		<td style="vertical-align:middle">
																			<?php if ($is_current == 1) {
																				echo 'ඔව්';
																			} ?></td>
																		<td id="td_btn">
																			<a type="button"
																				name="btn_delete_phy_res_status_details"
																				class="btn btn-danger btn-sm btn_delete_serv_grd"
																				value="Cancel" data-toggle="tooltip"
																				title="Delete this task"
																				data-id="<?php echo $stf_serv_grd_id; ?>"><i
																					class="fa fa-trash-o"></i></a>
																		</td>
																	</tr>
															<?php	}
															} ?>
															<tr>
																<td>
																	<button id="btn_add_new_grd_cls_info"
																		name="btn_add_new_grd_cls_info" type="button"
																		class="btn btn-primary btn-sm" value="Add"
																		data-toggle="modal"
																		data-target="#AssignServiceGrade"><i
																			class="fa fa-plus"></i> Assign </button>
																</td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
															</tr>
															</tbody>
														</table>
												</div> <!-- /col-lg-12 col-sm-12 -->
											</div> <!-- /row -->
										</div> <!-- /card body -->
									</div> <!-- /card -->
								</div> <!-- / col-lg-8 -->
							</div> <!-- / row -->
						</div> <!-- / tab-pane fade grade-history -->
						<!-- ----------------------------------------------------------------------------------------------------------------- -->
						<div class="tab-pane fade" id="profile-picture" role="tabpanel"
							aria-labelledby="profile-picture-tab">
							<div class="row">
								<div class="col-lg-12 col-sm-12">
									<div class="card mb-3" style="border-top: none">
										<div class="card-body">
											<div class="row">
												<div class="col-sm-12">
													<?php
													if (!empty($this->session->flashdata('stfImgUploadSuccess'))) {
														$message = $this->session->flashdata('stfImgUploadSuccess');  ?>
														<div class="alert alert-success"><?php echo $message; ?></div>
													<?php } ?>
													<?php
													if (!empty($this->session->flashdata('stfImgUploadError'))) {
														$message = $this->session->flashdata('stfImgUploadError');
														foreach ($message as $item => $value) {
															echo '<div class="alert alert-danger" >' . $item . ' : ' . $value . '</div>';
														}
													} ?>
													<?php
													if (!empty($this->session->flashdata('noImageError'))) {
														$message = $this->session->flashdata('noImageError');
														echo '<div class="alert alert-danger" >' . $message . '</div>';
													} ?>
												</div>
											</div>
											<div class="row">
												<div class="col-sm-12 my-auto">
													<?php $attributes = array("class" => "form-horizontal", "id" => "update_stf_image_form", "name" => "update_stf_image_form");
													echo form_open_multipart("Staff/uploadStaffImage", $attributes);	?>
													<fieldset>
														<div class="form-group">
															<div class="row">
																<div class="col-lg-6 col-sm-6">
																	<div class="row">
																		<div class="col-lg-12 col-sm-12">
																			<center>
																				<h4><?php echo $name_with_ini; ?></h4>
																			</center>
																			<center>
																				<h5><?php echo $staff_id; ?></h5>
																			</center>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-lg-6 col-sm-6">
																			<center><input type="file" name="stf_image"
																					size="20" id="stf_image"
																					title="Change Image" /></center>
																		</div>
																		<div class="col-lg-6 col-sm-6">
																			<img id="imgPrw" src="#" alt=""
																				class="imgPrw" />
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-lg-6 col-sm-6">
																			<input type="hidden" name="stf_id_hidden"
																				value="<?php echo $staff_id; ?>" />
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-lg-6 col-sm-6">
																			<button class="btn btn-primary" type="submit"
																				name="btn_upload_stf_img"
																				value="upload_stf_image"
																				style="margin:5 0 5 0; "> Upload </button>
																		</div>
																	</div>
																</div>
																<div class="col-lg-6 col-sm-6">
																	<center>
																		<?php
																		if (file_exists("./assets/uploaded/stf_images/$staff_id.jpg")) {
																		?>
																			<img src="<?php echo base_url(); ?>assets/uploaded/stf_images/<?php echo $staff_id; ?>.jpg"
																				style="">
																		<?php } else { ?>
																			<img src="<?php echo base_url(); ?>assets/uploaded/stf_images/default_profile_image.png"
																				style="">
																		<?php } ?>
																	</center>
																</div>
															</div> <!-- /row -->
														</div> <!-- /form group -->
													</fieldset>
													<?php echo form_close(); ?>
												</div> <!-- /col-lg-12 col-sm-12 -->
											</div> <!-- /row -->
										</div> <!-- /card body -->
									</div> <!-- /card -->
								</div> <!-- / col-lg-8 -->
							</div> <!-- / row -->
						</div> <!-- / tab-pane fade profile-picture -->
						<!-- ----------------------------------------------------------------------------------------------------------------- -->
						<div class="tab-pane fade" id="grade-history" role="tabpanel" aria-labelledby="grade-history-tab">
							<div class="row">
								<div class="col-lg-12 col-sm-12">
									<div class="card mb-3" style="border-top: none">
										<div class="card-body">
											<div class="row">
												<div class="col-sm-12">
													<?php
													if (!empty($this->session->flashdata('gradeClassMsg'))) {
														$gradeClassMsg = $this->session->flashdata('gradeClassMsg');
													?>
														<div class="<?php echo $gradeClassMsg['class']; ?>">
															<?php echo $gradeClassMsg['text']; ?></div>
													<?php   	} ?>
													<?php if (empty($stf_grd_cls_info)) {
														echo '<h4>Not Assigned!!!</h4>';
													} else {
													?>
														<table class="table table-hover" id="grade_info_tbl"
															class="table table-striped table-bordered" cellspacing="0" width="">
															<thead>
																<tr>
																	<th scope="col" class="col-sm-4"> පන්තිය </th>
																	<th scope="col" class="col-sm-4"> භූමිකාව </th>
																	<!-- 					                          <th scope="col" class="col-sm-2"> </th>
 -->
																	<th scope="col" class="col-sm-2"> </th>
																</tr>
															</thead>
															<tbody>
																<?php
																foreach ($stf_grd_cls_info as $gc_info) {
																	$stf_grd_cls_id = $gc_info->stf_grd_cls_id;
																	$grd_id = $gc_info->grade_id;
																	$cls_id = $gc_info->class_id;
																	$grade = $gc_info->grade;
																	$class = $gc_info->class;
																	$class_role_id = $gc_info->sec_role_id;
																	$class_role_name = $gc_info->sec_role_name;
																?>
																	<tr>
																		<td style="vertical-align:middle">
																			<?php echo $grade . ' ' . $class; ?></td>
																		<td style="vertical-align:middle">
																			<?php echo $class_role_name; ?></td>
																		<td id="td_btn">
																			<a type="button" id="btn_edit_gc_info"
																				name="btn_edit_gc_info" type="button"
																				class="btn btn-info btn-sm btn_edit_phy_res"
																				value="edit" title="Update" data-toggle="tooltip"
																				href="<?php echo base_url(); ?>Staff/editStaffGradeClassView/<?php echo $stf_grd_cls_id; ?>/<?php echo $staff_id; ?>"><i
																					class="fa fa-pencil"></i></a>
																		</td>
																		<td id="td_btn">
																			<a href="<?php echo base_url(); ?>Staff/deleteStaffGrdClsInfo/<?php echo $stf_grd_cls_id; ?>/<?php echo $staff_id; ?>"
																				type="button" name="btn_delete_gc_info"
																				class="btn btn-danger btn-sm" value="Cancel"
																				data-toggle="tooltip" title="Delete"
																				onClick="return confirmStatusDelete();"><i
																					class="fa fa-trash-o"></i></a>
																		</td>
																	</tr>
															<?php		}
															}
															?>
															<tr>
																<td>
																	<button id="btn_add_new_grd_cls_info"
																		name="btn_add_new_grd_cls_info" type="button"
																		class="btn btn-primary btn-sm" value="Add"
																		data-toggle="modal"
																		data-target="#AssignToNewGradeClass"><i
																			class="fa fa-plus"></i> Assign </button>
																</td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
															</tr>
															</tbody>
														</table>
												</div> <!-- /col-lg-12 col-sm-12 -->
											</div> <!-- /row -->
										</div> <!-- /card body -->
									</div> <!-- /card -->
								</div> <!-- / col-lg-8 -->
							</div> <!-- / row -->
						</div> <!-- / tab-pane fade grade-history -->
						<!-- ----------------------------------------------------------------------------------------------------------------- -->
						<div class="tab-pane fade" id="service-history" role="tabpanel"
							aria-labelledby="service-history-tab">
							<div class="row">
								<div class="col-lg-12 col-sm-12">
									<div class="card mb-3" style="border-top: none">
										<div class="card-body">
											<div class="row">
												<div class="col-sm-12">
													<?php
													if (!empty($this->session->flashdata('gradeClassMsg'))) {
														$gradeClassMsg = $this->session->flashdata('gradeClassMsg');  ?>
														<div class="<?php echo $gradeClassMsg['class']; ?>">
															<?php echo $gradeClassMsg['text']; ?></div>
													<?php   } ?>
													<?php if (empty($stf_grd_cls_info)) {
														echo '<h4>Not Assigned!!!</h4>';
													} else {
													?>
														<table class="table table-hover" id="grade_info_tbl"
															class="table table-striped table-bordered" cellspacing="0" width="">
															<thead>
																<tr>
																	<th scope="col" class="col-sm-4"> පන්තිය </th>
																	<th scope="col" class="col-sm-4"> භූමිකාව </th>
																	<!-- 					                          <th scope="col" class="col-sm-2"> </th>
 -->
																	<th scope="col" class="col-sm-2"> </th>
																</tr>
															</thead>
															<tbody>
																<?php
																foreach ($stf_grd_cls_info as $gc_info) {
																	$stf_grd_cls_id = $gc_info->stf_grd_cls_id;
																	$grd_id = $gc_info->grade_id;
																	$cls_id = $gc_info->class_id;
																	$grade = $gc_info->grade;
																	$class = $gc_info->class;
																	$class_role_id = $gc_info->sec_role_id;
																	$class_role_name = $gc_info->sec_role_name;
																?>
																	<tr>
																		<td style="vertical-align:middle">
																			<?php echo $grade . ' ' . $class; ?></td>
																		<td style="vertical-align:middle">
																			<?php echo $class_role_name; ?></td>
																		<td id="td_btn">
																			<a type="button" id="btn_edit_gc_info"
																				name="btn_edit_gc_info" type="button"
																				class="btn btn-info btn-sm btn_edit_phy_res"
																				value="edit" title="Update" data-toggle="tooltip"
																				href="<?php echo base_url(); ?>Staff/editStaffGradeClassView/<?php echo $stf_grd_cls_id; ?>/<?php echo $staff_id; ?>"><i
																					class="fa fa-pencil"></i></a>
																		</td>
																		<td id="td_btn">
																			<a href="<?php echo base_url(); ?>Staff/deleteStaffGrdClsInfo/<?php echo $stf_grd_cls_id; ?>/<?php echo $staff_id; ?>"
																				type="button" name="btn_delete_gc_info"
																				class="btn btn-danger btn-sm" value="Cancel"
																				data-toggle="tooltip" title="Delete"
																				onClick="return confirmStatusDelete();"><i
																					class="fa fa-trash-o"></i></a>
																		</td>
																	</tr>
															<?php	}
															} ?>
															<tr>
																<td>
																	<button id="btn_add_new_grd_cls_info"
																		name="btn_add_new_grd_cls_info" type="button"
																		class="btn btn-primary btn-sm" value="Add"
																		data-toggle="modal"
																		data-target="#AssignServiceGrade"><i
																			class="fa fa-plus"></i> Assign </button>
																</td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
															</tr>
															</tbody>
														</table>
												</div> <!-- /col-lg-12 col-sm-12 -->
											</div> <!-- /row -->
										</div> <!-- /card body -->
									</div> <!-- /card -->
								</div> <!-- / col-lg-8 -->
							</div> <!-- / row -->
						</div> <!-- / tab-pane fade service-history -->
						<div class="tab-pane fade" id="teaching-classes" role="tabpanel"
							aria-labelledby="teaching-classes-tab">
							<div class="row">
								<div class="col-lg-12 col-sm-12">
									<div class="card mb-3" style="border-top: none">
										<div class="card-body">
											<div class="row">
												<div class="col-sm-12">
													<?php
													$ci = &get_instance();
													$ci->load->model('Staff_model');
													$stf_grd_cls_info = $ci->Staff_model->get_stf_grd_cls($staff_id);
													?>
													<?php
													if (!empty($this->session->flashdata('gradeClassMsg'))) {
														$gradeClassMsg = $this->session->flashdata('gradeClassMsg');  ?>
														<div class="<?php echo $gradeClassMsg['class']; ?>">
															<?php echo $gradeClassMsg['text']; ?></div>
													<?php   	} ?>
													<?php if (empty($stf_grd_cls_info)) {
														echo '<h4>Not Assigned!!!</h4>';
													} else {
													?>
														<table class="table table-hover" id="grade_info_tbl"
															class="table table-striped table-bordered" cellspacing="0" width="">
															<thead>
																<tr>
																	<th scope="col" class="col-sm-4"> පන්තිය </th>
																	<th scope="col" class="col-sm-4"> භූමිකාව </th>
																	<th scope="col" class="col-sm-2"> </th>
																</tr>
															</thead>
															<tbody>
																<?php
																foreach ($stf_grd_cls_info as $gc_info) {
																	$stf_grd_cls_id = $gc_info->stf_grd_cls_id;
																	$grd_id = $gc_info->grade_id;
																	$cls_id = $gc_info->class_id;
																	$grade = $gc_info->grade;
																	$class = $gc_info->class;
																	$class_role_id = $gc_info->sec_role_id;
																	$class_role_name = $gc_info->sec_role_name;
																?>
																	<tr>
																		<td style="vertical-align:middle">
																			<?php echo $grade . ' ' . $class; ?></td>
																		<td style="vertical-align:middle">
																			<?php echo $class_role_name; ?></td>
																		<td id="td_btn">
																			<a type="button" id="btn_edit_gc_info"
																				name="btn_edit_gc_info" type="button"
																				class="btn btn-info btn-sm btn_edit_phy_res"
																				value="edit" title="Update" data-toggle="tooltip"
																				href="<?php echo base_url(); ?>Staff/editStaffGradeClassView/<?php echo $stf_grd_cls_id; ?>/<?php echo $staff_id; ?>"><i
																					class="fa fa-pencil"></i></a>
																		</td>
																		<td id="td_btn">
																			<a href="<?php echo base_url(); ?>Staff/deleteStaffGrdClsInfo/<?php echo $stf_grd_cls_id; ?>/<?php echo $staff_id; ?>"
																				type="button" name="btn_delete_gc_info"
																				class="btn btn-danger btn-sm" value="Cancel"
																				data-toggle="tooltip" title="Delete"
																				onClick="return confirmStatusDelete();"><i
																					class="fa fa-trash-o"></i></a>
																		</td>
																	</tr>
																<?php				} //end of foreach	
																?>

															</tbody>
														</table>
													<?php 		} 	?>
													<button id="btn_add_new_grd_cls_info" name="btn_add_new_grd_cls_info"
														type="button" class="btn btn-primary btn-sm" value="Add"
														data-toggle="modal" data-target="#AssignToNewGradeClass"><i
															class="fa fa-plus"></i> Assign </button>

												</div> <!-- /col-lg-12 col-sm-12 -->
											</div> <!-- /row -->
										</div> <!-- /card body -->
									</div> <!-- /card -->
								</div> <!-- / col-lg-8 -->
							</div> <!-- / row -->
						</div> <!-- / tab-pane fade teaching-classes -->
						<div class="tab-pane fade" id="extra-curricular" role="tabpanel"
							aria-labelledby="extra-curricular-tab">
							<div class="row">
								<div class="col-lg-12 col-sm-12">
									<div class="card mb-3" style="border-top: none">
										<div class="card-body">
											<div class="row">
												<div class="col-sm-12">
													<?php
													$ci = &get_instance();
													$ci->load->model('Staff_model');
													$stf_extra_cur = $ci->Staff_model->get_stf_extra_curri_info($staff_id);
													?>
													<?php
													if (!empty($this->session->flashdata('extCurMsg'))) {
														$extCurMsg = $this->session->flashdata('extCurMsg');  ?>
														<div class="<?php echo $extCurMsg['class']; ?>">
															<?php echo $extCurMsg['text']; ?></div>
													<?php   	} ?>
													<?php if (empty($stf_extra_cur)) {
														echo '<h4>Not Assigned!!!</h4>';
													} else {
													?>
														<table class="table table-hover" id="extracu_info_tbl"
															class="table table-striped table-bordered" cellspacing="0" width="">
															<thead>
																<tr>
																	<th scope="col" class="col-sm-6"> විෂය සමගාමී ක්‍රියාකාරකම
																	</th>
																	<th scope="col" class="col-sm-4"> භූමිකාව </th>
																	<th scope="col" class="col-sm-2"> </th>
																</tr>
															</thead>
															<tbody>
																<?php
																$no = 0;
																foreach ($stf_extra_cur as $stf_extra_cur) {
																?>
																	<tr>
																		<td style="vertical-align:middle">
																			<?php echo $stf_extra_cur->extra_curri_type; ?></td>
																		<td style="vertical-align:middle">
																			<?php echo $stf_extra_cur->ex_cu_role_name; ?></td>
																		<td id="td_btn">
																			<a href="<?php echo base_url(); ?>Staff/deleteExtraCurriInfo/<?php echo $stf_extra_cur->stf_extra_curri_id; ?>/<?php echo $staff_id; ?>"
																				type="button" name="btn_delete_ec_info"
																				class="btn btn-danger btn-sm" value="Cancel"
																				data-toggle="tooltip" title="Delete"
																				onClick="return confirmStatusDelete();"><i
																					class="fa fa-trash-o"></i></a>
																		</td>
																	</tr>
																<?php			}  // end of foreach   
																?>
															</tbody>
														</table>
													<?php	} // end of if(empty($stf_extra_cur)){  
													?>
													<button id="btn_add_new_ec_info" name="btn_add_new_ec_info"
														type="button" class="btn btn-primary btn-sm" value="Add"
														data-toggle="modal" data-target="#AssignToNewExtraCurri"><i
															class="fa fa-plus"></i> Add New</button>

												</div> <!-- /col-lg-12 col-sm-12 -->
											</div> <!-- /row -->
										</div> <!-- /card body -->
									</div> <!-- /card -->
								</div> <!-- / col-lg-8 -->
							</div> <!-- / row -->
						</div> <!-- / tab-pane fade extra-curricular -->
						<div class="tab-pane fade" id="games" role="tabpanel" aria-labelledby="games-tab">
							<div class="row">
								<div class="col-lg-12 col-sm-12">
									<div class="card mb-3" style="border-top: none">
										<div class="card-body">
											<div class="row">
												<div class="col-sm-12">
													<?php
													if (!empty($this->session->flashdata('gameMsg'))) {
														$gameMsg = $this->session->flashdata('gameMsg');  ?>
														<div class="<?php echo $gameMsg['class']; ?>">
															<?php echo $gameMsg['text']; ?></div>
													<?php   } ?>
													<?php if (empty($stf_game_info)) {
														echo '<h4>Not Assigned!!!</h4>';
													} else {
													?>
														<table class="table table-hover" id="games_info_tbl"
															class="table table-striped table-bordered" cellspacing="0" width="">
															<thead>
																<tr>
																	<th scope="col" class="col-sm-2"> Game Name</th>
																	<th scope="col" class="col-sm-4"> Role </th>
																	<th scope="col" class="col-sm-2"> </th>
																	<th scope="col" class="col-sm-4"> </th>
																</tr>
															</thead>
															<tbody>
																<?php
																$no = 0;
																foreach ($stf_game_info as $game_info) {
																	$stgm_id = $game_info->stf_gm_id;
																	$stf_id = $game_info->stf_id;
																	$game_id = $game_info->game_id;
																	$game_name = $game_info->game_name;
																	$game_role_id = $game_info->gm_role_id;
																	$game_role = $game_info->gm_role_name;
																?>
																	<tr>
																		<td style="vertical-align:middle"><?php echo $game_name; ?>
																		</td>
																		<td style="vertical-align:middle"><?php echo $game_role; ?>
																		</td>
																		<td id="td_btn">
																			<a href="<?php echo base_url(); ?>Staff/editGameInfo/<?php //echo $stgm_id; 
																																	?>/<?php echo $stf_id; ?>" type="button" id="btn_edit_game_info"
																				name="btn_edit_game_info" type="button"
																				class="btn btn-info btn-sm btn_edit_phy_res"
																				value="edit" title="Update this details"
																				data-toggle="tooltip" data-hidden="" onclick=""><i
																					class="fa fa-pencil"></i></a>
																		</td>
																		<td id="td_btn">
																			<a href="<?php echo base_url(); ?>Staff/deleteGameInfo/<?php echo $stgm_id;; ?>/<?php echo $stf_id; ?>"
																				type="button" name="btn_delete_game_info"
																				class="btn btn-danger btn-sm" value="Cancel"
																				data-toggle="tooltip" title="Delete this details"
																				onClick="return confirmStatusDelete();"><i
																					class="fa fa-trash-o"></i></a>
																		</td>
																	</tr>
															<?php	}
															} ?>
															<tr>
																<td>
																	<button id="btn_add_new_game_info"
																		name="btn_add_new_game_info" type="button"
																		class="btn btn-primary btn-sm" value="Add"
																		data-toggle="modal"
																		data-target="#AssignToNewGame"><i
																			class="fa fa-plus"></i> Add New</button>
																</td>
																<td></td>
															</tr>
															</tbody>
														</table>
												</div> <!-- /col-lg-12 col-sm-12 -->
											</div> <!-- /row -->
										</div> <!-- /card body -->
									</div> <!-- /card -->
								</div> <!-- / col-lg-8 -->
							</div> <!-- / row -->
						</div> <!-- / tab-pane fade games -->
					</div> <!-- / col-lg-12 -->
				</div> <!-- / row -->
			<?php } ?>
			<!-- if not empty $stf_result -->
			<!-- /following bootstrap model used to assign tasks to staff-->
			<div class="modal fade" id="AssignToTask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
				aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> Assign to
								Tasks </h5>
							<button class="close" type="button" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-sm-12 my-auto">
									<?php
									$attributes = array("class" => "form-horizontal", "id" => "insert_task_form", "name" => "insert_task_form", "accept-charset" => "UTF-8");
									echo form_open("Staff/AssignToTask", $attributes); ?>
									<fieldset>
										<div class="form-group">
											<div class="row">
												<div class="col-lg-3 col-sm-3">
													<input type="hidden" name="stf_id_hidden"
														value="<?php echo $staff_id; ?>" />
													<input type="hidden" name="census_id_hidden"
														value="<?php echo $census_id; ?>" />
													<label for="Assign to a task type" class="control-label"> කාර්ය
														වර්ගය </label>
												</div>
												<div class="col-lg-9 col-sm-9">
													<select class="form-control" id="task_type_select"
														name="task_type_select">
														<option value="" selected>---මෙහි ක්ලික් කරන්න---</option>
														<?php foreach ($this->all_task_types as $row) { ?>
															<!-- from Building controller constructor method -->
															<option value="<?php echo $row->involved_task_type_id; ?>">
																<?php echo $row->involved_task_type; ?></option>
														<?php } ?>
													</select>
												</div>
											</div> <!-- /row -->
										</div> <!-- /form group -->
										<div class="form-group">
											<div class="row">
												<div class="col-lg-3 col-sm-3">
													<label for="Assign to a task" class="control-label"> කාර්යය </label>
												</div>
												<div class="col-lg-9 col-sm-9">
													<select class="form-control" id="task_select" name="task_select">
														<option value="" selected>---මෙහි ක්ලික් කරන්න---</option>
														<?php foreach ($this->all_tasks_involved as $row) { ?>
															<!-- from Building controller constructor method -->
															<option value="<?php echo $row->involved_task_id; ?>">
																<?php echo $row->inv_task; ?></option>
														<?php } ?>
													</select>
												</div>
											</div> <!-- /row -->
										</div> <!-- /form group -->
										<div class="form-group">
											<div class="row">
												<div class="col-lg-3 col-sm-3">
													<label for="Assign to a section" class="control-label"> උගන්වන
														අංශය</label>
												</div>
												<div class="col-lg-9 col-sm-9">
													<select class="form-control" id="task_section_select"
														name="task_section_select">
														<option value="" selected>---ක්ලික් කරන්න---</option>
														<?php foreach ($this->all_sections as $row) { ?>
															<!-- from Staff controller constructor method -->
															<option value="<?php echo $row->section_id; ?>">
																<?php echo $row->section_name; ?></option>
														<?php } ?>
													</select>
												</div>
											</div> <!-- /row -->
										</div> <!-- /form group -->
										<div class="form-group">
											<div class="row">
												<div class="col-lg-3 col-sm-3">
													<label for="Assign to a subject" class="control-label">උගන්වන
														විෂය</label>
												</div>
												<div class="col-lg-9 col-sm-9">
													<select class="form-control" id="subject_select"
														name="subject_select">
														<option value="" selected>---පළමුව අංශය තෝරන්න---</option>
														<?php //foreach ($this->all_subjects as $row){ 
														?>
														<!-- from Staff controller constructor method -->
														<!--                        <option value="<?php //echo $row->subject_id; 
																									?>"><?php //echo $row->subject; 
																										?></option> -->
														<?php //} 
														?>
													</select>
												</div>
											</div> <!-- /row -->
										</div> <!-- /form group -->
										<!-- <fieldset> -->
								</div> <!-- /col-sm-12 -->
							</div> <!-- /row -->
						</div> <!-- /modal-body -->
						<div class="modal-footer">
							<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
							<button class="btn btn-primary" type="submit" name="btn_add_new_task"
								value="Add_New">Save</button>
						</div> <!-- /modal-footer -->
						</fieldset>
						<?php echo form_close(); ?>
					</div> <!-- /#bootstrap model content -->
				</div> <!-- /#bootstrap model dialog -->
			</div> <!-- / .modal fade -->
			<!-- /following bootstrap model used to assign tasks to staff-->
			<div class="modal fade" id="AssignServiceGrade" tabindex="-1" role="dialog"
				aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> සේවා ශ්‍රේණිය
							</h5>
							<button class="close" type="button" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-sm-12 my-auto">
									<?php
									$attributes = array("class" => "form-horizontal", "id" => "insert_service_grade_form", "name" => "insert_service_grade_form", "accept-charset" => "UTF-8");
									echo form_open("Staff/AssignToServiceGrade", $attributes); ?>
									<fieldset>
										<div class="form-group">
											<div class="row">
												<div class="col-lg-5 col-sm-5">
													<input type="hidden" name="stf_id_hidden"
														value="<?php echo $staff_id; ?>" />
													<input type="hidden" name="census_id_hidden"
														value="<?php echo $census_id; ?>" />
													<label for="Assign to a service grade" class="control-label"> වත්මන්
														සේවයේ ශ්‍රේණිය </label>
												</div>
												<div class="col-lg-7 col-sm-7">
													<select class="form-control" id="serv_grd_select"
														name="serv_grd_select">
														<option value="" selected>---මෙහි ක්ලික් කරන්න---</option>
														<?php foreach ($this->all_service_grades as $row) { ?>
															<!-- from Building controller constructor method -->
															<option value="<?php echo $row->serv_grd_id; ?>">
																<?php echo $row->serv_grd_type; ?></option>
														<?php } ?>
													</select>
												</div>
											</div> <!-- /row -->
										</div> <!-- /form group -->
										<div class="form-group">
											<div class="row">
												<div class="col-lg-5 col-sm-5">
													<label for="dob" class="control-label"> ක්‍රියාත්මක වන දිනය </label>
												</div>
												<div class="col-lg-7 col-sm-7">
													<input class="form-control datepicker"
														id="serv_grd_effective_dt_txt" name="serv_grd_effective_dt_txt"
														placeholder="---ක්ලික් කරන්න---" type="text" value=""
														size="60" />
												</div>
											</div> <!-- /row -->
										</div> <!-- /form group -->
										<div class="form-group">
											<div class="row">
												<div class="col-lg-5 col-sm-5">
													<label for="Assign to a section" class="control-label"> වර්ථමාන
														ශ්‍රේණියද ?</label>
												</div>
												<div class="col-lg-7 col-sm-7">
													<select class="form-control" id="is_current_select"
														name="is_current_select">
														<option value="" selected>---ක්ලික් කරන්න---</option>
														<option value="1"> ඔව් </option>
														<option value="0"> නැත </option>
													</select>
												</div>
											</div> <!-- /row -->
										</div> <!-- /form group -->
										<!-- <fieldset> -->
								</div> <!-- /col-sm-12 -->
							</div> <!-- /row -->
						</div> <!-- /modal-body -->
						<div class="modal-footer">
							<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
							<button class="btn btn-primary" type="submit" name="btn_add_new_serv_grd"
								value="Add_New">Save</button>
						</div> <!-- /modal-footer -->
						</fieldset>
						<?php echo form_close(); ?>
					</div> <!-- /#bootstrap model content -->
				</div> <!-- /#bootstrap model dialog -->
			</div> <!-- / .modal fade -->
			<!-- /following bootstrap model used to assign games to staff-->
			<div class="modal fade" id="AssignToNewGame" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
				aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> Assign to a
								new game </h5>
							<button class="close" type="button" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-sm-12 my-auto">
									<?php
									$attributes = array("class" => "form-horizontal", "id" => "insert_stf_game_info_form", "name" => "insert_stf_game_info_form", "accept-charset" => "UTF-8");
									echo form_open("Staff/AssignToNewGame", $attributes); ?>
									<fieldset>
										<div class="form-group">
											<div class="row">
												<div class="col-lg-3 col-sm-3">
													<label for="Assign to a game" class="control-label"> Game </label>
												</div>
												<div class="col-lg-9 col-sm-9">
													<select class="form-control" id="game_select" name="game_select">
														<option value="" selected>---Select---</option>
														<?php foreach ($this->all_games as $row) { ?>
															<!-- from Building controller constructor method -->
															<option value="<?php echo $row->game_id; ?>">
																<?php echo $row->game_name; ?></option>
														<?php } ?>
													</select>
												</div>
											</div> <!-- /row -->
										</div> <!-- /form group -->
										<div class="form-group" id="game_role_select_form_group">
											<div class="row">
												<div class="col-lg-3 col-sm-3">
													<label for="Assign to a game" class="control-label"> Game Role
													</label>
												</div>
												<div class="col-lg-9 col-sm-9">
													<select class="form-control" id="game_role_select"
														name="game_role_select">
														<option value="" selected>---Select---</option>
														<?php foreach ($this->all_game_roles as $row) { ?>
															<!-- from Building controller constructor method -->
															<option value="<?php echo $row->gm_role_id; ?>">
																<?php echo $row->gm_role_name; ?></option>
														<?php } ?>
													</select>
													<input type="hidden" name="stf_no_hidden"
														value="<?php echo $staff_id; ?>">
													<!-- here $staff_id from top of the page -->
												</div>
											</div> <!-- /row -->
										</div> <!-- /form group -->
										<!-- <fieldset> -->
								</div> <!-- /col-sm-12 -->
							</div> <!-- /row -->
						</div> <!-- /modal-body -->
						<div class="modal-footer">
							<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
							<button class="btn btn-primary" type="submit" name="btn_add_new_game_info"
								value="Add_New">Save</button>
						</div> <!-- /modal-footer -->
						</fieldset>
						<?php echo form_close(); ?>
					</div> <!-- /#bootstrap model content -->
				</div> <!-- /#bootstrap model dialog -->
			</div> <!-- / .modal fade -->
			<!-- /following bootstrap model used to assign extra curry. to staff-->
			<div class="modal fade" id="AssignToNewExtraCurri" tabindex="-1" role="dialog"
				aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> Assign to an
								extra curricular activity </h5>
							<button class="close" type="button" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-sm-12 my-auto">
									<?php
									$attributes = array("class" => "form-horizontal", "id" => "insert_ex_curri_form", "name" => "insert_ex_curri_form", "accept-charset" => "UTF-8");
									echo form_open("Staff/AssignToNewExtraCurri", $attributes); ?>
									<fieldset>
										<div class="form-group">
											<div class="row">
												<div class="col-lg-3 col-sm-3">
													<label for="Assign to a extra cu." class="control-label">
														ක්‍රියාකාරකම </label>
												</div>
												<div class="col-lg-9 col-sm-9">
													<select class="form-control" id="extra_cu_select"
														name="extra_cu_select">
														<option value="" selected>---Select---</option>
														<?php foreach ($this->all_extra_curri as $row) { ?>
															<!-- from Building controller constructor method -->
															<option value="<?php echo $row->extra_curri_id; ?>">
																<?php echo $row->extra_curri_type; ?></option>
														<?php } ?>
													</select>
												</div>
											</div> <!-- /row -->
										</div> <!-- /form group -->
										<div class="form-group" id="game_role_select_form_group">
											<div class="row">
												<div class="col-lg-3 col-sm-3">
													<label for="Assign to a game" class="control-label"> භූමිකාව
													</label>
												</div>
												<div class="col-lg-9 col-sm-9">
													<select class="form-control" id="ex_curri_role_select"
														name="ex_curri_role_select">
														<option value="" selected>---Select---</option>
														<?php foreach ($this->all_extra_curri_roles as $row) { ?>
															<!-- from Building controller constructor method -->
															<option value="<?php echo $row->ex_cu_role_id; ?>">
																<?php echo $row->ex_cu_role_name; ?></option>
														<?php } ?>
													</select>
													<input type="hidden" name="stf_no_hidden"
														value="<?php echo $staff_id; ?>">
													<!-- here $staff_id from top of the page -->
												</div>
											</div> <!-- /row -->
										</div> <!-- /form group -->
										<!-- <fieldset> -->
								</div> <!-- /col-sm-12 -->
							</div> <!-- /row -->
						</div> <!-- /modal-body -->
						<div class="modal-footer">
							<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
							<button class="btn btn-primary" type="submit" name="btn_add_new_extra"
								value="Add_New">Save</button>
						</div> <!-- /modal-footer -->
						</fieldset>
						<?php echo form_close(); ?>
					</div> <!-- /#bootstrap model content -->
				</div> <!-- /#bootstrap model dialog -->
			</div> <!-- / .modal fade -->
			<!-- /following bootstrap model used to assign grade and class to staff-->
			<div class="modal fade" id="AssignToNewGradeClass" tabindex="-1" role="dialog"
				aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> Assign to a
								Class </h5>
							<button class="close" type="button" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-sm-12 my-auto">
									<?php
									$attributes = array("class" => "form-horizontal", "id" => "insert_classes_form", "name" => "insert_classes_form", "accept-charset" => "UTF-8");
									echo form_open("Staff/AssignToNewGradeClass", $attributes); ?>
									<fieldset>
										<div class="form-group">
											<div class="row">
												<div class="col-lg-3 col-sm-5">
													<label for="new category" class="control-label"> Year </label>
												</div>
												<div class="col-lg-9 col-sm-7">
													<input type="hidden" name="census_id_hidden" id="census_id_hidden"
														value="<?php echo $census_id; ?>" />
													<select class="form-control mb-2 mr-sm-2" id="year_select"
														name="year_select" title="Please select">
														<option value="" selected>---Select---</option>
														<?php
														$year = date('Y');
														$selected_year = set_value('year_select');
														for ($year; $year > 2019; $year--) {
															if ($year == $selected_year) {
																echo '<option value="' . $year . '" >' . $year . '</option>';
															} else {
																echo '<option value="' . $year . '" >' . $year . '</option>';
															}
														}
														?>
													</select>
												</div>
											</div> <!-- /row -->
										</div> <!-- /form group -->
										<div class="form-group">
											<div class="row">
												<div class="col-lg-3 col-sm-3">
													<label for="Assign to a Grade" class="control-label"> Grade </label>
												</div>
												<div class="col-lg-9 col-sm-9">
													<select class="form-control" id="grade_select" name="grade_select">
														<option value="" selected>------</option>
													</select>
												</div>
											</div> <!-- /row -->
										</div> <!-- /form group -->
										<div class="form-group">
											<div class="row">
												<div class="col-lg-3 col-sm-3">
													<label for="Assign to a Class" class="control-label"> Class </label>
												</div>
												<div class="col-lg-9 col-sm-9">
													<select class="form-control" id="class_select" name="class_select">
														<option value="" selected>------</option>
													</select>
												</div>
											</div> <!-- /row -->
										</div> <!-- /form group -->
										<div class="form-group">
											<div class="row">
												<div class="col-lg-3 col-sm-3">
													<label for="Class Role" class="control-label"> Class Role </label>
												</div>
												<div class="col-lg-9 col-sm-9">
													<select class="form-control" id="class_role_select"
														name="class_role_select">
														<option value="3"> Class Teacher </option>
														<option value="4" selected> Teacher </option>
														<option value="5"> Not Assigned </option>
													</select>
													<input type="hidden" name="stf_no_hidden"
														value="<?php echo $staff_id; ?>">
													<!-- here $staff_id from top of the page -->
													<input type="hidden" name="section_no_hidden"
														value="<?php echo $section_id; ?>">
													<!-- here $staff_id from top of the page -->
												</div>
											</div> <!-- /row -->
										</div> <!-- /form group -->
										<!-- <fieldset> -->
								</div> <!-- /col-sm-12 -->
							</div> <!-- /row -->
						</div> <!-- /modal-body -->
						<div class="modal-footer">
							<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
							<button class="btn btn-primary" type="submit" name="btn_add_new_grdcls"
								value="Add_New">Save</button>
						</div> <!-- /modal-footer -->
						</fieldset>
						<?php echo form_close(); ?>
					</div> <!-- /#bootstrap model content -->
				</div> <!-- /#bootstrap model dialog -->
			</div> <!-- / .modal fade -->
			<!-- /following bootstrap model used to assign grade and class to staff-->
			<div class="modal fade" id="editGradeClass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
				aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> Change grade
								and class </h5>
							<button class="close" type="button" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-sm-12 my-auto">
									<?php
									$attributes = array("class" => "form-horizontal", "id" => "insert_ex_curri_form", "name" => "insert_ex_curri_form", "accept-charset" => "UTF-8");
									echo form_open("Staff/editGradeClass", $attributes); ?>
									<fieldset>
										<div class="form-group">
											<div class="row">
												<div class="col-lg-3 col-sm-3">
													<label for="Assign to a Grade" class="control-label"> Grade </label>
												</div>
												<div class="col-lg-9 col-sm-9">
													<select class="form-control" id="grade_select" name="grade_select">
														<option value="<?php echo $grade_id; ?>" selected>
															<?php echo $grade_name; ?></option>
														<?php foreach ($this->all_grades as $row) { ?>
															<!-- from Building controller constructor method -->
															<option value="<?php echo $row->grade_id; ?>">
																<?php echo $row->grade; ?></option>
														<?php } ?>
													</select>
												</div>
											</div> <!-- /row -->
										</div> <!-- /form group -->
										<div class="form-group">
											<div class="row">
												<div class="col-lg-3 col-sm-3">
													<label for="Assign to a Class" class="control-label"> Class </label>
												</div>
												<div class="col-lg-9 col-sm-9">
													<select class="form-control" id="class_select" name="class_select">
														<option value="<?php echo $class_id; ?>" selected>
															<?php echo $class_name; ?></option>
														<?php foreach ($this->all_classes as $row) { ?>
															<!-- from Building controller constructor method -->
															<option value="<?php echo $row->class_id; ?>">
																<?php echo $row->class; ?></option>
														<?php } ?>
													</select>
												</div>
											</div> <!-- /row -->
										</div> <!-- /form group -->
										<div class="form-group">
											<div class="row">
												<div class="col-lg-3 col-sm-3">
													<label for="Class Role" class="control-label"> Class Role </label>
												</div>
												<div class="col-lg-9 col-sm-9">
													<select class="form-control" id="class_role_select"
														name="class_role_select">
														<option value="<?php echo $section_role_id; ?>" selected>
															<?php echo $section_role_name; ?></option>
														<option value="3"> Class Teacher </option>
														<option value="4"> Teacher </option>
														<option value="5"> Not Assigned </option>
													</select>
													<input type="hidden" name="stf_no_hidden"
														value="<?php echo $staff_id; ?>">
													<!-- here $staff_id from top of the page -->
													<input type="hidden" name="section_no_hidden"
														value="<?php echo $section_id; ?>">
													<!-- this is not used yet -->
												</div>
											</div> <!-- /row -->
										</div> <!-- /form group -->
										<!-- <fieldset> -->
								</div> <!-- /col-sm-12 -->
							</div> <!-- /row -->
						</div> <!-- /modal-body -->
						<div class="modal-footer">
							<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
							<button class="btn btn-primary" type="submit" name="btn_add_new_grdcls"
								value="Add_New">Save</button>
						</div> <!-- /modal-footer -->
						</fieldset>
						<?php echo form_close(); ?>
					</div> <!-- /#bootstrap model content -->
				</div> <!-- /#bootstrap model dialog -->
			</div> <!-- / .modal fade -->
			<!-- /following bootstrap model used to edit extra cur. acti. of a staff-->
			<div class="modal fade" id="editExCu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
				aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> Change extra
								curricular activity </h5>
							<button class="close" type="button" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-sm-12 my-auto">
									<?php
									$attributes = array("class" => "form-horizontal", "id" => "edit_ex_curri_form", "name" => "edit_ex_curri_form", "accept-charset" => "UTF-8");
									echo form_open("Staff/editExCu", $attributes); ?>
									<fieldset>
										<div class="form-group">
											<div class="row">
												<div class="col-lg-3 col-sm-3">
													<label for="Assign to a Grade" class="control-label"> ක්‍රියාකාරකම
													</label>
												</div>
												<div class="col-lg-9 col-sm-9">
													<select class="form-control" id="ex_cu_select" name="ex_cu_select">
														<option value="<?php echo $ec_id; ?>" selected>
															<?php echo $ec_name; ?></option>
														<?php foreach ($this->all_extra_curri as $row) { ?>
															<!-- from Staff controller constructor method -->
															<option value="<?php echo $row->extra_curri_id; ?>">
																<?php echo $row->extra_curri_type; ?></option>
														<?php } ?>
													</select>
												</div>
											</div> <!-- /row -->
										</div> <!-- /form group -->
										<div class="form-group">
											<div class="row">
												<div class="col-lg-3 col-sm-3">
													<label for="Assign to a Class" class="control-label"> භූමිකාව
													</label>
												</div>
												<div class="col-lg-9 col-sm-9">
													<select class="form-control" id="ex_cu_role_select"
														name="ex_cu_role_select">
														<option value="<?php echo $ec_role_id; ?>" selected>
															<?php echo $ec_role; ?></option>
														<?php foreach ($this->all_extra_curri_roles as $row) { ?>
															<!-- from Staff controller constructor method -->
															<option value="<?php echo $row->ex_cu_role_id; ?>">
																<?php echo $row->ex_cu_role_name; ?></option>
														<?php } ?>
													</select>
													<input type="hidden" name="stfec_no_hidden"
														value="<?php echo $stfec_id; ?>">
													<!-- here $staff_id from top of the page -->
												</div>
											</div> <!-- /row -->
										</div> <!-- /form group -->
										<!-- <fieldset> -->
								</div> <!-- /col-sm-12 -->
							</div> <!-- /row -->
						</div> <!-- /modal-body -->
						<div class="modal-footer">
							<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
							<button class="btn btn-primary" type="submit" name="btn_add_new_grdcls"
								value="Add_New">Save</button>
						</div> <!-- /modal-footer -->
						</fieldset>
						<?php echo form_close(); ?>
					</div> <!-- /#bootstrap model content -->
				</div> <!-- /#bootstrap model dialog -->
			</div> <!-- / .modal fade -->
			<!-- /following bootstrap model used to edit current service status of a staff-->
			<div class="modal fade" id="editCurServStatus" tabindex="-1" role="dialog"
				aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> වර්ථමාන සේවා
								තත්ත්වය </h5>
							<button class="close" type="button" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-sm-12 my-auto">
									<?php
									$attributes = array("class" => "form-horizontal", "id" => "edit_cur_serv_status_form", "name" => "edit_cur_serv_status_form", "accept-charset" => "UTF-8");
									echo form_open("Staff/addCurrentServiceStatus", $attributes); ?>
									<fieldset>
										<div class="form-group">
											<div class="row">
												<div class="col-lg-3 col-sm-3">
													<input type="hidden" name="stf_id_hidden"
														value="<?php echo $staff_id; ?>" />
													<input type="hidden" name="census_id_hidden"
														value="<?php echo $census_id; ?>" />
													<label for="Task Involved" class="control-label"> වර්තමාන සේවා තත්වය
													</label>
												</div>
												<div class="col-lg-9 col-sm-9">
													<select class="form-control" id="current_service_status_select"
														name="current_service_status_select">
														<option value="" selected>---ක්ලික් කරන්න---</option>
														<?php foreach ($this->all_service_status as $row) { ?>
															<!-- from Staff controller constructor method -->
															<option value="<?php echo $row->service_status_id; ?>">
																<?php echo $row->service_status; ?></option>
														<?php } ?>
													</select>
												</div>
											</div> <!-- /row -->
										</div> <!-- /form group -->
										<div class="form-group" id="province_select_form_group_div">
											<div class="row">
												<div class="col-lg-3 col-sm-3">
													<label for="Task Involved" class="control-label"> අනුයුක්ත පළාත
													</label>
												</div>
												<div class="col-lg-9 col-sm-9">
													<select class="form-control" id="province_select"
														name="province_select">
														<option value="" selected>---ක්ලික් කරන්න---</option>
														<?php foreach ($this->all_province as $row) { ?>
															<!-- from Staff controller constructor method -->
															<option value="<?php echo $row->pro_id; ?>">
																<?php echo $row->pro_name; ?></option>
														<?php } ?>
													</select>
												</div>
											</div> <!-- /row -->
										</div> <!-- /form group -->
										<div class="form-group" id="zone_select_from_group_div">
											<div class="row">
												<div class="col-lg-3 col-sm-3">
													<label for="Task Involved" class="control-label"> අනුයුක්ත කලාපය
													</label>
												</div>
												<div class="col-lg-9 col-sm-9">
													<select class="form-control" id="zone_select" name="zone_select">
														<option value="" selected>---ක්ලික් කරන්න---</option>
														<?php foreach ($this->all_zones as $row) { ?>
															<!-- from Staff controller constructor method -->
															<option value="<?php echo $row->edu_zone; ?>">
																<?php echo $row->edu_zone; ?></option>
														<?php } ?>
													</select>
												</div>
											</div> <!-- /row -->
										</div> <!-- /form group -->
										<div class="form-group" id="attached_sch_select_form_group_div">
											<div class="row">
												<div class="col-lg-3 col-sm-3">
													<label for="Task Involved" class="control-label"> අනුයුක්ත පාසල
													</label>
												</div>
												<div class="col-lg-9 col-sm-9">
													<select class="form-control" id="attached_sch_select"
														name="attached_sch_select">
														<option value="" selected>---ක්ලික් කරන්න---</option>
														<?php foreach ($this->all_schools as $row) { ?>
															<!-- from Staff controller constructor method -->
															<option value="<?php echo $row->sch_name; ?>">
																<?php echo $row->sch_name; ?></option>
														<?php } ?>
													</select>
												</div>
											</div> <!-- /row -->
										</div> <!-- /form group -->
										<div class="form-group" id="attached_institute_txt_form_group_div">
											<div class="row">
												<div class="col-lg-3 col-sm-3">
													<label for="dob" class="control-label"> අනුයුක්ත ආයතනය </label>
												</div>
												<div class="col-lg-9 col-sm-9">
													<input class="form-control" id="attached_institute_txt"
														name="attached_institute_txt" placeholder="---ටයිප් කරන්න---"
														type="text" value="" />
												</div>
											</div> <!-- /row -->
										</div> <!-- /form group -->
										<div class="form-group" id="started_dt_txt_form_group_div">
											<div class="row">
												<div class="col-lg-3 col-sm-3">
													<label for="dob" class="control-label"> ක්‍රියාත්මක වන දිනය </label>
												</div>
												<div class="col-lg-9 col-sm-9">
													<input class="form-control datepicker" id="started_dt_txt"
														name="started_dt_txt" placeholder="---ක්ලික් කරන්න---"
														type="text" value="" size="60" />
												</div>
											</div> <!-- /row -->
										</div> <!-- /form group -->
										<div class="form-group" id="period_txt_form_group_div">
											<div class="row">
												<div class="col-lg-3 col-sm-3">
													<label for="dob" class="control-label"> කාලය </label>
												</div>
												<div class="col-lg-9 col-sm-9">
													<input class="form-control" id="period_txt" name="period_txt"
														placeholder="---ටයිප් කරන්න---" type="text" value="" />
												</div>
											</div> <!-- /row -->
										</div> <!-- /form group -->
										<!-- <fieldset> -->
								</div> <!-- /col-sm-12 -->
							</div> <!-- /row -->
						</div> <!-- /modal-body -->
						<div class="modal-footer">
							<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
							<button class="btn btn-primary" type="submit" name="btn_add_new_grdcls"
								value="Add_New">Save</button>
						</div> <!-- /modal-footer -->
						</fieldset>
						<?php echo form_close(); ?>
					</div> <!-- /#bootstrap model content -->
				</div> <!-- /#bootstrap model dialog -->
			</div> <!-- / .modal fade -->
			</div> <!-- /container-fluid -->
			<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
			<script type="text/javascript">
				// වර්ෂය තෝරනවිට ශ්‍රේණිය ලෝඩ් කිරීමට යොදා ගැනේ. 
				$(document).on('change', '#year_select', function() {
					var year = $(this).val();
					<?php if ($userrole_id == 2) { // school 
					?>
						var census_id = $('#census_id_hidden').val();
						//alert(census_id);
					<?php } else { // if not chool 
					?>
						var census_id = $('#select_school_in_modal_form').val();
					<?php } ?>
					if (!year) {
						swal('Please select the year')
					} else if (!census_id) {
						swal('Please select the school')
					} else {
						$.ajax({
							url: "<?php echo base_url(); ?>SchoolGrades/viewGradesSchoolWise",
							method: "POST",
							data: {
								census_id: census_id,
								year: year
							},
							dataType: "json",
							success: function(grades) {
								if (!grades) {
									swal('Grades not found!!!!')
									$('select#grade_select').html('');
									$('select[name="grade_select"]').append(
										'<option value="">---No Grades---</option>').attr("selected",
										"true");
								} else {
									$('select#grade_select').html('');
									$('select[name="grade_select"]').append(
										'<option value="">---Select Grade---</option>').attr("selected",
										"true");
									$.each(grades, function(key, value) {
										$('select[name="grade_select"]').append('<option value="' +
											value.grade_id + '">' + value.grade + '</option>');
									});
								}
							},
							error: function(xhr, status, error) {
								alert(xhr.responseText);
							}
						})
					}
				});
				// ශ්‍රේණිය තෝරනවිට පන්තිය ලෝඩ් කිරීමට යොදා ගැනේ. 
				$(document).on('change', '#grade_select', function() {
					var grade_id = $(this).val();
					var year = $('#year_select').val();
					<?php if ($userrole_id == 1) { ?>
						var census_id = $('#school_select').val();
					<?php }
					if ($userrole_id == 2) { ?>
						var census_id = $('#census_id_hidden').val();
					<?php } ?>
					if (!census_id) {
						swal('Select the School');
					} else if (!year) {
						swal('Select the Year');
					} else {
						$.ajax({
							url: "<?php echo base_url(); ?>SchoolClasses/viewClassesGradeWise",
							method: "POST",
							data: {
								grade_id: grade_id,
								census_id: census_id,
								year: year
							},
							dataType: "json",
							success: function(classes) {
								if (!classes) {
									$('select#class_select').html('');
									swal('Classes not found!!!!');
									$('select#grade_select').disabled();
								} else {
									$('select#class_select').html('');
									$.each(classes, function(key, value) {
										$('select[name="class_select"]').append('<option value="' +
											value.class_id + '">' + value.class + '</option>');
									});
								}
							},
							error: function(xhr, status, error) {
								alert(xhr.responseText);
							}
						})
					}
				});
				// date picker
				$(document).ready(function() {
					// date picker
					$('.datepicker').datepicker({
						dateFormat: 'yy-mm-dd',
						changeYear: true,
						yearRange: '1955:',
					})
				})

				function readURL(input) {
					if (input.files && input.files[0]) {
						var reader = new FileReader();
						reader.onload = function(e) {
							$('#imgPrw').attr('src', e.target.result);
						}
						reader.readAsDataURL(input.files[0]);
					}
				}
				$(document).ready(function() {
					$("#stf_image").change(function() {
						readURL(this);
					});
				})
				// used when inserting involved task in staff update view.
				// when section is selected, loaded the relevant subjects automatically by ajax
				$(document).on('change', '#task_section_select', function() {
					var sec_id = $(this).val();
					//alert(stream_id);
					$.ajax({
						url: "<?php echo base_url(); ?>Staff/viewSubjectsSectionWise",
						method: "POST",
						data: {
							sec_id: sec_id
						},
						dataType: "json",
						success: function(subjects) {
							if (!subjects) {
								$('select#subject_select').html('');
								//swal('Classes not found!!!!');
							} else {
								$('select#subject_select').html('');
								$.each(subjects, function(key, value) {
									$('select[name="subject_select"]').append('<option value="' +
										value.subject_id + '">' + value.subject + '</option>');
								});
							}
						},
						error: function(xhr, status, error) {
							alert(xhr.responseText);
						}
					})
				});
				// deleting involved task in staff update view
				$(".btn_delete_task").click(function() {
					var row_id = $(this).parents("tr").attr("id");
					var task_id = $(this).attr("data-id");
					swal({
							title: "Are you sure?",
							text: "You will not be able to recover this record!",
							type: "warning",
							showCancelButton: true,
							confirmButtonClass: "btn-danger",
							confirmButtonText: "Yes, delete it!",
							cancelButtonText: "No, cancel!",
							closeOnConfirm: false,
							closeOnCancel: true
						},
						function(isConfirm) {
							if (isConfirm) {
								$.ajax({
									url: "<?php echo base_url(); ?>Staff/deleteInvolvedTask",
									method: "POST",
									data: {
										task_id: task_id
									},
									error: function() {
										alert('Something is wrong');
									},
									success: function(data) {
										if (data.trim() == 'true') {
											$("#" + row_id).remove();
											swal("Deleted!", "Task details has been deleted.",
												"success");
										} else {
											swal("Error!", "Task details not deleted.", "error");
										}
									}
								});
							}
						});
				});
				// deleting service status in staff update view
				$(".btn_delete_service_status").click(function() {
					var row_id = $(this).parents("tr").attr("id");
					var status_id = $(this).attr("data-id");
					swal({
							title: "Are you sure?",
							text: "You will not be able to recover this record!",
							type: "warning",
							showCancelButton: true,
							confirmButtonClass: "btn-danger",
							confirmButtonText: "Yes, delete it!",
							cancelButtonText: "No, cancel!",
							closeOnConfirm: false,
							closeOnCancel: true
						},
						function(isConfirm) {
							if (isConfirm) {
								$.ajax({
									url: "<?php echo base_url(); ?>Staff/deleteCurrentServiceStatus",
									method: "POST",
									data: {
										status_id: status_id
									},
									error: function() {
										alert('Something is wrong');
									},
									success: function(data) {
										if (data.trim() == 'true') {
											$("#" + row_id).remove();
											swal("Deleted!", "Service status details has been deleted.",
												"success");
										} else {
											swal("Error!", "Service status details not deleted.",
												"error");
										}
									}
								});
							}
						});
				});
				// deleting service grade in staff update view
				$(".btn_delete_serv_grd").click(function() {
					var row_id = $(this).parents("tr").attr("id");
					var serv_grd_id = $(this).attr("data-id");
					swal({
							title: "Are you sure?",
							text: "You will not be able to recover this record!",
							type: "warning",
							showCancelButton: true,
							confirmButtonClass: "btn-danger",
							confirmButtonText: "Yes, delete it!",
							cancelButtonText: "No, cancel!",
							closeOnConfirm: false,
							closeOnCancel: true
						},
						function(isConfirm) {
							if (isConfirm) {
								$.ajax({
									url: "<?php echo base_url(); ?>Staff/deleteServiceGrade",
									method: "POST",
									data: {
										serv_grd_id: serv_grd_id
									},
									error: function() {
										alert('Something is wrong');
									},
									success: function(data) {
										if (data.trim() == 'true') {
											$("#" + row_id).remove();
											swal("Deleted!", "Service grade details has been deleted.",
												"success");
										} else {
											swal("Error!", "Service grade details not deleted.",
												"error");
										}
									}
								});
							}
						});
				});
				$(document).ready(function() {
					$('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
						localStorage.setItem('activeTab', $(e.target).attr('href'));
					});
					var activeTab = localStorage.getItem('activeTab');
					if (activeTab) {
						$('#myTab a[href="' + activeTab + '"]').tab('show');
					}
				});
				$(document).ready(function() {
					// auto complete when type school name
					$('#province_select_form_group_div').hide();
					$('#zone_select_from_group_div').hide();
					$('#attached_sch_select_form_group_div').hide();
					$('#attached_institute_txt_form_group_div').hide();
					$('#started_dt_txt_form_group_div').hide();
					$('#period_txt_form_group_div').hide();

					$("#school_txt").autocomplete({
						source: function(request, response) {
							// Fetch data
							$.ajax({
								url: "<?= base_url() ?>School/viewSchoolList",
								type: 'post',
								dataType: "json",
								data: {
									search: request.term
								},
								success: function(data) {
									response(data);
								}
							});
						},
						//appendTo: "#school_txt",
						select: function(event, ui) {
							// Set selection
							$('#school_txt').val(ui.item.label); // display the selected text
							$('#census_id_hidden').val(ui.item.value); // save selected id to input
							//alert(ui.item.value);
							return false;
						}
					});

					// වර්ථමාන සේවා තත්ත්වය යාවත්කාලීන කිරීමේදී 
					$("#current_service_status_select").change(function() {
						if ($(this).val() != 1) {
							$('#started_dt_txt_form_group_div').fadeIn(); // කියාත්මක වන දිනය
							$('#period_txt_form_group_div').fadeIn(); // කාලය
						} else {
							$('#started_dt_txt_form_group_div').fadeOut();
							$('#period_txt_form_group_div').fadeOut();
						}
						if ($(this).val() == 5) {
							$('#province_select_form_group_div').fadeIn(); // පලාත තේරීම
						} else {
							$('#province_select_form_group_div').fadeOut();
						}
						if ($(this).val() == 4) {
							$('#zone_select_from_group_div').fadeIn(); // කලාපය තේරීම
						} else {
							$('#zone_select_from_group_div').fadeOut();
						}
						if ($(this).val() == 6) {
							$('#attached_institute_txt_form_group_div').fadeIn(); // වෙනත් ආයතනයකට අනුයුක්ත
						} else {
							$('#attached_institute_txt_form_group_div').fadeOut();
						}
					});
				});
				// empty field validation add building sizes
				$("#edit_cur_serv_status_form").submit(function() {
					var status = $('#current_service_status_select').val();
					var started_date = $('#started_dt_txt').val();
					var period = $('#period_txt').val();
					if (!status) {
						swal("Error!", "Status is required!!!", "warning");
						return false;
					} else if (status != 1) {
						if (started_date == '') {
							swal("Error!", "Started date is required!!!", "warning");
							return false;
						} else if (period == '') {
							swal("Error!", "Period is required!!!", "warning");
							return false;
						}
					} else {
						return true;
					}
				});
			</script>