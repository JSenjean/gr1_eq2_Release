
<div calss="row">


<label for="urlGit">URL github</label>
<input type="text" class="form-control" id="urlGit" value="<?php echo $gitUrl ?>">
<button class="btn btn-primary" type="button" id="changeGitUrl">changer de dépot git</button>


</div>

<div class="row pt-5">
<div class="col-sm col-lg-4 accordion" id="repo_list">
    <h1 id="title_repo_list"> les commits </h1> 
    <?php foreach ($commits as $commit) : ?>
        <div class='card' id='card<?php echo $commit["sha"] ?>'>
            <div class='card-header text-center' id='heading<?php echo $commit["sha"] ?>'>
                <button class='btn btn-link' type='button' data-toggle='collapse' data-target='#collapse<?php echo $commit["sha"] ?>' aria-expanded='false' aria-controls='collapse<?php echo $commit["sha"] ?>'>
                <?php echo $commit["committerName"] ?>
                </button>
                <h6 class='mb-0 text-center'>
                <?php echo $commit["commitDate"] ?>
                </h6>
            </div>
            <div id='collapse<?php echo $commit["sha"] ?>' class='collapse' aria-labelledby='heading<?php echo $commit["sha"] ?>' data-parent='#accordionRole'>
                <div class='card-body'><?php echo $commit["commitMessage"] ?></div>
                <div class='card-footer bg-white text-right'>
                    <a class='btn btn-primary' href='<?php echo $commit["commitUrl"] ?>' target='_blank' role='button'>voir sur GitHub <i class='fas fa-arrow-right' style='color:white'></i></a>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>
<div class="col-sm col-lg-8 accordion" id="release_list">
<h1 id="title_release_list"> les releases </h1> 
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/showdown@1.9.0/dist/showdown.min.js" ></script>


<script>
$(document).ready(function() {
var projectId= <?php echo $projectId; ?>;


var lastCommitDate = <?php echo ($lastCommit != null) ? "'" . $lastCommit . "'" : "null"  ?>;

if($("#urlGit").val()!="")
{
prepareGetRelease();
prepareGetCommits();
}

function checkUrl(urlToCheck)
{
    var pattern = new RegExp('^(https?:\\/\\/)?' + // protocol
        '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // domain name
        '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
        '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // port and path
        '(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
        '(\\#[-a-z\\d_]*)?$', 'i'); // fragment locator

    return pattern.test(urlToCheck);
}

function prepareGetCommits() {
    var allCommits = new Array();
    var urlGit = $("#urlGit").val();

    if (!checkUrl(urlGit)) {
        alert("ce n'est pas une url valide");
    } else {

        var urlPart = urlGit.split("/");

        name = urlPart[3];
        repo = urlPart[4];
        getLastCommit(1, name, repo, allCommits);
    }
};



function getLastCommit(iteration, name, repo, allCommits) {
    since= (lastCommitDate!=null) ? "&since=" + lastCommitDate + "Z" :""
    $.ajax({
        type: "GET",
        /*headers: {
            'Authorization': `token b77f80cd817e370705ea022823a85c5db901e6f9`,
        },*/
        url: "https://api.github.com/repos/" + name + "/" + repo + "/commits?per_page=100" + since + "&page=" + iteration,
        dataType: "json",
        success: function(result) {
            allCommits[iteration] = result;
            if (result.length == 100) {
                newIt = iteration + 1;
                getLastCommit(newIt, name, repo,allCommits);
            } else {
                displayCommit(allCommits);
                saveCommit(allCommits);
            }

        }
    });
}

function displayCommit(allCommits) {
    var htmlToWrite = "";
    var date;
    allCommits.forEach(oneResult => {
        oneResult.forEach(oneCommit => {
            date = new Date(oneCommit.commit.author.date);

            htmlToWrite += "<div class='card border-success border-width-3px' id='card" + oneCommit.sha + "'>"
            htmlToWrite += "<div class='card-header text-center' id='heading" + oneCommit.sha + "'>"
            htmlToWrite += "<button class='btn btn-link' type='button' data-toggle='collapse' data-target='#collapse" + oneCommit.sha + "' aria-expanded='false' aria-controls='collapse" + oneCommit.Sha + "'>"
            htmlToWrite += oneCommit.commit.author.name
            htmlToWrite += "</button>"
            htmlToWrite += "<h6 class='mb-0 text-center'>"
            htmlToWrite += date.toLocaleString();
            htmlToWrite += "</h6>"
            htmlToWrite += "</div>"
            htmlToWrite += "<div id='collapse" + oneCommit.sha + "' class='collapse' aria-labelledby='heading" + oneCommit.sha + "' data-parent='#accordionRole'>"
            htmlToWrite += "<div class='card-body'>" + oneCommit.commit.message + "</div>"
            htmlToWrite += "<div class='card-footer bg-white text-right'>"
            htmlToWrite += "<a class='btn btn-primary' href='" + oneCommit.html_url + "' target='_blank' role='button'>voir sur GitHub <i class='fas fa-arrow-right' style='color:white'></i></a>"
            htmlToWrite += "</div>"
            htmlToWrite += "</div>"
            htmlToWrite += "</div>"
            $(htmlToWrite).insertAfter("#title_repo_list");
            htmlToWrite = "";
        });
    });
}

function saveCommit(allCommits) {

    $.ajax({
        type: "POST",
        url: 'index.php?action=release',
        data: {
            saveCommit: "exist",
            projectId: projectId,
            allCommits: JSON.stringify(allCommits),

        },
        success: function(result) {
        }
    });

}


function prepareGetRelease() {
    
    var urlGit = $("#urlGit").val();

    if (!checkUrl(urlGit)) {
        alert("ce n'est pas une url valide");
    } else {

        var urlPart = urlGit.split("/");

        name = urlPart[3];
        repo = urlPart[4];
        getLastRelease(name, repo);
    }
};

function getLastRelease(name, repo) {


$.ajax({
    type: "GET",
    /*headers: {
        'Authorization': `token 288f795f97ebc8b6c5a487a4cec5e89f3f2eaef6`,
    },*/
    url: "https://api.github.com/repos/" + name + "/" + repo + "/releases",
    dataType: "json",
    success: function(result) {
         displayRelease(result);;
        }
    });
}


function displayRelease(releases)
{
    var htmlToWriteRealease ="";
    var converter = new showdown.Converter({tables: true});
    var date;
    releases.forEach(oneRelease => {
        date = new Date(oneRelease.published_at);
        htmlToWriteRealease += "<div class='card' id='card" + oneRelease.id + "'>"
        htmlToWriteRealease += "<div class='card-header text-center' id='heading" + oneRelease.id + "'>"
        htmlToWriteRealease += "<button class='btn btn-link' type='button' data-toggle='collapse' data-target='#collapse" + oneRelease.id + "' aria-expanded='false' aria-controls='collapse" + oneRelease.id + "'>"
        htmlToWriteRealease += oneRelease.tag_name
        htmlToWriteRealease += "</button>"
        htmlToWriteRealease += "<h6 class='mb-0 text-center'>"
        htmlToWriteRealease += date.toLocaleString();
        htmlToWriteRealease += "</h6>"
        htmlToWriteRealease += "</div>"
        htmlToWriteRealease += "<div id='collapse" + oneRelease.id + "' class='collapse' aria-labelledby='heading" + oneRelease.id + "' data-parent='#accordionRole'>"
        htmlToWriteRealease += "<div class='card-body' style='max-height: 500px; overflow: auto;'>" + converter.makeHtml(oneRelease.body) + "</div>"
        htmlToWriteRealease += "<div class='card-footer bg-white text-right'>"
        htmlToWriteRealease += "<a class='btn btn-primary' href='" + oneRelease.html_url + "' target='_blank' role='button'>voir sur GitHub <i class='fas fa-arrow-right' style='color:white'></i></a>"
        htmlToWriteRealease += "<a class='btn btn-primary' href='" + oneRelease.zipball_url + "' target='_blank' role='button'>telecharger la release <i class='fas fa-arrow-right' style='color:white'></i></a>"
        htmlToWriteRealease += "</div>"
        htmlToWriteRealease += "</div>"
        htmlToWriteRealease += "</div>"

        $("#release_list").append(htmlToWriteRealease);
        htmlToWriteRealease="";
    });

}




$("#changeGitUrl").click(function(){   
    var urlGit = $("#urlGit").val();
    if (!checkUrl(urlGit)) {
        alert("ce n'est pas une url valide");
    } else {
        confirm=window.confirm("Cette action entraînera la suppression de tous les commit sauvegardés sur le site. Confirmez-vous ?");
        if (confirm==1) {
            
            saveGitUrl(urlGit);
           

        }
    }

})

function saveGitUrl(urlGit)
{
    $.ajax({
        type: "POST",
        url: 'index.php?action=release',
        data: {
            saveGitUrl: urlGit,
            projectId: projectId,

        },
        success: function(result) {
            location.reload()
        }
    });
}

});
</script>