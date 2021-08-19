// JavaScript Document
   var a = Math.ceil(Math.random() * 9)+ '';
    var b = Math.ceil(Math.random() * 9)+ '';      
    var c = Math.ceil(Math.random() * 9)+ ''; 
    var d = Math.ceil(Math.random() * 9)+ ''; 
    var e = Math.ceil(Math.random() * 9)+ ''; 

    var code = a + b + c + d + e;
    document.getElementById("txtCaptcha").value = code;
    document.getElementById("txtCaptchaDiv").innerHTML = code; 



function checkform(theform){
    var why = "";
    if(theform.txtInput.value == ""){
        why += "Verification code should not be empty.\n";
    }
    if(theform.txtInput.value != ""){
        if(ValidCaptcha(theform.txtInput.value) == false){
            why += "Verification code did not match.\n";
        }
    }
    if(why != ""){
        alert(why);
        return false;
    }

}
function ValidCaptcha(){
    var str1 = removeSpaces(document.getElementById('txtCaptcha').value);
    var str2 = removeSpaces(document.getElementById('txtInput').value);
    if (str1 == str2){
        return true;   
    }else{
        return false;
    }
}

function removeSpaces(string){
    return string.split(' ').join('');
}