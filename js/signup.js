//$(document).ready(function(){

	function emptyElement(x){
	_(x).innerHTML = "";
	}

	//Removes all unwanted Text/	
	function restrict(elem){
		var tf = _(elem);
		var rx = new RegExp;
		if (elem = "email") {
			rx = /[" "]/gi;
		}
		else if(elem == "username"){
			rx = /[^a-z0-9]/gi;
		}
		tf.value = tf.value.replace(rx, "");
	}



	function checkusername(){
		var u = _("username").value;
		if (u != "") {
			_("unamestatus").innerHTML = 'Checking...';

			var ajax = ajaxObj("POST", "signup.php");

			ajax.onreadystatechange = function(){
				if (ajaxReturn(ajax) == true ) {
					_("unamestatus").innerHTML = ajax.responseText;
				}
			}
			ajax.send("usernamecheck="+u);
		}
	}

	// function checkemail(){
	// 	var e = _("email").value;
	// 	if (e != "") {
	// 		_("estatus").innerHTML = 'Checking...';
	// 		setTimeout(3000);
	// 		var ajax = ajaxObj("POST", "signup.php");

	// 		ajax.onreadystatechange = function(){
	// 			if (ajaxReturn(ajax) == true ) {
	// 				_("estatus").innerHTML = ajax.responseText;
	// 			}
	// 		}
	// 		ajax.send("emailcheck="+e);
	// 	}
	// }


	// check the password:
	function checkpassword(){
		var p = _("pass1").value;
		if (p != "") {
			_("createpasswordStatus").innerHTML = 'Checking...';

			var ajax = ajaxObj("POST", "signup.php");
			ajax.onreadystatechange = function(){
				if (ajaxReturn(ajax) == true ) {
					_("createpasswordStatus").innerHTML = ajax.responseText;
				}
			}
			ajax.send("checkpassword="+p);
		}
	}

	function checkconfirmpassword(){
		let cp = _("pass2").value;
		if(cp != ""){
			_("confirmpasswordStatus").innerHTML = 'Checking...';

			var ajax = ajaxObj("POST", "signup.php");
			ajax.onreadystatechange = function(){
				if (ajaxReturn(ajax) == true ) {
					_("confirmpasswordStatus").innerHTML = ajax.responseText;
				}
			}
			ajax.send("checkconfirmpassword="+cp);
		}
	}

	// Here we check if everything is correct:
	function signup(){
		console.log("signup function has ran");

		var fn = _("firstname").value;
		var ln = _("lastname").value;

		var u = _("username").value;
		var e = _("email").value;
		var p1 = _("pass1").value;
		
		var c = _("country").value;
		var g = _("gender").value;
		var status = _("status");

		if (fn == "" || ln == "" || u == "" || e == "" || p1 == "" || c == "" || g == "") {
			status.innerHTML = "Please out all the form data";
		}else if(p1 < 7){
			status.innerHTML = "Password cannot be less than 8 charectors long";
		}else{

			// remove the signup button
			_("signupbtn").style.display = "none";
			status.innerHTML = "Please wait";
			
			var ajax = ajaxObj("POST", "signup.php");
			ajax.onreadystatechange = function(){
				if (ajaxReturn(ajax) == true ) {
					if (ajax.responseText != "signup_success") {
						status.innerHTML = ajax.responseText;
					}else{
						//when everything is okay:
						window.scrollTo(0,0);
						_("signupform").innerHTML = "Okay, "+u+"Veryfy your EmailAddress on your email "+e+".";
					}
				}
			}
			ajax.send("u="+u+"&fn="+fn+"&ln="+ln+"&e="+e+"&p="+p1+"&c="+c+"&g="+g);		
		}
	}// end of function

// });

