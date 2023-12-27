@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div id="container" style="width: 50%"></div>

                        <div id="container_2" style="width: 50%"></div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 

@push('scripts')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script type="text/javascript">
        var array_data =  {{ Js::from($array_data) }};
        var array_data_short_life =  {{ Js::from($array_data_short_life) }};
        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Product With High Quantity'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                type: 'category',
                min: 0,
                max: 10,
                tickLength: 0,
            },
            yAxis: {
                title: {
                    text: 'Quantity'
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
                name: 'Quantity Stock',
                data: array_data
            }]
        });

        Highcharts.chart('container_2', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Product Short Shelf Life With High Quantity'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                type: 'category',
                min: 0,
                max: 10,
                tickLength: 0,
            },
            yAxis: {
                title: {
                    text: 'Quantity'
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
                name: 'Quantity Stock',
                data: array_data_short_life
            }]
        });
        
    </script>
@endpush