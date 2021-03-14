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
            <li class="breadcrumb-item"><a href="#"><h3>Daftar Supplier</h3></a></li>
          </ol>
        </div>
        <div class="col-sm-6">
          <div class="d-flex justify-content-end">
            <a class="btn btn-default ng-binding mr-2" onClick="window.location.reload()"> <i class="fas fa-sync-alt"></i> Total Supplier : {{ count($suppliers) }}</a>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-lg">
              Tambah Supplier
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
                    <th>Nama Supplier</th>
                    <th>Alamat Supplier</th>
                    <th>Telepon Supplier</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    @php $n = 1 @endphp
                    @foreach($suppliers as $supplier)
                        <tr>
                            <td>{{ $n++ }}</td>
                            <td id="nama-supplier-{{$supplier->id}}">{{$supplier->nama_supplier}}</td>
                            <td>{{$supplier->alamat_supplier}}</td>
                            <td>{{$supplier->telepon_supplier}}</td>
                            <td class="text-right py-0 align-middle">
                              <div class="btn-group btn-group-sm">
                                <a href="{{ route('inventaris.show.product', $supplier->id) }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                <button onclick="deleteConfirmation({{$supplier->id}})" class="btn btn-danger">
                                  <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-supplier-form-{{$supplier->id}}" class="d-none" action="{{route('supplier.delete', $supplier->id)}}" method="post">
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
            <h4 class="modal-title">Tambah Supplier Baru</h4>
            <a href="#" class="btn btn-default ng-binding mx-2" id="reset-form"> <i class="fas fa-sync-alt"></i> &nbsp; Reset Form</a>
            <button type="button" class="close close-tambah" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
            <div class="modal-body">

                      <!-- form start -->
                      <form method="POST" action="{{ route('supplier.new-supplier') }}" class="form-horizontal" id="tambah">
                        @csrf

                        <div class="card-body">
                          <p class="mb-1">Informasi Umum</p>
                          <hr class="mt-0">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="nama_supplier">Nama Supplier</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="nama_supplier" id="nama_supplier" placeholder="Masukkan Nama Supplier">
                              <div class="alert-message" id="nama_supplierError" style="color: red;"></div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="alamat_supplier">Alamat Supplier</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="alamat_supplier" id="alamat_supplier" placeholder="Masukkan Alamat Supplier">
                              <div class="alert-message" id="alamat_supplierError" style="color: red;"></div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="telepon_supplier">Telepon Supplier</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="telepon_supplier" id="telepon_supplier" placeholder="Masukkan nomor telepon supplier">
                              <div class="alert-message" id="telepon_supplierError" style="color: red;"></div>
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
            title: 'Berhasil Menambahkan supplier baru',
            position: 'topLeft',
            autohide: true,
            delay: 10000,
            body: "Nama Supplier&emsp;&emsp; : &nbsp"+data.nama_supplier+
                  "<br>Alamat Supplier&emsp;&ensp; : &nbsp"+data.alamat_supplier+
                  "<br>Telepon Supplier&emsp; : &nbsp"+data.telepon_supplier
          });
          },500);
          $('.alert-message').empty();
        },
        error: function(data) {
              $('#nama_supplierError').text(data.responseJSON.error.nama_supplier);
              $('#alamat_supplierError').text(data.responseJSON.error.alamat_supplier);
              $('#telepon_supplierError').text(data.responseJSON.error.telepon_supplier);
           }
        });
    });

    $('.close-tambah').on('click', function() {
      $('.alert-message').empty();
    });
    $('#reset-form').on('click', function() {
      $('#tambah').trigger("reset");
      $('.alert-message').empty();
    });
  });
</script>

<script></script>

<script type="text/javascript">
  function deleteConfirmation(id) {
      var nama_supplier = $('#nama-supplier-'+id).text();
      console.log(nama_supplier);

      Swal.fire({
          title: "Hapus supplier "+nama_supplier,
          text: "Menghapus supplier juga akan menghapus data terkait dari supplier tersebut, Apakah anda tetap ingin melanjutkan ?",
          type: "warning",
          showCancelButton: !0,
          confirmButtonText: "Ya",
          cancelButtonText: "Tidak, batalkan!",
          reverseButtons: !0
      }).then(function (e) {

          if (e.value === true) {

              document.getElementById('delete-supplier-form-'+id).submit();

          } else {
              e.dismiss;
          }

      }, function (dismiss) {
          return false;
      })
  }
</script>
@endsection

