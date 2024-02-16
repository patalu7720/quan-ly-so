<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.7.0.slim.min.js" integrity="sha256-tG5mcZUtJsZvyKAxYLVXrmjKBVLd6VpVccqz/r4ypFE=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/5a5ecc0be1.js" crossorigin="anonymous"></script>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        body{
            font-size: 12.5px;
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
    @livewireStyles
    
</head>
<body style="background-color:white">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Eighth navbar example">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExample07">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    {{-- @can('menu_bao_gia')
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('bao-gia') }}">Báo giá</a>
                        </li>
                    @endcan --}}
                    @can('menu_tdg')
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('tdg') }}">TDG</a>
                        </li>
                    @endcan
                    @can('menu_ttdh')
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('ttdh') }}">TTĐH</a>
                        </li>
                    @endcan
                    @can('menu_contracts')
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('hop-dong') }}">Hợp đồng</a>
                        </li>
                    @endcan
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('so') }}">SO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('so-tam') }}">SO Tạm</a>
                    </li>
                    @can('menu_tdg')
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('tc') }}">TC</a>
                        </li>
                    @endcan
                    @can('menu_pxxdhs')
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('phieu-xxdh') }}">Phiếu XXĐH</a>
                        </li>
                    @endcan
                    @can('menu_ptksx')
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Phiếu TKSX
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('phieu-tbtdmhdty') }}">DTY</a>
                                <a class="dropdown-item" href="{{ route('phieu-tksx-fdy') }}">FDY</a>
                            </div>
                        </li>
                    @endcan
                    @can('menu_tdg')
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Báo cáo
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('bc-hop-dong') }}">Hợp đồng</a>
                                <a class="dropdown-item" href="{{ route('bc-tdg') }}">TDG</a>
                                <a class="dropdown-item" href="{{ route('bc-ttdh') }}">TTDH</a>
                            </div>
                        </li>
                    @endcan
                    @can('menu_cancel_revised_so')
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('cancel-revised-so') }}">Cancel-Revised S/O</a>
                        </li>
                    @endcan
                    
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            QA
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            @can('menu_mo_phong')
                                <a class="dropdown-item" href="{{ route('mo-phong') }}">Mô phỏng</a>
                                <a class="dropdown-item" href="{{ route('theo-doi-tksx-dty') }}">Theo dõi SX DTY</a>
                            @endcan
                            @can('menu_tckh')
                                <a class="dropdown-item" href="{{ route('tieu-chuan-khach-hang') }}">Tiêu chuẩn khách hàng</a>
                            @endcan
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('theo-doi-thu-mau') }}">Theo dõi thử mẫu</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('thay-doi-mat-khau') }}">Thay đổi mật khẩu</a>
                                <a class="dropdown-item" href="{{ route('dangxuat') }}"
                                   onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    Đăng xuất
                                </a>
                                <form id="logout-form" action="{{ route('dangxuat') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div class="modal" id="modal" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Modal title</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
    </div>

    {{$slot}}
    
    @livewireScripts
    <script>

        window.livewire.on('deleteHD', ()=>{
            $('#ModalXoa').modal('hide');
        });

        window.livewire.on('deleteHDXK', ()=>{
            $('#ModalXoaXK').modal('hide');
        });

        window.livewire.on('storeHDNDTV', ()=>{
            $('#ModalNDTV').modal('hide');
        });

        window.livewire.on('updateHDNDTV', ()=>{
            $('#ModalNDTV').modal('hide');
        });

        window.livewire.on('storeHDNDSN', ()=>{
            $('#ModalNDSNTV').modal('hide');
            $('#ModalNDSNTA').modal('hide');
        });

        window.livewire.on('updateHDNDSN', ()=>{
            $('#ModalNDSNTV').modal('hide');
            $('#ModalNDSNTA').modal('hide');
        });

        window.livewire.on('storeHDXKTCTA', ()=>{
            $('#ModalXKTCTA').modal('hide');
        });

        window.livewire.on('updateHDXKTCTA', ()=>{
            $('#ModalXKTCTA').modal('hide');
        });

        window.livewire.on('storeHDXKTCSN', ()=>{
            $('#ModalXKTCSNTV').modal('hide');
            $('#ModalXKTCSNTA').modal('hide');
        });

        window.livewire.on('updateHDNDSN', ()=>{
            $('#ModalXKTCSNTV').modal('hide');
            $('#ModalXKTCSNTA').modal('hide');
        });

        window.livewire.on('storeHDXKTT', ()=>{
            $('#ModalXKTT').modal('hide');
        });

        window.livewire.on('updateHDXKTT', ()=>{
            $('#ModalXKTT').modal('hide');
        });

        window.livewire.on('uploadFileScan', ()=>{
            $('#ModalUpFileScan').modal('hide');
        });

        window.livewire.on('uploadFileRoot', ()=>{
            $('#ModalUpFileRoot').modal('hide');
        });

        window.livewire.on('uploadHopDongCoFileSan', ()=>{
            $('#ModalUploadHopDongCoFileSan').modal('hide');
        });

        window.livewire.on('uploadPhuLuc', ()=>{
            $('#ModalUpFilePhuLuc').modal('hide');
        });

        window.livewire.on('uploadTDG', ()=>{
            $('#ModalUpFileTDG').modal('hide');
        });

        window.livewire.on('rejectModal', ()=>{
            $('#rejectModal').modal('hide');
        });
          
    </script>
    <script>
        window.livewire.on('addPhieuXXDHModal', ()=>{
           $('#addPhieuXXDHModal').modal('hide');
        });
        window.livewire.on('editPhieuXXDHModal', ()=>{
           $('#editPhieuXXDHModal').modal('hide');
        });
        window.livewire.on('deletePhieuXXDHModal', ()=>{
           $('#deletePhieuXXDHModal').modal('hide');
        });
        window.livewire.on('approvePhieuXXDHModal', ()=>{
           $('#approvePhieuXXDHModal').modal('hide');
        });
        window.livewire.on('rollBackPhieuXXDHModal', ()=>{
                $('#rollBackPhieuXXDHModal').modal('hide');
            });
        window.livewire.on('xacNhanPhieuXXDHModal', ()=>{
            $('#xacNhanPhieuXXDHModal').modal('hide');
        });
    </script>
    <script>
        window.livewire.on('addPhieuMHDTYModal', ()=>{
            $('#addPhieuMHDTYModal').modal('hide');
        });
        window.livewire.on('editPhieuMHDTYModal', ()=>{
            $('#editPhieuMHDTYModal').modal('hide');
        });
        window.livewire.on('deletePhieuMHDTYModal', ()=>{
            $('#deletePhieuMHDTYModal').modal('hide');
        });
        window.livewire.on('approvePhieuMHDTYModal', ()=>{
            $('#approvePhieuMHDTYModal').modal('hide');
        });
        window.livewire.on('rollBackPhieuTKSXModal', ()=>{
            $('#rollBackPhieuTKSXModal').modal('hide');
        });
    </script>
    <script>
        window.livewire.on('addPhieuTKSXFDYModal', ()=>{
            $('#addPhieuTKSXFDYModal').modal('hide');
        });
        window.livewire.on('editPhieuTKSXFDYModal', ()=>{
            $('#editPhieuTKSXFDYModal').modal('hide');
        });
        window.livewire.on('deletePhieuTKSXFDYModal', ()=>{
            $('#deletePhieuTKSXFDYModal').modal('hide');
        });
        window.livewire.on('approvePhieuTKSXFDYModal', ()=>{
            $('#approvePhieuTKSXFDYModal').modal('hide');
        });
        window.livewire.on('rollBackPhieuTKSXFDYModal', ()=>{
            $('#rollBackPhieuTKSXFDYModal').modal('hide');
        });
    </script>
    <script>
        window.livewire.on('bookingModal', ()=>{
                $('#bookingModal').modal('hide');
            });
    </script>
    <script>
        Livewire.onPageExpired((response, message) => {
            $("#modal").modal({show: true});
        })
    </script>
    <script>
        window.livewire.on('addBaoGiaModal', ()=>{
        $('#addBaoGiaModal').modal('hide');});
        window.livewire.on('editBaoGiaModal', ()=>{
        $('#editBaoGiaModal').modal('hide');});
        window.livewire.on('approveBaoGiaModal', ()=>{
        $('#approveBaoGiaModal').modal('hide');});
        window.livewire.on('deleteBaoGiaModal', ()=>{
        $('#deleteBaoGiaModal').modal('hide');});
        window.livewire.on('rollbackBaoGiaModal', ()=>{
        $('#rollbackModal').modal('hide');});
        window.livewire.on('confirmBaoGiaModal', ()=>{
        $('#confirmBaoGiaModal').modal('hide');});  
    </script>
    <script>
        window.livewire.on('createTDGModal', ()=>{
        $('#createTDGModal').modal('hide');});
        window.livewire.on('duyetWebModal', ()=>{
        $('#duyetWebModal').modal('hide');});   
        window.livewire.on('rejectModal', ()=>{
        $('#rejectModal').modal('hide');});
        window.livewire.on('createTDGNewVersionModal', ()=>{
        $('#createTDGNewVersionModal').modal('hide');});   
        window.livewire.on('createTTDHNewVersionModal', ()=>{
        $('#createTTDHNewVersionModal').modal('hide');});
    </script>
    <script>
        window.livewire.on('addXNDHModal', ()=>{
        $('#addXNDHModal').modal('hide');});
        window.livewire.on('approveXNDHModal', ()=>{
        $('#approveXNDHModal').modal('hide');});
        window.livewire.on('rollbackXNDHModal', ()=>{
        $('#rollbackXNDHModal').modal('hide');});
        window.livewire.on('updateXNDHModal', ()=>{
        $('#updateXNDHModal').modal('hide');});
    </script>
    <script>
        window.livewire.on('detailHopDongModal', ()=>{
            $('#detailHopDongModal').modal('hide');
        });
    </script>
    <script>
        window.livewire.on('upFileBookingModal', ()=>{
            $('#upFileBookingModal').modal('hide');
        });
        window.livewire.on('upFileAllModal', ()=>{
            $('#upFileAllModal').modal('hide');
        });
        window.livewire.on('upFileModal', ()=>{
            $('#upFileModal').modal('hide');
        });
        window.livewire.on('updateFileModal', ()=>{
            $('#updateFileModal').modal('hide');
        });
        window.livewire.on('capNhatModal', ()=>{
            $('#capNhatModal').modal('hide');
        });
        window.livewire.on('ketThucMoPhongModal', ()=>{
            $('#ketThucMoPhongModal').modal('hide');
        });
    </script>
    <script>
         window.livewire.on('closeModal', ()=>{
            $('#createModal').modal('hide');
            $('#editModal').modal('hide');
            $('#approveModal').modal('hide');
            $('#deleteModal').modal('hide');
            $('#rejectModal').modal('hide');
            $('#duyetModal').modal('hide');
        });
    </script>
</body>
<footer>
    <div class="container">
        <div class="row" style="height:50px"></div>
    </div>
</footer>
</html>
