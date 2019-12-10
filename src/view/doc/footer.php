
        </div>
    </div>

</div>


<script>
    $('#addtodo').change(function() {
        $this.stopPropagation();
        if($('#displaytodo').prop('checked')) {
            $('#addtodo').show();
        } else {
            $('#addtodo').hide();
        }
    });
    
    $('#deprecated').change(function() {
        if($('#displaydeprecated').prop('checked')) {
            $('#adddeprecated').show();
        } else {
            $('#adddeprecated').hide();
        }
    });
    
    $('#adddone').change(function() {
        if($('#displaydone').prop('checked')) {
            $('#adddone').show();
        } else {
            $('#adddone').hide();
        }
    });

    var projectId=<?php echo $projectId ?>;

    function refreshDiv(state) {
        $.ajax({
            type: "POST",
            url: 'index.php?action=doc',
            data: {
                projectId: projectId,
                divToRefresh: state
            },
            success:
                function(response){
                    var div = '#add' + state
                    $(div).html(response);
                }
        });
    }

    function refreshProgressBar() {
        $.ajax({
            type: "POST",
            url: 'index.php?action=doc',
            data: {
                projectId: projectId,
                refreshProgressBar: true
            },
            success:
                function(response){
                    $('#progressBar').html(response);
                }
        });
    }

</script>
