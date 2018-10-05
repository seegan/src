<style type="text/css">
	.select2-container {
	    z-index: 9998;
	}
	.select2-dropdown {
		width: 220px !important;
	}
  .sal_pay {
    display: block;
  }
  .sal_adv {
    display: none;
  }  
</style>

<?php
  if(isset($_POST['id']) AND $_POST['id'] != '') {
    $employee_detail = get_employee_by_id($_POST['id']);

    $sal_detail = get_salery_pay_details($_POST['id'], date("Y-m-d"));
  }
?>
<div class="form-grid">
	<form method="post" name="add_salary" id="add_salary" class="popup_form" onsubmit="return false;">
		<div class="form_detail">
			<label>Employee Name
				<abbr class="require" title="Required Field">*</abbr>
			</label>
			<div style="float:left;width: 138px;">
            <input type="text" name="" value="<?php echo isset($employee_detail['emp_name']) ? $employee_detail['emp_name'] : ''; ?>">
            <input type="hidden" name="emp_name" value="<?php echo isset($employee_detail['id']) ? $employee_detail['id'] : ''; ?>">
		    </div>
		</div>
		<div class="form_detail">
			<label style="width: 115px;">Employee Id
				<abbr class="require" title="Required Field">*</abbr>
			</label>
			<input type="text" id="emp_id"  name="emp_id" autocomplete="off" readonly="" value="<?php echo isset($employee_detail['id']) ? 'EMP'.$employee_detail['id'] : ''; ?>">
		</div>
		<div class="form_detail">
			<label>Mobile
				<abbr class="require" title="Required Field">*</abbr>
			</label>
			<input type="text" id="emp_mobile" onkeypress="return isNumberKey(event)" name="emp_mobile" autocomplete="off" readonly value="<?php echo isset($employee_detail['emp_mobile']) ? $employee_detail['emp_mobile'] : ''; ?>">
		</div>
		<div class="form_detail">
			<label style="width: 115px;">Salary Paid Date
			</label>
			<input type="text" id="salary_date" name="salary_date" autocomplete="off" value="<?php echo date("Y-m-d", time()); ?>">
		</div>
    <div class="form_detail">
      <label>Pay
      </label>
      <input type="radio" name="pay_in" value="salary" checked> Salary
      <input type="radio" name="pay_in" value="advance"> Advance
    </div>
    <div class="form_detail">
    </div>
		<div class="form_detail">
			<label>Salary Pay
			</label>
			<input type="text" id="salary_pay" name="salary_pay" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off" value="<?php echo $sal_detail['working_salary'] ?>">
		</div>
    <div class="form_detail sal_pay">
      <label>You have to Pay :
      </label>
      <label>
        <span class="have_to_pay"><?php echo $sal_detail['working_salary']; ?>
        </span>
        <input type="hidden" name="have_to_pay_input" id="have_to_pay_input" value="<?php echo $sal_detail['working_salary']; ?>">
      </label>
    </div>

    <div class="form_detail sal_adv">
      <label style="width: 115px;">Sal. in Advance
      </label>
      <input type="text" id="salary_advance" name="salary_advance" onkeypress="return isNumberKeyWithDot(event)" autocomplete="off">
    </div>
		<div class="button_sub">
			<button type="submit" name="new_customer_list" id="btn_submit" class="submit-button">Submit</button>
		</div>

    <br>
    <div class="aditional_fld">
      Working Days : <input type="text" id="total_working" onkeypress="return isNumberKeyWithDot(event)" style="width:50px;" value="<?php echo $sal_detail['workingDaysFromLastPaid']; ?>" name="total_working"> Leave Taken : <input type="text" id="leave_taken" style="width:50px;" value="0" name="leave_taken"> Advance in hand : <input type="text" id="adv_hand" onkeypress="return isNumberKeyWithDot(event)" style="width:50px;" readonly value="<?php echo $sal_detail['adv_last_paid_amount']; ?>" name="adv_hand"> Sal. From Advance <input type="checkbox" id="sal_from_adv" name="sal_from_adv">
      <input type="hidden" value="<?php echo $sal_detail['salary_per_day']; ?>" id="sal_per_day"><input type="hidden" id="adv_hand_orig" value="<?php echo $sal_detail['adv_last_paid_amount']; ?>">
    </div>

	</form>



</div>


<script type="text/javascript">

  jQuery('#total_working, #leave_taken, #adv_hand').on('input', function(){
    populateSalaryPay();
  });

  jQuery('#sal_from_adv, #salary_pay').on('change', function(){
    populateBalancePay();
  });

  function populateSalaryPay() {
    var sal_per_day = jQuery('#sal_per_day').val();
    var total_working = jQuery('#total_working').val();
    var leave_taken = jQuery('#leave_taken').val();
    var adv_hand = jQuery('#adv_hand_orig').val();
    var salary_pay = jQuery('#salary_pay').val();
    var sal_from_adv = jQuery('#sal_from_adv:checked').length;


    var sal_pay_tot = ( total_working - leave_taken ) * sal_per_day;

    jQuery('#salary_pay').val(sal_pay_tot).change();
  }

  function populateBalancePay() {
    var sal_per_day = jQuery('#sal_per_day').val();
    var total_working = jQuery('#total_working').val();
    var leave_taken = jQuery('#leave_taken').val();
    var adv_hand = jQuery('#adv_hand_orig').val();
    var salary_pay = jQuery('#salary_pay').val();
    var sal_from_adv = jQuery('#sal_from_adv:checked').length;

    var bal_pay;
    if(sal_from_adv == 1) { console.log('a')
      bal_pay = salary_pay - adv_hand;
      jQuery('.have_to_pay').text(bal_pay);
      jQuery('#have_to_pay_input').val(bal_pay);
      

      if(bal_pay > 0) {
        jQuery('#adv_hand').val( 0 );
      } else {
        jQuery('#adv_hand').val( Math.abs(bal_pay) );
      }


    } else { console.log('s')
      bal_pay = salary_pay;
      jQuery('.have_to_pay').text(bal_pay);
      jQuery('#have_to_pay_input').val(bal_pay);
      jQuery('#adv_hand').val(adv_hand);
      
    }


  }




  jQuery('input[name="pay_in"]').on('change', function(){

    if(jQuery('input[name="pay_in"]:checked').val() == 'salary') {
      jQuery('.sal_pay').css('display', 'block');
      jQuery('.sal_adv').css('display', 'none');

      jQuery('.aditional_fld').css('display', 'block');



    }
    if(jQuery('input[name="pay_in"]:checked').val() == 'advance') {
      jQuery('.sal_adv').css('display', 'block');
      jQuery('.sal_pay').css('display', 'none');

      jQuery('.aditional_fld').css('display', 'none');
    }

  });




	jQuery('#add_salary .submit-button').click(function () {
		var salary_advance = jQuery('#salary_advance').val();
		var salary_pay = jQuery('#salary_pay').val();

		if(salary_pay != '' || salary_advance != '' ) {
			salary_create_submit_popup('post_salary_create_popup', 'ddf');
		} else {
			alert_popup('<span class="error_msg">Enter the mandatory fields!!</span>', 'Alert!');
		}
	});

/*  jQuery("#emp_name").select2({
      allowClear: true,
      width: '100%',
      multiple: false,
      minimumInputLength: 1,
      ajax: {
          type: 'POST',
          url: frontendajax.ajaxurl,
          delay: 250,
          dataType: 'json',
          data: function(params) {
            return {
              action: 'get_employee_data', // search term
              page: 1,
              search_key: params.term,
            };
          },
          processResults: function(data) {
            var results = [];

            return {
                results: jQuery.map(data.items, function(obj) {
                    return { id: obj.id, emp_mobile:obj.emp_mobile, emp_name: obj.emp_name, employee_no : obj.employee_no };
                })
            };
          },
          cache: true
      },
      templateResult: formatCustomerNameResult,
      templateSelection: formatCustomerName
  }).on("select2:select", function (e) { 
      jQuery('#emp_id').val(e.params.data.employee_no);
      jQuery('#emp_mobile').val(e.params.data.emp_mobile);

    console.log(e.params); 
  });*/



    function formatCustomerName (state) {
      if (!state.id) {
        return state.id;
      }
      var $state = jQuery(
        '<span>' +
          state.emp_name +
        '</span>'
      );
      return $state;
    };

    function formatCustomerNameResult(data) {
      if (!data.id) { // adjust for custom placeholder values
        return 'Searching ...';
      }
      var $state = jQuery(
        '<span>Name : ' +
          data.emp_name +
        '</span>' +
        '<br><span> Employee Id : ' +
          data.employee_no +
        '</span>' +
        '<br><span> Mobile : ' +
          data.emp_mobile +
        '</span>'
      );
      return $state;
    }



	jQuery(document).ready(function(){
        jQuery("#salary_date" ).datepicker({dateFormat: "yy-mm-dd"});
    })

jQuery(document).on("keydown", "#edit_salary .submit-button", function(e) {
    if(event.keyCode == 9) {
      if(event.shiftKey && event.keyCode == 9) {  
         e.preventDefault(); 
        jQuery('#edit_salary #sal_from_adv').focus();
      }
      else { 
        e.preventDefault(); 
        jQuery('#edit_salary #emp_name').select2('open');
      }
    }
  });
  jQuery(document).on("keydown", ".select2-search__field", function(e) {
    if(event.keyCode == 9) {
      console.log(jQuery(this));
      if(event.shiftKey && event.keyCode == 9) {  
         e.preventDefault(); 
         jQuery(this).parent().find('#edit_salary .submit-button').focus();
      }
      else { 
        e.preventDefault(); 
        jQuery('#edit_salary #emp_id').focus();
      }
    }
  });
  jQuery(document).on("keydown", "#edit_salary #salary_pay", function(e) {
    if(event.keyCode == 9) {
      if(event.shiftKey && event.keyCode == 9) {  
         e.preventDefault(); 
         jQuery('input[name="pay_in"]').focus();
      }
      else {
        e.preventDefault(); 
        jQuery('#edit_salary #total_working').focus();
      }
    }
  });
  jQuery(document).on("keydown", "#edit_salary #sal_from_adv", function(e) {
    if(event.keyCode == 9) {
      if(event.shiftKey && event.keyCode == 9) {  
         e.preventDefault(); 
         jQuery('#edit_salary #leave_taken').focus();
      }
      else {
        e.preventDefault(); 
        jQuery('#edit_salary .submit-button').focus();
      }
    }
  });
    jQuery(document).on("keydown", "#edit_salary #total_working", function(e) {
    if(event.keyCode == 9) {
      if(event.shiftKey && event.keyCode == 9) {  
         e.preventDefault(); 
         jQuery('#edit_salary #salary_pay').focus();
      }
      else {
        e.preventDefault(); 
        jQuery('#edit_salary #leave_taken').focus();
      }
    }
  });
</script>