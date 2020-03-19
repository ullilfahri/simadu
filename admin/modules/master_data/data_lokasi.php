<?php
include '../../../sysconfig.php';
if (isset($_GET['data'])) :
$sql=$conn->query("SELECT * FROM lokasi_antar");
?>

                           <div class="table-responsive">
                                <table id="example" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Jarak</th>
                                            <th>Tarif</th>
                                            <th>Premi</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
									$no=1;
                                    while ($x=$sql->fetch_array()) :
									
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><a href="#" class="live_edit" data-name="jarak" data-type="text" data-pk="<?=$x['id']?>" data-title="jarak"><?=$x['jarak']?></a></td>
                                            <td><a href="#" class="live_edit" data-name="tarif" data-type="text" data-pk="<?=$x['id']?>" data-title="tarif"><?=$x['tarif']?></a></td>
                                            <td><a href="#" class="live_edit" data-name="premi" data-type="text" data-pk="<?=$x['id']?>" data-title="premi"><?=$x['premi']?></a></td>
                                            <td><a href="#" class="aktif" data-pk="<?=$x['id']?>" data-name="non_aktif" data-type="select" data-value="<?=$x['non_aktif']?>"></a></td>
                                        </tr>
                                   <?php endwhile;?>     
                                    </tbody>
                                </table>
                            </div>
                            

<script type="text/javascript">
    $('.live_edit').editable({
           url: '../global/update.php?live_edit&tabel=lokasi_antar&jenis_id=id',
           type: 'text',
           pk: 1,
           name: 'name',
           title: 'Enter name'
    });	
</script>
<script type="text/javascript">
var source = [{'value': 0, 'text': 'Aktif'}, {'value': 1, 'text': 'Non Aktif'}];

	$('.aktif').editable({
           url: '../global/update.php?live_edit&tabel=lokasi_antar&jenis_id=id',
           type: 'text',
           pk: 1,
           name: 'name',
           title: 'Status :',
    	   source: function() {return source;}
});

$(document).ready(function() {      
    var table = $('#example').DataTable({
       order: [[ 3, 'asc' ]],
       drawCallback: function(settings){
          var api = this.api();    
		var source = [{'value': 0, 'text': 'Aktif'}, {'value': 1, 'text': 'Non Aktif'}];

		$('.stok_aktif').editable({
           url: '../global/update.php?live_edit&tabel=lokasi_antar&jenis_id=id',
           type: 'text',
           pk: 1,
           name: 'name',
           title: 'Status :',
    	   source: function() {return source;}
		});

       }
    });    
    
} );

</script>

<?php
endif;

if (isset($_GET['simpan'])) :

$jarak = $_POST['jarak'];
$premi = preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['premi']);
$tarif = preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['tarif']);

$masuk=$conn->query("INSERT INTO `lokasi_antar`(`jarak`, `tarif`, `premi`) VALUES ('$jarak', '$tarif', '$premi')");

if ($masuk) {
echo json_encode(array('status' =>true, 'pesan' =>'Berhasil Menyinmpan Data Lokasi Antar'));
} else {
echo json_encode(array('error' =>true, 'pesan' =>'Gagal Menyinmpan Data Lokasi Antar'));
}

endif;
?>
