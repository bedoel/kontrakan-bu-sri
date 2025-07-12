<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('title', 'Kontrakan Bu Sri - Admin')</title>
    <link href="{{ asset('back/assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="{{ asset('back/assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('back/assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    @stack('styles')
</head>

<body id="page-top">
    <div id="wrapper">
        @include('admin.partials.sidebar')
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('admin.partials.topbar')
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            @include('admin.partials.footer')
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    @include('admin.partials.logout-modal')

    <script src="{{ asset('back/assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('back/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('back/assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('back/assets/js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('back/assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('back/assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('back/assets/vendor/chart.js/Chart.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.datatable').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    zeroRecords: "Tidak ada data ditemukan",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data tersedia",
                    paginate: {
                        previous: '<i class="bi bi-chevron-left"></i>',
                        next: '<i class="bi bi-chevron-right"></i>'
                    }
                }
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
