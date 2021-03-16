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
            <li class="breadcrumb-item"><a href="#"><h3>Daftar Permintaan Karyawan</h3></a></li>
          </ol>
        </div>
        <div class="col-sm-6">
          <div class="d-flex justify-content-end">
            <a class="btn btn-default ng-binding mr-2" onClick="window.location.reload()"> <i class="fas fa-sync-alt"></i> Total Permintaan Karyawan : {{ count($requests) }}</a>
            {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
              Tambah Karyawan
            </button> --}}
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
                    <th>Permintaan Role</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    @php $n = 1 @endphp
                    @foreach($requests as $request)
                        <tr>
                            <td>{{ $n++ }}</td>
                            <td><img src="{{$request->user->profile_picture}}" alt="Foto User" style="max-height: 50px; max-width: 50px;"></td>
                            <td id="nama-user-{{$request->id}}">{{$request->user->name}}</td>
                            <td>{{ $request->user->email}}</td>
                            <td>{{ ucfirst($request->role->role_name) }}</td>
                            <td class="text-right py-0 align-middle">
                              <div class="btn-group btn-group-lg btn-group-toggle">
                                <a href="{{ route('karyawan.request.accept', $request->id) }}" class="btn btn-info"><i class="fas fa-user-check"></i></a>
                                <a href="{{ route('karyawan.request.decline', $request->id) }}" class="btn btn-info btn-danger"><i class="fas fa-user-times"></i></a>
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
          console.log(data)
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
      var nama_karyawan = $('#nama-user-'+id).text();

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

              document.getElementById('decline-request-form-'+id).submit();

          } else {
              e.dismiss;
          }

      }, function (dismiss) {
          return false;
      })
  }
</script>

@endsection

