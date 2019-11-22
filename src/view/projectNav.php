<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <strong><a class="navbar-brand" href='index.php?action=selectedProject&projectId=<?php echo $projectId ?>'>Vue générale</a></strong>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <strong><a class="nav-item nav-link" href="index.php?action=backlog&projectId=<?php echo $projectId ?>">Backlog</a></strong>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <strong><a class="nav-item nav-link" href="index.php?action=sprints&projectId=<?php echo $projectId ?>">Sprints</a></strong>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <strong><a class="nav-item nav-link" href="index.php?action=tests&projectId=<?php echo $projectId ?>">Tests</a></strong>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <strong><a class="nav-item nav-link" href="index.php?action=doc&projectId=<?php echo $projectId ?>">Documentation</a></strong>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <strong><a class="nav-item nav-link" href="index.php?action=release&projectId=<?php echo $projectId ?>">Release</a></strong>
            </li>
        </ul>
  </div>
</nav>