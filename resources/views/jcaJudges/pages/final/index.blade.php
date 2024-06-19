@extends('layout.judgesLayout')


@section('judgesNavs')
    <div class="d-flex ml-5 gap-5">
        <li class="nav-item d-none d-sm-inline-block"><a href="{{ route('final.index') }}" class="nav-link">Gown</a></li>

        <li class="nav-item d-none d-sm-inline-block"><a href="{{ route('semifinal.index') }}" class="nav-link">Semifinal</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block"><a href="{{ route('finalJudge.index') }}" class="nav-link">Final</a></li>
    </div>
@endsection

@section('eventHeader')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Gown rating sheet</h1>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div>
    </div>
@endsection


@section('judgesCont')
    <form action="{{ route('gownScore') }}" method="POST" id="addGown">

        <div class="p-0">
            @if ($isRecorded)
                <h5 class="text-center">Respond recorded succesfully. Thank you for your participation!</h5>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tabulation</h3>
                </div>

                <div class="card-body p-0">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th scope="col">Contestants</th>
                                <th scope="col">Suitability (50%)</th>
                                <th scope="col">Projection (50%)</th>
                                <th scope="col">Total</th>
                                @if ($isRecorded)
                                    <th scope="col">Rank</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($contestants as $contestant)
                                <tr>
                                    <th>
                                        <span
                                            style="visibility: hidden">{{ $contestant->id }}</span>{{ $contestant->contestantNum }}.
                                        {{ $contestant->name }}
                                    </th>
                                    <td>
                                        @if ($contestant->suitability)
                                            {{ $contestant->suitability }}
                                        @else
                                            <input type="number" class="form-control w-75 gownSuitability"
                                                placeholder="Suitability" min="1" max="50"
                                                name="gownSuitability">
                                        @endif
                                    </td>
                                    <td>
                                        @if ($contestant->projection)
                                            {{ $contestant->projection }}
                                        @else
                                            <input type="number" class="form-control w-75 gownProjection"
                                                placeholder="Projection" min="1" max="50"
                                                name="gownProjection">
                                        @endif
                                    </td>
                                    <td class="gownTotal">
                                        @if ($contestant->projection && $contestant->suitability)
                                            {{ $contestant->projection + $contestant->suitability }}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    @if ($isRecorded)
                                        <td>
                                            {{ $contestant->rank }}
                                        </td>
                                    @endif

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            <button type="submit" id="gownSubmitButton" class="btn btn-primary mt-3" disabled>Submit</button>

        </div>

    </form>
@endsection


@section('judgingScript')
    <script type="module">
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let totalRate = [];

            $('input[type="number"]').on('input', function() {
                var value = parseInt($(this).val(), 10);
                if (value < 1) {
                    $(this).val(1);
                } else if (value > 50) {
                    $(this).val(50);
                }

                const row = $(this).closest('tr');
                const suitability = parseInt(row.find('.gownSuitability').val()) || 0;
                const projection = parseInt(row.find('.gownProjection').val()) || 0;
                const total = suitability + projection;
                row.find('.gownTotal').text(total);

                totalRate = [];

                const rows = $('tbody tr');
                rows.each(function() {
                    const row = $(this);
                    const initTotal = row.find('.gownTotal').text();
                    let total = 0;

                    if (!isNaN(initTotal)) {
                        total = Number(initTotal);
                    }

                    totalRate.push(total);
                });

                const isMoreThan75 = totalRate.every(rate => rate > 75);
                if (isMoreThan75) {
                    $('#gownSubmitButton').prop('disabled', false);
                } else {
                    $('#gownSubmitButton').prop('disabled', true);
                }

            });

            $('#addGown').submit(function() {
                event.preventDefault();
                $('#gownSubmitButton').prop('disabled', true);
                const rows = $('tbody tr');
                const rowData = [];
                var url = $(this).attr("action");

                rows.each(function() {
                    const row = $(this);
                    const composureInput = row.find('.gownSuitability');
                    const projectionInput = row.find('.gownProjection');
                    const initTotal = row.find('.gownTotal').text();
                    let total = 0;

                    if (!isNaN(initTotal)) {
                        total = Number(initTotal);
                    }

                    const rowObj = {
                        contestantID: row.find('span').text().trim(),
                        suitability: composureInput.val(),
                        projection: projectionInput.val(),
                        total
                    };

                    rowData.push(rowObj);
                });
                const filteredData = rowData.filter(data => data.projection !== undefined);

                if (filteredData?.length) {
                    sendData(filteredData, url)
                }
            });
        });

        function sendData(data, url) {
            let completedRequests = 0;
            const totalRequests = data.length;

            for (let x = 0; x < totalRequests; x++) {
                const formData = data[x];
                processedData(formData);

                function processedData(formData) {
                    $.post(url, formData)
                        .done(function(response) {
                            completedRequests++;

                            if (completedRequests === totalRequests) {
                                location.reload();
                            }
                        })
                        .fail(function(error) {
                            processedData(formData);
                            completedRequests++;
                        });
                }
            }
        }
    </script>
@endsection
