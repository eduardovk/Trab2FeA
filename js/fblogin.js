window.fbAsyncInit = function() {
    FB.init({
        appId      : '866877217157004',
        xfbml      : true,
        version    : 'v7.0'
    });
    FB.AppEvents.logPageView();
};

(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function checkLoginState() {
    FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
    });
}

function statusChangeCallback(response){
    if(response.status === 'connected'){
        console.log("Usuário Autorizado");
        console.log("User ID: ", response.authResponse.userID);
        console.log("Token: ", response.authResponse.accessToken);
        var id = response.authResponse.userID;
        var token = response.authResponse.accessToken;
        localStorage.setItem('userToken', token)
        app.user.userToken = token;
        app.user.userID = id;
        localStorage.setItem('userID', id)
        requestAPI();
    }else{
        console.log("Usuário Não Autorizado");
    }
}

function requestAPI(){
    FB.api('me?fields=id,name,email,birthday', function(response){
        if(response){
            console.log(response);
            localStorage.setItem('userName', response.name)
            app.user.userName = response.name;
            localStorage.setItem('email', response.email)
            app.user.email = response.email;
            app.logado = true;
        }
    })
}
