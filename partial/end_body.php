   	<script type="text/javascript" src="<?=PLG?>jquery.idle/jquery.idle.js"></script>
    <script>
    $(document).idle({
        onIdle: function(){
            window.location="../login/logout.php";                
        },
        idle: 1000 * 1500 //1000 = 1 detik
    });
	</script>


</body>

</html>