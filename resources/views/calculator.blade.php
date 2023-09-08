@extends('layouts.layout')

@section('title', 'Calculator')

@section('content')

<body>
    <style>
        .output {
            display: flex;
            justify-content: space-evenly;
        }
    </style>

    <div class="container mt-4 mb-5">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"><span style="color:gold">Calculator</span></li>
            </ol>
        </nav>

        <h5 class="mt-4">{{__('Current Gold Price (USD/g)')}} ({{$currentGoldPrice_updTime}}):
            <span class="text-warning">{{number_format($currentGoldPrice_USDg, 2)}}</span>
        </h5>
        <h5 class="mt-4">
            {{__('Current Exchange Rate (MYR/USD)')}} ({{$exchangeRate_updTime}}):
            <span class="text-warning">{{number_format($exchangeRate, 2)}}</span>
        </h5>
        <form action="" method="post" class="align-item-center">
            @csrf
            <div class="row justify-content-center mt-4 mb-3">
                <div class="col-sm-3">
                    <h4>{{__('Buy date:')}}</h4>
                    <input type="date" class="bg-dark form-control text-white @error('buyDate') is-invalid @enderror" style="color-scheme: dark;" name="buyDate" value="{{$buyDate? $buyDate:old('buyDate')}}" required>
                    @error('buyDate')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-3">
                    <h4>{{__('Gold price(USD/g):')}}</h4>
                    <input type="number" step="any" min="0" oninput="check(this)" class="bg-dark form-control text-white @error('goldPrice') is-invalid @enderror" style="color-scheme: dark;" name="goldPrice" value="{{$goldPrice}}" required>
                    @error('goldPrice')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-3">
                    <h4>{{__('Downpayment(USD):')}}</h4>
                    <input type="number" step="any" min="0" oninput="check(this)" class="bg-dark form-control text-white @error('downpayment_USD') is-invalid @enderror" style="color-scheme: dark;" name="downpayment_USD" value="{{$downpayment_USD}}" required>
                    @error('downpayment_USD')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row justify-content-center mt-4 mb-3">
                <div class="col-sm-3 align-items-baseline d-flex flex-wrap">
                    <h5>{{__('Convert rate:')}}</h5>
                    &nbsp;
                    <input style="width:80px;" step="any" min="0" type="number" class="bg-dark form-control text-white" style="color-scheme: dark;" name="convertPercent" value="{{$convertPercent}}" placeholder="%">
                </div>
                <div class="col-sm-4 align-items-baseline d-flex flex-wrap">
                    <h5>{{__('Annual Management Fee:')}}</h5>
                    &nbsp;
                    <input style="width:80px;" step="any" min="0" type="number" class="bg-dark form-control text-white" style="color-scheme: dark;" name="managementFeePercent" value="{{$managementFeePercent}}" placeholder="%">
                </div>
            </div>

            <div class="col-md-12 text-center">
                <button class="btn btn-outline-warning" type="submit">Calculate</button>
            </div>
        </form>
        <hr>
        @if(Request::isMethod('post'))
        <div class="row">
            <table class="col-6">
                <tr>
                    <td>
                        <h4 title="{{__('downpayment / gold price')}}">{{__('Total Holding Gold(g)')}}</h4>
                    </td>
                    <td>
                        <h4>&emsp;:&nbsp;</h4>
                    </td>
                    <td>
                        <h4 class="text-warning">{{number_format($totalHoldingGold, 4)}}</h4>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4 title="{{__('downpayment * convert percent')}}">{{__('Convert')}}({{$convertPercent}}%)</h4>
                    </td>
                    <td>
                        <h4>&emsp;:&nbsp;</h4>
                    </td>
                    <td>
                        <h4 class="text-warning">{{number_format($convert_USD, 2)}}&nbsp;USD &nbsp; {{number_format($convert_MYR, 2)}}&nbsp;MYR</h4>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4 title="{{__('downpayment - convert')}}">{{__('Holding Amt')}}({{100-$convertPercent}}%)</h4>
                    </td>
                    <td>
                        <h4>&emsp;:&nbsp;</h4>
                    </td>
                    <td>
                        <h4 class="text-warning">{{number_format($holdingAmt_USD, 2)}}&nbsp;USD &nbsp; {{number_format($holdingAmt_MYR, 2)}}&nbsp;MYR</h4>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4 title="{{__('convert / gold price')}}">{{__('GC Amt(g)')}}</h4>
                    </td>
                    <td>
                        <h4>&emsp;:&nbsp;</h4>
                    </td>
                    <td>
                        <h4 class="text-warning">{{number_format($GCAmt, 4)}}</h4>
                    </td>
                </tr>
            </table>

            <table class="col-6">
                <tr>
                    <td>
                        <h4>{{__('Terminate Date')}}</h4>
                    </td>
                    <td>
                        <h4>&emsp;:&nbsp;</h4>
                    </td>
                    <td>
                        <h4 class="text-warning">{{$terminateDate}}</h4>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4 title="{{__('current gold price * total holding gold')}}">{{__('Current Value')}}</h4>
                    </td>
                    <td>
                        <h4>&emsp;:&nbsp;</h4>
                    </td>
                    <td>
                        <h4 class="text-warning">{{number_format($currentValue_USD, 2)}}&nbsp;USD &nbsp; {{number_format($currentValue_MYR, 2)}}&nbsp;MYR</h4>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4>{{__('Holding days')}}</h4>
                    </td>
                    <td>
                        <h4>&emsp;:&nbsp;</h4>
                    </td>
                    <td>
                        <h4 class="text-warning">{{$days}}</h4>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4 title="{{__('convert * management fee percent / 365')}}">{{__('Management Fee /day')}}({{$managementFeePercent}}%)</h4>
                    </td>
                    <td>
                        <h4>&emsp;:&nbsp;</h4>
                    </td>
                    <td>
                        <h4 class="text-warning">{{number_format($managementFee_day_USD, 2)}}&nbsp;USD &nbsp; {{number_format($managementFee_day_MYR, 2)}}&nbsp;MYR</h4>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4 title="{{__('management fee per day * holding days')}}">{{__('Total management Fee')}}</h4>
                    </td>
                    <td>
                        <h4>&emsp;:&nbsp;</h4>
                    </td>
                    <td>
                        <h4 class="text-warning">{{number_format($managementFee_total_USD, 2)}}&nbsp;USD &nbsp; {{number_format($managementFee_total_MYR, 2)}}&nbsp;MYR</h4>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4 title="{{__('current value - convert - total management fee')}}">{{__('Net CashOut')}}</h4>
                    </td>
                    <td>
                        <h4>&emsp;:&nbsp;</h4>
                    </td>
                    <td>
                        <h4 class="text-warning">{{number_format($netCashOut_USD, 2)}}&nbsp;USD &nbsp; {{number_format($netCashOut_MYR, 2)}}&nbsp;MYR</h4>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4 title="{{__('net cash out - holding amt')}}">{{__('Profit')}}</h4>
                    </td>
                    <td>
                        <h4>&emsp;:&nbsp;</h4>
                    </td>
                    <td>
                        <h4 class="text-warning">{{number_format($profit_USD, 2)}}&nbspUSD &nbsp; {{number_format($profit_MYR, 2)}}&nbsp;MYR</h4>
                    </td>
                </tr>
            </table>
        </div>
        @endif
    </div>

    <script>
        function check(input) {
            if (input.value != '' && input.value <= 0) {
                input.setCustomValidity('The number must bigger than 0.');
                input.title = 'The number must bigger than 0.';
            } else {
                // input is fine -- reset the error message
                input.setCustomValidity('');
                input.removeAttribute("title");
            }
        }

        $('[type="date"]').prop('max', new Date().toLocaleDateString('fr-ca'))
    </script>
</body>
@endsection