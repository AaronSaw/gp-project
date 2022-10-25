@extends('layouts.app')

@section('content')
            <div class="col-md-12">

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Test</li>
                    </ol>
                </nav>
                {{-- <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif --}}

                {{-- {{ __('You are logged in!') }}
                    <br>
                    {{ Auth::user() }} --}}


                <div class="row mb-3">
                    <div class="col-6 ">
                        <div class="card">
                            <div class="card-body">
                                <canvas id="op" width="100%" height="100%"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <canvas id="ol" width="100%" height="100%"></canvas>
                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </div>

    </div>
@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"
        integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @php

        use App\Http\Controllers\PostController;
        use App\Models\Category;


        $dataArr = [];
        $visitorRate = [];
        $transitonRate = [];
        $today = date('Y-m-d');
        //date 10၇◌က် နုတ်ရန်
        for ($i = 0; $i < 10; $i++) {
            $date = date_create($today);

            date_sub($date, date_interval_create_from_date_string("$i days"));
            $current = date_format($date, 'Y-m-d');

            array_push($dataArr, $current);

            $result = PostController::countTotal('views', $current);
            //create at ကိုdate ပြောင်းရန်
            array_push($visitorRate, $result);
        }

        $catName = [];
        $countPostByCategory = [];
        foreach (Category::all() as $c) {
            array_push($catName,$c->title);

            array_push($countPostByCategory, PostController::countPost('posts', $c->id));
        }
    @endphp
    <script>
        let dateArr = {!! json_encode($dataArr) !!};
        let viewerCountArr = {!! json_encode($visitorRate) !!};
        let op = document.getElementById('op').getContext('2d');
        let opChart = new Chart(op, {
            type: 'line',
            data: {
                labels: dateArr,
                datasets: [{
                    label: '# of Votes',
                    data: viewerCountArr,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        display: false,
                        ticks: {
                            beginAtZero: true
                        }
                    }],
                    xAxes: [{
                        display: false
                    }]
                },
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        fontColor: '#dc3545',
                        usePointStyle: true
                    }
                }
            }
        });

        //post and Category
        let catArr = {!! json_encode($catName) !!};
        let CountPostArr = {!! json_encode($countPostByCategory) !!};
        let ol = document.getElementById('ol').getContext('2d');
        let olChart = new Chart(ol, {
            type: 'bar',
            data: {
                labels: catArr,
                datasets: [{
                    label: '# of Votes',
                    data: CountPostArr,
                    backgroundColor: [
                        '#7D0552',
                        '#FF0000',
                        '#52D017',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        '#00FF00',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                    scales: {
                        y: {
                            display: true,
                            beginAtZero: false,
                            ticks: {
                                color: 'green',
                                font: {
                                    size: 15,
                                }
                            }
                        },
                        x: {
                            display: true,
                            ticks: {
                                color: 'green',
                                font: {
                                    size: 15,
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            shape: "circle",
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                backgroundColor: 'rgba(255, 159, 64, 1)',
                                color: 'rgba(255, 159, 64, 1)',
                                // This more specific font property overrides the global property
                                font: {
                                    size: 10,
                                },
                            }
                        }
                    }
                }
        });
    </script>
@endpush
