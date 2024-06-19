@extends('layout.eventLayout')

@section('eventHeader')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Preliminary tabulation result</h1>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div>
    </div>
@endsection


@section('eventContent')
    <form action="{{ url('/semiContestantAdd', [
        'event' => $event->id,
    ]) }}" method="POST"
        id="addSemiContestant">
        <div class="card">
            <div class="d-flex justify-content-between align-items-center customTableHeader">
                <h3 class="card-title mr-4">Tabulation</h3>
                <div class="d-flex gap-2">
                    <input type="number" class="form-control form-control-sm" id="topContestant"
                        placeholder="Semi contestant" maxLength="{{ $contestants->count() }}" >
                    <button type="submit" class="btn btn-primary btn btn-sm ml-3" id="submitSemiCont" >Submit</button>
                </div>
            </div>

            <div class="card-body p-0">
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Preliminary</th>
                            <th>Swimwear</th>
                            <th>Gown</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Contestant</th>
                            <th>Rank</th>
                            <th>Rank</th>
                            <th>Rank</th>
                            <th>Total</th>
                            <th>Rank</th>
                        </tr>
                        @foreach ($contestants as $con)
                            <tr class="rank-{{ $con->totalRank }} {{$con->atSemi ? 'bg-warning':''}}" data-id="{{ $con->id }}">
                                <th><span style="visibility:hidden">{{ $con->id }}</span> {{ $con->contestantNum }}.
                                    {{ $con->name }}</th>
                                <td>{{ $con->preliminaryRank }}</td>
                                <td>{{ $con->swimwearRank }}</td>
                                <td>{{ $con->gownRank }}</td>
                                <td>{{ $con->total }}</td>
                                <td>{{ $con->totalRank }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script type="module">
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            let selectedIds = []; // Array to store selected IDs

            $("#topContestant").on('input', function() {
                const curValue = parseInt($(this).val(), 10); // Get the current input value
                const totalRanks = {!! json_encode($contestants->pluck('totalRank')) !!}; // Get an array of totalRanks

                var max = $(this).attr("maxLength");

                if (curValue < 1) {
                    $(this).val('');
                }
                if (curValue > max) {
                    $(this).val(max);
                }

                // Reset background color for all elements with class starting with "rank-"
                $("tbody tr").css("background-color", "");
                selectedIds = [];

                // Highlight rows up to the input value
                for (let x = 1; x <= curValue; x++) {
                    $(`.rank-${x}`).css("background-color", "yellow");
                    selectedIds.push({
                        id: $(`.rank-${x}`).data("id"),
                        rank: $(`.rank-${x} td:last-child`)
                            .text() * 1,
                        category: 'semi'
                        // Get the text content of the last <td> element in the row
                    }); // Push IDs to the array
                }

                // Remove IDs from the array for rows where totalRank is greater than input value
                totalRanks.forEach(rank => {
                    if (rank > curValue) {
                        const index = selectedIds.indexOf($(`.rank-${rank}`).data("id"));
                        if (index !== -1) {
                            selectedIds.splice(index, 1);
                        }
                    }
                });
            });

            $('#addSemiContestant').submit(function(event) {
                event.preventDefault();
                var url = $(this).attr("action");

                let completedRequests = 0;
                const totalRequests = selectedIds.length;

                for (let x = 0; x < totalRequests; x++) {
                    const formData = selectedIds[x];
                    processedData(formData);

                    function processedData (formData) {
                        $.post(url, formData)
                        .done(function(response) {
                            completedRequests++;

                            if (completedRequests === totalRequests) {
                                // location.reload();
                            }
                        })
                        .fail(function(error) {
                            console.error('Error:', error);
                            completedRequests++;
                            if (completedRequests === totalRequests) {
                                processedData(formData);
                            }
                        });
                    }

                }
            })
        });
    </script>
@endsection

<style>
    .customTableHeader {
        border-bottom: 1px solid lightgray;
        padding: 10px;
    }

    #topContestant {
        width: 180px;
    }
</style>
