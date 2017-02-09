function login_validate()
{	
	 if(formsubmit('','login_validation', [['required','ls_username','ls_password']],''))
	 {
	 	
	 	return true;
	 }

	 else
	 {
	 	return false;
	 }
}
function department_registration_validation()
{	
	if(formsubmit('','department_registration', [['required','category','department','department_code']],''))
	 {
	 	
	 	return true;
	 }

	 else
	 {
	 	return false;
	 }
}

function edit_department_registration_validation()
{	
	 if(formsubmit('','edit_department_registration', [['required','category','edepartment','edepartment_code']],''))
	 {
	 	
	 	return true;
	 }

	 else
	 {
	 	return false;
	 }
}

function user_registration_validation()
{	
	 if(formsubmit('','user_registration', [['required','f_name','l_name','email','contact_no1'],['email','email'],['telno','contact_no1']],''))
	 {
	 	
	 	return true;
	 }

	 else
	 {
	 	return false;
	 }
}

function edit_user_registration_validation()
{	
	 if(formsubmit('','edit_user_registration', [['required','ef_name','el_name','email','econtact_no1'],['email','email'],['telno','econtact_no1']],''))
	 {
	 	
	 	return true;
	 }

	 else
	 {
	 	return false;
	 }
}

function role_registration_validation()
{	
	 if(formsubmit('','role_registration', [['required','category','role']],''))
	 {
	 	
	 	return true;
	 }

	 else
	 {
	 	return false;
	 }
}

function edit_role_registration_validation()
{	
	 if(formsubmit('','edit_role_registration', [['required','category','role']],''))
	 {
	 	
	 	return true;
	 }

	 else
	 {
	 	return false;
	 }
}

function category_registration_validation()
{	
	 if(formsubmit('','category_registration', [['required','main_category','category']],''))
	 {
	 	
	 	return true;
	 }

	 else
	 {
	 	return false;
	 }
}

function edit_category_registration_validation()
{	
	 if(formsubmit('','edit_category_registration', [['required','main_category','category']],''))
	 {
	 	
	 	return true;
	 }

	 else
	 {
	 	return false;
	 }
}

function function_role_mapping_validation() // function role mapping
{	
	 if(formsubmit('','function_role_mapping_registration', [['required','category','role','department']],''))
	 {
	 	
	 	return true;
	 }

	 else
	 {
	 	return false;
	 }
}

function edit_function_role_mapping_validation()
{	
	 if(formsubmit('','edit_function_role_mapping_registration', [['required','category','role','department']],''))
	 {
	 	
	 	return true;
	 }

	 else
	 {
	 	return false;
	 }
}