@extends('layout.eventLayout')

@section('eventHeader')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Swimwear score result</h1>
                </div>
                <div class="col-sm-6">
                    
                </div>
            </div>
        </div>
    </div>
@endsection

@section('eventContent')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tabulation</h3>
        </div>

        <div class="card-body p-0">
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th></th>
                        @foreach ($judges as $judge)
                            <th>{{ $judge->name }}</th>
                        @endforeach
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th style="width: 240px">Contestant</th>
                        @foreach ($judges as $judge)
                            <th>Total</th>
                        @endforeach
                        <th>Total</th>
                        <th>Rank</th>
                    </tr>
                    @foreach ($contestants as $contestant)
                        <tr>
                            <th>{{ $contestant->contestantNum }}.{{ $contestant->name }}</th>
                            @foreach ($contestant->total as $total)
                                <td>{{$total}}</td>
                            @endforeach
                            <td>{{$contestant->totalRate}}</td>
                            <td>{{$contestant->rank}}</td>
                        </tr>
                    @endforeach
                </tbody>
                
            </table>
        </div>

    </div>
@endsection
