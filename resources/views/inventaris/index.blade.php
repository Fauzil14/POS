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
          <h1>Daftar Produk</h1>
        </div>
        <div class="col-sm-6">
          <div class="d-flex justify-content-end">
            <a class="btn btn-default ng-binding mr-2">Total Produk : {{ count($products) }}</a>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-lg">
              Tambah Produk
            </button>
          </div>
        </div>
      </div>
    </div><!-- /.container-fluid -->
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
                    <th>UID</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Supplier</th>
                    <th>Stok</th>
                    <th>Harga Jual</th>
                    <th>Diskon</th>
                  </tr>
                  </thead>
                  <tbody>
                    @php $n = 1 @endphp
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $n++ }}</td>
                            <td>{{$product->uid}}</td>
                            <td>{{$product->nama}}</td>
                            <td>{{ucfirst($product->category->category_name)}}</td>
                            <td>{{$product->supplier->nama_supplier}}</td>
                            <td>{{$product->stok}}</td>
                            <td>{{$product->harga_jual}}</td>
                            <td>{{$product->diskon}}</td>
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
            <h4 class="modal-title">Tambah Produk Baru</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">

                      <!-- form start -->
                      <form method="POST" action="{{ route('inventaris.new-product') }}" class="form-horizontal">
                        @csrf

                        <div class="card-body">
                          <p class="mb-1">Informasi Umum</p>
                          <hr class="mt-0">
                          <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="uid">UID</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control @error('uid', 'tambah') is-invalid @enderror" name="uid" id="uid" placeholder="Masukkan Kode Produk (Optional)">
                              @error('uid', 'tambah')
                                <strong class="error-message" style="color: red;">{{ $message }}</strong>
                              @enderror
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="merek">Merek</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control @error('merek', 'tambah') is-invalid @enderror" name="merek" id="merek" placeholder="Masukkan merek Produk">
                              @error('merek', 'tambah')
                                <strong class="error-message" style="color: red;">{{ $message }}</strong>
                              @enderror
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="nama">Nama</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control @error('nama', 'tambah') is-invalid @enderror" name="nama" id="nama" placeholder="Masukkan nama Produk">
                              @error('nama', 'tambah')
                                <strong class="error-message" style="color: red;">{{ $message }}</strong>
                              @enderror
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-5">
                              <div class="form-group">
                                <label class="col-sm-6 col-form-label" for="category_id">Kategori Produk</label>
                                <div class="col-sm">
                                    <!-- select -->
                                      <select class="custom-select" id="category_id" name="category_id">
                                        <option selected disabled>Pilih Kategori Produk</option>
                                        @foreach ($categories as $category)
                                          <option value="{{ $category->id }}">{{ ucfirst($category->category_name) }}</option>
                                        @endforeach
                                      </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-sm-7">
                              <div class="form-group">
                                <label class="col-sm-6 col-form-label" for="supplier_id">Supplier</label>
                                <div class="col-sm">
                                    <!-- select -->
                                    <select class="custom-select" id="supplier_id" name="supplier_id">
                                      <option selected disabled>Pilih supplier</option>
                                      @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ ucfirst($supplier->nama_supplier) }}</option>
                                      @endforeach
                                    </select>
                                </div>
                              </div>
                            </div>
                          </div>
                          <p class="mb-0 mt-4">Kalkulasi Harga</p>
                          <hr class="mt-0 mb-1">
                          <div class="row">
                            <div class="col-sm-5">
                              <div class="form-group">
                                <label class="col-sm-4 col-form-label" for="harga_beli">Harga beli</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                  </div>
                                    <input type="number" class="form-control" id="harga_beli" name="harga_beli">
                                  </div>
                              </div>
                            </div>
                            <div class="col-sm-5">
                              <label class="col-sm-4 col-form-label" for="harga_jual">Harga Jual</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">Rp.</span>
                                </div>
                                <input type="number" class="form-control" id="harga_jual" name="harga_jual">
                              </div>
                            </div>
                            <div class="col-sm-2">
                              <label class="col-sm-4 col-form-label" for="diskon">Diskon</label>
                              <div class="input-group">
                                <input type="number" class="form-control" id="diskon" name="diskon">
                                <div class="input-group-append">
                                  <span class="input-group-text">%</span>
                                </div>
                              </div>
                            </div>
                          </div>
                          <p class="mb-0 mt-3">Persediaan</p>
                          <hr class="mt-0">                         
                          <div class="form-group row mt-3">
                              <label class="col-sm-2 col-form-label" for="stok">Stok</label>
                              <div class="col-sm-10">
                                <div class="input-group">
                                  <input type="number" class="form-control" id="stok" name="stok">
                                  <div class="input-group-append">
                                    <span class="input-group-text">PCS</span>
                                  </div>
                                </div>
                              </div>
                          </div>
                        </div>
                
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batalkan</button>
                    <button type="submit" class="btn btn-primary" id="simpan" name="simpan">Simpan</button>
                  </div>
                </form>
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

{{-- <script>
  $(document).ready(function() {
    var form = $("modal-lg");

    $('#simpan').on('click', function() {
      $.ajax({
        type: form.attr("method"),
        url: form.attr("action"),
      });
    });
  });
</script> --}}

@endsection

