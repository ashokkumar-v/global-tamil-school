function valid_chk()
{
	var why = "";

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

	



};

 