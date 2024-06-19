@extends('layout.eventLayout')

@section('eventHeader')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Final 4/Cronation</h1>
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
                    @foreach ($judgesFin as $judge)
                        <th>{{ $judge->name }}</th>
                    @endforeach
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th style="width: 240px">Contestant</th>
                    @foreach ($judgesFin as $judge)
                        <th>Total</th>
                    @endforeach
                    <th>Total</th>
                    <th>Rank</th>
                </tr>
                @foreach ($contestants as $contestant)
                    <tr class="{{ $contestant->rank == 1 ? 'bg-warning':'' }}">
                        <th>{{ $contestant->contestantNum }}.{{ $contestant->name }}</th>
                        @foreach ($contestant->totalRate as $rating)
                            <td>{{ $rating }}</td>
                        @endforeach
                        
                        <td>
                            {{$contestant->total}}
                        </td>
                        <td>
                            {{$contestant->rank}}
                        </td> 
                    </tr>
                @endforeach
            </tbody>
            
        </table>
    </div>

</div>
@endsection