@extends('layouts.admin-lte')

@section('styles')
  
@endsection

@section('content')

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="{{route('inventaris')}}"><h3>Daftar Produk</h3></a></li>
            <li class="breadcrumb-item"><a href="#"><h3>Detail Produk</h3></a></li>
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
                <h3 class="card-title">Informasi Produk</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong>UID</strong>

                <p id="info-uid" class="text-muted">
                  {{ $product->uid }}
                </p>

                <hr>

                <strong>Merek</strong>

                <p id="info-merek" class="text-muted">
                  {{ $product->merek }}
                </p>

                <hr>

                <strong>Nama</strong>

                <p id="info-nama" class="text-muted">
                  {{ $product->nama }}
                </p>

                <hr>

                <strong>Kategori</strong>

                <p id="info-category_name" class="text-muted">
                  {{ ucfirst($product->category->category_name) }}
                </p>

                <hr>

                <strong>Supplier</strong>

                <p id="info-nama_supplier" class="text-muted">
                  {{ $product->supplier->nama_supplier }}
                </p>

                <hr>

                <strong>Stok</strong>

                <p id="info-stok" class="text-muted">
                  {{ $product->stok }} PCS
                </p>

                <hr>

                <strong>Harga Beli</strong>

                <p id="info-harga_beli" class="text-muted">
                  Rp. {{ Str::decimalForm($product->harga_beli, true) }}
                </p>

                <hr>

                <strong>Harga Jual</strong>

                <p id="info-harga_jual" class="text-muted">
                  Rp. {{ Str::decimalForm($product->harga_jual, true) }}
                </p>

                <hr>

                <strong>Diskon</strong>

                <p id="info-diskon" class="text-muted">
                  {{ $product->diskon }} %
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
                    <form method="POST" action="{{ route('inventaris.update.product') }}" class="form-horizontal" id="update">
                      @method('PUT')
                      @csrf

                      <input type="hidden" name="id" value="{{ $product->id }}">

                      <div class="card-body pt-0">
                        <p class="mb-1">Informasi Umum</p>
                        <hr class="mt-0">
                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label" for="uid">UID</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="uid" id="uid" value="{{$product->uid}}" placeholder="Masukkan Kode Produk (Optional)">
                            <div class="alert-message" id="uidError" style="color: red;"></div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label" for="merek">Merek</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="merek" id="merek" value="{{$product->merek}}" placeholder="Masukkan merek Produk">
                            <div class="alert-message" id="merekError" style="color: red;"></div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label" for="nama">Nama</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="nama" id="nama" value="{{$product->nama}}" placeholder="Masukkan nama Produk">
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
                                      <option disabled>Pilih Kategori Produk</option>
                                      <option selected value="{{ $product->category_id }}">{{ ucfirst($product->category->category_name) }}</option>
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
                                    <option disabled>Pilih supplier</option>
                                    <option selected value="{{ $product->supplier_id }}">{{ $product->supplier->nama_supplier }}</option>
                                    @foreach ($suppliers as $supplier)
                                      <option value="{{ $supplier->id }}">{{ ucfirst($supplier->nama_supplier) }}</option>
                                    @endforeach
                                  </select>
                              </div>
                              <div class="alert-message" id="supplierIdError" style="color: red;"></div>
                            </div>
                          </div>
                        </div>
                        <p class="mb-0 mt-1">Kalkulasi Harga</p>
                        <hr class="mt-0 mb-1">
                        <div class="row">
                          <div class="col-sm-5">
                            <div class="form-group">
                              <label class="col-sm-4 col-form-label" for="harga_beli">Harga beli</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">Rp.</span>
                                </div>
                                  <input type="number" class="form-control" value="{{ $product->harga_beli }}" id="harga_beli" name="harga_beli">
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
                              <input type="number" class="form-control" value="{{ $product->harga_jual }}" id="harga_jual" name="harga_jual">
                            </div>
                            <div class="alert-message" id="hargaJualError" style="color: red;"></div>
                          </div>
                          <div class="col-sm-2">
                            <label class="col-sm col-form-label" for="diskon">Diskon</label>
                            <div class="input-group">
                              <input type="number" class="form-control" value="{{ $product->diskon }}" id="diskon" name="diskon">
                              <div class="input-group-append">
                                <span class="input-group-text">%</span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <p class="mb-0 mt-1">Persediaan</p>
                        <hr class="mt-0">                         
                        <div class="form-group row mt-3">
                            <label class="col-sm-2 col-form-label" for="stok">Stok</label>
                            <div class="col-sm-10">
                              <div class="input-group">
                                <input type="number" class="form-control" value="{{ $product->stok }}" id="stok" name="stok">
                                <div class="input-group-append">
                                  <span class="input-group-text">PCS</span>
                                </div>
                              </div>
                              <div class="alert-message" id="stokError" style="color: red;"></div>
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
                          <button onclick="deleteConfirmation({{$product->id}})" class="btn btn-danger float-right">
                            <i class="fas fa-trash"></i>
                          </button>
                          <form id="delete-product-form" class="d-none" action="{{route('inventaris.delete.product', $product->id)}}" method="post">
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
          $('#info-uid').text(data.uid);
          $('#info-merek').text(data.merek);
          $('#info-nama').text(data.nama);
          $('#info-category_name').text(data.category_name);
          $('#info-nama_supplier').text(data.nama_supplier);
          $('#info-harga_beli').text("Rp. "+data.harga_beli);
          $('#info-harga_jual').text("Rp. "+data.harga_jual);
          $('#info-diskon').text(data.diskon+" %");
          $('#info-stok').text(data.stok+" PCS");
          setTimeout(() => {
            $(document).Toasts('create', {
            class: 'bg-info',
            title: 'Data produk berhasil di ubah',
            position: 'topLeft',
            autohide: true,
            delay: 10000,
            body: "UID&emsp;&emsp;&emsp; : &nbsp"+"{{$product->uid}}"+"  =>  "+data.uid+
                  "<br>Merek&emsp;&emsp; : &nbsp"+"{{$product->merek}}"+"  =>  "+data.merek+
                  "<br>Nama&emsp;&emsp; : &nbsp"+"{{$product->nama}}"+"  =>  "+data.nama+
                  "<br>Kategori&emsp; : &nbsp"+"{{ucfirst($product->category->category_name)}}"+"  =>  "+data.category_name+
                  "<br>Supplier&emsp; : &nbsp"+"{{$product->supplier->nama_supplier}}"+"  =>  "+data.nama_supplier+
                  "<br>Harga Beli&thinsp; : &nbsp"+"{{$product->harga_beli}}"+"  =>  "+"Rp. "+data.harga_beli+
                  "<br>Harga Jual : &nbsp"+"{{$product->harga_jual}}"+"  =>  "+"Rp. "+data.harga_jual+
                  "<br>Diskon&emsp;&nbsp;&thinsp;&thinsp; : &nbsp"+"{{$product->diskon}}"+"  =>  "+data.diskon+
                  "<br>Stok&emsp;&emsp;&nbsp;&thinsp;&thinsp; : &nbsp"+"{{$product->stok}}"+"  =>  "+data.stok
          });
          },500);
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
  });
</script>

<script type="text/javascript">
  function deleteConfirmation(id) {
      event.preventDefault();
      var nama_product = $('#info-nama').text();
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

              document.getElementById('delete-product-form').submit();

          } else {
              e.dismiss;
          }

      }, function (dismiss) {
          return false;
      })
  }
</script>
@endsection

