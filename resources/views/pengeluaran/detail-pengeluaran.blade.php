@extends('layouts.admin-lte')

@section('styles')
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
            <li class="breadcrumb-item"><a href="{{route('pengeluaran')}}"><h3>Daftar Pengeluaran</h3></a></li>
            <li class="breadcrumb-item"><a href="#"><h3>Detail Pengeluaran</h3></a></li>
          </ol>
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

  <!-- /.content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Informasi Pengeluaran</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong>Tanggal</strong>

                <p id="info-tanggal" class="text-muted">
                  {{ Str::formatDate($pengeluaran->created_at, 'd-m-Y') }}
                </p>

                <hr>

                <strong>Nama Pegawai</strong>

                <p id="info-nama_pegawai" class="text-muted">
                  {{ $pengeluaran->pegawai->name }}
                </p>

                <strong>Jenis Beban</strong>

                <p id="info-jenis_beban" class="text-muted">
                  {{ $pengeluaran->beban->jenis_beban }}
                </p>

                <strong>Deskripsi</strong>

                <p id="info-deskripsi" class="text-muted">
                  {{ $pengeluaran->deskripsi }}
                </p>

                <hr>

                <strong>Nominal Pengeluaran</strong>

                <p id="info-nominal_pengeluaran" class="text-muted">
                  {{ $pengeluaran->subtotal_pengeluaran }}
                </p>

                <hr>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>
                  <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Edit</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane" id="timeline">
                    <!-- The timeline -->
                    <div class="timeline timeline-inverse">
                      <!-- timeline time label -->
                      <div class="time-label">
                        <span class="bg-danger">
                          10 Feb. 2014
                        </span>
                      </div>
                      <!-- /.timeline-label -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-envelope bg-primary"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 12:05</span>

                          <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                          <div class="timeline-body">
                            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                            weebly ning heekya handango imeem plugg dopplr jibjab, movity
                            jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                            quora plaxo ideeli hulu weebly balihoo...
                          </div>
                          <div class="timeline-footer">
                            <a href="#" class="btn btn-primary btn-sm">Read more</a>
                            <a href="#" class="btn btn-danger btn-sm">Delete</a>
                          </div>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-user bg-info"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>

                          <h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your friend request
                          </h3>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-comments bg-warning"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>

                          <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                          <div class="timeline-body">
                            Take me to your leader!
                            Switzerland is small and neutral!
                            We are more like Germany, ambitious and misunderstood!
                          </div>
                          <div class="timeline-footer">
                            <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                          </div>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <!-- timeline time label -->
                      <div class="time-label">
                        <span class="bg-success">
                          3 Jan. 2014
                        </span>
                      </div>
                      <!-- /.timeline-label -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-camera bg-purple"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 2 days ago</span>

                          <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                          <div class="timeline-body">
                            <img src="https://placehold.it/150x100" alt="...">
                            <img src="https://placehold.it/150x100" alt="...">
                            <img src="https://placehold.it/150x100" alt="...">
                            <img src="https://placehold.it/150x100" alt="...">
                          </div>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <div>
                        <i class="far fa-clock bg-gray"></i>
                      </div>
                    </div>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane active" id="settings">
                    <form method="POST" action="{{ route('pengeluaran.update') }}" class="form-horizontal" id="update">
                      @method('PUT')
                      @csrf

                      <input type="hidden" name="id" value="{{ $pengeluaran->id }}">

                      <div class="card-body pt-0">
                        <div class="form-group">
                          <label class="col-sm-6 col-form-label" for="tanggal">Tanggal</label>

                          <div class="input-group col-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input type="text" class="form-control" value="{{Str::formatDate($pengeluaran->created_at, 'd-m-Y')}}" id="tanggal" name="tanggal" placeholder="dd-mm-yyyy" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask>
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
                              <option disabled>Pilih jenis beban</option>
                              {{-- <option selected value="{{ $pengeluaran->beban->id }}">{{ ucfirst($pengeluaran->beban->jenis_beban) }}</option> --}}
                              @foreach ($bebans as $beban)
                              <option id="jenis_beban" value="{{ $beban->id }}" @if($pengeluaran->beban->id == $beban->id) 'selected' @endif>{{ ucfirst($beban->jenis_beban) }}</option>
                              @endforeach
                            </select>
                            <div class="alert-message" id="bebanIdError" style="color: red;"></div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-6 col-form-label" for="deskripsi">Deskripsi</label>
                        <div class="col-sm">
                          <input type="text" class="form-control" value="{{$pengeluaran->deskripsi}}" name="deskripsi" id="deskripsi" placeholder="Masukkan keterangan pengeluaran">
                          <div class="alert-message" id="deskripsiError" style="color: red;"></div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-6 col-form-label" for="subtotal_pengeluaran">Nominal Pengeluaran</label>
                        <div class="input-group col-sm">
                          <div class="input-group-prepend">
                            <span class="input-group-text">Rp.</span>
                          </div>
                            <input type="number" class="form-control" value="{{$pengeluaran->subtotal_pengeluaran}}" id="subtotal_pengeluaran" name="subtotal_pengeluaran">
                          </div>
                          <div class="alert-message" id="subtotal_pengeluaranError" style="color: red;"></div>
                      </div>

                      <hr class="mt-0">
                      <div class="row">
                        <div class="col-sm-6">
                          <button type="submit" class="btn btn-primary" id="simpan" name="simpan">Simpan</button>
                          </form>
                        </div>
                        <div class="col-sm-6">
                          <button onclick="deleteConfirmation({{$pengeluaran->id}})" class="btn btn-danger float-right">
                            <i class="fas fa-trash"></i>
                          </button>
                          <form id="delete-pengeluaran-form" class="d-none" action="{{route('pengeluaran.delete', $pengeluaran->id)}}" method="post">
                            @method('DELETE')
                            @csrf 
                          </form>
                        </div>
                      </div>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
      
    </section>
    <!-- /.container -->


@endsection

@section('javascripts')


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


<script>
  $(document).ready(function() {
    var form = $("#update");

    $('#simpan').on('click', function(e) {
      e.preventDefault();
      $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: form.serialize(),
        success: function(data) {
          console.log(data);
          var jenis_beban = $('#jenis_beban').text();
          $('#info-tanggal').text(data.tanggal);
          $('#info-jenis_beban').text(data.jenis_beban);
          $('#info-deskripsi').text(data.deskripsi);
          $('#info-nominal_pengeluaran').text(data.subtotal_pengeluaran);
          setTimeout(() => {
            $(document).Toasts('create', {
            class: 'bg-info',
            title: 'Data pengeluaran berhasil di ubah',
            position: 'topLeft',
            autohide: true,
            delay: 10000,
            body: "<p>Tanggal     :"+"{{Str::formatDate($pengeluaran->created_at, 'd-m-Y')}}"+"  =>  "+data.tanggal+"</p>"+ 
                  "<p>Jenis Beban :"+jenis_beban+"  =>  "+data.jenis_beban+"</p>"+
                  "<p>Deskripsi   :"+"{{$pengeluaran->deskripsi}}"+"  =>  "+data.deskripsi+"</p>"+
                  "<p>Nominal     :"+"{{$pengeluaran->subtotal_pengeluaran}}"+"  =>  "+data.subtotal_pengeluaran+"</p>"
          });
          },500);
        },
        error: function(data) {
              $('#tanggalError').text(data.responseJSON.error.tanggal);
              $('#bebanIdError').text(data.responseJSON.error.beban_id);
              $('#deskripsiError').text(data.responseJSON.error.deskripsi);
              $('#subtotal_pengeluaranError').text(data.responseJSON.error.subtotal_pengeluaran);
           }
        });
    });
  });
</script>

<script type="text/javascript">
  function deleteConfirmation(id) {
      event.preventDefault();
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

              document.getElementById('delete-pengeluaran-form').submit();

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

