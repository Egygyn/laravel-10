@extends('layout.main')
@section('content')
      <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">User</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Data User</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <a href="{{route('admin.user.create')}}" class="btn btn-primary">Tambah Data</a>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Responsive Hover Table</h3>
                <div class="card-tools">
                  <form action="{{ route ('admin.user') }}" method="GET">
                   <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="search" class="form-control float-right" placeholder="Search" value="{{ $request->get('search') }}">
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>

                  </form>

                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Photo</th>
                      <th>Nik</th>
                      <th>Nama</th>
                      <th>Assets</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($data as $d )
                    <tr>
                      <td>{{$loop->iteration}}</td>
                      <td><img src="{{ asset('storage/photo-user/'.$d->image) }}" alt="" width="80"></td>
                      <td>{{$d -> ktp-> nik ?? ''}}</td>
                      <td>{{$d -> name}}</td>
                        <td>
                            <ul>
                                @foreach ($d->assets as $asset)
                                    <li>{{ asset{{ $asset->name }} }}</li>
                                @endforeach
                            </ul>
                        </td>
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h4 class="modal-title">Konfirmasi Hapus Data</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <p>Apakah Kamu Yakin ? Untuk Menghapus Data <b>{{ $d->name }}</b></p>
                                  </div>
                                  <div class="modal-footer justify-content-between">
                                    <form action="{{ route('admin.user.delete',['id'=>$d->id]) }}" method="POST">
                                      @csrf
                                      @method('DELETE')
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Cencel</button>
                                      <button type="submit" class="btn btn-primary">Ya Hapus Data</button>
                                    </form>

                                  </div>
                                </div>
                                <!-- /.modal-content -->
                              </div>
                              <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                    @endforeach

                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection