@extends('layouts.layout')

@section('title', 'Report')

@section('content')


<body>
    <style>
        thead {
            position: sticky;
            top: 0;
        }

        thead::after {
            content: "";
            height: 0.5px;
            background-color: #ccc;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
        }

        .output {
            display: flex;
            justify-content: space-evenly;
        }

        @media print {
            * {
                color: black !important;
                font-size: 12px !important;
            }

            div {
                overflow: unset !important;
            }

            .navbar-brand img {
                content: url("/images/logo-light.svg");
                width: 200px;
            }
        }

        @page {
            size: portrait;
        }

        .maxHeight {
            max-height: 80vh;
        }
    </style>

    <div class="container mt-4 mb-5">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">{{_("Home")}}</a></li>
                <li class="breadcrumb-item"><a href="/transaction">{{_("Transaction")}}</a></li>
                <li class="breadcrumb-item active" aria-current="page"><span style="color:gold">{{_("Report")}}</span></li>
            </ol>
        </nav>
        @if(isset($data))
        <h3 class="text-bg-warning text-center">{{__('Report')}}</h3>
        <div class="row">
            <h5 class="col">{{__('Current Gold Price (/g)')}} ({{$cdata["currentGoldPrice_updTime"]}}):
                <span class="text-warning">{{number_format($cdata["currentGoldPrice_USDg"], 2)}}&nbspUSD&nbsp&nbsp{{number_format($cdata["currentGoldPrice_USDg"]*$cdata["exchangeRate"], 2)}}&nbspMYR</span>
            </h5>
            <h5 class="col">
                {{__('Current Exchange Rate (MYR/USD)')}} ({{$cdata["exchangeRate_updTime"]}}):
                <span class="text-warning">{{number_format($cdata["exchangeRate"], 2)}}</span>
            </h5>
        </div>
        @else
        <!-- dummy -->
        <h3 class="text-bg-warning text-center">{{__('DUMMY Report')}}</h3>
        <div class="row">
            <h5 class="col">{{__('Current Gold Price (USD/g)')}} ({{22222}}):
                <span class="text-warning">{{22222}}</span>
            </h5>
            <h5 class="col">
                {{__('Current Exchange Rate (MYR/USD)')}} ({{22222}}):
                <span class="text-warning">{{22222}}</span>
            </h5>
        </div>
        @endif

        <hr>

        <h5 class="text-bg-secondary text-center">{{__('Summary')}}</h5>
        <div class="row justify-content-center" style="padding: 0 12px;">
            @if(isset($data))
            <table class="col">
                <tr>
                    <td>
                        <h5>{{__('Total DownPayment')}}</h5>
                    </td>
                    <td>
                        <h5>&emsp;:&nbsp;</h5>
                    </td>
                    <td>
                        <h5 class="text-warning">{{number_format($summary[8], 2)}}&nbsp;USD &nbsp; {{number_format($summary[8]*$cdata["exchangeRate"], 2)}}&nbsp;MYR</h5>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h5>{{__('Total Holding Gold(g)')}}</h5>
                    </td>
                    <td>
                        <h5>&emsp;:&nbsp;</h5>
                    </td>
                    <td>
                        <h5 class="text-warning">{{number_format($summary[0], 2)}}</h5>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h5>{{__('Total Convert')}} ({{$cdata["convertPercent"]}}%)</h5>
                    </td>
                    <td>
                        <h5>&emsp;:&nbsp;</h5>
                    </td>
                    <td>
                        <h5 class="text-warning">{{number_format($summary[1], 2)}}&nbsp;USD &nbsp; {{number_format($summary[1]*$cdata["exchangeRate"], 2)}}&nbsp;MYR</h5>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h5>{{__('Total Holding Amt')}} ({{100-$cdata["convertPercent"]}}%)</h5>
                    </td>
                    <td>
                        <h5>&emsp;:&nbsp;</h5>
                    </td>
                    <td>
                        <h5 class="text-warning">{{number_format($summary[2], 2)}}&nbsp;USD &nbsp; {{number_format($summary[2]*$cdata["exchangeRate"], 2)}}&nbsp;MYR</h5>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h5>{{__('Total GC Amt(g)')}}</h5>
                    </td>
                    <td>
                        <h5>&emsp;:&nbsp;</h5>
                    </td>
                    <td>
                        <h5 class="text-warning">{{number_format($summary[3], 4)}}</h5>
                    </td>
                </tr>
            </table>

            <table class="col">
                <tr>
                    <td>
                        <h5>{{__('Avg.Gold Price(/g)')}}</h5>
                    </td>
                    <td>
                        <h5>&emsp;:&nbsp;</h5>
                    </td>
                    <td>
                        <h5 class="text-warning">{{number_format($summary[8]/$summary[0], 2)}}&nbsp;USD &nbsp; {{number_format($summary[8]/$summary[0]*$cdata["exchangeRate"], 2)}}&nbsp;MYR</h5>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h5>{{__('Current Value')}}</h5>
                    </td>
                    <td>
                        <h5>&emsp;:&nbsp;</h5>
                    </td>
                    <td>
                        <h5 class="text-warning">{{number_format($summary[4], 2)}}&nbsp;USD &nbsp; {{number_format($summary[4]*$cdata["exchangeRate"], 2)}}&nbsp;MYR</h5>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h5>{{__('Total management Fee')}}</h5>
                    </td>
                    <td>
                        <h5>&emsp;:&nbsp;</h5>
                    </td>
                    <td>
                        <h5 class="text-warning">{{number_format($summary[5], 2)}}&nbsp;USD &nbsp; {{number_format($summary[5]*$cdata["exchangeRate"], 2)}}&nbsp;MYR</h5>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h5>{{__('Net CashOut')}}</h5>
                    </td>
                    <td>
                        <h5>&emsp;:&nbsp;</h5>
                    </td>
                    <td>
                        <h5 class="text-warning">{{number_format($summary[6], 2)}}&nbsp;USD &nbsp; {{number_format($summary[6]*$cdata["exchangeRate"], 2)}}&nbsp;MYR</h5>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h5>{{__('Profit')}}</h5>
                    </td>
                    <td>
                        <h5>&emsp;:&nbsp;</h5>
                    </td>
                    <td>
                        @if ($summary[7] > 0)
                        <h5 style="color: lime">
                            {{ number_format($summary[7], 2)}}&nbspUSD &nbsp; {{number_format($summary[7]*$cdata["exchangeRate"], 2)}}&nbsp;MYR ↑
                        </h5>
                        @elseif ($summary[7] == 0)
                        <h5 class="text-warning">
                            {{ number_format($summary[7], 2)}}&nbspUSD &nbsp; {{number_format($summary[7]*$cdata["exchangeRate"], 2)}}&nbsp;MYR
                        </h5>
                        @else
                        <h5 style="color: red">
                            {{ number_format($summary[7], 2)}}&nbspUSD &nbsp; {{number_format($summary[7]*$cdata["exchangeRate"], 2)}}&nbsp;MYR ↓
                        </h5>
                        @endif
                    </td>
                </tr>
            </table>
            @else
            <!-- dummy -->
            <table class="col">
                <tr>
                    <td>
                        <h5>Total Holding Gold(g)</h5>
                    </td>
                    <td>
                        <h5>&emsp;:&nbsp;</h5>
                    </td>
                    <td>
                        <h5 class="text-warning">{{22222}}</h5>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h5>Convert({{2}}%)</h5>
                    </td>
                    <td>
                        <h5>&emsp;:&nbsp;</h5>
                    </td>
                    <td>
                        <h5 class="text-warning">{{2222}}&nbsp;USD &nbsp; {{222}}&nbsp;MYR</h5>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h5>Holding Amt({{100}}%)</h5>
                    </td>
                    <td>
                        <h5>&emsp;:&nbsp;</h5>
                    </td>
                    <td>
                        <h5 class="text-warning">{{2222}}&nbsp;USD &nbsp; {{2222}}&nbsp;MYR</h5>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h5>GC Amt(g)</h5>
                    </td>
                    <td>
                        <h5>&emsp;:&nbsp;</h5>
                    </td>
                    <td>
                        <h5 class="text-warning">{{2222}}</h5>
                    </td>
                </tr>
            </table>

            <table class="col">
                <tr>
                    <td>
                        <h5>Current Value</h5>
                    </td>
                    <td>
                        <h5>&emsp;:&nbsp;</h5>
                    </td>
                    <td>
                        <h5 class="text-warning">{{22222}}&nbsp;USD &nbsp; {{2222}}&nbsp;MYR</h5>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h5>Holding days</h5>
                    </td>
                    <td>
                        <h5>&emsp;:&nbsp;</h5>
                    </td>
                    <td>
                        <h5 class="text-warning">{{2222}}</h5>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h5>Management Fee /day(3.5%)</h5>
                    </td>
                    <td>
                        <h5>&emsp;:&nbsp;</h5>
                    </td>
                    <td>
                        <h5 class="text-warning">{{2222}}&nbsp;USD &nbsp; {{2222}}&nbsp;MYR</h5>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h5>Total management Fee</h5>
                    </td>
                    <td>
                        <h5>&emsp;:&nbsp;</h5>
                    </td>
                    <td>
                        <h5 class="text-warning">{{2222}}&nbsp;USD &nbsp; {{2222}}&nbsp;MYR</h5>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h5>Net CashOut</h5>
                    </td>
                    <td>
                        <h5>&emsp;:&nbsp;</h5>
                    </td>
                    <td>
                        <h5 class="text-warning">{{22222}}&nbsp;USD &nbsp; {{2222}}&nbsp;MYR</h5>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h5>Profit</h5>
                    </td>
                    <td>
                        <h5>&emsp;:&nbsp;</h5>
                    </td>
                    <td>
                        <h5 class="text-warning">{{2222}}&nbspUSD &nbsp; {{22222}}&nbsp;MYR</h5>
                    </td>
                </tr>
            </table>
            @endif

        </div>

        <h5 class="text-bg-secondary text-center">{{__('Detail')}}</h5>
        <div class="overflow-auto maxHeight transactionTable">
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        @if(isset($data))
                        <th>{{__('ID')}}</th>
                        <th>{{__('Date')}}</th>
                        <th>{{__('Gold Price (/g)')}}</th>
                        <th>{{__('Downpayment')}}</th>
                        <th>{{__('Total Holding Gold (g)')}}</th>
                        <th>{{__('Convert ')}}({{$cdata["convertPercent"]}}%)</th>
                        <th>{{__('Holding Amt ')}}({{100-$cdata["convertPercent"]}}%)</th>
                        <th>{{__('GC Amt (g)')}}</th>
                        <th>{{__('Terminate Date')}}</th>
                        <th>{{__('Current Value')}}</th>
                        <th>{{__('Holding days')}}</th>
                        <th>{{__('Management Fee (/day)')}}({{$cdata["managementFeePercent"]}}%)</th>
                        <th>{{__('Total management Fee')}}</th>
                        <th>{{__('Net CashOut')}}</th>
                        <th>{{__('Profit/Loss')}}</th>
                        @else
                        <!-- dummy -->
                        <th>{{__('ID')}}</th>
                        <th>{{__('Date')}}</th>
                        <th>{{__('Gold Price (/g)')}}</th>
                        <th>{{__('Downpayment (USD)')}}</th>
                        <th>{{__('Total Holding Gold(g)')}}</th>
                        <th>{{__('Convert ')}}(%)</th>
                        <th>{{__('Holding Amt ')}}(%)</th>
                        <th>{{__('GC Amt (g)')}}</th>
                        <th>{{__('Terminate Date')}}</th>
                        <th>{{__('Current Value (USD)')}}</th>
                        <th>{{__('Holding days')}}</th>
                        <th>{{__('Management Fee /day')}}(%) {{__('(USD)')}}</th>
                        <th>{{__('Total management Fee (USD)')}}</th>
                        <th>{{__('Net CashOut (USD)')}}</th>
                        <th>{{__('Profit/Loss (USD)')}}</th>
                        @endif

                    </tr>
                </thead>

                <tbody>
                    @if(isset($data))
                    @php
                    $count = 0;
                    @endphp
                    @foreach ($data as $transaction)
                    <tr class=''>
                        <td>{{$transaction->id}}</td>
                        <td>{{$transaction->created_at}}</td>
                        <td>
                            $&nbsp;{{$transaction->gold_price}}
                            <hr style="margin: unset;">RM&nbsp;{{number_format($transaction->gold_price * $cdata["exchangeRate"], 2)}}
                        </td>
                        <td>
                            $&nbsp;{{$transaction->downpayment}}
                            <hr style="margin: unset;">RM&nbsp;{{number_format($transaction->downpayment * $cdata["exchangeRate"], 2)}}
                        </td>
                        <td>{{number_format($result[$count]->totalHoldingGold, 4)}}</td>
                        <td>
                            $&nbsp;{{number_format($result[$count]->convert_USD, 2)}}
                            <hr style="margin: unset;">RM&nbsp;{{number_format($result[$count]->convert_MYR, 2)}}
                        </td>
                        <td>
                            $&nbsp;{{number_format($result[$count]->holdingAmt_USD, 2)}}
                            <hr style="margin: unset;">RM&nbsp;{{number_format($result[$count]->holdingAmt_MYR, 2)}}
                        </td>
                        <td>{{number_format($result[$count]->GCAmt, 4)}}</td>
                        <td>{{$transaction->terminate_at}}</td>
                        <td>
                            $&nbsp;{{number_format($result[$count]->currentValue_USD, 2)}}
                            <hr style="margin: unset;">RM&nbsp;{{number_format($result[$count]->currentValue_MYR, 2)}}
                        </td>
                        <td>{{$result[$count]->days}}</td>
                        <td>
                            $&nbsp;{{number_format($result[$count]->managementFee_day_USD, 2)}}
                            <hr style="margin: unset;">RM&nbsp;{{number_format($result[$count]->managementFee_day_MYR, 2)}}
                        </td>
                        <td>
                            $&nbsp;{{number_format($result[$count]->managementFee_total_USD, 2)}}
                            <hr style="margin: unset;">RM&nbsp;{{number_format($result[$count]->managementFee_total_MYR, 2)}}
                        </td>
                        <td>
                            $&nbsp;{{number_format($result[$count]->netCashOut_USD, 2)}}
                            <hr style="margin: unset;">RM&nbsp;{{number_format($result[$count]->netCashOut_MYR, 2)}}
                        </td>
                        @if ($result[$count]->profit_USD > 0)
                        <td style="color: lime" class="d-flex align-items-center">
                            <div>
                                $&nbsp;{{number_format($result[$count]->profit_USD, 2)}}
                                <hr style="margin: unset;">RM&nbsp;{{number_format($result[$count]->profit_MYR, 2)}}
                            </div>
                            <div class="ms-1 fs-4">↑</div>
                        </td>
                        @elseif ($result[$count]->profit_USD == 0)
                        <td>
                            $&nbsp;0
                            <hr style="margin: unset;">RM&nbsp;0
                        </td>
                        @else
                        <td style="color: red" class="d-flex align-items-center">
                            <div>
                                $&nbsp;{{number_format($result[$count]->profit_USD, 2)}}
                                <hr style="margin: unset;">RM&nbsp;{{number_format($result[$count]->profit_MYR, 2)}}
                            </div>
                            <div class="ms-1 fs-4">↓</div>
                        </td>
                        @endif
                    </tr>
                    @php
                    $count ++
                    @endphp
                    @endforeach
                    @else
                    <!-- dummy -->
                    <tr class=''>
                        <td>1</td>
                        <td>2022-05-04</td>
                        <td>56</td>
                        <td>1000</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="color: lime">7.8 ↑</td>
                    </tr>
                    <tr class=''>
                        <td>2</td>
                        <td>2022-05-19</td>
                        <td>63</td>
                        <td>1000</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="color: red">12.5 ↓</td>
                    </tr>
                    <tr class=''>
                        <td>3</td>
                        <td>2022-05-30</td>
                        <td>46</td>
                        <td>1000</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="color: lime">9.6 ↑</td>
                    </tr>
                    @endif
                </tbody>
            </table>

        </div>

    </div>

    <script>
        window.onbeforeprint = function() {
            $(".transactionTable").removeClass("overflow-auto maxHeight");
            $(".transactionTable table").removeClass("table-hover");
        };
        window.onafterprint = function() {
            $(".transactionTable").addClass("overflow-auto maxHeight");
            $(".transactionTable table").addClass("table-hover");
        };
    </script>

</body>
@endsection