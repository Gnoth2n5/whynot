@extends('layouts.admin')
@section('content')
<section section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Thông tin thương hiệu</h3>
            <div class="card-tools">
            </div>
          </div>
          <!-- /.card-header -->
          <x-form-crud route="{{ route('admin.brands_store') }}" cancel="admin.brands_index" :fields="$fields" :rules="$rules" :messages="$messages" />
        </div>
      </div>
    </div>
  </div>
  <!-- /.container-fluid -->
</section>
@vite(['resources/admin/js/user-create.js'])
@endsection