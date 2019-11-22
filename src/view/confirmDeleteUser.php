<?php

echo <<<confirm

<div class="card text-center">
  <div class="card-body">
    <h4 class="card-title">Attention !</h4>
    <h6 class="card-subtitle mb-2 text-muted">Votre compte est sur le point d'être supprimé.</h6>
    <p class="card-text">Cette action est définitive, veuillez confirmer cette action :</p>
    <a href="index.php?action=deleteAccountConfirmed" class="btn btn-danger" >Supprimer le compte</a>
    <a href="index.php?action=profile" class="btn btn-secondary mr-2" >Retour</a>
  </div>
</div>

</body>
</html>

confirm;

?> 