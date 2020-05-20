function getValidate(form){
    var login = form.login.value;
    var password = form.password.value;
    var email = form.email.value;
    if(login == ""){
	alert("Ћогин не введен");
	return false;
    }
    if(password == ""){
	alert("ѕароль не введен");
	return false;
    }
    if(email == ""){
	alert("E-mail не введен");
	return false;
    }else{
	var regV = /[A-Za-z0-9\-\_]{2,30}\@[A-Za-z0-9\-\_]{2,30}\.[A-Za-z0-9]{2,4}/;
	var result = email.match(regV);
	if(!result){
	    alert("¬ведите корректный email");
	    return false;
	}

    }
}


