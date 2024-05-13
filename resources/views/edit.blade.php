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
              <li class="breadcrumb-item active">Edit User</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
      <div class="container-fluid">
        <form action="{{ route('admin.user.update',['id'=> $data -> id]) }}"method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Form Edit User</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form>
                <div class="card-body">
                @if ($data->image)
                  <img src="{{ asset('storage/photo-user/'.$data->image) }}" width="80px" alt="">
                @endif
                  <div class="form-group">
                    <label for="InputEmail">Photo Profil</label>
                    <input type="file" name="photo" class="form-control">
                    <small>Upload Photo Jika Ingin Menggantinya</small>
                      @error('photo')
                          <small>{{ $message }}</small>
                          <br>
                      @enderror
                  </div>
                  <div class="form-group">
                    <label for="InputEmail">Email address</label>
                    <input type="email" name="email" class="form-control" id="InputEmail" value="{{ $data->email }}" placeholder="Enter email">
                      @error('email')
                          <small>{{ $message }}</small>
                      @enderror
                  </div>
                  <div class="form-group">
                    <label for="InputNama">Nama</label>
                    <input type="text" class="form-control" id="InputNama" name="nama"  value="{{ $data->name }}" placeholder="Enter Nama">
                      @error('nama')
                          <small>{{ $message }}</small>
                      @enderror
                  </div>
                  <div class="form-group">
                    <label for="InputPassword">Password</label>
                    <input type="password" name="password" class="form-control" id="InputPassword" placeholder="Password">
                      @error('password')
                          <small>{{ $message }}</small>
                      @enderror
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
  
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (right) -->
        </div>
        </form>
 
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
  </div>
@endsection