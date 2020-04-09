<script type = "text/javascript" >
window.history.pushState({page: 1}, "", "");
window.onpopstate = function(event) {
  if(event){
    swal({
		html: true,
        title: "Keluar",
        text: "Tekan OK Untuk Logout",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
    }, function () {
		window.location.href = '../login/logout.php';
    
	});
  }
}
</script>    


    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Harap Tunggu Sejenak...</p>
        </div>
    </div>