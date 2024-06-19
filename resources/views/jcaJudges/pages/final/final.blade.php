@extends('layout.judgesLayout')

@section('judgesNavs')
<div class="d-flex ml-5 gap-5">
    <li class="nav-item d-none d-sm-inline-block"><a
            href="{{ route('final.index')}}"
            class="nav-link">Gown</a></li>

    <li class="nav-item d-none d-sm-inline-block"><a
            href="{{ route('semifinal.index')}}"
            class="nav-link">Semifinal</a></li>
    <li class="nav-item d-none d-sm-inline-block"><a
            href="{{ route('finalJudge.index')}}"
            class="nav-link">Final</a></li>
</div>
@endsection

@section('eventHeader')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Final rating sheet</h1>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('judgesCont')
<form action="{{ route('finalScore') }}" method="POST" id="addFinal">
<div class="p-0">
    @if ($ranks)
                <h5 class="text-center">Respond recorded succesfully. Thank you for your participation!</h5>
            @endif
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tating sheet</h3>
        </div>

        <div class="card-body p-0">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col">Contestants</th>
                        <th scope="col">Beauty (50%)</th>
                        <th scope="col">Poise and projection (35%)</th>
                        <th scope="col">Projection (15%)</th>
                        <th scope="col">Total</th>
                        @if ($ranks)
                        <th>Rank</th>
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
                                @if ($contestant->beauty)
                                    {{ $contestant->beauty }}
                                @else
                                <input type="number" class="form-control w-75 finalBeauty" placeholder="Beauty ...."
                                min="1" max="50" name="finalBeauty[{{ $contestant->id }}]">
                                @endif
                            </td>
                            <td>
                                @if ($contestant->poise)
                                    {{$contestant->poise}}
                                @else
                                    <input type="number" class="form-control w-75 finalPoise"
                                    placeholder="Poise grace ...." min="1" max="50"
                                    name="finalPoise[{{ $contestant->id }}]">
                                @endif
                            </td>
                            <td>
                               @if ($contestant->projection)
                                   {{$contestant->projection}}
                               @else
                               <input type="number" class="form-control w-75 finalProjection"
                               placeholder="Projection ...." min="1" max="50"
                               name="finalProjection[{{ $contestant->id }}]">
                               @endif

                            </td>
                            <td class="finalTotal">
                                @if ($contestant->total)
                                    {{$contestant->total}}
                                @else
                                    0
                                @endif
                            </td>
                            @if ($ranks)
                            <td>
                                {{$contestant->rank}}
                            </td>
                            @endif
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <button type="submit" id="finalCrowSubmitButton" class="btn btn-primary mt-3" disabled>Submit</button>
</div>
<form>
@endsection


@section('judgingScript')
    <script type="module">
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.finalBeauty').on('input', function() {
                const row = $(this).closest('tr');
                const beauty = parseInt(row.find('.finalBeauty').val()) || 0;
                if (beauty < 1) {
                    $(this).val('');
                } else if (beauty > 50) {
                    $(this).val(50);
                }
            });
            $('.finalPoise').on('input', function() {
                const row = $(this).closest('tr');
                const beauty = parseInt(row.find('.finalPoise').val()) || 0;
                if (beauty < 1) {
                    $(this).val('');
                } else if (beauty > 35) {
                    $(this).val(35);
                }
            });
            $('.finalProjection').on('input', function() {
                const row = $(this).closest('tr');
                const beauty = parseInt(row.find('.finalProjection').val()) || 0;
                if (beauty < 1) {
                    $(this).val('');
                } else if (beauty > 15) {
                    $(this).val(15);
                }
            });

            $('.finalBeauty, .finalPoise, .finalProjection').on('input', function() {
                const row = $(this).closest('tr');
                const beauty = parseInt(row.find('.finalBeauty').val()) || 0;
                const semiPoise = parseInt(row.find('.finalPoise').val()) || 0;
                const semiProjection = parseInt(row.find('.finalProjection').val()) || 0;
                const total = beauty + semiPoise + semiProjection;
                row.find('.finalTotal').text(total);

                let totalRate = [];

                const rows = $('tbody tr');
                rows.each(function() {
                    const row = $(this);
                    const initTotal = row.find('.finalTotal').text();
                    let total = 0;

                    if (!isNaN(initTotal)) {
                        total = Number(initTotal);
                    }

                    totalRate.push(total);
                });
                const isMoreThan75 = totalRate.every(rate => rate > 75);
                if (isMoreThan75) {
                    $('#finalCrowSubmitButton').prop('disabled', false);
                } else {
                    $('#finalCrowSubmitButton').prop('disabled', true);
                }
            });


            $('#addFinal').submit(function() {
                event.preventDefault();
                $('#finalCrowSubmitButton').prop('disabled', true);
                const rows = $('tbody tr');
                const rowData = [];
                var url = $(this).attr("action");

                rows.each(function() {
                    const row = $(this);
                    const beauty = row.find('.finalBeauty');
                    const poise = row.find('.finalPoise');
                    const projection = row.find('.finalProjection');
                    const initTotal = row.find('.finalTotal').text();
                    let total = 0;

                    if (!isNaN(initTotal)) {
                        total = Number(initTotal);
                    }

                    const rowObj = {
                        contestantID: row.find('span').text().trim(),
                        beauty: beauty.val(),
                        poise: poise.val(),
                        projection: projection.val(),
                        total
                    };

                    rowData.push(rowObj);
                });

                const filteredData = rowData.filter(data => data.projection !== undefined);
                
                if(filteredData?.length){
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
