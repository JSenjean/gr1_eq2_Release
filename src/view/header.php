<!DOCTYPE html>
<html>
<head>
  <title>WaterScrum</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/x-icon" href="view/favicon.ico" />

  <script>
    $(document).ready(function(){

        $("#InputLogin1").keyup(function(){
          var usrname = $("#InputLogin1").val().trim();
          console.log(usrname);
          
          if(usrname != ''){
            $("#usrname_response").show();

            $.ajax({
              url: 'signUpCheck.php',
              type: 'post',
              data: {usrname:usrname, action:'usrname'},
              success: function(response){

                // Show status
                if(response > 0){
                  $("#usrname_response").html("<span class='text-danger'>Identifiant déjà utilisé.</span>");
                  $("#InputLogin1").removeClass('is-valid').addClass('is-invalid');
                }else{
                  $("#usrname_response").html("<span class='text-success'>Identifiant disponible.</span>");
                  $("#InputLogin1").removeClass('is-invalid').addClass('is-valid');
                }
              },
              
            });

          }else{
            $("#usrname_response").hide();
          }
        });

        $("#InputEmail").keyup(function(){
          var mail = $("#InputEmail").val().trim();

          if(mail != ''){
            $("#mail_response").show();

            $.ajax({
              url: 'signUpCheck.php',
              type: 'post',
              data: {mail:mail, action:'mail'},
              success: function(response){

                // Show status
                if(response > 0){
                  $("#mail_response").html("<span class='text-danger'>Email déjà utilisé.</span>");
                  $("#InputEmail").removeClass('is-valid').addClass('is-invalid');
                }else{
                  $("#mail_response").html("<span class='text-success'>Email disponible.</span>");
                  $("#InputEmail").removeClass('is-invalid').addClass('is-valid');
                }

              }
            });

          }else{
            $("#mail_response").hide();
          }
        });

    });
  </script>

</head>

<body class="container pt-5 mt-3">
<header>
  <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]" ?>">WaterScrum</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-item nav-link" href="index.php?action=faq">FAQ</a>
          </li>
        </ul>
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#"> <span class="sr-only">(current)</span></a>
          </li>
        </ul>
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-item nav-link" data-toggle="modal" data-target="#signupModal" href="#">Inscription</a>
          </li>
          <li class="nav-item">
            <a class="nav-item nav-link" data-toggle="modal" data-target="#loginModal" href="#">Connexion</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>



<!-- SIGN UP -->
<div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="signUpModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="signUpModalLabel">Inscription</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" data-toggle="validator" action="index.php?action=signup">
          <div class="form-group">
            <label for="InputLogin1">Identifiant</label>
            <input type="text" class="form-control" id="InputLogin1" placeholder="Entrez un identifiant" name="username" required>
            <div id="usrname_response" class="valid-feedback"></div>
          </div>
          <div class="form-group form-row">
            <div class="col">
              <label for="InputFirstname">Prénom</label>
              <input type="text" class="form-control" id="InputFirstname" placeholder="Entrez votre prénom" name="firstname" required>
            </div>
            <div class="col">
              <label for="InputLastname">Nom</label>
              <input type="text" class="form-control" id="InputLastname" placeholder="Entrez votre nom" name="lastname" required>
            </div>
            
          </div>
          <div class="form-group form-row">
            <div class="col">
              <label for="InputEmail">Email</label>
              <input type="email" class="form-control" id="InputEmail" placeholder="name@example.com" name="email" required>
              <div id="mail_response" class="valid-feedback"></div>
            </div>
            <div class="col">
              <label for="InputEmail2">Confirmation de l'email</label>
              <input type="email" class="form-control" id="InputEmail2" placeholder="name@example.com" name="email2" required>
            </div>
          </div>
          <div class="form-group form-row">
            <div class="col">
              <label for="InputPassword1">Mot de passe</label>
              <input type="password" class="form-control" id="InputPassword1" placeholder="Entrez un mot de passe" name="password" required>
            </div>
            <div class="col">
              <label for="InputPassword2">Confirmation du mot de passe</label>
              <input type="password" class="form-control" id="InputPassword2" placeholder="Confirmez le mot de passe" name="password2" required>
            </div>
          </div>
          <button type="submit" class="btn btn-primary btn-block" name="submit">Inscription</button>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- LOG IN -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Connexion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="index.php?action=login">
          <div class="form-group">
            <label for="InputLogin2">Identifiant ou email</label>
            <input type="text" class="form-control" id="InputLogin2" placeholder="Entrez votre identifiant ou votre adresse mail" name="login" required>
          </div>
          <div class="form-group">
            <label for="InputPassword3">Mot de passe</label>
            <input type="password" class="form-control" id="InputPassword3" placeholder="Entrez votre mot de passe" name="password" required>
          </div>
          <button type="submit" class="btn btn-primary" name="submit">Connexion</button>
          <a class="btn btn-link" href="index.php?action=resetPassword&enterMailResetPassword=1" role="button">Mot de passe oublié ?</a>
        </form>
      </div>
    </div>
  </div>
</div>