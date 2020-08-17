<script>
    do {
        var password = prompt('Enter valid password');
        $.ajax({
            url: '<?php echo base_url()?>/Ajax/runMigration',
            data: {
                'password' : password
            },
            type: 'POST',
            success: function (response) {
                alert(response);
            },
            error: function (err) {
                console.dir(err);
            }
        });
    } while(!password);
    
</script>