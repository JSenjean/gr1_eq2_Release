<div class="clearfix">
    <a class="h1 text-dark card-link" href="index.php?action=faq">Questions fréquemment posées</a>
    <form class="float-right mt-2" action="index.php?action=faq" method="post">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Mot(s)-clés" name="search">
        <span class="input-group-append">
          <button type="submit" class="btn btn-outline-primary btn-search" name="search_faq">Rechercher</button>
        </span>
      </div>
    </form>
  </div>
  <br>

  <div id="accordion">
    <?php
    if (isset($_SESSION['role']) && ($_SESSION['role'] == 'admin')){
      echo 
        '<div class="card border-secondary">
          <div class="card-header text-white bg-secondary" id="heading00" data-toggle="collapse" data-target="#collapse00" aria-expanded="false" aria-controls="collapse00">
            <a class="text-light" href="#" data-toggle="collapse" aria-expanded="true">
              Outils d\'administration
            </a>
          </div>
          <div id="collapse00" class="collapse" aria-labelledby="heading00" data-parent="#accordion">
            <div class="card-body row">
            <div class="col-sm">

            <form method="POST" action="index.php?action=faq">
              <div class="form-group">
                <label for="select1">Sélectionner une catégorie</label>
                <select class="form-control" id="select2" name="category">';
                  $categories = getCategories();
                  foreach ($categories as $category):
                    echo '<option>'.$category['category'].'</option>';
                  endforeach;
                echo '</select>
              </div>
              <div class="form-group">
                <label for="exampleFormControlInput1">Question</label>
                <input type="text" class="form-control" name="question" required>
              </div>
              <div class="form-group">
                <label for="exampleFormControlTextarea1">Réponse</label>
                <textarea type="text" class="form-control" name="answer" rows="3" required></textarea>
              </div>
              <button type="submit" class="btn btn-primary btn-block" name="addQA">Poster</button>
            </form>  
            </div>
              <br>
              <div class="col-sm">
              <form method="POST" action="index.php?action=faq" class="pb-3">
                <label for="exampleFormControlInput1">Nouvelle catégorie</label>
                <div class="input-group">
                  <input type="text" class="form-control" name="category" placeholder="Nom" required>
                  <span class="input-group-append">
                    <button type="submit" class="btn btn-primary float-right" name="addCategory">Ajouter</button>
                  </span>
                </div>
              </form>
              <form method="POST" action="index.php?action=faq">
                <label for="exampleFormControlInput1">Supprimer une catégorie</label>
                <div class="input-group">
                  <select class="form-control" id="select1" name="category">';
                    $categories = getCategories();
                    foreach ($categories as $category):
                      echo '<option>'.$category['category'].'</option>';
                    endforeach;
                  echo '</select>
                  <span class="input-group-append">
                    <button type="button" class="btn btn-danger float-right" data-toggle="modal" data-target="#confirmDelCatModal">Supprimer</button>
                  </span>
                </div>
                
                <div class="modal fade" id="confirmDelCatModal" tabindex="-1" role="dialog" aria-hidden="true">
                   <div class="modal-dialog" role="document">
                     <div class="modal-content">
                       <div class="modal-header">
                         <h5 class="modal-title" id="exampleModalLabel">Confirmer la suppression</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                         </button>
                       </div>
                       <div class="modal-body">
                         <p>Cette action est irréversible, continuer ?</p>
                       </div>
                       <div class="modal-footer"> 
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                          <button type="submit" class="btn btn-danger float-right" name="delCategory">Supprimer</a>
                       </div>
                     </div>
                   </div>
                 </div>
              </form>
              </div>
            </div>
          </div>
        </div>
        <br>';
    }
    ?>

    <div class="row">
      <div class="col-md-auto">
        <div class="list-group" id="list-tab" role="tablist">
          <?php
            if (isset($search))
              echo '<a class="list-group-item list-group-item-action" id="list-searchresults-list" data-toggle="list" href="#searchresults" role="tab" aria-controls="searchresults">Recherche</a>';
            $categories = getCategories();
            foreach ($categories as $category):
              echo '<a class="list-group-item list-group-item-action" id="list-'.$category['category'].'-list" data-toggle="list" href="#'.$category['category'].'" role="tab" aria-controls="'.$category['category'].'">'.$category['category'].'</a>';
            endforeach;
          ?>
        </div>
        <br>
      </div>
      <div class="col-lg">
        <div class="tab-content" id="nav-tabContent">
          <?php
            if (isset($search)){
              echo '<div class="tab-pane fade show" id="searchresults" role="tabpanel" aria-labelledby="list-searchresults-list">';
              foreach ($search as $value): ?>
                <div class="card">
                  <div class="card-header" id="heading<?php echo $value['id']?>">
                    <a class="text-dark" href="#" data-toggle="collapse" data-target="#collapseSearch<?php echo $value['id']?>" aria-expanded="false" aria-controls="collapseSearch<?php echo $value['id']?>">
                      <?php echo $value['question']; ?>
                    </a>
                  </div>
                  <div id="collapseSearch<?php echo $value['id']?>" class="collapse" aria-labelledby="headingSearch<?php echo $value['id']?>" data-parent="#accordion">
                    <div class="card-body">
                      <?php echo(nl2br($value['answer'])); ?>
                    </div>
                    <?php
                      $QA_ID = $value['id'];
                      if (isset($_SESSION['role']) && ($_SESSION['role'] == 'admin')){
                        echo 
                          '<div class="card-footer bg-transparent">
                            <button type="button" class="btn btn-link p-0" data-toggle="modal" data-target="#editInfoModalSearch'.$value['id'].'">Modifier</button>
                            <button type="button" class="btn btn-link p-0 pl-2 text-danger" data-toggle="modal" data-target="#confirmDelModalSearch'.$value['id'].'">Supprimer</button>
                          </div>';
                       echo 
                          '<div class="modal fade" id="editInfoModalSearch'.$value['id'].'" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Modifier les informations</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <form method="POST" action="index.php?action=editQA&id='.$value['id'].'">
                                  <div class="modal-body">
                                      
                                    <div class="form-group">
                                      <label for="select1">Catégorie</label>
                                      <select class="form-control" id="select2" name="category">';
                                        $categories = getCategories();
                                        echo '<option selected>'.$value['category'].'</option>';
                                        foreach ($categories as $category):
                                          if ($category['category'] != $value['category'])
                                            echo '<option>'.$category['category'].'</option>';
                                        endforeach;
                                      echo '</select>
                                    </div>
                                      
                                      
                                    <div class="form-group">
                                      <label for="exampleFormControlInput1">Question</label>
                                      <textarea type="text" class="form-control" name="question" rows="2" required>'.$value['question'].'</textarea>
                                    </div>
                                    <div class="form-group">
                                      <label for="exampleFormControlTextarea1">Réponse</label>
                                      <textarea type="text" class="form-control" name="nswer" rows="5" required>'.$value['answer'].'</textarea>
                                    </div>
                                  </div>
                                  <div class="modal-footer"> 
                                    <button type="submit" class="btn btn-primary" name="submit">Modifier</button> 
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>';
                                      
                        echo 
                          '<div class="modal fade" id="confirmDelModalSearch'.$value['id'].'" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Confirmer la suppression</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p>Cette action est irréversible, continuer ?</p>
                                </div>
                                <div class="modal-footer"> 
                                  <a class="btn btn-danger float-right" href="index.php?action=delQA&id='.$value['id'].'" role="button">Supprimer</a>
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                </div>
                              </div>
                            </div>
                          </div>';
                      }
                    ?>
                </div>
            </div>
            <br>
            <?php 
              endforeach;
              echo '</div>';
            }

            $categories = getCategories();
            foreach ($categories as $category):
              $faq = getQA($category['category']);
              echo '<div class="tab-pane fade show" id="'.$category['category'].'" role="tabpanel" aria-labelledby="list-'.$category['category'].'-list">';
              foreach ($faq as $value): ?>
                <div class="card">      
                  <div class="card-header" id="heading<?php echo $value['id']?>">
                    <a class="text-dark" href="#" data-toggle="collapse" data-target="#collapse<?php echo $value['id']?>" aria-expanded="false" aria-controls="collapse<?php echo $value['id']?>">
                      <?php echo $value['question']; ?>
                    </a>
                  </div>
                  <div id="collapse<?php echo $value['id']?>" class="collapse" aria-labelledby="heading<?php echo $value['id']?>" data-parent="#accordion">
                    <div class="card-body">
                      <?php echo $value['answer']; ?>
                    </div>
                    <?php
                      $QA_ID = $value['id'];
                      if (isset($_SESSION['role']) && ($_SESSION['role'] == 'admin')){
                        echo 
                          '<div class="card-footer bg-transparent">
                            <button type="button" class="btn btn-link p-0" data-toggle="modal" data-target="#editInfoModal'.$value['id'].'">Modifier</button>
                            <button type="button" class="btn btn-link p-0 pl-2 text-danger" data-toggle="modal" data-target="#confirmDelModal'.$value['id'].'">Supprimer</button>
                          </div>';
                       echo 
                          '<div class="modal fade" id="editInfoModal'.$value['id'].'" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Modifier les informations</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <form method="POST" action="index.php?action=editQA&id='.$value['id'].'">
                                  <div class="modal-body">
                                      
                                    <div class="form-group">
                                      <label for="select1">Catégorie</label>
                                      <select class="form-control" id="select2" name="category">';
                                        $categories = getCategories();
                                        echo '<option selected>'.$value['category'].'</option>';
                                        foreach ($categories as $category):
                                          if ($category['category'] != $value['category'])
                                            echo '<option>'.$category['category'].'</option>';
                                        endforeach;
                                      echo '</select>
                                    </div>
                                      
                                      
                                    <div class="form-group">
                                      <label for="exampleFormControlInput1">Question</label>
                                      <textarea type="text" class="form-control" name="question" rows="2" required>'.$value['question'].'</textarea>
                                    </div>
                                    <div class="form-group">
                                      <label for="exampleFormControlTextarea1">Réponse</label>
                                      <textarea type="text" class="form-control" name="answer" rows="5" required>'.$value['answer'].'</textarea>
                                    </div>
                                  </div>
                                  <div class="modal-footer"> 
                                    <button type="submit" class="btn btn-primary" name="submit">Modifier</button> 
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>';
                                      
                        echo 
                          '<div class="modal fade" id="confirmDelModal'.$value['id'].'" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Confirmer la suppression</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p>Cette action est irréversible, continuer ?</p>
                                </div>
                                <div class="modal-footer"> 
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                  <a class="btn btn-danger float-right" href="index.php?action=delQA&id='.$value['id'].'" role="button">Supprimer</a>
                                </div>
                              </div>
                            </div>
                          </div>';
                      }
                    ?>
              </div>
            </div>
            <br>
            <?php 
              endforeach;
              echo '</div>';
              endforeach;
            ?>
        </div>
      </div>
    </div>
  </div>

  <script>
    $('#list-tab a:first-child').tab('show')
  </script>

</body>

</html>