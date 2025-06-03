@extends('layouts.app')

@section('title', $restaurant->name)

@section('content')
    @include('components.form-alert')

    <div class="row">
        <div class="col-md-3">
            <div class="card card-primary">
                <div class="card-body">
                    <strong><i class="fas fa-book mr-1"></i> Category</strong>
                    <p class="text-muted">{{ $restaurant->category->name }}</p>
                    <hr>
                    <strong><i class="fas fa-book mr-1"></i> About</strong>
                    <p class="text-muted">{{ $restaurant->description }}</p>
                    <hr>
                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
                    <p class="text-muted">$restaurant->location</p>
                    @if ($restaurant->yandex_map_widget)
                        <p>
                            <iframe src="{{ $restaurant->yandex_map_widget }}" allowfullscreen="true" frameborder="0"
                                width=100% height="400"></iframe>
                        </p>
                    @endif
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Statistics</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Всего посещений</span>
                                    <span class="info-box-number text-center text-muted mb-0">
                                        123
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">последнее посещение</span>
                                    <span class="info-box-number text-center text-muted mb-0">
                                        {{ $restaurant->created_at }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">в бане</span>
                                    <span class="info-box-number text-center text-muted mb-0">
                                        1
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <!-- small card -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>9.5</h3>
                                    <p>Средняя оценка</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                    Все оценки <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-6 col-12">
                            <!-- small card -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>9.8</h3>
                                    <p>Ваша оценка</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                    Изменить оценку <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg">$18,230.00</span>
                                    <span>Sales Over Time</span>
                                </p>
                                <p class="ml-auto d-flex flex-column text-right">
                                    <span class="text-success">
                                        <i class="fas fa-arrow-up"></i> 33.1%
                                    </span>
                                    <span class="text-muted">Since last month</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->

                            <div class="position-relative mb-4">
                                <canvas id="sales-chart" height="200"></canvas>
                            </div>

                            <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2">
                                    <i class="fas fa-square text-primary"></i> This year
                                </span>

                                <span>
                                    <i class="fas fa-square text-gray"></i> Last year
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Comments</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body card-comments">
                    <div class="card-comment">
                        <!-- User image -->
                        <img class="img-circle img-sm" src="../dist/img/user3-128x128.jpg" alt="User Image">
                        <div class="comment-text">
                            <span class="username">
                                Maria Gonzales
                                <span class="text-muted float-right">8:03 PM Today</span>
                            </span><!-- /.username -->
                            It is a long established fact that a reader will be distracted
                            by the readable content of a page when looking at its layout.
                        </div>
                        <!-- /.comment-text -->
                    </div>
                    <!-- /.card-comment -->
                    <div class="card-comment">
                        <!-- User image -->
                        <img class="img-circle img-sm" src="../dist/img/user5-128x128.jpg" alt="User Image">
                        <div class="comment-text">
                            <span class="username">
                                Nora Havisham
                                <span class="text-muted float-right">8:03 PM Today</span>
                            </span><!-- /.username -->
                            The point of using Lorem Ipsum is that it hrs a morer-less
                            normal distribution of letters, as opposed to using
                            'Content here, content here', making it look like readable English.
                        </div>
                        <!-- /.comment-text -->
                    </div>
                    <!-- /.card-comment -->
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <form action="#" method="post">
                            <img class="img-fluid img-circle img-sm" src="../dist/img/user4-128x128.jpg" alt="Alt Text">
                            <!-- .img-push is used to add margin to elements next to floating images -->
                            <div class="img-push">
                                <input type="text" class="form-control form-control-sm" placeholder="Press enter to post comment">
                            </div>
                        </form>
                    </div>
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
@endsection

@section('inline-script')
    $(function () {
      'use strict'

      var ticksStyle = {
        fontColor: '#495057',
        fontStyle: 'bold'
      }

      var mode = 'index'
      var intersect = true

      var $salesChart = $('#sales-chart')
      new Chart($salesChart, {
        type: 'bar',
        data: {
          labels: ['JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
          datasets: [
            {
              backgroundColor: '#007bff',
              borderColor: '#007bff',
              data: [1000, 2000, 3000, 2500, 2700, 2500, 3000]
            },
            {
              backgroundColor: '#ced4da',
              borderColor: '#ced4da',
              data: [700, 1700, 2700, 2000, 1800, 1500, 2000]
            }
          ]
        },
        options: {
          maintainAspectRatio: false,
          tooltips: {
            mode: mode,
            intersect: intersect
          },
          hover: {
            mode: mode,
            intersect: intersect
          },
          legend: {
            display: false
          },
          scales: {
            yAxes: [{
              // display: false,
              gridLines: {
                display: true,
                lineWidth: '4px',
                color: 'rgba(0, 0, 0, .2)',
                zeroLineColor: 'transparent'
              },
              ticks: $.extend({
                beginAtZero: true,

                // Include a dollar sign in the ticks
                callback: function (value) {
                  if (value >= 1000) {
                    value /= 1000
                    value += 'k'
                  }

                  return '$' + value
                }
              }, ticksStyle)
            }],
            xAxes: [{
              display: true,
              gridLines: {
                display: false
              },
              ticks: ticksStyle
            }]
          }
        }
      })
    });
@endsection
