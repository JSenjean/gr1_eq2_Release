
        </div>
    </div>

</div>


<script>
    $('#addfailed').change(function() {
        $this.stopPropagation();
        if($('#displayfailed').prop('checked')) {
            $('#addfailed').show();
        } else {
            $('#addfailed').hide();
        }
    });
    
    $('#deprecated').change(function() {
        if($('#displayfailed').prop('checked')) {
            $('#adddeprecated').show();
        } else {
            $('#adddeprecated').hide();
        }
    });
    
    $('#addneverrun').change(function() {
        if($('#displayneverrun').prop('checked')) {
            $('#addneverrun').show();
        } else {
            $('#addneverrun').hide();
        }
    });
    
    $('#addpassed').change(function() {
        if($('#displaypassed').prop('checked')) {
            $('#addpassed').show();
        } else {
            $('#addpassed').hide();
        }
    });

    var projectId=<?php echo $projectId ?>;

    function refreshDiv(state) {
        $.ajax({
            type: "POST",
            url: 'index.php?action=tests',
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
            url: 'index.php?action=tests',
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
