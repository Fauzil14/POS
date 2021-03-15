@extends('layouts.admin-lte')

@section('styles')
   <!-- DataTables -->
   <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
   <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
   <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  
   <!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css')}}">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="{{ asset('plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="{{ asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css')}}">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="{{ asset('plugins/bs-stepper/css/bs-stepper.min.css')}}">
@endsection

@section('content')

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="#"><h3>Daftar Pengeluaran</h3></a></li>
          </ol>
        </div>
        <div class="col-sm-6">
          <div class="d-flex justify-content-end">
            <a class="btn btn-default ng-binding mr-2" onClick="window.location.reload()"> <i class="fas fa-sync-alt"></i> Total Pengeluaran : {{ count($pengeluarans) }}</a>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
              Input Pengeluaran
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
                    <th>Tanggal</th>
                    <th>Nama Pegawai</th>
                    <th>Jenis Beban</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    @php $n = 1 @endphp
                    @foreach($pengeluarans as $pengeluaran)
                        <tr>
                            <td>{{ $n++ }}</td>
                            <td>{{Str::formatDate($pengeluaran->pengeluaran->tanggal, 'd-F-Y')}}</td>
                            <td>{{$pengeluaran->pegawai->name}}</td>
                            <td id="jenis_beban">{{$pengeluaran->beban->jenis_beban}}</td>
                            <td>{{$pengeluaran->deskripsi}}</td>
                            <td class="text-right py-0 align-middle">
                              <div class="btn-group btn-group-sm">
                                <a href="{{ route('pengeluaran.show', $pengeluaran->id) }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                <button onclick="deleteConfirmation({{$pengeluaran->id}})" class="btn btn-danger">
                                  <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-pengeluaran-form-{{$pengeluaran->id}}" class="d-none" action="{{route('pengeluaran.delete', $pengeluaran->id)}}" method="post">
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
            <h4 class="modal-title">Input Pengeluaran Baru</h4>
            <a href="#" class="btn btn-default ng-binding mx-2" id="reset-form"> <i class="fas fa-sync-alt"></i> &nbsp; Reset Form</a>
            <button type="button" class="close close-tambah" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
            <div class="modal-body">

              <!-- form start -->
                      <form method="POST" action="{{ route('pengeluaran.new-pengeluaran') }}" class="form-horizontal" id="tambah">
                        @csrf

                        <div class="card-body">
                          <!-- Date dd/mm/yyyy -->
                            <div class="form-group">
                              <label class="col-sm-6 col-form-label" for="tanggal">Tanggal</label>

                              <div class="input-group col-sm">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="text" class="form-control" id="tanggal" name="tanggal" placeholder="dd-mm-yyyy" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask>
                                <div class="alert-message" id="tanggalError" style="color: red;"></div>
                              </div>
                              <!-- /.input group -->
                            </div>
                            <!-- /.form group -->
                          <div class="form-group">
                            <label class="col-sm-6 col-form-label" for="beban_id">Jenis Beban</label>
                            <div class="col-sm">
                                <!-- select -->
                                <select class="custom-select" id="beban_id" name="beban_id">
                                  <option selected disabled>Pilih jenis beban</option>
                                  @foreach ($bebans as $beban)
                                    <option id="jenis_beban" value="{{ $beban->id }}">{{ ucfirst($beban->jenis_beban) }}</option>
                                  @endforeach
                                </select>
                                <div class="alert-message" id="bebanIdError" style="color: red;"></div>
                            </div>
                          </div>
  
                          <div class="form-group">
                            <label class="col-sm-6 col-form-label" for="deskripsi">Deskripsi</label>
                            <div class="col-sm">
                              <input type="text" class="form-control" name="deskripsi" id="deskripsi" placeholder="Masukkan keterangan pengeluaran">
                              <div class="alert-message" id="deskripsiError" style="color: red;"></div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-sm-6 col-form-label" for="subtotal_pengeluaran">Nominal Pengeluaran</label>
                            <div class="input-group col-sm">
                              <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                              </div>
                                <input type="number" class="form-control" id="subtotal_pengeluaran" name="subtotal_pengeluaran">
                              </div>
                              <div class="alert-message" id="subtotal_pengeluaranError" style="color: red;"></div>
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

<!-- Select2 -->
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="{{asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')}}"></script>
<!-- InputMask -->
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('plugins/inputmask/jquery.inputmask.min.js')}}"></script>
<!-- date-range-picker -->
<script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- bootstrap color picker -->
<script src="{{asset('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Bootstrap Switch -->
<script src="{{asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
<!-- BS-Stepper -->
<script src="{{asset('plugins/bs-stepper/js/bs-stepper.min.js')}}"></script>

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
          var jenis_beban = $('#jenis_beban').text();
          var deskripsi = $('#deskripsi').val();
          var subtotal_pengeluaran = $('#subtotal_pengeluaran').val();
          console.log(data);
          setTimeout(() => {
            $(document).Toasts('create', {
            class: 'bg-success',
            title: 'Pengeluaran baru telah di masukkan',
            position: 'topLeft',
            autohide: true,
            delay: 10000,
            body: "Tanggal&emsp;&emsp; : &nbsp"+data.tanggal+
                  "<br>Jenis Beban&emsp;&ensp; : &nbsp"+jenis_beban+
                  "<br>Deskripsi&emsp; : &nbsp"+deskripsi+
                  "<br>Nominal Pengeluaran : &nbsp"+subtotal_pengeluaran
          });
          },500);
          $('.alert-message').empty();
        },
        error: function(data) {
              $('#tanggalError').text(data.responseJSON.error.tanggal);
              $('#bebanIdError').text(data.responseJSON.error.beban_id);
              $('#deskripsiError').text(data.responseJSON.error.deskripsi);
              $('#subtotal_pengeluaranError').text(data.responseJSON.error.subtotal_pengeluaran);
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
      var jenis_beban = $('#jenis_beban').text();

      Swal.fire({
          title: "Hapus pengeluaran "+jenis_beban,
          text: "Menghapus pengeluaran juga akan menghapus data terkait dari pengeluaran tersebut, Apakah anda tetap ingin melanjutkan ?",
          type: "warning",
          showCancelButton: !0,
          confirmButtonText: "Ya",
          cancelButtonText: "Tidak, batalkan!",
          reverseButtons: !0
      }).then(function (e) {

          if (e.value === true) {

              document.getElementById('delete-pengeluaran-form-'+id).submit();

          } else {
              e.dismiss;
          }

      }, function (dismiss) {
          return false;
      })
  }
</script>


<script>
  $(function() {
    //Datemask dd/mm/yyyy
    $('#tanggal').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' })

  });
</script>

@endsection

