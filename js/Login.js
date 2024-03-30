function Verfiy(){
    var name,password;
    name=document.forms["form"]["Name"].value;
    password=document.forms["form"]["password"].value;
    if (name=="Ahmed"  &&  password=="123")
    {
        open("Users.html");
    }
    else
    {
        console.log(name);
        console.log(password);
        alert ("Username or password is wrong");
    }

}