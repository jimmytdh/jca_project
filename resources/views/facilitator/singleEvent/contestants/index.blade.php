@extends('layout.eventLayout')

@section('eventHeader')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Contestant</h1>
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
            <h3 class="card-title">Registered contestant</h3>


            @include('facilitator.singleEvent.contestants.addContestantModal')




        </div>
        <div class="card-body p-0">
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>Number</th>
                        <th>Address</th>
                        <th>Photo</th>
                        <th>Age</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contestants as $contestant)
                        <tr>
                            <th>{{ $contestant->contestantNum }}. {{ $contestant->name }}</th>
                            <td>{{ $contestant->address }}</td>
                            <td>
                                {{ $contestant->id }}
                                {{-- <img src="{{ url('public/Image/'.$contestant->photo) }}"
            style="height: 100px; width: 150px;"> --}}
                            </td>
                            <td>{{ $contestant->age }}</td>
                            <td class="d-flex gap-2">

                                <div>
                                    @include('facilitator.singleEvent.contestants.editContestant')
                                </div>

                                <form method="POST"
                                    action="{{ route('contestant.delete', [
                                        'contestant' => $contestant->id,
                                        'event' => $event->id,
                                    ]) }}">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn btn-sm"><i
                                            class="fa fa-trash"></i></button>
                                </form>

                                <div>
                                    @include('facilitator.singleEvent.contestants.viewContestant')
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>


    </div>
    @endsection
