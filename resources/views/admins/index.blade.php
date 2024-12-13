@extends('layouts.app')

@push('style')
    <style>
        th {
            white-space: nowrap !important;
        }
    </style>
@endpush

@section('content')
    <ol class="breadcrumb p-l-0">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="#">Admin</a></li>
        <li class="breadcrumb-item active">Data Admin</li>
    </ol>

    <div class="row">
        <div class="col-md-12 project-list">
            <div class="card">
                <div class="row">
                    <div class="col-md-6 d-flex mt-2 p-0">
                        <h4>Data Admin</h4>
                    </div>
                    <div class="col-md-6 p-0">
                        <button class="btn btn-primary btn-sm ms-2" type="button" data-bs-toggle="modal" data-bs-target="#mdlCreate"><i class="fa fa-plus-circle"></i> Tambah</button>
                        <div id="mdlCreate" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-md">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title" id="mySmallModalLabel">Tambah Admin</h4>
                                  <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="#">
                                        <div class="form-group col-sm-10">
                                            {!! Form::label('name', 'Nama Admin:', ['style' => 'font-weight: bold;']) !!}
                                            {!! Form::text('name', null, ['id' => 'name', 'class' => 'form-control']) !!}
                                        </div>
                                        <div class="form-group col-sm-10">
                                            {!! Form::label('username', 'Username:', ['style' => 'font-weight: bold;']) !!}
                                            {!! Form::text('username', null, ['id' => 'username', 'class' => 'form-control']) !!}
                                        </div>
                                        <div class="form-group col-sm-10">
                                            {!! Form::label('password', 'Password:', ['style' => 'font-weight: bold;']) !!}
                                            <input type="password" id="password" class="form-control">
                                        </div>
                                        <div class="form-group col-sm-10">
                                            {!! Form::label('confirm_password', 'Konfirmasi Password:', ['style' => 'font-weight: bold;']) !!}
                                            <input type="password" id="confirm_password" class="form-control">
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Tutup</button>
                                    <button class="btn btn-primary" type="button" onclick="saveData()">Simpan</button>
                                  </div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">

                    <div class="">
                        <table class="display cell-border nowrap stripe" id="mytable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end me-4 mt-4">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="mdlEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="mySmallModalLabel">Edit Admin</h4>
              <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#">
                    <input type="hidden" id="idEdit">
                    <div class="form-group col-sm-10">
                        {!! Form::label('nameEdit', 'Nama Admin:', ['style' => 'font-weight: bold;']) !!}
                        {!! Form::text('nameEdit', null, ['id' => 'nameEdit', 'class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-sm-10 editMe">
                        {!! Form::label('usernameEdit', 'Username:', ['style' => 'font-weight: bold;']) !!}
                        {!! Form::text('usernameEdit', null, ['id' => 'usernameEdit', 'class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-sm-10 editMe">
                        {!! Form::label('password', 'Password:', ['style' => 'font-weight: bold;']) !!}
                        <input type="password" id="passwordEdit" class="form-control">
                    </div>
                    <div class="form-group col-sm-10 editMe">
                        {!! Form::label('confirm_password', 'Konfirmasi Password:', ['style' => 'font-weight: bold;']) !!}
                        <input type="password" id="confirm_passwordEdit" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Tutup</button>
                <button class="btn btn-primary" type="button" onclick="updateData()">Simpan</button>
              </div>
          </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#mytable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admins.datatables') }}",
                    type: "GET",
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                columnDefs: [
                    { target: [0, 1, 2], className: 'text-center' }
                ],
                pageLength: 25
            });
        });

        function reloadDatatable() {
            $('#mytable').DataTable().ajax.reload()
        }

        function saveData() {
            let name = $('#name').val()
            let username = $('#username').val()
            let password = $('#password').val()
            let confirm_password = $('#confirm_password').val()

            createOverlay("Proses...");
            var token = "{{ csrf_token() }}";
            $.ajax({
                type  : "POST",
                url   : "{{ route('admins.store') }}",
                data : {
                    "name": name,
                    "username": username,
                    "password": password,
                    "confirm_password": confirm_password,
                    "_token": token
                },
                success : function(data) {
                    gOverlay.hide();

                    if(data["STATUS"] == "SUCCESS") {
                        Toast.fire({
                            icon: "success",
                            title: "Berhasil",
                            text: data['MESSAGE']
                        })
                        $("#mdlCreate").modal("hide");
                        $("#mytable").DataTable().ajax.reload();
                    }
                    else {
                        Toast.fire({
                            icon: "error",
                            title: "Gagal",
                            text: data['MESSAGE']
                        })
                    }
                },
                error : function(error) {
                    gOverlay.hide();
                    Toast.fire({
                        icon: "error",
                        title: "Network/server error\r\n",
                        text: error
                    })
                }
            });
        }

        function editData(id, name) {
            $("#mdlEdit").on("shown.bs.modal", function (e) {
                $("#idEdit").val(id);
                $("#nameEdit").val(name);

                $(".editMe").css('display', 'none');
            });
            $("#mdlEdit").modal("show");   
        }

        function editDataMe(id, name, username) {
            $("#mdlEdit").on("shown.bs.modal", function (e) {
                $("#idEdit").val(id);
                $("#nameEdit").val(name);
                $("#usernameEdit").val(username);
                
                $(".editMe").css('display', 'initial');
            });
            $("#mdlEdit").modal("show");   
        }

        function updateData() {
            let id = $("#idEdit").val();
            let name = $("#nameEdit").val();
            let username = $('#usernameEdit').val()
            let password = $('#passwordEdit').val()
            let confirm_password = $('#confirm_passwordEdit').val()

            let url = "{{ route('admins.update') }}";
            let data = {
                "id" : id,
                "name" : name,
                "_token": "{{ csrf_token() }}",
                "_method": "PUT"
            }

            if (id == "{{ auth()->user()->id }}") {
                url = "{{ route('admins.update_me') }}";
                data = {
                    "id" : id,
                    "name" : name,
                    "username": username,
                    "password": password,
                    "confirm_password": confirm_password,
                    "_token": "{{ csrf_token() }}",
                    "_method": "PUT"
                }
            }

            createOverlay("Proses...");
            $.ajax({
                type  : "POST",
                url   : url,
                data  : data,
                success : function(data) {
                    gOverlay.hide();
                    if(data["STATUS"] == "SUCCESS") {
                        Toast.fire({
                            icon: "success",
                            title: "Berhasil",
                            text: data['MESSAGE']
                        })
                        $("#mdlEdit").modal("hide");
                        $("#mytable").DataTable().ajax.reload();
                    }
                    else {
                        Toast.fire({
                            icon: "error",
                            title: "Gagal",
                            text: data['MESSAGE']
                        })
                    }
                },
                error : function(error) {
                    gOverlay.hide();
                    Toast.fire({
                        icon: "error",
                        title: "Gagal",
                        text: "Network/server error\r\n" + error
                    })
                }
            });
        }
        
        function deleteData(id, name) {
            Swal.fire({
                title: "Apakah anda yakin?",
                html: "Hapus data Admin <b>" + name + "</b> ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya",
                cancelButtonText: "Batal",
                closeOnConfirm: true,   
            }).then((result) => {
                if (result.isConfirmed) {
                    createOverlay("Proses...");
                    $.ajax({
                        type  : "POST",
                        url   : "{{ route('admins.delete') }}",
                        data  : {
                            "id": id,
                            "_method" : "DELETE",
                            "_token": "{{ csrf_token() }}"
                        },
                        success : function(data) {
                            gOverlay.hide();
                            if(data["STATUS"] == "SUCCESS") {
                                Toast.fire({
                                    icon: "success",
                                    title: "Berhasil",
                                    text: data['MESSAGE']
                                })
                                $("#mytable").DataTable().ajax.reload();
                            }
                            else {
                                Toast.fire({
                                    icon: "error",
                                    title: "Gagal",
                                    text: data['MESSAGE']
                                })
                            }
                        },
                        error : function(error) {
                            gOverlay.hide();
                            Toast.fire({
                                icon: "error",
                                title: "Gagal",
                                text: "Network/server error\r\n" + error
                            })
                        }
                    });
                }
            });
        }
    </script>
@endpush
