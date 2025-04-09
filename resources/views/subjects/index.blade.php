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
        <li class="breadcrumb-item"><a href="#">Nilai {{ ucwords(strtolower(request()->route('type'))) }}</a></li>
        <li class="breadcrumb-item active">Mapel {{ ucwords(strtolower(request()->route('type'))) }}</li>
    </ol>

    <div class="row">
        <div class="col-md-12 project-list">
            <div class="card">
                <div class="row">
                    <div class="col-md-6 d-flex mt-2 p-0">
                        <h4>Data Mapel {{ ucwords(strtolower(request()->route('type'))) }}</h4>
                    </div>
                    <div class="col-md-6 p-0">
                        <button class="btn btn-primary btn-sm ms-2" type="button" data-bs-toggle="modal" data-bs-target="#mdlCreate"><i class="fa fa-plus-circle"></i> Tambah</button>
                        <div id="mdlCreate" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-md">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title" id="mySmallModalLabel">Tambah Mapel Rapor</h4>
                                  <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="#">
                                        <div class="form-group col-sm-10">
                                            {!! Form::label('name', 'Nama Mapel '.ucwords(strtolower(request()->route("type"))) .':', ['style' => 'font-weight: bold;']) !!}
                                            {!! Form::text('name', null, ['id' => 'name', 'class' => 'form-control']) !!}
                                        </div>
                                        <div class="form-group col-sm-10">
                                            {!! Form::label('orderNo', 'Nomor Urut Mapel '.ucwords(strtolower(request()->route("type"))) .':', ['style' => 'font-weight: bold;']) !!}
                                            {!! Form::text('orderNo', $nextOrderNo, ['id' => 'orderNo', 'class' => 'form-control']) !!}
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
                    <ul class="nav nav-tabs border-tab nav-primary" id="info-tab" role="tablist">
                        <li class="nav-item" style="flex-grow:1;">
                            <a class="nav-link @if(strtoupper(request()->route('type')) == 'RAPOR') active @endif" 
                                id="info-home-tab"
                                href="{{ route('subjects.index', ['type' => 'RAPOR']) }}" 
                                role="tab" aria-controls="info-book" aria-selected="false">
                                    <i class="icofont icofont-read-book"></i>Mapel Rapor
                            </a>
                        </li>

                        <li class="nav-item" style="flex-grow:1;">
                            <a class="nav-link @if(strtoupper(request()->route('type')) == 'UJIAN') active @endif" 
                                id="profile-info-tab"
                                href="{{ route('subjects.index', ['type' => 'UJIAN']) }}" 
                                role="tab" aria-controls="info-book" aria-selected="false">
                                    <i class="icofont icofont-read-book"></i>Mapel Ujian
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content" id="info-tabContent">
                        <div class="tab-pane fade show active" id="info-home" role="tabpanel" aria-labelledby="info-home-tab">
                            
                            <div class="">
                                <table class="display cell-border nowrap stripe" id="mytable">
                                    <thead>
                                        <tr>
                                            <th width="10%">Nomor Urut</th>
                                            <th width="80%">Mata Pelajaran</th>
                                            <th width="10%">Actions</th>
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
        </div>
    </div>

    <div id="mdlEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="mySmallModalLabel">Edit Mapel {{ ucwords(strtolower(request()->route('type'))) }}</h4>
              <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#">
                    <input type="hidden" id="idEdit">
                    <div class="form-group col-sm-10">
                        {!! Form::label('nameEdit', 'Nama Mapel '.ucwords(strtolower(request()->route("type"))) .':', ['style' => 'font-weight: bold;']) !!}
                        {!! Form::text('nameEdit', null, ['id' => 'nameEdit', 'class' => 'form-control']) !!}
                    </div>

                    <div class="form-group col-sm-10">
                        {!! Form::label('orderNoEdit', 'Nomor Urut Mapel '.ucwords(strtolower(request()->route("type"))) .':', ['style' => 'font-weight: bold;']) !!}
                        {!! Form::text('orderNoEdit', null, ['id' => 'orderNoEdit', 'class' => 'form-control']) !!}
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
                paging: false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('subjects.datatables', request()->route('type')) }}",
                    type: "GET",
                },
                columns: [
                    { data: 'order_no', name: 'order_no'},
                    { data: 'name', name: 'name' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                columnDefs: [
                    { target: [0, 1, 2], className: 'text-center' }
                ],
                order: [[0, 'asc']]
            });
        });

        function reloadDatatable() {
            $('#mytable').DataTable().ajax.reload()
        }

        function saveData() {
            let name = $('#name').val()
            let orderNo = $('#orderNo').val()
            console.log(name)

            createOverlay("Proses...");
            var token = "{{ csrf_token() }}";
            $.ajax({
                type  : "POST",
                url   : "{{ route('subjects.store', request()->route('type')) }}",
                data : {
                    "name": name,
                    "order_no": orderNo,
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

        function editData(id, name, orderNo) {
            $("#mdlEdit").on("shown.bs.modal", function (e) {
                $("#idEdit").val(id);
                $("#nameEdit").val(name);
                $("#orderNoEdit").val(orderNo);
            });
            $("#mdlEdit").modal("show");   
        }

        function updateData() {
            var id = $("#idEdit").val();
            var name = $("#nameEdit").val();
            var orderNo = $("#orderNoEdit").val();

            createOverlay("Proses...");
            $.ajax({
                type  : "POST",
                url   : "{{ route('subjects.update', request()->route('type')) }}",
                data  : {
                    "id" : id,
                    "name" : name,
                    "order_no": orderNo,
                    "_token": "{{ csrf_token() }}",
                    "_method": "PUT"
                },
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
                html: "Hapus data Mata Pelajaran <b>" + name + "</b> ?<br>Semua nilai siswa terkait mata pelajaran tersebut akan dihapus dari sistem",
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
                        url   : "{{ route('subjects.delete', request()->route('type')) }}",
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

