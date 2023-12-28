@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div id="container_top_request"></div>
                    </div>
                    
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div id="container" style="width: 50%"></div>

                        <div id="container_2" style="width: 50%"></div>
                    </div>
                    
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div id="container_3" style="width: 50%"></div>

                        <div id="container_4" style="width: 50%"></div>
                    </div>

                    <div class="row">
                        <div id="container_5" style="width: 50%"></div>
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
        var array_data_paddy =  {{ Js::from($array_data_paddy) }};
        var array_data_seafood =  {{ Js::from($array_data_seafood) }};
        var array_data_fresh_fruits =  {{ Js::from($array_data_fresh_fruits) }};
        var all_order =  {{ Js::from($all_order) }};

        Highcharts.chart('container_top_request', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Top Product Has Request'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                type: 'category',
                min: 0,
                max: 20,
                tickLength: 0,
                labels: {
                    formatter: function() {
                        return typeof this.value !== 'number' ? this.value : ''
                    }
                }
            },
            yAxis: {
                title: {
                    text: 'Quantity (KG)'
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
                name: 'Order Quantity',
                data: all_order
            }]
        });
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
                labels: {
                    formatter: function() {
                        return typeof this.value !== 'number' ? this.value : ''
                    }
                }
            },
            yAxis: {
                title: {
                    text: 'Quantity (KG)'
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
                labels: {
                    formatter: function() {
                        return typeof this.value !== 'number' ? this.value : ''
                    }
                }
            },
            yAxis: {
                title: {
                    text: 'Quantity (KG)'
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

        Highcharts.chart('container_3', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Paddy Product With High Quantity (KG)'
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
                data: array_data_paddy
            }]
        });

        Highcharts.chart('container_4', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'SeaFood Product With High Quantity (KG)'
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
                data: array_data_seafood
            }]
        });

        Highcharts.chart('container_5', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Fresh - Fruits Product With High Quantity (KG)'
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
                data: array_data_fresh_fruits
            }]
        });
        
    </script>
@endpush