<div class="panel-body">
                            <div class="col-md-6">
                               
                                <div class="form-group">
                                    <label>Pilih Foto / Gambar</label>
                                    <input type="file" id="fupload" />
                                </div>                         
                                <button type="submit" name="ubah_foto" class="btn btn-primary simpan">Submit Button</button>
                                <button type="reset" class="btn btn-default">Reset Button</button>
                            </div>
                            <div class="col-md-6" id="hasil" style="display:none;"><img src="#" id="tampil" /></div>
                            </div>                            
                            
<script type="text/javascript">
        function readURL(input){
        if(input.files && input.files[0]){
        var reader = new FileReader();
        reader.onload = function(e){
        $('#tampil').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
        }
        }
        $("#fupload").change(function(){
        readURL(this);
        $('#hasil').show();
                });
</script>