 
 <form action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="application/x-www-form-urlencoded" method="post" id="frmdelete">

    <input type="hidden" name="pk_del_id" id="pk_del_id" value="" />
    <input type="submit" style="display:none" class="btn3" name="action" id="Delete" value="Delete">
 </form>
 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 <script>
    $('.btndelete').on('click', function(){
        debugger;
        var id = $(this).attr('id');
        $('#pk_del_id').val(id);
        if (confirm("Are you sure you want to delete record?")) {
				$("#Delete").click();
				  return false;
			}  
    });
    
</script>
</body>
</html>