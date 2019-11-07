<?php

echo <<<notAdmin

<div class="alert alert-danger">
  <strong>Erreur !</strong> Vous devez être administrateur pour accéder à cette page.
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

notAdmin;

?>