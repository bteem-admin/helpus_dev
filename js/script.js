jQuery(function($) {
	var name=/^[a-zA-Z]{3,15}$/i;
	var email = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
	var phone = /^[0-9]{10}$/i;
	
	var path=window.location;	

	$('.popup-background').click(function(event){
		$('.popup-background').removeClass('popup-widget-overlay');
		$('.popup-popup-content').css({
			'display': 'none'
		});
		$('.popup-more-content').css({
			'display': 'none'
		});
		$('.popup__content').html('');
	});
	
	$('.required').blur(function () {
		var id = $(this).attr('id');
		fieldcheck(id,['required']);
	});		
	$('.email').blur(function () {
		var id = $(this).attr('id');
		fieldcheck(id,['required','email']);
	});

	$('.required_unique_id').blur(function () {
		var id = $(this).attr('id');
		fieldcheck(id,['required']);
	});

	$('.required_email_id').blur(function () {
		var id = $(this).attr('id');
		fieldcheck(id,['required','email']);
	});

	$('.required_mobile_no').blur(function () {
		var id = $(this).attr('id');
		fieldcheck(id,['required','telno']);
	});

	$('.username').blur(function () {
		var id = $(this).attr('id');
		fieldcheck(id,['required','username']);
	});
	$('.password').blur(function () {
		var id = $(this).attr('id');
		fieldcheck(id,['required','password']);
	});

	$('.confirm_password').on('keyup', function () {
	    var id = $(this).attr('id');
		fieldcheck(id,['required','confirm_password']);
	});
	
});

var pathstring = String(window.location);
var patharray = pathstring.split("/");
var path = patharray[0] + '//' + patharray[2] + '/' + patharray[3];

function popupcontent_injection1(data)
{
    $("html, body").animate({scrollTop: 0}, 500);
    $('.popup-popup-content').css({
        'background-color': '#fcfcfc',
        'opacity': '1',
        'border': '1px solid #c5c5c5',
        'display': 'block',
        'height': 'auto',
        'left': '40%',
        'position': 'absolute',
        'top': '108px',
        'width': '535px',
        'z-index': '999'
    });
    $('.popup__content').html(data);
    $('.popup-background').addClass('popup-widget-overlay');
    $('.main').css({
        'min-height': '670px'
    });
}

function popupcontent_injection2(data)
{
    $("html, body").animate({scrollTop: 0}, 500);
    $('.popup-popup-content').css({
        'background-color': '#fcfcfc',
        'opacity': '1',
        'border': '1px solid #c5c5c5',
        'display': 'block',
        'height': 'auto',
        'left': '20%',
        'position': 'absolute',
        'top': '108px',
        'width': 'auto',
        'z-index': '999'
    });
    $('.popup__content').html(data);
    $('.popup-background').addClass('popup-widget-overlay');
    $('.main').css({
        'min-height': '670px'
    });
}

function popupcontent_injection(data)
{
    $("html, body").animate({scrollTop: 0}, 500);
    $('.popup-popup-content').css({
        'background-color': '#fcfcfc',
        'opacity': '1',
        'border': '1px solid #c5c5c5',
        'display': 'block',
        'height': 'auto',
        'left': '40%',
        'position': 'absolute',
        'top': '108px',
        'width': 'auto',
        'z-index': '999'
    });
    $('.popup__content').html(data);
    $('.popup-background').addClass('popup-widget-overlay');
    $('.main').css({
        'min-height': '670px'
    });
}

function popupcontent_ajax(data)
{
    $("html, body").animate({scrollTop: 0}, 500);
    $('.popup__content').html(data);
    $('.popup-background').addClass('popup-widget-overlay');
    $('.main').css({
        'min-height': '670px'
    });
    $('.popup-popup-content').css({
        'background-color': 'transparent',
        'opacity': '0.68',
        'border': 'none',
        'display': 'block',
        'height': 'auto',
        'left': '22%',
        'position': 'absolute',
        'top': '17px',
        'width': 'auto',
        'z-index': '999'
    });
}

function closePopup()
{
	$('.popup-background').removeClass('popup-widget-overlay');
	$('.popup-popup-content').css({
		'display': 'none'
	});	
	$('.popup-more-content').css({
		'display': 'none'
	});
	$('.popup__content').html('');
	$('.more__content').html('');
}
function closemorePopup()
{
	$('.popup-more-content').css({
		'display': 'none'
	});
	$(".popup-popup-content").animate({left:"33%"}, 800 );
	$('.more__content').html('');
}


function checkrequired(id){			
	// var fname = document.getElementById("name").value;
	var fname = $('#'+id).val();				

	if (fname == "") {
		$('#'+id).addClass('input__error');
		return true;
	} else {
		$('#'+id).removeClass('input__error');
		return false;
	}		
};

function checkemail(id){		
	var nameRegex = /^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/i;
	// var fname = document.getElementById("name").value;
	var fname = $('#'+id).val();				

	if (fname == "") {
		$('#'+id).addClass('input__error');
		return true;
	} else if (!(nameRegex.test(fname))) {
		$('#'+id).addClass('input__error');	
		return true;
	} else {
		$('#'+id).removeClass('input__error');
		return false;
	}		
};

function fieldcheck(element_id,ruleArray)
{
var total = 0;
var total = ruleArray.length - 1;
	for(i=0;i<ruleArray.length;i++)
	{
		if(ruleArray[i]=='required')
		{	
			if(document.getElementById(element_id).value.trim() != '' && i==total)
			{
				success_border(element_id);
				document.getElementById('error_'+element_id).innerHTML = '';
			}
			else if(document.getElementById(element_id).value.trim() != '' && i!=total)
			{
				continue;
			}
			else
			{
				document.getElementById('error_'+element_id).innerHTML = 'Required';
				fail_border(element_id);
				break;
			}
		}
		if(ruleArray[i]=='email')
		{
			if(document.getElementById(element_id).value.trim() != '')
			{
				if(/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/i.test(document.getElementById(element_id).value) && i==total)
				{
					success_border(element_id);
					document.getElementById('error_'+element_id).innerHTML = '';
					var pathstring = String(window.location);
					var patharray  = pathstring.split("/");		
					var path=patharray[0]+'//'+patharray[2]+'/'+patharray[3];

					var field_name = document.getElementById('email').name;
					var email = document.getElementById('email').value;
					if(field_name == 'email')
					{
						var url = path+"/index.php/jobseeker_registration/get_existing_email";
					}
					else if(field_name=='c_email')
					{
						var url = path+"/index.php/client_registration/get_existing_email";
					}
					else if(field_name=='e_email')
					{
						var url = path+"/index.php/client/user/get_existing_email";
					}

					//var url = path+"/index.php/jobseeker_registration/get_existing_email";

					$.post(url,{email:email, field_name:field_name},function(data) {	
						if(data=='existing')
						{
							$('#error_email').html("Email Already Exists");
						}
						else
						{
							$('#error_email').html("");
							$('#error_c_email').html("");
						}
					});
				}
				else if(/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/i.test(document.getElementById(element_id).value) && i!=total)
				{
					continue;
				}
				else
				{
					document.getElementById('error_'+element_id).innerHTML = 'Enter a valid email';
					fail_border(element_id);
					break;
				}
			}
			else
			{
				back_toclearBorder(element_id);
			}
		}
		if(ruleArray[i]=='username')
		{			
			if(document.getElementById(element_id).value.trim() != '')
			{
				if(document.getElementById(element_id).value.length>=6 && document.getElementById(element_id).value.length<26)
				{
					if(/^[a-zA-Z0-9\_\.]+$/i.test(document.getElementById(element_id).value) && i==total)
					{
						success_border(element_id);
						document.getElementById('error_'+element_id).innerHTML = '';

						var pathstring = String(window.location);
						var patharray  = pathstring.split("/");		
						var path=patharray[0]+'//'+patharray[2]+'/'+patharray[3];

						var username = document.getElementById(element_id).value;
						var email = document.getElementById('email').value;
						var email_name = document.getElementById('email').name;
						if(email_name == 'e_email')
						{
							var url = path+"/index.php/client/user/get_existing_username";
						}
						else if(email_name == 'c_email')
						{
							var url = path+"/index.php/client_registration/get_existing_username";
						}
						else
						{
							var url = path+"/index.php/jobseeker_registration/get_existing_username";
						}
						
						$.post(url,{username:username, email:email},function(data) {	//alert(data);
							if(data=='existing')
							{
								$('#error_username').html("Username Already Exists");
							}
							else
							{
								$('#error_username').html("");
							}
						});
					}
					else if(/^[a-zA-Z0-9\_\.]+$/i.test(document.getElementById(element_id).value) && i!=total)
					{
						continue;
					}
					else
					{
						document.getElementById('error_'+element_id).innerHTML = 'you can use only letters (a-z), numbers, and periods';
						fail_border(element_id);
						break;
					}
				}
				else
				{
					document.getElementById('error_'+element_id).innerHTML = 'Please use between 6 and 25 characters.';
					fail_border(element_id);
					break;
				}
			}
			else
			{
				back_toclearBorder(element_id);
			}
		}
		if(ruleArray[i]=='password')
		{
			if(document.getElementById(element_id).value.trim() != '')
			{
				if(document.getElementById(element_id).value.length>=6 && i==total)
				{
					success_border(element_id);
					document.getElementById('error_'+element_id).innerHTML = '';
				}
				else if(document.getElementById(element_id).value.length>=6 && i!=total)
				{
					continue;
				}
				else
				{
					document.getElementById('error_'+element_id).innerHTML = 'password must be at least 6 characters long';
					fail_border(element_id);
					break;
				}
			}
			else
			{
				back_toclearBorder(element_id);
			}
		}

		if(ruleArray[i]=='confirm_password')
		{
			if(document.getElementById(element_id).value.trim() != '')
			{
				if ($('#password').val() == $('#confirm_password').val()) 
				{
			        document.getElementById('error_'+element_id).innerHTML = '';
			    } 
			    else 
			    {
			        document.getElementById('error_'+element_id).innerHTML = 'Not Matching';
			    }
			}
			else
			{
				back_toclearBorder(element_id);
			}
		}

		if(ruleArray[i]=='telno')
		{
			if(document.getElementById(element_id).value.trim() != '')
			{
				if(/^[0-9]{10}$/i.test(document.getElementById(element_id).value) && i==total)
				{
					success_border(element_id);
					document.getElementById('error_'+element_id).innerHTML = '';
				}
				else if(/^[0-9]{10}$/i.test(document.getElementById(element_id).value) && i!=total)
				{
					continue;
				}
				// else if(/^[0-9]{10}$/i.test(document.getElementById(element_id).value.length>=10) && (/^[0-9]{10}$/i.test(document.getElementById(element_id).value.length<=12)))
				// {
				// 	document.getElementById('error_'+element_id).innerHTML = 'Please use 10 to 12 characters.';
				// 	fail_border(element_id);
				// 	break;
				// }
				else
				{
					document.getElementById('error_'+element_id).innerHTML = 'only numbers';
					fail_border(element_id);
					break;
				}
			}
			else
			{
				back_toclearBorder(element_id);
			}
		}
		if(ruleArray[i]=='alpha')
		{
			if(document.getElementById(element_id).value.trim() != '')
			{
				if(/^[a-zA-Z]+$/i.test(document.getElementById(element_id).value) && i==total)
				{
					success_border(element_id);
				}
				else if(/^[a-zA-Z]+$/i.test(document.getElementById(element_id).value) && i!=total)
				{
					continue;
				}
				else
				{
					document.getElementById('error_'+element_id).innerHTML = 'only alphabets';
					fail_border(element_id);
					break;
				}
			}
			else
			{
				back_toclearBorder(element_id);
			}
		}
		if(ruleArray[i]=='dropdown')
		{
			if(document.getElementById(element_id).value!=0 && i==total)
			{
				success_border(element_id);
			}
			else if(document.getElementById(element_id).value!=0 && i!=total)
			{
				continue;
			}
			else
			{
				document.getElementById('error_'+element_id).innerHTML = 'select';
				fail_border(element_id);
				break;
			}
		}
		if(ruleArray[i]=='none')
		{
			back_toclearBorder(element_id);
		}
	}
}

/*Entire Form Validation*/

function formsubmit(NowBlock, formName, reqFieldArr ,nextAction){	
	var curForm = new formObj(NowBlock, formName, reqFieldArr ,nextAction);
    if(curForm.valid)
	{	
		return true;	
	}
	
    else{
		return false;
        curForm.paint();    
        curForm.listen();
    }	
}

function formObj(NowBlock, formName, reqFieldArr, nextAction){	

    var filledCount = 0;
    var fieldArr = new Array();
	var k = 0;
	this.formNM = formName;
	
	/*if(document.forms[this.formNM].elements['submit_tp'].value == '1ax')
	{
		this.nextaction = nextAction;
		this.now = NowBlock;
	}*/
	
	for(i=0;i<reqFieldArr.length;i++)
	{
		if(reqFieldArr[i][0]=='required')
		{				
			for(j=reqFieldArr[i].length-1; j>=1; j--){
				fieldArr[k] = new fieldObj(this.formNM, reqFieldArr[i][j],'required');
				if(fieldArr[k].filled == true)
				{
					filledCount++;
				}
				k++;
			}
		}
		if(reqFieldArr[i][0]=='email')
		{	
			for(j=reqFieldArr[i].length-1; j>=1; j--){
				fieldArr[k] = new fieldObj(this.formNM, reqFieldArr[i][j],'email');
				if(fieldArr[k].filled == true)
				{
					filledCount++;
				}
				k++;
			}
		}
		if(reqFieldArr[i][0]=='username')
		{	
			for(j=reqFieldArr[i].length-1; j>=1; j--){
				fieldArr[k] = new fieldObj(this.formNM, reqFieldArr[i][j],'username');
				if(fieldArr[k].filled == true)
				{
					filledCount++;
				}
				k++;
			}
		}
		if(reqFieldArr[i][0]=='password')
		{	
			for(j=reqFieldArr[i].length-1; j>=1; j--){
				fieldArr[k] = new fieldObj(this.formNM, reqFieldArr[i][j],'password');
				if(fieldArr[k].filled == true)
				{
					filledCount++;
				}
				k++;
			}
		}
		if(reqFieldArr[i][0]=='telno')
		{	
			for(j=reqFieldArr[i].length-1; j>=1; j--){
				fieldArr[k] = new fieldObj(this.formNM, reqFieldArr[i][j],'telno');
				if(fieldArr[k].filled == true)
				{
					filledCount++;
				}
				k++;
			}
		}
		if(reqFieldArr[i][0]=='alpha')
		{	
			for(j=reqFieldArr[i].length-1; j>=1; j--){
				fieldArr[k] = new fieldObj(this.formNM, reqFieldArr[i][j],'alpha');
				if(fieldArr[k].filled == true)
				{
					filledCount++;
				}
				k++;
			}
		}
		if(reqFieldArr[i][0]=='equal')
		{	
			for(j=reqFieldArr[i].length-1; j>=1; j--){
				fieldArr[k] = new fieldObj(this.formNM, reqFieldArr[i][j],'equal');
				if(fieldArr[k].filled == true)
				{
					filledCount++;
				}
				k++;
			}
		}
		if(reqFieldArr[i][0]=='notequal')
		{
			for(j=reqFieldArr[i].length-1; j>=1; j--){
				fieldArr[k] = new fieldObj(this.formNM, reqFieldArr[i][j],'notequal');
				if(fieldArr[k].filled == true)
				{
					filledCount++;
				}
				k++;
			}
		}
	}
    if(filledCount == fieldArr.length)
	{
        this.valid = true;
	}
    else
	{
        this.valid = false;
	}


    this.paint = function(){
        for(i=fieldArr.length-1; i>=0; i--){
            if(fieldArr[i].filled == false)
                fieldArr[i].paintInRed();
            else
                fieldArr[i].unPaintInRed();
        }
    }    
    this.listen = function(){
        for(i=fieldArr.length-1; i>=0; i--){
            fieldArr[i].fieldListen();
        }
    }	
}

formObj.prototype.send = function(){
		if(document.forms[this.formNM].elements['submit_tp'].value == '1ax')
		{
			var to = document.forms[this.formNM].elements['submit_action'].value;
			var tofunction = document.forms[this.formNM].elements['submit_fn'].value;			
			var now = this.now;
			var next = this.nextaction; 
			
			var str = $('#'+this.formNM).serialize();			
			
			var url = path+"index.php/"+to+"/"+tofunction;					
			$.post(url,{fieldval:str},function(data) {
				if(data=='next')
				{			
					if(next != 'none')
					{
						document.getElementById(now).style.display="none";
						document.getElementById(next).style.display="block";
						return true;
					}
				}
				else
				{					
					//document.getElementById('set_notset').value = 'notset';
				}															
			});
		}
		
		if(document.getElementById('submit_tp').value == '')
		{
			document.forms[this.formNM].submit();
			return true;
		}
};

function fieldObj(formName, fName,typeOchk){

	if(typeOchk != 'equal' && typeOchk != 'notequal')
	{
		var curField = document.forms[formName].elements[fName];
	}
    this.filled = getValueBool(typeOchk);

    this.paintInRed = function(){
		//document.getElementById('error_'+fName).innerHTML = 'required';
        //curField.addClassName('red');		
    }

    this.unPaintInRed = function(){
        //curField.removeClassName('red');
		//document.getElementById('error_'+fName).innerHTML = '';
    }

    this.fieldListen = function(){
        curField.onkeyup = function(){
            if(curField.value != ''){			
                curField.removeClassName('red');				
            }
            else{
                curField.addClassName('red');				
            }
        }
    }

    function getValueBool(type){
		if(type=='required')
		{
			if($.trim(curField.value) != '')
			{
				document.getElementById('error_'+fName).innerHTML = '';
				return true;
			}
			else
			{
				var chkvalue = document.getElementById('error_'+fName).innerHTML.trim();
				if(chkvalue == '')
				{
					document.getElementById('error_'+fName).innerHTML = 'Required';
					fail_border(fName);
				}
				return false;
			}
		}
		if(type=='email')
		{
			if($.trim(curField.value) != '')
			{			
				if(/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/i.test(curField.value))
				{
					document.getElementById('error_'+fName).innerHTML = '';
					return true;
				}
				else
				{
					var chkvalue = document.getElementById('error_'+fName).innerHTML.trim();
					
					if(chkvalue == '')
					{				
						document.getElementById('error_'+fName).innerHTML = 'Enter a valid email';
						fail_border(fName);
					}
					return false;
				}
			}
			else
			{
				return true;
			}
		}
		if(type=='username')
		{
			if($.trim(curField.value) != '')
			{
				if(curField.value.length>=6 && curField.value.length<26)
				{
					if(/^[a-zA-Z0-9\_\.]+$/i.test(curField.value))
					{
						document.getElementById('error_'+fName).innerHTML = '';
						return true;
					}
					else
					{
						var chkvalue = document.getElementById('error_'+fName).innerHTML.trim();
					
						if(chkvalue == '')
						{				
							document.getElementById('error_'+fName).innerHTML = 'you can use only letters (a-z), numbers, and periods';
							fail_border(fName);
						}
						return false;
					}
				}
				else
				{
					var chkvalue = document.getElementById('error_'+fName).innerHTML.trim();
					
					if(chkvalue == '')
					{				
						document.getElementById('error_'+fName).innerHTML = 'Please use between 6 and 25 characters.';
						fail_border(fName);
					}
					return false;
				}
			}
			else
			{
				return true;
			}
		}
		if(type=='password')
		{
			if($.trim(curField.value) != '')
			{
				if(curField.value.length>=6)
				{
					document.getElementById('error_'+fName).innerHTML = '';
					return true;
				}
				else
				{
					var chkvalue = document.getElementById('error_'+fName).innerHTML.trim();
					
					if(chkvalue == '')
					{				
						document.getElementById('error_'+fName).innerHTML = 'password must be at least 6 characters long';
						fail_border(fName);
					}
					return false;
				}
			}
			else
			{
				return true;
			}
		}
		if(type=='telno')
		{
			if($.trim(curField.value) != '')
			{
				if(/^[0-9]{10}$/i.test(curField.value))
				{
					document.getElementById('error_'+fName).innerHTML = '';
					return true;
				}
				else
				{
					var chkvalue = document.getElementById('error_'+fName).innerHTML.trim();
					
					if(chkvalue == '')
					{				
						document.getElementById('error_'+fName).innerHTML = 'Enter a valid phone number';
						fail_border(fName);
					}
					return false;
				}
			}
			else
			{
				return true;
			}
		}
		if(type=='alpha')
		{
			if($.trim(curField.value) != '')
			{
				if(/^[a-zA-Z]+$/i.test(curField.value))
				{
					document.getElementById('error_'+fName).innerHTML = '';
					return true;
				}
				else
				{
					var chkvalue = document.getElementById('error_'+fName).innerHTML.trim();
					
					if(chkvalue == '')
					{				
						document.getElementById('error_'+fName).innerHTML = 'sholud be a charector';
						fail_border(fName);
					}
					return false;
				}
			}
			else
			{
				return true;
			}
		}
		if(type=='equal')
		{
		
			FfName = fName[0];
			LfName = fName[1];
			var FcurField = document.forms[formName].elements[FfName];
			var LcurField = document.forms[formName].elements[LfName];	
			if($.trim(FcurField.value) != '')
			{
				if($.trim(FcurField.value)==$.trim(LcurField.value))
				{
					document.getElementById('error_'+LfName).innerHTML = '';
					return true;
				}
				else
				{
					var chkvalue = document.getElementById('error_'+LfName).innerHTML.trim();
					if(chkvalue == '')
					{				
						document.getElementById('error_'+LfName).innerHTML = 'sholud be same';
						fail_border(LfName);
					}					
					return false;
				}
			}
			else
			{
				return true;
			}
		}
		if(type=='notequal')
		{			
			var FfName = fName[0];	
			var Fvalue = document.forms[formName].elements[FfName].value;
			var Tvalue = fName[1];
			
			if(Fvalue!=Tvalue)
			{			
				elem = document.forms[formName].elements[FfName].setAttribute("style","border: 1px solid #ccc; box-shadow: none;");
				return true;
			}
			else
			{				
				elem = document.forms[formName].elements[FfName].setAttribute("style","border: 1px solid #EF672F; box-shadow: 0 0 2px #EF672F;");	
				return false;
			}			
		}
    }
}
	
/*END*/


function success_border(id)
{
	$('#'+id).removeClass('input__error');
	// elem = document.getElementById(id);
	// elem.setAttribute("style","border: 1px solid #D3D3D3; box-shadow: none;");
	// document.getElementById('error_'+id).innerHTML = '';
	// document.getElementById('error_'+id).style.display = 'none';
}

function fail_border(id)
{
	$('#'+id).addClass('input__error');
	// elem = document.getElementById(id);
	// elem.setAttribute("style","border: 1px solid #EF672F; box-shadow: 0 0 2px #EF672F;");	
	// document.getElementById('error_'+id).style.display = 'block';	
}

function focus_border(id)
{
	elem = document.getElementById(id);
	elem.setAttribute("style","outline:none; border-color: #4D90FE; box-shadow: 0 0 2px #4D90FE;");
}
function back_toclearBorder(id)
{
	elem = document.getElementById(id);
	elem.setAttribute("style","border: 1px solid #D3D3D3; box-shadow: none;");
}


/* Deparment */
function departmentaddpopup()
{
    popupcontent_ajax('<div class="image_loader" style=""></div>');

    var url = path + "/index.php/Department/add";
    $.post(url, {}, function (data) {
        if (data != '')
        {
            popupcontent_injection(data);
        }
        else
        {
            var form = 'Invalid Request';
        }
    });
}
function departmenteditpopup(department_id)
{
    popupcontent_ajax('<div class="image_loader" style=""></div>');

    var url = path + "/index.php/Department/edit";
    $.post(url, {department_id: department_id}, function (data) {
        if (data != '')
        {
            popupcontent_injection(data);
        }
        else
        {
            var form = 'Invalid Request';
        }
    });
}

function useraddpopup()
{
    popupcontent_ajax('<div class="image_loader" style=""></div>');

    var url = path + "/index.php/User/add";
    $.post(url, {}, function (data) {
        if (data != '')
        {
            popupcontent_injection(data);
        }
        else
        {
            var form = 'Invalid Request';
        }
    });
}
function usereditpopup(id)
{
    popupcontent_ajax('<div class="image_loader" style=""></div>');

    var url = path + "/index.php/User/edit";
    $.post(url, {id: id}, function (data) {
        if (data != '')
        {
            popupcontent_injection(data);
        }
        else
        {
            var form = 'Invalid Request';
        }
    });
}

/*--- function role mapping ---*/
function mappingaddpopup()
{
    popupcontent_ajax('<div class="image_loader" style=""></div>');

    var url = path + "/index.php/Function_role_mapping/add";
    $.post(url, {}, function (data) {
        if (data != '')
        {
            popupcontent_injection(data);
        }
        else
        {
            var form = 'Invalid Request';
        }
    });
}
function mappingeditpopup(id)
{
	var ids = id.split("_");
	var mapping_id = ids[0];
	var category_id = ids[1];
	var role_id = ids[2];
	var department_id = ids[1];
	
    popupcontent_ajax('<div class="image_loader" style=""></div>');

    var url = path + "/index.php/Function_role_mapping/edit";
    $.post(url, {mapping_id: mapping_id, category_id:category_id, role_id:role_id, department_id:department_id}, function (data) {
        if (data != '')
        {
            popupcontent_injection(data);
        }
        else
        {
            var form = 'Invalid Request';
        }
    });
}

function get_existing_username(sel)
{
	var username = sel.value;

	var pathstring = String(window.location);
	var patharray  = pathstring.split("/");		
	var path=patharray[0]+'//'+patharray[2]+'/'+patharray[3];
	var url = path+"/index.php/User/get_existing_username";	
	var email = document.getElementById('email').value;
	
	$.post(url,{username:username, email:email},function(data) {	//alert(data);
		if(data=='existing')
		{
			$('#error_username').html("Username Already Exists");
		}
		else
		{
			$('#error_username').html("");
		}
	});
}

function roleaddpopup()
{
    popupcontent_ajax('<div class="image_loader" style=""></div>');

    var url = path + "/index.php/Role/add";
    $.post(url, {}, function (data) {
        if (data != '')
        {
            popupcontent_injection(data);
        }
        else
        {
            var form = 'Invalid Request';
        }
    });
}
function roleeditpopup(id)
{
    popupcontent_ajax('<div class="image_loader" style=""></div>');

    var url = path + "/index.php/Role/edit";
    $.post(url, {id: id}, function (data) {
        if (data != '')
        {
            popupcontent_injection(data);
        }
        else
        {
            var form = 'Invalid Request';
        }
    });
}

function categoryaddpopup()
{
    popupcontent_ajax('<div class="image_loader" style=""></div>');

    var url = path + "/index.php/Category/add";
    $.post(url, {}, function (data) {
        if (data != '')
        {
            popupcontent_injection(data);
        }
        else
        {
            var form = 'Invalid Request';
        }
    });
}
function categoryeditpopup(id)
{
    popupcontent_ajax('<div class="image_loader" style=""></div>');

    var url = path + "/index.php/Category/edit";
    $.post(url, {id: id}, function (data) {
        if (data != '')
        {
            popupcontent_injection(data);
        }
        else
        {
            var form = 'Invalid Request';
        }
    });
}


function get_user_role(category_id)
{
    var url = path + "/index.php/User/get_user_category_role";
    $.post(url, {category_id:category_id}, function (data) {
    	if(document.getElementById('category_'+category_id).checked === true)
    	{
	        if (data != '')
	        {
	            $('#category_dept_'+category_id).html(data);
	        }
	        else
	        {
	            $('#category_dept_'+category_id).html('No Data Found');
	        }
	    }
	    else
	    {
	    	$('#category_dept_'+category_id).html('');
	    	$('.category_dept_role').html('');
	    }
    });
}

function get_category_role(category_id)
{
    var url = path + "/index.php/Department/get_category_role";
    $.post(url, {category_id:category_id}, function (data) {
        if (data != '')
        {
            $('#category_role').html(data);
        }
        else
        {
            $('#category_role').html('No Data Found');
        }
    });
}

function get_function_role_department(category_id)
{
    var url = path + "/index.php/Function_role_mapping/get_fn_category_role";
    $.post(url, {category_id:category_id}, function (data) {

        if (data != '')
        {
            $('#fn_role_dept').html(data);
        }
        else
        {
            $('#fn_role_dept').html('No Data Found');
        }

    });
}