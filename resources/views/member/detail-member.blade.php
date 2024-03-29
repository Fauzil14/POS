@extends('layouts.admin-lte')

@section('styles')
  
@endsection

@section('content')

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="{{route('member')}}"><h3>Daftar Member</h3></a></li>
            <li class="breadcrumb-item"><a href="#"><h3>Detail Member</h3></a></li>
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
                <h3 class="card-title">Informasi Member</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong>Nama Member</strong>

                <p id="info-kode_member" class="text-muted">
                  {{ $member->kode_member }}
                </p>

                <hr>

                <strong>Nama Member</strong>

                <p id="info-nama" class="text-muted">
                  {{ $member->nama }}
                </p>

                <strong>No Telepon</strong>

                <p id="info-no_telephone" class="text-muted">
                  {{ $member->no_telephone }}
                </p>

                <hr>

                <strong>Saldo</strong>

                <p id="info-saldo" class="text-muted">
                  {{ Str::decimalForm($member->saldo, true) }}
                </p>

                <hr>

                <strong>Jumlah Transaksi</strong>

                <p id="info-jumlah_transaksi" class="text-muted">
                  {{ count($member->penjualan) }}
                </p>

                <hr>

                <strong>Total Pembelian</strong>

                <p id="info-jumlah_pembelian" class="text-muted">
                  {{ Str::decimalForm($member->penjualan->sum('total_price'), true) }}
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
                    <form method="POST" action="{{ route('member.update') }}" class="form-horizontal" id="update">
                      @method('PUT')
                      @csrf

                      <input type="hidden" name="id" value="{{ $member->id }}">

                      <div class="card-body">
                        <p class="mb-1">Informasi Umum</p>
                        <hr class="mt-0">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label" for="nama">Nama Member</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="nama" id="nama" value="{{$member->nama}}" placeholder="Masukkan Nama Member">
                            <div class="alert-message" id="namaError" style="color: red;"></div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label" for="no_telephone">No Telephone</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="no_telephone" id="no_telephone" value="{{$member->no_telephone}}" placeholder="Masukkan nomor telepon">
                            <div class="alert-message" id="no_telephoneError" style="color: red;"></div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label" for="saldo">Saldo</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="saldo" id="saldo" value="{{$member->saldo}}" placeholder="Masukkan saldo awal member">
                            <div class="alert-message" id="saldoError" style="color: red;"></div>
                          </div>
                        </div>

                      <hr class="mt-0">
                      <div class="row">
                        <div class="col-sm-6">
                          <button type="submit" class="btn btn-primary" id="simpan" name="simpan">Simpan</button>
                          </form>
                        </div>
                        <div class="col-sm-6">
                          <button onclick="deleteConfirmation({{$member->id}})" class="btn btn-danger float-right">
                            <i class="fas fa-trash"></i>
                          </button>
                          <form id="delete-member-form" class="d-none" action="{{route('member.delete', $member->id)}}" method="post">
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
          $('#info-nama').text(data.nama);
          $('#info-no_telephone').text(data.no_telephone);
          $('#info-saldo').text(data.saldo);
          setTimeout(() => {
            $(document).Toasts('create', {
            class: 'bg-info',
            title: 'Data Member berhasil di ubah',
            position: 'topLeft',
            autohide: true,
            delay: 10000,
            body: "Nama Member&emsp;&emsp;&emsp; : &nbsp"+"{{$member->nama}}"+"  =>  "+data.nama+
                  "No Telepon&emsp;&emsp;&emsp; : &nbsp"+"{{$member->no_telephone}}"+"  =>  "+data.no_telephone+
                  "Saldo&emsp;&emsp;&emsp; : &nbsp"+"{{$member->saldo}}"+"  =>  "+data.saldo
          });
          },500);
        },
        error: function(data) {
              $('#namaError').text(data.responseJSON.error.nama);
              $('#no_telephoneError').text(data.responseJSON.error.no_telephone);
              $('#saldoError').text(data.responseJSON.error.saldo);
           }
        });
    });
  });
</script>

<script type="text/javascript">
  function deleteConfirmation(id) {
      event.preventDefault();
      var nama_member = $('#info-nama').text();
      Swal.fire({
          title: "Hapus member "+nama_member,
          text: "Menghapus member juga akan menghapus data terkait dari member tersebut, Apakah anda tetap ingin melanjutkan ?",
          type: "warning",
          showCancelButton: !0,
          confirmButtonText: "Ya",
          cancelButtonText: "Tidak, batalkan!",
          reverseButtons: !0
      }).then(function (e) {

          if (e.value === true) {

              document.getElementById('delete-member-form').submit();

          } else {
              e.dismiss;
          }

      }, function (dismiss) {
          return false;
      })
  }
</script>
@endsection

