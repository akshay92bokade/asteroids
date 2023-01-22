@extends('layouts.app')

@push('styles')

@endpush
    
@section('content')

<div class="container">
    <div class="row justify-content-center">

        <div class="col-sm-4">
            <div class="card">
                <div class="card-header text-center"><h3>Fastest Asteroid:<h3></div>
                <div class="card-body">
                    <strong>Id:</strong> {{ $fastest['id'] }}<br>
                    <strong>Speed:</strong> {{ $fastest['speed'] }} km/hr<br>
                    <strong>Date:</strong> {{ $fastest['date'] }}
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="card">
                <div class="card-header text-center"><h3>Fastest Asteroid:<h3></div>
                <div class="card-body">
                    <strong>Id:</strong> {{ $closest['id'] }}<br>
                    <strong>Distance:</strong> {{ $closest['distance'] }} km<br>
                    <strong>Date:</strong> {{ $closest['date'] }}
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="card">
                <div class="card-header text-center"><h3>Average Size:<h3></div>
                <div class="card-body">
                    <strong>Size:</strong> {{ $avgSize }} km<br>
                    
                </div>
            </div>
        </div>

        <canvas id="myChart" class="col-sm-12"></canvas>

        <div class="col-sm-12">
            <a href="{{ url('/') }}" class="btn btn-success">Go Back</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
    </script>

    <script>
        var xValues = @php echo json_encode($dates) @endphp;
        var yValues = @php echo json_encode($count) @endphp;

        new Chart("myChart", {
        type: "bar",
        data: {
            labels: xValues,
            datasets: [{
            backgroundColor: "green",
            data: yValues
            }]
        },
        options: {
            legend: {display: false},
            title: {
            display: true,
            text: "No. of asteroids each day"
            }
        }
        });
    </script>
@endpush