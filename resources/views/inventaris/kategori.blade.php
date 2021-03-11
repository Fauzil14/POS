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
            <li class="breadcrumb-item"><a href="#"><h3>Daftar Kategori</h3></a></li>
          </ol>
        </div>
        <div class="col-sm-6">
          <div class="d-flex justify-content-end">
            <a class="btn btn-default ng-binding mr-2" onClick="window.location.reload()"> <i class="fas fa-sync-alt"></i> Total Kategori : {{ count($categories) }}</a>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
              Tambah Kategori
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
            <div class="card-header">
              <h3 class="card-title"></h3>

              <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                  <div class="input-group-append">
                    <button type="submit" class="btn btn-default">
                      <i class="fas fa-search"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0" style="height: 400px;">
              <table class="table table-head-fixed text-nowrap">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    @php $n = 1 @endphp
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $n++ }}</td>
                            <td id="nama-kategori-{{$category->id}}">{{ucfirst($category->category_name)}}</td>
                            <td class="text-left py-0 align-middle">
                              <div class="btn-group btn-group-sm">
                                <a href="{{ route('inventaris.kategori.show', $category->id) }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                <button onclick="deleteConfirmation({{$category->id}})" class="btn btn-danger">
                                  <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-kategori-form-{{$category->id}}" class="d-none" action="{{route('inventaris.delete.kategori', $category->id)}}" method="post">
                                  @method('DELETE')
                                  @csrf 
                                </form>
                              </div>
                            </td>
                        </tr>
                    @endforeach
                  </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->

    <div class="modal fade" id="modal-default">
      <div class="modal-dialog modal-default">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Tambah Kategori Baru</h4>
            <a href="#" class="btn btn-default ng-binding mx-2" id="reset-form"> <i class="fas fa-sync-alt"></i> &nbsp; Reset Form</a>
            <button type="button" class="close close-tambah" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
            <div class="modal-body">

                      <!-- form start -->
                      <form method="POST" action="{{ route('inventaris.new.kategori') }}" id="tambah">
                        @csrf

                        <div class="card-body pt-0">
                          <div class="form-group">
                            <label class="col col-form-label" for="category_name">Nama Kategori</label>
                            <div class="col">
                              <input type="text" class="form-control" name="category_name" id="category_name" placeholder="Masukkan Nama Kategori">
                              <div class="alert-message" id="category_nameError" style="color: red;"></div>
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
          console.log(data);
          setTimeout(() => {
            $(document).Toasts('create', {
            class: 'bg-success',
            title: 'Berhasil Menambahkan kategori baru',
            position: 'topLeft',
            autohide: true,
            delay: 10000,
            body: "category_name&emsp;&emsp;&emsp; : &nbsp"+data.category_name
          });
          },500);
          $('.alert-message').empty();
        },
        error: function(data) {
              console.log(data);
              $('#category_nameError').text(data.responseJSON.error.category_name);
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
      var nama_product = $('#nama-kategori-'+id).text();
      console.log(nama_product);

      Swal.fire({
          title: "Hapus kategori "+nama_product,
          text: "Menghapus kategori juga akan menghapus data terkait dari kategori tersebut, Apakah anda tetap ingin melanjutkan?",
          type: "warning",
          showCancelButton: !0,
          confirmButtonText: "Ya",
          cancelButtonText: "Tidak, batalkan!",
          reverseButtons: !0
      }).then(function (e) {

          if (e.value === true) {

              document.getElementById('delete-kategori-form-'+id).submit();

          } else {
              e.dismiss;
          }

      }, function (dismiss) {
          return false;
      })
  }
</script>
@endsection

