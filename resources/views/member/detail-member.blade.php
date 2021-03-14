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
                  {{ $member->kode_member) }}
                </p>

                <hr>

                <strong>Nama Member</strong>

                <p id="info-nama" class="text-muted">
                  {{ $member->nama }}
                </p>

                <strong>No Telepon</strong>

                <p id="info-no_telephone" class="text-muted">
                  {{ $member->no_telephone) }}
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
                  {{ $member->penjualan->sum('total_price') }}
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
                    <form method="POST" action="{{ route('supplier.update') }}" class="form-horizontal" id="update">
                      @method('PUT')
                      @csrf

                      <input type="hidden" name="id" value="{{ $supplier->id }}">

                      <div class="card-body pt-0">
                        <p class="mb-1">Informasi Umum</p>
                        <hr class="mt-0">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label" for="nama_supplier">Nama Supplier</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="nama_supplier" id="nama_supplier" value="{{ $supplier->nama_supplier }}" placeholder="Masukkan Nama Supplier">
                            <div class="alert-message" id="nama_supplierError" style="color: red;"></div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label" for="alamat_supplier">Alamat Supplier</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="alamat_supplier" id="alamat_supplier" value="{{$supplier->alamat_supplier}}" placeholder="Masukkan alamat supplier">
                            <div class="alert-message" id="alamat_supplierError" style="color: red;"></div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label" for="telepon_supplier">Telepon Supplier</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="telepon_supplier" id="telepon_supplier" value="{{$supplier->telepon_supplier}}" placeholder="Masukkan telepon supplier supplier">
                            <div class="alert-message" id="telepon_supplierError" style="color: red;"></div>
                          </div>
                        </div>
                      </div>

                      <hr class="mt-0">
                      <div class="row">
                        <div class="col-sm-6">
                          <button type="submit" class="btn btn-primary" id="simpan" name="simpan">Simpan</button>
                          </form>
                        </div>
                        <div class="col-sm-6">
                          <button onclick="deleteConfirmation({{$supplier->id}})" class="btn btn-danger float-right">
                            <i class="fas fa-trash"></i>
                          </button>
                          <form id="delete-supplier-form" class="d-none" action="{{route('supplier.delete', $supplier->id)}}" method="post">
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
          $('#info-kode_member').text(data.nama_supplier);
          $('#info-nama').text(data.alamat_supplier);
          $('#info-no_telephone').text(data.telepon_supplier);
          setTimeout(() => {
            $(document).Toasts('create', {
            class: 'bg-info',
            title: 'Data Supplier berhasil di ubah',
            position: 'topLeft',
            autohide: true,
            delay: 10000,
            body: "Nama Supplier&emsp;&emsp;&emsp; : &nbsp"+"{{$supplier->nama_supplier}}"+"  =>  "+data.nama_supplier+
                  "Alamat Supplier&emsp;&emsp;&emsp; : &nbsp"+"{{$supplier->alamat_supplier}}"+"  =>  "+data.alamat_supplier+
                  "Telepon Supplier&emsp;&emsp;&emsp; : &nbsp"+"{{$supplier->telepon_supplier}}"+"  =>  "+data.telepon_supplier
          });
          },500);
        },
        error: function(data) {
              $('#nama_supplierError').text(data.responseJSON.error.nama_supplier);
              $('#alamat_supplierError').text(data.responseJSON.error.alamat_supplier);
              $('#telepon_supplierError').text(data.responseJSON.error.telepon_supplier);
           }
        });
    });
  });
</script>

<script type="text/javascript">
  function deleteConfirmation(id) {
      event.preventDefault();
      var nama_supplier = $('#info-kode_member').text();
      Swal.fire({
          title: "Hapus Supplier "+nama_supplier,
          text: "Menghapus Supplier juga akan menghapus data terkait dari Supplier tersebut, Apakah anda tetap ingin melanjutkan?",
          type: "warning",
          showCancelButton: !0,
          confirmButtonText: "Ya",
          cancelButtonText: "Tidak, batalkan!",
          reverseButtons: !0
      }).then(function (e) {

          if (e.value === true) {

              document.getElementById('delete-supplier-form').submit();

          } else {
              e.dismiss;
          }

      }, function (dismiss) {
          return false;
      })
  }
</script>
@endsection

