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
              <li class="breadcrumb-item active">Tambah User</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
      <div class="container-fluid">
        <form action="{{ route('admin.user.store') }}"method="POST" enctype="multipart/form-data">
          @csrf
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Form Tambah User</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label for="InputEmail">Photo Profil</label>
                    <input type="file" name="photo" class="form-control" id="Inputphoto">
                      @error('photo')
                          <small>{{ $message }}</small>
                      @enderror
                  </div>
                  <div class="form-group">
                    <label for="InputEmail">Email address</label>
                    <input type="email" name="email" class="form-control" id="InputEmail" placeholder="Enter email" value="{{ old('email') }}">
                      @error('email')
                          <small>{{ $message }}</small>
                      @enderror
                  </div>
                  <div class="form-group">
                    <label for="InputNama">Nama</label>
                    <input type="text" class="form-control" id="InputNama" name="nama" placeholder="Enter Nama" value="{{ old('nama') }}">
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