@extends('layouts.admin-lte')

@section('styles')
   <!-- DataTables -->
   <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
   <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
   <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  
@endsection

@section('content')

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="#"><h3>Daftar Produk</h3></a></li>
          </ol>
        </div>
        <div class="col-sm-6">
          <div class="d-flex justify-content-end">
            <a class="btn btn-default ng-binding mr-2" onClick="window.location.reload()"> <i class="fas fa-sync-alt"></i> Total Produk : {{ count($products) }}</a>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-lg">
              Tambah Produk
            </button>
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
              <div class="card-body">
                <table id="example1" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>UID</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Supplier</th>
                    <th>Stok</th>
                    <th>Harga Jual</th>
                    <th>Diskon</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    @php $n = 1 @endphp
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $n++ }}</td>
                            <td>{{$product->uid}}</td>
                            <td id="nama-product-{{$product->id}}">{{$product->nama}}</td>
                            <td>{{ucfirst($product->category->category_name)}}</td>
                            <td>{{$product->supplier->nama_supplier}}</td>
                            <td>{{$product->stok}}</td>
                            <td>{{$product->harga_jual}}</td>
                            <td>{{$product->diskon}}</td>
                            <td class="text-right py-0 align-middle">
                              <div class="btn-group btn-group-sm">
                                <a href="{{ route('inventaris.show.product', $product->id) }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                <button onclick="deleteConfirmation({{$product->id}})" class="btn btn-danger">
                                  <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-product-form-{{$product->id}}" class="d-none" action="{{route('inventaris.delete.product', $product->id)}}" method="post">
                                  @method('DELETE')
                                  @csrf 
                                </form>
                              </div>
                            </td>
                        </tr>
                    @endforeach
                  </tfoot>
                </table>
              </div>
            </div>
        
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->

    <div class="modal fade" id="modal-lg">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Tambah Produk Baru</h4>
            <a href="#" class="btn btn-default ng-binding mx-2" id="reset-form"> <i class="fas fa-sync-alt"></i> &nbsp; Reset Form</a>
            <button type="button" class="close close-tambah" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
            <div class="modal-body">

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
                
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default close-tambah" data-dismiss="modal">Batalkan</button>
                    <button type="submit" class="btn btn-primary" id="simpan" name="simpan">Simpan</button>
                  </div>
                </form>
            </div>

            <div id="toastsContainerTopLeft" class="toasts-top-left fixed">
              <div class="toast bg-success fade" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                  <strong class="mr-auto">Toast Title</strong>
                  <small>Subtitle</small>
                  <button data-dismiss="toast" type="button" class="ml-2 mb-1 close-tambah" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                <div class="toast-body">Lorem ipsum dolor sit amet, consetetur sadipscing elitr.</div>
              </div>
            </div>

        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
   
  </section>



@endsection

@section('javascripts')

<!-- DataTables  & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>              
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["colvis"],
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

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
            body: "UID&emsp;&emsp;&emsp; : &nbsp"+data.uid+
                  "<br>Merek&emsp;&emsp; : &nbsp"+data.merek+
                  "<br>Nama&emsp;&emsp; : &nbsp"+data.nama+
                  "<br>Kategori&emsp; : &nbsp"+data.category_name+
                  "<br>Supplier&emsp; : &nbsp"+data.nama_supplier+
                  "<br>Harga Beli&thinsp; : &nbsp"+"Rp. "+data.harga_beli+
                  "<br>Harga Jual : &nbsp"+"Rp. "+data.harga_jual+
                  "<br>Diskon&emsp;&nbsp;&thinsp;&thinsp; : &nbsp"+data.diskon+
                  "<br>Stok&emsp;&emsp;&nbsp;&thinsp;&thinsp; : &nbsp"+data.stok

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
    $('#reset-form').on('click', function() {
      $('#tambah').trigger("reset");
    });
  });
</script>

<script></script>

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

