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
    @livewireStyles
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script> --}}
    
</head>
<body style="background-color:white">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Eighth navbar example">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExample07">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                      <a class="nav-link active" aria-current="page" href="{{ route('admin.quan.ly.user') }}">Quản lý User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('admin.roles') }}">Roles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('admin.permissions') }}">Permissions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('admin.tdg') }}">TDG</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::guard('admin')->user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('thay-doi-mat-khau') }}">Thay đổi mật khẩu</a>
                                <a class="dropdown-item" href="{{ route('dangxuat') }}"
                                   onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    Đăng xuất
                                </a>
                                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    {{$slot}}
    
    @livewireScripts
    <script>
        window.livewire.on('addNewRolesModal', ()=>{
            $('#addNewRolesModal').modal('hide');
        });
        window.livewire.on('addNewPermissionModal', ()=>{
            $('#addNewPermissionModal').modal('hide');
        });
        window.livewire.on('deleteRoleModal', ()=>{
            $('#deleteRoleModal').modal('hide');
        });
        window.livewire.on('deletePermissionModal', ()=>{
            $('#deletePermissionModal').modal('hide');
        });
        window.livewire.on('editRolesModal', ()=>{
            $('#editRolesModal').modal('hide');
        });

        
        window.livewire.on('addRolesToUserModal', ()=>{
            $('#addRolesToUserModal').modal('hide');
        });
        window.livewire.on('editUserModal', ()=>{
            $('#editUserModal').modal('hide');
        });
        window.livewire.on('changePasswordModal', ()=>{
            $('#changePasswordModal').modal('hide');
        });
        window.livewire.on('addNewUserModal', ()=>{
            $('#addNewUserModal').modal('hide');
        });
        window.livewire.on('addPermissionModal', ()=>{
            $('#addPermissionModal').modal('hide');
        });

        
    </script>
</body>
<footer>
    <div class="container">
        <div class="row" style="height:50px"></div>
    </div>
</footer>
</html>
