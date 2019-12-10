<div class="modal fade" id="linkUSToSprintModal" tabindex="-1" role="dialog" aria-labelledby="linkUSToSprintLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="linkUSToSprintLabel">Ajouter une User Story</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeCrossLinkUS">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" data-toggle="validator LinkUsToSprint" action="index.php?action=sprint" id="LinkUsToSprint">
                    <div class="form-group">
                        <select class="selectpicker multSelect" data-style="pb-4" id="multSelect" name="multSelect" multiple data-live-search="true">
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button id="validate" type="input" class="btn btn-primary validate">Valider</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    function removeElement(array, elem) {
        var index = array.indexOf(elem);
        if (index > -1) {
            array.splice(index, 1);
        }
    }
    $(document).ready(function() {
        var projectId = null;
        var sprintId = null;
        var SelectChildren = null;
        var allSelected = null;

        $("#linkUSToSprintModal").on("shown.bs.modal", function(event) {
            var button = $(event.relatedTarget);
            projectId = button.data('projectid');
            sprintId = button.data('sprintid');

            $.ajax({
                type: 'POST',
                url: 'index.php?action=sprints',
                data: {
                    getAllUS: true,
                    projectId: projectId
                },
                success: function(response) {
                    SelectChildren = $(".multSelect").parent().children("select").children();
                    if (SelectChildren.length != 0) {
                        for (let i = 0; i < SelectChildren.length; i++) {
                            $(SelectChildren[i]).remove();
                        }
                        $('.multSelect').selectpicker('refresh');
                    }
                    var us = JSON.parse(response);
                    var htmlToWrite = "";
                    var where = ".multSelect";
                    us.forEach(function(item) {
                        htmlToWrite += "<option style='display: none;' value='" + item['id'] + "' >" + item['name'] + "</option>";
                    });
                    $(where).append(htmlToWrite);

                    SelectChildren = $(".multSelect").parent().children("select").children();
                    for (let i = 0; i < SelectChildren.length; i++) {
                        $(SelectChildren[i]).show();
                    }
                    $('.multSelect').selectpicker('refresh');
                }
            })



            $.ajax({
                type: 'POST',
                url: 'index.php?action=sprints',
                data: {
                    linkedUS: true,
                    sprintId: sprintId
                },
                success: function(response) {
                    var us = JSON.parse(response);
                    allSelected = [];
                    us.forEach(function(item) {
                        allSelected.push(item['id']);
                    });
                    $('.multSelect').val(allSelected);
                    $('.multSelect').selectpicker('refresh');
                }
            })
        });

        $("#LinkUsToSprint").on('submit', function(event) {
            event.preventDefault();
            event.stopImmediatePropagation();

            var USToLink = $('#multSelect').val();
            var USToUnlink = new Array();
            for (let i = 0; i < allSelected.length; i++) {
                $curren_us_id = USToLink.find(us_id => us_id === allSelected[i]);
                if ($curren_us_id != undefined) {
                    removeElement(USToLink, $curren_us_id);
                } else {
                    USToUnlink.push(allSelected[i]);
                }
            }

            $.ajax({
                type: 'POST',
                url: 'index.php?action=sprints',
                data: {
                    linkUsToSprint: true,
                    USToLink: USToLink,
                    USToUnlink: USToUnlink,
                    sprintId: sprintId
                },
                 success: function(response) {
                    $('#closeCrossLinkUS').click();
                    $('.sprint[data-sprintid="'+ sprintId +'"]').click();
                 }
            })
        });
    });
</script>