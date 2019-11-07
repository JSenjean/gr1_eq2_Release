<?php
include_once("header.php");
echo <<<index
  
  <div class="jumbotron">
    <h1 class="display-4">Bienvenue sur WaterScrum !</h1>
    <p class="lead">Vous n'êtes pas connecté.</p>
    <br>
    <div class="btn-group btn-block" role="group" aria-label="Basic example">
      <button type="button" class="btn btn-lg btn-outline-secondary" data-toggle="modal" data-target="#signupModal">Inscription</button>
      <button type="button" class="btn btn-lg btn-outline-primary" data-toggle="modal" data-target="#loginModal">Connexion</button>
    </div>
  </div>

</body>
</html>
index;
?>