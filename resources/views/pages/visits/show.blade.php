@extends('layouts.app')

@section('title', 'Посещение: ' . $visit->datetime)

@section('content')
    @include('components.form-alert')

    <div class="row">
        <div class="col-md-3">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Информация</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <strong><i class="fas fa-book mr-1"></i> Ресторан</strong>
                    <p class="text-muted">{{ $visit->restaurant->name }}</p>
                    <hr>
                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Местоположение</strong>
                    <p class="text-muted">{{ $visit->restaurant->location }}</p>
                    <hr>
                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Группа</strong>
                    <p class="text-muted"> {{ $visit->group->name }}</p>
                    @can('edit visits')
                    <a class="btn btn-info btn-sm" href="{{ route('visits.edit', $visit->id) }}">
                        <i class="fas fa-pencil-alt"></i> Изменить
                    </a>
                    @endcan
                    @can('delete visits')
                    <button type="submit" class="btn btn-danger btn-sm btn-delete" form="destroy-{{ $visit->id }}">
                        <i class="fas fa-trash"></i> Удалить
                    </button>
                    <form method="POST" action="{{ route('visits.destroy', $visit->id) }}" id="destroy-{{ $visit->id }}" hidden>
                        @csrf
                        @method('DELETE')
                    </form>
                    @endif
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Заметка</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    {{ $visit->notes }}
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
