@extends('layout.eventLayout')


@section('eventHeader')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Judges</h1>
            </div>
        </div>
    </div>
</div>
@endsection

@section('eventContent')

    @include('facilitator.singleEvent.judges.byCategory.preliminary')
    @include('facilitator.singleEvent.judges.byCategory.final')

@endsection
