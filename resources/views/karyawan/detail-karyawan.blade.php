@extends('layouts.admin-lte')

@section('styles')
  
@endsection

@section('content')
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="{{route('karyawan')}}"><h3>Daftar Karyawan</h3></a></li>
            <li class="breadcrumb-item"><a href="#"><h3>Detail Karyawan</h3></a></li>
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

            <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle"
                     src="{{ $karyawan->profile_picture }}"
                     alt="User profile picture">
              </div>

              <h3 class="profile-username text-center">{{ $karyawan->name }}</h3>

              <p class="text-muted text-center">{{ $karyawan->role }}</p>

              {{-- <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>Test</b> <br> <a class="float-right"></a>
                </li>
              </ul> --}}

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Informasi Karyawan</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong>Nama Karyawan</strong>

                <p id="info-naem" class="text-muted">
                  {{ $karyawan->name }}
                </p>

                <hr>

                <strong>Nama Email</strong>

                <p id="info-email" class="text-muted">
                  {{ $karyawan->email }}
                </p>

                <strong>Password</strong>

                <p id="info-password" class="text-muted">
                  {{ $password }}
                </p>

                <hr>

                <strong>Umur</strong>

                <p id="info-umur" class="text-muted">
                  {{ $karyawan->umur }}
                </p>

                <hr>

                <strong>Alamat</strong>

                <p id="info-alamat" class="text-muted">
                  {{ $karyawan->alamat }}
                </p>

                <hr>

                <strong>Role</strong>

                <p id="info-role" class="text-muted">
                  {{ $karyawan->role }}
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


                          <div class="timeline-body">
                            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                            weebly ning heekya handango imeem plugg dopplr jibjab, movity
                            jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                            quora plaxo ideeli hulu weebly balihoo...
                          </div>
                          <div class="timeline-footer">
                          </div>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-user bg-info"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>

                          </h3>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-comments bg-warning"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>


                          <div class="timeline-body">
                            Take me to your leader!
                            Switzerland is small and neutral!
                            We are more like Germany, ambitious and misunderstood!
                          </div>
                          <div class="timeline-footer">
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
                    <form method="POST" action="{{ route('karyawan.update') }}" class="form-horizontal" id="update">
                      @method('PUT')
                      @csrf

                      <input type="hidden" name="id" value="{{ $karyawan->id }}">

                      <div class="card-body">
                        <p class="mb-1">Informasi Umum</p>
                        <hr class="mt-0">

                        <div class="form-group">
                          <label class="col-form-label" for="name">Nama</label>
                          <div>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $karyawan->name }}" placeholder="Masukkan Nama Karyawan">
                            <div class="alert-message" id="nameError" style="color: red;"></div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-form-label" for="email">Email</label>
                          <div>
                            <input type="email" class="form-control" name="email" id="email" value="{{ $karyawan->email }}" placeholder="Masukkan email">
                            <div class="alert-message" id="emailError" style="color: red;"></div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-form-label" for="password">Password</label>
                          <div>
                            <input type="text" class="form-control" name="password" id="password" value="{{ $password }}" placeholder="Masukkan password">
                            <div class="alert-message" id="passwordError" style="color: red;"></div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-form-label" for="umur">Umur</label>
                          <div>
                            <input type="number" class="form-control" name="umur" id="umur" value="{{ $karyawan->umur }}" placeholder="Masukkan email">
                            <div class="alert-message" id="umurError" style="color: red;"></div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-form-label" for="alamat">Alamat</label>
                          <div>
                            <input type="text" class="form-control" name="alamat" id="alamat" value="{{ $karyawan->alamat }}" placeholder="Masukkan alamat">
                            <div class="alert-message" id="alamatError" style="color: red;"></div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-form-label" for="role_id">Role</label>
                          <div>
                              <!-- select -->
                              <select class="custom-select" id="role_id" name="role_id">
                                <option disabled>Pilih Role</option>
                                @foreach ($allroles as $frole)
                                  <option id="role_name" value="{{ $frole->id }}" @if($karyawan->roles->first()->id == $frole->id) selected @endif>{{ ucfirst($frole->role_name) }}</option>
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

                      <hr class="mt-0">
                      <div class="row">
                        <div class="col-sm-6">
                          <button type="submit" class="btn btn-primary" id="simpan" name="simpan">Simpan</button>
                          </form>
                        </div>
                        <div class="col-sm-6">
                          <button onclick="deleteConfirmation({{$karyawan->id}})" class="btn btn-danger float-right">
                            <i class="fas fa-trash"></i>
                          </button>
                          <form id="delete-karyawan-form" class="d-none" action="{{route('karyawan.delete', $karyawan->id)}}" method="post">
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
  // Add the following code if you want the name of the file appear on select
  $(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
  });
</script>

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
            title: 'Data karyawan berhasil di ubah',
            position: 'topLeft',
            autohide: true,
            delay: 10000,
            body: "Nama karyawan&emsp;&emsp;&emsp; : &nbsp"+"{{$karyawan->nama}}"+"  =>  "+data.nama+
                  "No Telepon&emsp;&emsp;&emsp; : &nbsp"+"{{$karyawan->no_telephone}}"+"  =>  "+data.no_telephone+
                  "Saldo&emsp;&emsp;&emsp; : &nbsp"+"{{$karyawan->saldo}}"+"  =>  "+data.saldo
          });
          },500);
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
  });
</script>

<script type="text/javascript">
  function deleteConfirmation(id) {
      event.preventDefault();
      var nama_karyawan = $('#info-nama').text();
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

              document.getElementById('delete-karyawan-form').submit();

          } else {
              e.dismiss;
          }

      }, function (dismiss) {
          return false;
      })
  }
</script>
@endsection

