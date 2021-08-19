function valid_chk()
{
	var why = "";
	
if(document.form.name.value=="" || document.form.name.value=="Name")
{
alert("Please enter Your Name")
document.form.name.focus()
return false;
}
if(document.form.mob.value=="" || document.form.mob.value=="Mobile No")
{
alert("Please Enter Mobile No")
document.form.mob.focus()
return false;
}

var reg = document.form.mob.value.length;
		
if (reg<10||reg>10) 
{
alert('Enter 10digit Mobile number');
document.form.mob.focus()
return false;
}

if(document.form.pro.value=="" || document.form.pro.value=="")
{
alert("Please Select Admission")
document.form.pro.focus()
return false;
}

if(document.form.email.value==""  || document.form.email.value=="Email Id")
{
alert("Please enter your E-mail ID")
document.form.email.focus()
return false;
}

 var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		
		

        if (reg.test(document.form.email.value) == false) 
        {
            alert('Invalid Email Address');
			document.form.email.focus()
            return false;
        }

	


if(document.form.message.value=="" || document.form.message.value=="Write Your Message")
{
alert("Please Enter Your Message")
document.form.message.focus()
return false;
}


if(document.form.txtInput.value == ""){
			why += "Verification code should not be empty.\n";
		}
		if(document.form.txtInput.value != ""){
			if(ValidCaptcha(document.form.txtInput.value) == false){
				why += "Enter Captcha Code Here.\n";
			}
		}
		if(why != ""){
			alert(why);
			document.form.txtInput.focus()
			return false;
		}

}

function Isempty(obj)
{
  var objValue;
  objValue = obj.value.replace(/\s+$/,"");
  if(objValue.length == 0)
  {return true;}
  else{return false;}
}

//Trim
function trim(s) {
    return s.replace( /^\\s*/, "" ).replace( /\\s*$/, "" );
}

//DIGIT VALIDATION
function isDigits(argvalue) {
    argvalue = argvalue.toString();
    var validChars = "0123456789";
    var startFrom = 0;
    if (argvalue.substring(0, 2) == "0x") {
       validChars = "0123456789abcdefABCDEF";
       startFrom = 2;
    } else if (argvalue.charAt(0) == "0") {
       validChars = "01234567";
       startFrom = 1;
    }
    for (var n = 0; n < argvalue.length; n++) {
        if (validChars.indexOf(argvalue.substring(n, n+1)) == -1) return false;
    }
  return true;
}



function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : event.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }

 