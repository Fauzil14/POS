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
            <li class="breadcrumb-item"><a href="#"><h3>Daftar Karyawan</h3></a></li>
          </ol>
        </div>
        <div class="col-sm-6">
          <div class="d-flex justify-content-end">
            <a class="btn btn-default ng-binding mr-2" onClick="window.location.reload()"> <i class="fas fa-sync-alt"></i> Total Karyawan : {{ count($karyawans) }}</a>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
              Tambah Karyawan
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
                    <th>Foto</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    @php $n = 1 @endphp
                    @foreach($karyawans as $karyawan)
                        <tr>
                            <td>{{ $n++ }}</td>
                            <td><img src="{{$karyawan->profile_picture}}" alt="Foto Karyawan" style="max-height: 50px; max-width: 50px;"></td>
                            <td id="nama-karyawan-{{$karyawan->id}}">{{$karyawan->name}}</td>
                            <td>{{$karyawan->email}}</td>
                            <td>{{ucfirst($karyawan->role)}}</td>
                            <td class="text-right py-0 align-middle">
                              <div class="btn-group btn-group-sm">
                                <a href="{{ route('karyawan.show', $karyawan->id) }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                <button onclick="deleteConfirmation({{$karyawan->id}})" class="btn btn-danger">
                                  <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-karyawan-form-{{$karyawan->id}}" class="d-none" action="{{route('karyawan.delete', $karyawan->id)}}" method="post">
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

    <div class="modal fade" id="modal-default">
      <div class="modal-dialog modal-default">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Tambah Karyawan Baru</h4>
            <a href="#" class="btn btn-default ng-binding mx-2" id="reset-form"> <i class="fas fa-sync-alt"></i> &nbsp; Reset Form</a>
            <button type="button" class="close close-tambah" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
            <div class="modal-body">
                      <!-- form start -->
                      <form method="POST" action="{{ route('karyawan.new-karyawan') }}" class="form-horizontal" id="tambah" enctype="multipart/form-data">
                        @csrf

                        <div class="card-body">
                          <p class="mb-1">Informasi Umum</p>
                          <hr class="mt-0">

                              <div class="form-group">
                                <label class="col-form-label" for="name">Nama</label>
                                <div>
                                  <input type="text" class="form-control" name="name" id="name" placeholder="Masukkan Nama Karyawan">
                                  <div class="alert-message" id="nameError" style="color: red;"></div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-form-label" for="email">Email</label>
                                <div>
                                  <input type="email" class="form-control" name="email" id="email" placeholder="Masukkan email">
                                  <div class="alert-message" id="emailError" style="color: red;"></div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-form-label" for="password">Password</label>
                                <div>
                                  <input type="text" class="form-control" name="password" id="password" placeholder="Masukkan password">
                                  <div class="alert-message" id="passwordError" style="color: red;"></div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-form-label" for="umur">Umur</label>
                                <div>
                                  <input type="number" class="form-control" name="umur" id="umur" placeholder="Masukkan email">
                                  <div class="alert-message" id="umurError" style="color: red;"></div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-form-label" for="alamat">Alamat</label>
                                <div>
                                  <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Masukkan alamat">
                                  <div class="alert-message" id="alamatError" style="color: red;"></div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-form-label" for="role_id">Role</label>
                                <div>
                                    <!-- select -->
                                    <select class="custom-select" id="role_id" name="role_id">
                                      <option selected disabled>Pilih Role</option>
                                      @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ ucfirst($role->role_name) }}</option>
                                      @endforeach
                                    </select>
                                </div>
                                <div class="alert-message" id="role_idError" style="color: red;"></div>
                              </div>
                              <div class="form-group">
                                <label class="col-form-label" for="profile_picture">Foto Profil</label>
                                <div class="input-group">
                                  <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="profile_picture" name="profile_picture">
                                    <label class="custom-file-label" for="profile_picture">Pilih File</label>
                                  </div>
                                  <div class="input-group-append">
                                    <span class="input-group-text">Upload</span>
                                  </div>
                                  <div class="alert-message" id="profile_pictureError" style="color: red;"></div>
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
  // Add the following code if you want the name of the file appear on select
  $(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
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
            title: 'Berhasil Menambahkan karyawan baru',
            position: 'topLeft',
            autohide: true,
            delay: 10000,
            body: "Nama Karyawan&emsp;&emsp; : &nbsp"+data.name+
                  "<br>Email&emsp;&ensp; : &nbsp"+data.email+
                  "<br>Password&emsp;&ensp; : &nbsp"+data.password+
                  "<br>Umur&emsp; : &nbsp"+data.umur+
                  "<br>Alamat&emsp; : &nbsp"+data.alamat+
                  "<br>Role&emsp; : &nbsp"+data.role
          });
          },500);
          $('.alert-message').empty();
        },
        error: function(data) {
              console.log(data);
              $('#nameError').text(data.responseJSON.error.name);
              $('#emailError').text(data.responseJSON.error.email);
              $('#passwordError').text(data.responseJSON.error.password);
              $('#umurError').text(data.responseJSON.error.umur);
              $('#alamatError').text(data.responseJSON.error.alamat);
              $('#role_idError').text(data.responseJSON.error.role_id);
              $('#profile_pictureError').text(data.responseJSON.error.profile_picture);
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


<script type="text/javascript">
  function deleteConfirmation(id) {
      var nama_karyawan = $('#nama-karyawan-'+id).text();

      Swal.fire({
          title: "Hapus karyawan "+nama_karyawan,
          text: "Menghapus karyawan juga akan menghapus data terkait dari karyawan tersebut, Apakah anda tetap ingin melanjutkan ?",
          type: "warning",
          showCancelButton: !0,
          confirmButtonText: "Ya",
          cancelButtonText: "Tidak, batalkan!",
          reverseButtons: !0
      }).then(function (e) {

          if (e.value === true) {

              document.getElementById('delete-karyawan-form-'+id).submit();

          } else {
              e.dismiss;
          }

      }, function (dismiss) {
          return false;
      })
  }
</script>

{{-- <script>
  $(function () {
    bsCustomFileInput.init();
  });
  </script> --}}
@endsection

