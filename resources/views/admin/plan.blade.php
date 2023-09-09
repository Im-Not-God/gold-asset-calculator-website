@extends('layouts.adminLayout')

@section('title', __('Plan'))

@section('content')

<!-- <head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head> -->

<body>

    <style>
        .tick {
            color: lime !important;
        }

        .gold {
            color: gold;
        }

        .invalid-feedback {
            display: unset;
        }

        input {
            color: #dee2e6 !important;
        }
    </style>

    <div class="container mt-4 mb-5">
        <!-- <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"><span style="color:gold">Plan</span></li>
            </ol>
        </nav> -->

        <h3>Subsciption plan & pricing (admin)</h3>
        <sub>*-1 is unlimited</sub>
        <form method="post" action="">
            @csrf
            <button type="submit" class="btn btn-warning saveBtn" hidden>save</button>

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $errors }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="overflow-x-auto">
                <table class="table table-dark text-center fs-5">
                    <thead class="align-middle">
                        <tr>
                            <th>Plans</th>
                            @php
                            $count=0;
                            @endphp
                            @foreach ($data as $plan)

                            <th>
                                <h5>{{$plan->type}}</h5>
                                <input type="hidden" name="id[]" value="{{$plan->id}}" hidden readonly>
                                <h5 class="align-items-center d-flex justify-content-center">
                                    <span class="gold">$&nbsp;</span>
                                    <input class="form-control @error('price.'.$count) is-invalid @enderror" step="any" min="0" style="max-width: 30%!important;" type="number" name="price[]" value="{{$plan->price}}" required>
                                    <span class="text-muted">&nbsp;/month</span>
                                </h5>
                                @error('price.'.$count)
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </th>
                            @php
                            $count++;
                            @endphp
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        <tr>
                            <td>
                                {{__("Number of portfolio")}}
                            </td>
                            @php
                            $count=0;
                            @endphp
                            @foreach ($details as $detail)
                            <td>
                                <input step="any" min="-1" class="form-control m-auto @error('detail.0.'.$count) is-invalid @enderror" style="max-width: 30%!important;" type="number" name="detail[0][]" value="{{$detail[0]}}" required>
                                @error('detail.0.'.$count)
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </td>
                            @php
                            $count++;
                            @endphp
                            @endforeach
                        </tr>
                        <tr>
                            <td>
                                {{__("Number of transactions")}}
                            </td>
                            @php
                            $count=0;
                            @endphp
                            @foreach ($details as $detail)
                            <td>
                                <input step="any" min="-1" class="form-control m-auto @error('detail.1.'.$count) is-invalid @enderror" style="max-width: 30%!important;" type="number" name="detail[1][]" value="{{$detail[1]}}" required>
                                @error('detail.1.'.$count)
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </td>
                            @php
                            $count++;
                            @endphp
                            @endforeach
                        </tr>
                        <tr>
                            <td>
                                {{__("Number of transactions per portfolio")}}
                            </td>
                            @php
                            $count=0;
                            @endphp
                            @foreach ($details as $detail)
                            <td>
                                <input step="any" min="-1" class="form-control  m-auto @error('detail.2.'.$count) is-invalid @enderror" style="max-width: 30%!important;" type="number" name="detail[2][]" value="{{$detail[2]}}" required>
                                @error('detail.2.'.$count)
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </td>
                            @php
                            $count++;
                            @endphp
                            @endforeach
                        </tr>
                        <tr>
                            <td>
                                Feature A
                            </td>
                            <td class="tick">
                                ❌
                            </td>
                            <td class="tick">
                                ✔
                            </td>
                            <td class="tick">
                                ✔
                            </td>
                            <td class="tick">
                                ✔
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Feature B
                            </td>
                            <td>
                                ❌
                            </td>
                            <td>
                                ❌
                            </td>
                            <td class="tick">
                                ✔
                            </td>
                            <td class="tick">
                                ✔
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Feature C
                            </td>
                            <td>
                                ❌
                            </td>
                            <td class="tick">
                                ❌
                            </td>
                            <td class="tick">
                                ❌
                            </td>
                            <td class="tick">
                                ✔
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>

    </div>

    <script>
        $("input").on('input', function() {
            console.log("inputting");
            if ($(this).val() < 0)
                $(this).val(-1);
            $(".saveBtn").removeAttr("hidden");
        });
    </script>
</body>
@endsection