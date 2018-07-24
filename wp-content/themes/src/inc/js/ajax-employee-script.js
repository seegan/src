jQuery('.popup-add-employee').live('click', function() {
    create_popup('get_employee_create_form_popup', 'Add New Employee');
});

function employee_create_submit_popup(action = '', data = '') {
    jQuery.ajax({
        type: "POST",
        url: frontendajax.ajaxurl,
        data: {
        	key : 'post_popup_content',
			data : jQuery("#add_employee").serialize(),
            action : action
        },
        success: function (data) {

            if (/^[\],:{}\s]*$/.test(data.replace(/\\["\\\/bfnrtu]/g, '@').
            replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').
            replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {

                var obj = jQuery.parseJSON(data);
                if(obj.success == 0) {
                    alert_popup('<span class="error_msg">Something Went Wrong! try again!</span>', 'Error');
                } else {
                    clear_main_popup();
                    jQuery('#src_info_box').bPopup().close();
                    alert_popup('<span class="success_msg">Employee Created!</span>', 'Success');   
                }
            } else {
                jQuery('.list_customers').html(data);
                clear_main_popup();
                jQuery('#src_info_box').bPopup().close();
                alert_popup('<span class="success_msg">Employee Created!</span>', 'Success'); 
            }
        }
    });
}


jQuery('a.employee_edit').live('click', function(e) {
    e.preventDefault();
    jQuery('#src_info_box').bPopup({
      modalClose: false,
        position: ['auto', 50] 
      });
});

jQuery('a.employee_edit').live('click', function() {
    employee_edit_popup('edit_employee_create_form_popup', 'Edit Customer', this);
});

function employee_edit_popup(action= '', title = '', data = '') {

    jQuery.ajax({
        type: "POST",
        url: frontendajax.ajaxurl,
        data: {
            key : 'edit_popup_content',
            action : action,
            id : jQuery(data).data('id'),
            roll_id : jQuery(data).data('roll'),
        },
        success: function (data) {
            jQuery('#popup-title').html(title);
            clear_main_popup();
            jQuery('#popup-content').html(data);
        }
    });
}


jQuery('#edit_employee .submit-button').live('click',function () {
    var employee_name = jQuery('#employee_name').val();
    var employee_mobile = jQuery('#employee_mobile').val();
    var employee_address = jQuery('#employee_address').val();
    var employee_joining = jQuery('#employee_joining').val();
    var employee_salary = jQuery('#employee_salary').val();

    if(employee_name != '' && employee_mobile != '' && validatePhone(employee_mobile) && employee_joining!='' && employee_salary!='' )
    {
        employee_edit_submit_popup('post_employee_edit_popup', 'dummy');
    } else {
        alert_popup('<span class="error_msg">Enter the mandatory fields!!</span>', 'Alert!');
    }
});


function employee_edit_submit_popup(action = '', data = '') {
    jQuery.ajax({
        type: "POST",
        url: frontendajax.ajaxurl,
        data: {
            key : 'edit_popup_content',
            data : jQuery("#edit_employee").serialize(),
            action : action
        },
        success: function (data) {
                var obj = jQuery.parseJSON(data);
                if(obj.success == 1) {
                    var update_row = "#employee-data-"+obj.id;
                    jQuery(update_row).html(obj.content);
                    clear_main_popup();
                    jQuery('#src_info_box').bPopup().close();
                    alert_popup('<span class="success_msg">Customer Updated!</span>', 'Success'); 

                } else {
                    alert_popup('<span class="error_msg">Can\'t Edit this data try again!</span>', 'Error');  
                }
        }
    });
}





/*Updated for filter 11/10/16*/
jQuery('.employee_filter #per_page, .employee_filter #emp_no, .employee_filter #emp_name, .employee_filter #emp_mobile, .employee_filter #emp_salary, .employee_filter #emp_status, .employee_filter #join_from, .employee_filter #join_to').live('change', function(){

    var per_page = jQuery('#per_page').val();
    var emp_no = jQuery('#emp_no').val();
    var emp_name = jQuery('#emp_name').val();
    var emp_mobile = jQuery('#emp_mobile').val();
    var emp_salary = jQuery('#emp_salary').val();
    var emp_status = jQuery('#emp_status').val();

    var join_from = jQuery('#join_from').val();
    var join_to = jQuery('#join_to').val();


    jQuery.ajax({
      type: "POST",
      url: frontendajax.ajaxurl,
      data: {
          per_page : per_page,
          emp_no : emp_no,
          emp_name : emp_name,
          emp_mobile : emp_mobile,
          emp_salary : emp_salary,
          emp_status : emp_status,

          join_from : join_from,
          join_to : join_to,
          action : 'employee_list_filter'
      },

      success: function (data) {

          if (/^[\],:{}\s]*$/.test(data.replace(/\\["\\\/bfnrtu]/g, '@').
          replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').
          replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {

              var obj = jQuery.parseJSON(data);
              if(obj.success == 0) {
                  alert_popup('<span class="error_msg">Something Went Wrong! try again!</span>', 'Error');
              }
          } else {
              jQuery('.list_customers').html(data);
          }
      }
    });
});


jQuery(document).ready(function(){
    jQuery("#join_from" ).datepicker({dateFormat: "yy-mm-dd"});
    jQuery("#join_to" ).datepicker({dateFormat: "yy-mm-dd"});
});
/*End Updated for filter 11/10/16*/









/*attendance Script*/

jQuery('.mark_attendance').live('change', function(){
    var current_sel = this;
    jQuery.ajax({
        type: "POST",
        url: frontendajax.ajaxurl,
        data: {
            attendance : jQuery(this).find(':selected').val(),
            action : 'mark_attendance',
            emp_id : jQuery(this).attr('data-empid'),
            attendance_date : jQuery(this).attr('data-attdate'),
        },
        success: function (data) {
                var obj = jQuery.parseJSON(data);
                var att = '-';
                if(obj.attendance == 1) { att = 'Present'; }
                if(obj.attendance == 0) { att = 'Absent'; }

                if(obj.success == 1) {
                    jQuery(current_sel).parent().parent().find('.attendance_val').text(att);
                } else {
                    alert_popup('<span class="error_msg">Can\'t Edit this data try again!</span>', 'Error');  
                }
        }
    });
});


/*Updated for filter 11/10/16*/
jQuery('.attendance_filter #per_page, .attendance_filter #emp_no, .attendance_filter #emp_name, .attendance_filter #attendance_date, .attendance_filter #attendance_status').live('change', function(){

    var per_page = jQuery('#per_page').val();
    var emp_no = jQuery('#emp_no').val();
    var emp_name = jQuery('#emp_name').val();
    var attendance_date = jQuery('#attendance_date').val();
    var attendance_status = jQuery('#attendance_status').val();

    jQuery.ajax({
      type: "POST",
      url: frontendajax.ajaxurl,
      data: {
          per_page : per_page,
          emp_no : emp_no,
          emp_name : emp_name,
          attendance_date : attendance_date,
          attendance_status : attendance_status,
          action : 'attendance_list_filter'
      },

      success: function (data) {

          if (/^[\],:{}\s]*$/.test(data.replace(/\\["\\\/bfnrtu]/g, '@').
          replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').
          replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {

              var obj = jQuery.parseJSON(data);
              if(obj.success == 0) {
                  alert_popup('<span class="error_msg">Something Went Wrong! try again!</span>', 'Error');
              }
          } else {
              jQuery('.list_customers').html(data);
          }
      }
    });
});

jQuery(document).ready(function(){
    jQuery("#attendance_date" ).datepicker({dateFormat: "yy-mm-dd"});
});
/*End Updated for filter 11/10/16*/





/*salary script*/


jQuery('.popup-add-salary').live('click', function() {
    create_popup('get_salary_create_form_popup', 'Make New Salary');
});

function salary_create_submit_popup(action = '', data = '') {
    jQuery.ajax({
        type: "POST",
        url: frontendajax.ajaxurl,
        data: {
            key : 'post_popup_content',
            data : jQuery("#add_salary").serialize(),
            action : action
        },
        success: function (data) {

            if (/^[\],:{}\s]*$/.test(data.replace(/\\["\\\/bfnrtu]/g, '@').
            replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').
            replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {

                var obj = jQuery.parseJSON(data);
                if(obj.success == 0) {
                    alert_popup('<span class="error_msg">Something Went Wrong! try again!</span>', 'Error');
                } else {
                    clear_main_popup();
                    jQuery('#src_info_box').bPopup().close();
                    alert_popup('<span class="success_msg">Salary Updated!</span>', 'Success');   
                }
            } else {
                jQuery('.list_customers').html(data);
                clear_main_popup();
                jQuery('#src_info_box').bPopup().close();
                alert_popup('<span class="success_msg">Salary Updated!</span>', 'Success'); 
            }
        }
    });
}

jQuery('a.salary_edit').live('click', function(e) {
    e.preventDefault();
    jQuery('#src_info_box').bPopup({
      modalClose: false,
    });
});

jQuery('a.salary_edit').live('click', function() {
    salary_edit_popup('edit_salary_create_form_popup', 'Update Salary', this);
});


function salary_edit_popup(action= '', title = '', data = '') {

    jQuery.ajax({
        type: "POST",
        url: frontendajax.ajaxurl,
        data: {
            key : 'edit_popup_content',
            action : action,
            id : jQuery(data).data('id'),
            roll_id : jQuery(data).data('roll'),
        },
        success: function (data) {
            jQuery('#popup-title').html(title);
            clear_main_popup();
            jQuery('#popup-content').html(data);
        }
    });
}




/*Updated for filter 11/10/16*/
jQuery('.salary_filter #per_page, .salary_filter #emp_no, .salary_filter #emp_name, .salary_filter #emp_mobile, .salary_filter #paid_amount, .salary_filter #paid_advance, .salary_filter #paid_from, .salary_filter #paid_to, .salary_filter #attendance_status').live('change', function(){

    var per_page = jQuery('#per_page').val();
    var emp_no = jQuery('#emp_no').val();
    var emp_name = jQuery('#emp_name').val();
    var emp_mobile = jQuery('#emp_mobile').val();
    var attendance_status = jQuery('#attendance_status').val();

    jQuery.ajax({
      type: "POST",
      url: frontendajax.ajaxurl,
      data: {
          per_page : per_page,
          emp_no : emp_no,
          emp_name : emp_name,
          emp_mobile : emp_mobile,
          attendance_status : attendance_status,
          action : 'salary_list_filter'
      },

      success: function (data) {

          if (/^[\],:{}\s]*$/.test(data.replace(/\\["\\\/bfnrtu]/g, '@').
          replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').
          replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {

              var obj = jQuery.parseJSON(data);
              if(obj.success == 0) {
                  alert_popup('<span class="error_msg">Something Went Wrong! try again!</span>', 'Error');
              }
          } else {
              jQuery('.list_customers').html(data);
          }
      }
    });
});

jQuery(document).ready(function(){
    jQuery("#attendance_date" ).datepicker({dateFormat: "yy-mm-dd"});
});
/*End Updated for filter 11/10/16*/