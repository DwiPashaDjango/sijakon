@extends('_layouts.app', [
    'title' => 'Dashboard',
    'is_dashboard' => true,
])

@section('content')
@endsection

@section('javascript')
    <script type="text/javascript">
        class Dashboard extends App {
            constructor() {
                super()
            }
        }

        var dashboard = new Dashboard

    </script>
@endsection