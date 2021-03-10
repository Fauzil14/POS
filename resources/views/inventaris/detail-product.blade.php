@extends('layouts.admin-lte')

@section('styles')
  
@endsection

@section('content')

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Detail Produk</h1>
        </div>
        <div class="col-sm-6">
          <div class="d-flex justify-content-end">
            <a class="btn btn-default ng-binding mr-2" onClick="window.location.reload()"> <i class="fas fa-sync-alt"></i> </a>
          </div>
        </div>
      </div>
    </div>
    <!-- /.container-fluid -->
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
        
            <div class="card">
                <div class="card-header p-2">
                  <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Settings</a></li>
                  </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content">
                    
                    <div class="tab-pane" id="settings">
                    
                        <!-- form start -->
                      <form method="POST" action="{{ route('inventaris.new-product') }}" class="form-horizontal" id="tambah">
                        @csrf

                        <div class="card-body">
                          <p class="mb-1">Informasi Umum</p>
                          <hr class="mt-0">
                          <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="uid">UID</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" name="uid" id="uid" placeholder="Masukkan Kode Produk (Optional)">
                              <div class="alert-message" id="uidError" style="color: red;"></div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="merek">Merek</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" name="merek" id="merek" placeholder="Masukkan merek Produk">
                              <div class="alert-message" id="merekError" style="color: red;"></div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="nama">Nama</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan nama Produk">
                              <div class="alert-message" id="namaError" style="color: red;"></div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-5">
                              <div class="form-group">
                                <label class="col-sm-6 col-form-label" for="category_id">Kategori</label>
                                <div class="col-sm">
                                    <!-- select -->
                                      <select class="custom-select" id="category_id" name="category_id">
                                        <option selected disabled>Pilih Kategori Produk</option>
                                        @foreach ($categories as $category)
                                          <option value="{{ $category->id }}">{{ ucfirst($category->category_name) }}</option>
                                        @endforeach
                                      </select>
                                </div>
                                <div class="alert-message" id="categoryIdError" style="color: red;"></div>
                              </div>
                            </div>
                            <div class="col-sm-7">
                              <div class="form-group">
                                <label class="col-sm-6 col-form-label" for="supplier_id">Supplier</label>
                                <div class="col-sm">
                                    <!-- select -->
                                    <select class="custom-select" id="supplier_id" name="supplier_id">
                                      <option selected disabled>Pilih supplier</option>
                                      @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ ucfirst($supplier->nama_supplier) }}</option>
                                      @endforeach
                                    </select>
                                </div>
                                <div class="alert-message" id="supplierIdError" style="color: red;"></div>
                              </div>
                            </div>
                          </div>
                          <p class="mb-0 mt-4">Kalkulasi Harga</p>
                          <hr class="mt-0 mb-1">
                          <div class="row">
                            <div class="col-sm-5">
                              <div class="form-group">
                                <label class="col-sm-4 col-form-label" for="harga_beli">Harga beli</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                  </div>
                                    <input type="number" class="form-control" id="harga_beli" name="harga_beli">
                                  </div>
                                  <div class="alert-message" id="hargaBeliError" style="color: red;"></div>
                              </div>
                            </div>
                            <div class="col-sm-5">
                              <label class="col-sm-4 col-form-label" for="harga_jual">Harga Jual</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">Rp.</span>
                                </div>
                                <input type="number" class="form-control" id="harga_jual" name="harga_jual">
                              </div>
                              <div class="alert-message" id="hargaJualError" style="color: red;"></div>
                            </div>
                            <div class="col-sm-2">
                              <label class="col-sm-4 col-form-label" for="diskon">Diskon</label>
                              <div class="input-group">
                                <input type="number" class="form-control" id="diskon" name="diskon">
                                <div class="input-group-append">
                                  <span class="input-group-text">%</span>
                                </div>
                              </div>
                            </div>
                          </div>
                          <p class="mb-0 mt-3">Persediaan</p>
                          <hr class="mt-0">                         
                          <div class="form-group row mt-3">
                              <label class="col-sm-2 col-form-label" for="stok">Stok</label>
                              <div class="col-sm-10">
                                <div class="input-group">
                                  <input type="number" class="form-control" id="stok" name="stok">
                                  <div class="input-group-append">
                                    <span class="input-group-text">PCS</span>
                                  </div>
                                </div>
                                <div class="alert-message" id="stokError" style="color: red;"></div>
                              </div>
                          </div>
                        </div>
                
                    <button type="button" class="btn btn-default close-tambah" data-dismiss="modal">Batalkan</button>
                    <button type="submit" class="btn btn-primary" id="simpan" name="simpan">Simpan</button>
                </form>
                    
                    </div>
                    <!-- /.tab-pane -->
                  </div>
                  <!-- /.tab-content -->
                </div><!-- /.card-body -->
              </div>
        
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
   
  </section>



@endsection

@section('javascripts')


<script>
  $(document).ready(function() {
    var form = $("#tambah");

    $('#simpan').on('click', function(e) {
      e.preventDefault();
      $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: form.serialize(),
        success: function(data) {
          setTimeout(() => {
            $(document).Toasts('create', {
            class: 'bg-success',
            title: 'Berhasil Menambahkan produk baru',
            position: 'topLeft',
            autohide: true,
            delay: 10000,
            body: "UID            : "+data.uid+"<br>Merek      : "+data.merek+"<br>Nama       : "+data.nama+"<br>Kategori   : "+data.category_name+"<br>Supplier   : "+data.nama_supplier+"<br>Harga Beli : Rp. "+data.harga_beli+"<br>Harga Jual : Rp. "+data.harga_jual+"<br>Diskon     : "+data.diskon+"<br>Stok       : "+data.stok
          });
          },500);
          $('.alert-message').empty();
        },
        error: function(data) {
              $('#uidError').text(data.responseJSON.error.uid);
              $('#merekError').text(data.responseJSON.error.merek);
              $('#namaError').text(data.responseJSON.error.nama);
              $('#categoryIdError').text(data.responseJSON.error.category_id);
              $('#supplierIdError').text(data.responseJSON.error.supplier_id);
              $('#hargaBeliError').text(data.responseJSON.error.harga_beli);
              $('#hargaJualError').text(data.responseJSON.error.harga_jual);
              $('#stokError').text(data.responseJSON.error.stok);
           }
        });
    });

    $('.close-tambah').on('click', function() {
      $('.alert-message').empty();
    });
  });
</script>

<script type="text/javascript">
  function deleteConfirmation(id) {
      var nama_product = $('#nama-product-'+id).text();
      console.log(nama_product);

      Swal.fire({
          title: "Hapus produk "+nama_product,
          text: "Menghapus produk juga akan menghapus data terkait dari produk tersebut, Apakah anda tetap ingin melanjutkan?",
          type: "warning",
          showCancelButton: !0,
          confirmButtonText: "Ya",
          cancelButtonText: "Tidak, batalkan!",
          reverseButtons: !0
      }).then(function (e) {

          if (e.value === true) {

              document.getElementById('delete-product-form-'+id).submit();

          } else {
              e.dismiss;
          }

      }, function (dismiss) {
          return false;
      })
  }
</script>
@endsection

