@extends('layouts.admin')

@section('title-website') Logs @endsection
@section('title') Logs @endsection

@section('content')
@php
    use Jenssegers\Date\Date;

    Date::setLocale('id');
@endphp
@include('admin.logs.modal')
    <div class="col-md-12">
        <ul class="timeline">
            <div id="data-logs">
                @foreach ($activities as $data)
                @php
                    $dateDay = Date::parse($data->created_at)->locale('id_ID')->isoFormat('LLLL');
                    $dateTimeLine = Date::parse($data->updated_at)->locale('id_ID')->isoFormat('ll');
                    if ($data->description == 'created'):
                        $customDesc = 'membuat';
                    elseif($data->description == 'updated'):
                        $customDesc = 'mengubah';
                    elseif($data->description == 'deleted'):
                        $customDesc = 'menghapus';
                    endif;
                @endphp
                    <div class="timeline">

                        <!-- timeline time label -->
                        <li class="time-label">
                            @if ($data->description == 'created')
                                <span class="bg-blue">
                                    {{ $dateTimeLine }}
                                </span>
                            @elseif($data->description == 'updated')
                                <span class="bg-yellow">
                                    {{ $dateTimeLine }}
                                </span>
                            @elseif($data->description == 'deleted')
                                <span class="bg-red">
                                    {{ $dateTimeLine }}
                                </span>
                            @elseif($data->description == 'login')
                                <span class="bg-green">
                                    {{ $dateTimeLine }}
                                </span>
                            @endif
                        </li>
                        <!-- /.timeline-label -->

                        <!-- timeline item -->
                        @if ($data->description != 'login')
                            <li>
                                @if ($data->description == 'created')
                                    <i class="fa fa-user bg-green"></i>
                                @elseif($data->description == 'updated')
                                    <i class="fa fa-user bg-yellow"></i>
                                @elseif($data->description == 'deleted')
                                    <i class="fa fa-user bg-red"></i>
                                @endif


                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i> {{ $data->updated_at->diffForHumans() }}</span>

                                    <h3 class="timeline-header"><a href="#">{{ $data->causer->name }}</a> {{ $customDesc }} sesuatu</h3>

                                    <div class="timeline-body">
                                        Pada Hari {{ $dateDay }}, {{ $data->causer->name }} melakukan perubahan pada model <b>{{ substr($data->subject_type, 4) }}</b>
                                        <ul>
                                            @if($data->description == 'updated')
                                                <li>Data {{ substr($data->subject_type, 4) }} dengan nama
                                                    @foreach($data->properties['old'] as $attr => $old)
                                                        @if($attr == 'nama')
                                                            <b>{{ $old }}</b> diubah menjadi
                                                            <b>{{ $data->properties['attributes'][$attr] }}</b>
                                                        @endif
                                                    @endforeach
                                            @elseif($data->description == 'created')
                                                <li>Data {{ substr($data->subject_type, 4) }} dengan nama
                                                        @foreach($data->properties['attributes'] as $attr => $old)
                                                            @if($attr == 'nama')
                                                                <b>{{ $old }}</b> telah dibuat
                                                            @endif
                                                        @endforeach
                                            @elseif($data->description == 'deleted')
                                                <li>Data {{ substr($data->subject_type, 4) }} dengan nama
                                                        @foreach($data->properties['attributes'] as $attr => $old)
                                                            @if($attr == 'nama')
                                                                <b>{{ $old }}</b> telah hapus
                                                            @endif
                                                        @endforeach
                                            @endif

                                        </ul>
                                    </div>
                                    <div class="timeline-footer">
                                        @if($data->description == 'updated')
                                            <span class="label label-warning">PATCH / PUT</span>
                                        @elseif($data->description == 'deleted')
                                            <span class="label label-danger">DELETE</span>
                                        @elseif($data->description == 'created')
                                            <span class="label label-primary">POST</span>
                                        @endif
                                        <a data-id="{{ $data->id }}" id="tombHapusLog" href="javascript:void(0)" class="label label-danger" data-toggle="modal" data-target="#modalHapusLog">HAPUS LOG</a>
                                    </div>
                                </div>
                            </li>
                        @endif

                        @if ($data->description == 'login')
                            <li>
                                <i class="fa fa-user bg-aqua"></i>

                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i> {{ $data->updated_at->diffForHumans() }}</span>

                                    <h3 class="timeline-header"><a href="#">{{ $data->causer->name }}</a> {{ $data->description }} kedalam akun</h3>

                                    <div class="timeline-body">
                                        Pada Hari {{ $dateDay }}, {{ $data->causer->name }} melakukan Login</b>
                                        <ul>
                                            @foreach($data->properties as $k)
                                                <li><b>{{ $k }}</b></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="timeline-footer">
                                        <span class="label label-success">POST</span>
                                        <a data-id="{{ $data->id }}" id="tombHapusLogi" href="javascript:void(0)" class="label label-danger" data-toggle="modal" data-target="#modalHapusLog">HAPUS LOG</a>
                                    </div>
                                </div>
                            </li>
                        @endif

                        <!-- END timeline item -->
                    </div>
                @endforeach
            </div>
            <div class="pagination-logs">
                {{ $activities->links() }}
            </div>
        </ul>
        <!-- The time line -->

        <!-- timeline item -->
    </div>
@endsection

@section('css')

  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/skins/_all-skins.min.css') }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
@endsection

@push('js')
    <!-- jQuery 3 -->
    <script src="{{ asset('AdminLTE/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('AdminLTE/bower_components/fastclick/lib/fastclick.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('AdminLTE/dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('AdminLTE/dist/js/demo.js') }}"></script>
    <script src="https://momentjs.com/downloads/moment.min.js"></script>
    <script src="https://momentjs.com/downloads/moment-timezone-with-data.min.js"></script>

    <script>
        // var moment = require('./node-modules/moment-timezone');

        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Data Logs
            $.ajax({
                url: "{{ route('logs.index') }}",
                method: "GET",
                success: (res) => {

                    $.each(res.data, function(k, v) {
                        moment.locale('id');
                        moment.locale();
                        moment.tz.add("Asia/Jakarta|BMT +0720 +0730 +09 +08 WIB|-77.c -7k -7u -90 -80 -70|01232425|-1Q0Tk luM0 mPzO 8vWu 6kpu 4PXu xhcu|31e6")
                        var TzAsiaJakarta = moment(''+v.updated_at+'');

                        var desc, bgDate, day, method;

                        if(v.description == 'updated') {
                            var desc = 'mengubah';
                            var method = 'PUT / PACTH';
                            var bgDate = 'bg-yellow';
                            var colorLabel = 'warning';
                        } else if (v.description == 'created') {
                            var desc = 'menambah';
                            var method = 'POST';
                            var bgDate = 'bg-green';
                            var colorLabel = 'success';
                        } else if (v.description == 'deleted') {
                            var desc = 'menghapus';
                            var method = 'DELETE';
                            var bgDate = 'bg-red';
                            var colorLabel = 'danger';
                        }

                        if (TzAsiaJakarta.tz("Asia/Taipei").format('dddd') == 'Sunday') {
                            var day = 'Minggu'
                        } else if (TzAsiaJakarta.tz("Asia/Taipei").format('dddd') == 'Monday') {
                            var day = 'Senin'
                        } else if (TzAsiaJakarta.tz("Asia/Taipei").format('dddd') == 'Tuesday') {
                            var day = 'Selasa'
                        } else if (TzAsiaJakarta.tz("Asia/Taipei").format('dddd') == 'Wednesday') {
                            var day = 'Rabu'
                        } else if (TzAsiaJakarta.tz("Asia/Taipei").format('dddd') == 'Thursday') {
                            var day = 'Kamis'
                        } else if (TzAsiaJakarta.tz("Asia/Taipei").format('dddd') == 'Friday') {
                            var day = 'Jumat'
                        } else if (TzAsiaJakarta.tz("Asia/Taipei").format('dddd') == 'Saturday') {
                            var day = 'Sabtu'
                        }

                    })

                    // $('.pagination-logs').append(`
                    //     <ul class="pagination pagination-sm no-margin pull-left" style="${ (!res.prev_page_url) ? 'display: none;' : '' }">
                    //         <li><a id="prev-logs" href="${res.prev_page_url}">Sebelumnya</a></li>
                    //     </ul>
                    //     <ul class="pagination pagination-sm no-margin pull-right" style="${ (!res.next_page_url) ? 'display: none;' : '' }">
                    //         <li><a id="next-logs" href="${res.next_page_url}">Selanjutnya</a></li>
                    //     </ul>
                    // `)
                },
                error: (err) => {
                    console.log(err);

                }
            })

            // Get ID Logs
            $('#modalHapusLog').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var id = button.data('id')

                var modal = $(this)

                modal.find('#hidden-id-log').val(id)
            })

            // Hapus Log
            $('#formHapusLog').on('submit', function (e) {
                e.preventDefault();

                var id = $('#hidden-id-log').val()

                $.ajax({
                    url: '/admin/logs/'+id,
                    method: 'DELETE',
                    data: {
                        password: $('input[name="password"]').val()
                    },
                    success: (res) => {
                        if(res.errors) {
                            $.each(res.errors, function(k, v) {
                            $('.notify-alert-delete-log').show();
                            $('.notify-alert-delete-log').html('')
                            $('.notify-alert-delete-log').append(
                                    `
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <h4><i class="icon fa fa-ban"></i> Upss!</h4>
                                        ${v}
                                    </div>
                                    `
                                )
                            })
                        } else {
                            console.log(res.message);
                            alert(res.message);
                            location.reload();
                            $('#formHapusLog')[0].reset();
                        }
                    },
                    error: (err) => {
                        console.log(err);
                    }
                })

            })
        })
    </script>
@endpush
