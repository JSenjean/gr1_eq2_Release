<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <b><a class="navbar-brand" href='index.php?action=selectedProject&projectId=<?php echo($projectId) ?>'>Vue générale</a></b>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <b><a class="nav-item nav-link" href="index.php?action=selectedProject&projectId=<?php echo($projectId) ?>&page=backlog">Backlog</a></b>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <b><a class="nav-item nav-link" href="index.php?action=selectedProject&projectId=<?php echo($projectId) ?>&page=sprints">Sprints</a></b>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <b><a class="nav-item nav-link" href="index.php?action=selectedProject&projectId=<?php echo($projectId) ?>&page=tests">Tests</a></b>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <b><a class="nav-item nav-link" href="index.php?action=selectedProject&projectId=<?php echo($projectId) ?>&page=doc">Documentation</a></b>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <b><a class="nav-item nav-link" href="index.php?action=selectedProject&projectId=<?php echo($projectId) ?>&page=release">Release</a></b>
            </li>
        </ul>
  </div>
</nav>