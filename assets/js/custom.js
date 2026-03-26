  $(function(){

    // User login validation
    $("#loginform").submit(function(){
      var txtUsername = $(txt_username).val();
      var txtPassword = $(txt_password).val();
      if( txtUsername.length<5 ){
          swal("Login Error!", "Username must be more than 4 characters", "warning");
          return false;    
      }else if (!/^[a-zA-Z0-9_]{5,}$/.test(txtUsername)) {
          swal("Login Error!", "Please type correct Username", "warning");
          $(txt_username).val('');
          return false;
      }else if(txtPassword.length<5){
          swal("Login Error!", "Password must be more than 4 characters", "warning");
          return false;    
      }else if (!/^[a-zA-Z0-9_]{5,}$/.test(txtPassword)) { // minimum length is 5, $=end of the string, ^=starting the string
          swal("Login Error!", "Please type correct Password", "warning");
          $(txt_password).val('');
          return false;
      }else{ return true; }
    });
    // empty field validation add physical resource details
    $("#insert-physical-resource-details").submit(function(){
      var census_id = $('#census_id_select option:selected').val();
      var phy_res_item = $('#phy_res_item_select option:selected').val();
      var phy_res_item_status = $('#phy_res_item_status_select option:selected').val();
      if(census_id == ''){
          swal("Error!", "Require the census id", "warning");
          return false;    
      }else if(phy_res_item == ''){
          swal("Error!", "Require the item name", "warning");
          return false;        
      }else if(phy_res_item_status == ''){
          swal("Error!", "Require the status", "warning");
          return false; 
      }else{ return true; }
    });
    // empty field validation add physical resource item
    $("#insert_new_phy_res_form").submit(function(){
      var item_name = $(new_phy_res_txt).val().length;
      if(item_name === 0){
          swal("Error!", "Require the item name", "warning");
          return false;    
      }else{ return true; }
    });
    // empty field validation update physical resource item
    $("#update-physical-resource").submit(function(){
      var item_name = $(item_name_txt).val();      
      if(!isNaN(item_name)){
          swal("Error!", "Require the item name", "warning");
          return false;    
      }else{ return true; }
    });
    // empty field validation add physical resource status
    $("#insert_new_phy_res_status_form").submit(function(){
      var status_name_length = $(new_phy_res_status_txt).val().length;
      var status_name = $(new_phy_res_status_txt).val();
      var status_group_id_length = $(status_group_no_txt).val().length;
      var status_group_id = $(status_group_no_txt).val();
      if(status_name_length === 0){
        swal("Error!", "Require the status", "warning");
        return false;    
      }else if(!isNaN(status_name)){ 
        swal("Error!", "Invalid Status Type", "warning");
        return false; 
      }else if(isNaN(status_group_id) || status_group_id_length==0){ 
        swal("Error!", "Invalid group ID", "warning");
        return false; 
      }else{ return true;}
    });
    // empty field validation update physical resource status
    $("#update-status").submit(function(){
      var status_type = $(status_type_txt).val();      
      if(!isNaN(status_type)){
        swal("Error!", "Letters only", "warning");
        return false;
      }else{ return true;}
    });

  $( "#btn_print1" ).click(function (){
    var contents = $("#printDiv").html();
    //alert('asdf');
    frameDoc = window.open('','','width=800,height=800,top=100,left=100');
    frameDoc.document.open();
      //Create a new HTML document.
      frameDoc.document.write('<html><head><title>Management Reports</title>');
      //Append the external CSS file.
      frameDoc.document.write('<link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css" />');
      frameDoc.document.write('<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />');
      frameDoc.document.write('<link href="<?php echo base_url(); ?>assets/css/print.css" rel="stylesheet" type="text/css" media="screen, print" />');
      frameDoc.document.write('</head><body onload="window.print();">');
      //Append the DIV contents.
      frameDoc.document.write(contents);
      frameDoc.document.write('</body></html>');
      frameDoc.document.close();
      setTimeout(function () {
        frameDoc.close();
        frame1.remove();
      }, 500);
  });     // end #print

  }); //  $(function(){
  function confirmDelete1(){
    job = swal({
      title: "Are you sure?",
      text: "Your will not be able to recover this item!",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "No",
      closeOnConfirm: true,
      showLoaderOnConfirm: true
    },
      function(){
        return true;
      }
    );
    if(job != true){
      return false;
    }
  }

  function confirmItemDelete(){
    job=confirm("Are you sure to delete this item permanently?");
    if(job != true){
      return false;
    }
  }
  function confirmStatusDelete(){
    job=confirm("Are you sure to delete this status permanently?");
    if(job != true){
      return false;
    }
  }
  function confirmItemStatusDetailsDelete(){
    job=confirm("Are you sure to delete this item details permanently?");
    if(job != true){
      return false;
    }
  }
  // empty field validation add computer lab items
  $("#insert_com_lab_item_form").submit(function(){
    var item_name = $(new_item_txt).val();      
    //if(!/^[a-z," "]+$/.test(status_type)){
    if(!isNaN(item_name)){
      swal("Error!", "Item name is required!!!", "warning");
      return false;
    }else{ return true;}
  });
  // empty field validation add computer lab item status
  $("#insert_com_lab_res_info_form").submit(function(){
    var census_id = $('#census_id_select option:selected').val();
    var item = $('#com_res_item_select option:selected').val();
    var qty = parseFloat($('#quantity_txt').val());
    var working = parseFloat($('#working_txt').val());
    var repairable = parseFloat($('#repairable_txt').val());
    if(census_id == ''){
        swal("Error!", "Require the census id", "warning");
        return false;    
    }else if(item == ''){
        swal("Error!", "Require the item name", "warning");
        return false;        
    }else if(qty == '' || isNaN(qty)){
        swal("Error!", "Require the quantiy", "warning");
        return false; 
    }else if(working == '' || isNaN(working)){
        swal("Error!", "Require the working quantity", "warning");
        return false;
    }else if(working > qty){
        swal("Error!", "Working quantity is more than the existing quantity", "warning");
        return false;  
    }else if((repairable+working) > qty || isNaN(repairable)){
        swal("Error!", "Repairable quantity is not correct!!!", "warning");
        return false;        
    }else{ return true; }
  });
  // empty field validation add computer lab item status
  $("#update-computer-resource-status-details").submit(function(){
    var qty = parseFloat($('#quantity_txt').val());
    var working = parseFloat($('#working_txt').val());
    var repairable = parseFloat($('#repairable_txt').val());
    if(qty == '' || isNaN(qty)){
        swal("Error!", "Require the quantiy", "warning");
        return false; 
    }else if(working == '' || isNaN(working)){
        swal("Error!", "Require the working quantity", "warning");
        return false;
    }else if(working > qty){
        swal("Error!", "Working quantity is more than the existing quantity", "warning");
        return false;  
    }else if((repairable+working) > qty || isNaN(repairable)){
        swal("Error!", "Repairable quantity is not correct!!!", "warning");
        return false;        
    }else{ return true; }
  });
  // empty field validation add library items
  $("#insert_lib_item_form").submit(function(){
    var item_name = $(new_item_txt).val();      
    //if(!/^[a-z," "]+$/.test(status_type)){
    if(!isNaN(item_name)){
      swal("Error!", "Item name is required!!!", "warning");
      return false;
    }else{ return true;}
  });
    // empty field validation add computer lab item status
  $("#insert_lib_info_form").submit(function(){
    var census_id = $('#census_id_select option:selected').val();
    var item = $('#lib_res_item_select option:selected').val();
    var qty = parseFloat($('#quantity_txt').val());
    if(census_id == ''){
        swal("Error!", "Require the census id", "warning");
        return false;    
    }else if(item == ''){
        swal("Error!", "Require the item name", "warning");
        return false;        
    }else if(qty == '' || isNaN(qty)){
        swal("Error!", "Require the quantiy", "warning");
        return false;        
    }else{ return true; }
  });
  // empty field validation add sanitary item
  $("#insert_san_item_form").submit(function(){
    var item_name = $(new_item_txt).val();      
    //if(!/^[a-z," "]+$/.test(status_type)){
    if(!isNaN(item_name)){
      swal("Error!", "Item name is required!!!", "warning");
      return false;
    }else{ return true;}
  });
    // empty field validation add sanitary item status
  $("#insert_san_info_form").submit(function(){
    var census_id = $('#census_id_select option:selected').val();
    var item = $('#san_item_select option:selected').val();
    var qty = parseInt($('#quantity_txt').val());
    var usable = parseInt($('#usable_txt').val());
    var repairable = parseInt($('#repairable_txt').val());
    if(census_id == ''){
        swal("Error!", "Require the census id", "warning");
        return false;    
    }else if(item == ''){
        swal("Error!", "Require the item name", "warning");
        return false;        
    }else if(qty === '' || isNaN(qty)){
        swal("Error!", "Require the quantiy", "warning");
        return false; 
    }else if(usable === '' || isNaN(usable)){
        swal("Error!", "Require the usable quantiy", "warning");
        return false; 
    }else if(usable > qty){
        swal("Error!", "Usable quantity is more than the existing quantity", "warning");
        return false;  
    }else if((repairable+usable) > qty || isNaN(repairable)){
        swal("Error!", "Repairable quantity is not correct!!!", "warning");
        return false;                 
    }else{ return true; }
  });
  $(function(){
    $('#repaired_info_div').hide();
    $('#repairable_info_div').hide();
    $('#repaired_chkbox').click(function () {                
      $('#repaired_info_div').fadeToggle();
    });
    $('#repairable_chkbox').click(function () {                
      $('#repairable_info_div').fadeToggle();
    });
  });
  // empty field validation add building sizes
  $("#insert_san_item_form").submit(function(){
    var item_name = $(new_item_txt).val();      
    //if(!/^[a-z," "]+$/.test(status_type)){
    if(!isNaN(item_name)){
      swal("Error!", "Item name is required!!!", "warning");
      return false;
    }else{ return true;}
  });
    // empty field validation add building details
  $("#insert_building_info_form").submit(function(){
    var census_id = $('#census_id_select option:selected').val();
    var category = $('#building_cat_select option:selected').val();
    var usage = $('#usage_select option:selected').val();
    var size = $('#size_select option:selected').val();
    var donatedby = $('#donatedby_txt').val();
    if(census_id == ''){
        swal("Error!", "Require the census id", "warning");
        return false;    
    }else if(category == ''){
        swal("Error!", "Require the building category", "warning");
        return false;        
    }else if(usage==''){
        swal("Error!", "Require the building usage field", "warning");
        return false; 
    }else if(size == ''){
        swal("Error!", "Require the size", "warning");
        return false; 
    }else if(donatedby == ''){
        swal("Error!", "Require the donated field to be filled", "warning");
        return false; 
    }else if($('#repaired_chkbox')[0].checked){
      var repaired_institute = $('#repaired_institute_txt').val();
      var repaired_dt = $('#repaired_date_txt').val();
      var repaired_info = $('#repaired_info_txtarea').val();
      var pattern = new regExp('^[0-9]+$');
      if(repaired_institute == '' || !pattern.match(repaired_institute) ){
        swal("Error!", "Require the repaired institute", "warning");
        return false;
      }if(repaired_dt == ''){
        swal("Error!", "Require the repaired date", "warning");
        return false;
      }if(repaired_info == ''){
        swal("Error!", "Require the repaired details", "warning");
        return false;
      }
    }else if($('#repairable_chkbox')[0].checked){
      var repairable_part = $('#repairable_part_txt').val();
      var repairable_info = $('#repairable_info_txtarea').val();
      if(repairable_part == ''){
        swal("Error!", "Require the repairable part", "warning");
        return false;
      }if(repairable_info == ''){
        swal("Error!", "Require the repairable details", "warning");
        return false;
      }               
    }else{ return true; }
  });
  // empty field validation add furniture item information
  $("#insert_furniture_info_form").submit(function(){
    var census_id = $('#census_id_select option:selected').val();
    var fur_item_id = $('#fur_item_select option:selected').val();
    var qty = parseFloat($('#qty_txt').val());
    var usable = parseFloat($('#usable_txt').val());
    var repairable = parseFloat($('#repairable_txt').val());
    var need_more = parseFloat($('#needed_more_txt').val());
    if(census_id === ''){
        swal("Error!", "Require the census id", "warning");
        return false;    
    }else if(fur_item_id === ''){
        swal("Error!", "Require the furniture item", "warning");
        return false;        
    }else if(qty === '' || isNaN(qty)){
        swal("Error!", "Require the quantiy", "warning");
        return false; 
    }else if( (qty != '') && (usable === '' || isNaN(usable)) ){
        swal("Error!", "Require the usable quantity", "warning");
        return false;
    }else if(usable > qty){
        swal("Error!", "Working quantity is more than the existing quantity", "warning");
        return false;  
    }else if( (qty != '') && ((repairable+usable) > qty || isNaN(repairable)) ){
        swal("Error!", "Repairable quantity is not correct!!!", "warning");
        return false;        
    }else{ return true; }
  });

  // empty field validation add staff 
  $("#insert_staff_info_form").submit(function(){
    var title = $('#title_select').val();
    var name_with_ini = $('#name_with_ini_txt').val();
    var full_name = $('#full_name_txt').val();
    var nic = $('#nic_txt').val();
    var dob = $('#dob_txt').val();
    var civil_status = $('#civil_status_select').val(); 
    var gender = $('#gender_select').val();
    var staff_type = $('#stf_type_select').val();
    var designation = $('#desig_select').val();
    var f_app_dt = $('#f_app_dt_txt').val();
    var school = $('#school_select').val();
    var serv_grd = $('#service_grade_select').val();
    var serv_grd_dt = $('#service_grd_dt_txt').val();
    var school = $('#school_select').val();
    var serv_status = $('#current_service_status_select').val();
    var attached_province = $('#province_select').val();
    var attached_zone = $('#zone_select').val();
    var attached_school = $('#attached_sch_select').val();
    var attached_institute = $('#attached_institute_txt').val();

    if(title == ''){
        swal("Error!", "Require the title", "warning");
        return false;    
    }else if(name_with_ini == ''){
        swal("Error!", "Require the name with initials", "warning");
        return false;    
    }else if(full_name == ''){
        swal("Error!", "Require the full name", "warning");
        return false;        
    }else if(nic == ''){
        swal("Error!", "Require the NIC number", "warning");
        return false; 
    }else if(dob == ''){
        swal("Error!", "Require the date of birth", "warning");
        return false;       
    }else if(civil_status == ''){
        swal("Error!", "Require the civil status", "warning");
        return false;       
    }else if(gender == ''){
        swal("Error!", "Require the gender", "warning");
        return false;       
    }else if(staff_type == ''){
        swal("Error!", "Require the staff type", "warning");
        return false;       
    }else if(f_app_dt == ''){
        swal("Error!", "Require the first appoinment date", "warning");
        return false;       
    }else if(serv_grd =='' && serv_grd_dt != ''){
        swal("Error!", "Require the service grade", "warning");
        return false;       
    }else if(serv_grd !='' && serv_grd_dt == ''){ // service grade
        swal("Error!", "Require the date of service grade", "warning");
        return false;       
    }else if(school == ''){
        swal("Error!", "Require the School name", "warning");
        return false;       
    }else if(designation == ''){
        swal("Error!", "Require the designation", "warning");
        return false;       
    }else if(serv_status == ''){    // service status
        swal("Error!", "Require the service status", "warning");
        return false;       
    }else if(serv_status != 1 && effective_date == ''){
        swal("Error!", "Require the effective date of service status", "warning");
        return false;       
    }else{ return true; }
  });




