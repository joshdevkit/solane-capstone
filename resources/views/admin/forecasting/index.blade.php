@extends('layouts.app')

@section('title', 'FORECASTING - Dashboard')

@section('content')
    <div class="py-12 lg:ml-64 mx-auto max-w-full mt-16">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-xl font-bold">Data Forecasting</h1>
                    <div class="flex justify-end items-center mb-4">
                        <button id="generateForecastBtn"
                            class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600 mr-4">
                            Generate Forecast
                        </button>
                    </div>

                </div>
            </div>

            <div id="forecastChart" style="margin-top: 20px; height: 400px;"></div>
        </div>
    </div>

    <script>
        document.getElementById('generateForecastBtn').addEventListener('click', function() {
            document.getElementById('forecastChart').innerHTML = 'Loading forecast...';

            fetch("{{ route('forecast.generate') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const forecastDates = data.forecast.map(item => item.date);
                        const forecastSales = data.forecast.map(item => item.predicted_sales);

                        const options = {
                            chart: {
                                type: 'line',
                                height: 400,
                            },
                            series: [{
                                name: 'Predicted Sales',
                                data: forecastSales
                            }],
                            xaxis: {
                                categories: forecastDates,
                                title: {
                                    text: 'Month'
                                }
                            },
                            yaxis: {
                                title: {
                                    text: 'Sales'
                                }
                            },
                            title: {
                                text: 'Sales Forecast for the Next 12 Months',
                                align: 'center'
                            }
                        };

                        const chart = new ApexCharts(document.querySelector("#forecastChart"), options);
                        chart.render();
                    }
                })
                .catch(error => {
                    console.error('Error generating forecast:', error);
                });
        });
    </script>

@endsection
