var shown=false;
function showhideEmail(){
	if(shown){
		document.getElementById("email").innerHTML ="Show my emial";
		shown=false;
	}
	else{
		var myemail="<a href='mailto:bhavansr"+"0"+"ucmail.uc.edu'>bhavansr"+
		"@"+"ucmail.uc.edu</a>";
		document.getElementById('email').innerHTML = myemail;
		shown=true;
	}
}
