@extends('layouts.adminLayout')

@section('title', __('Plan'))

@section('content')

<!-- <head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head> -->

<body>

    <style>
        .tick {
            color: lime;
        }

        .gold {
            color: gold;
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
            <div class="overflow-x-auto">
                <table class="table table-dark text-center fs-5">
                    <thead class="align-middle">
                        <tr>
                            <th>Plans</th>
                            @foreach ($data as $plan)
                            <th>
                                <h5>{{$plan->type}}</h5>
                                <input type="hidden" name="id[]" value="{{$plan->id}}" hidden readonly>
                                <h5><span class="gold">$<input class="@error('price.*') is-invalid @enderror" step="any" min="0" style="max-width: 25%!important;" type="number" name="price[]" value="{{$plan->price}}" required></span> <span class="text-muted">/month</span></h5>
                            </th>
                            @endforeach

                            @error('price.*')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        <tr>
                            <td>
                                Number of portfolio
                            </td>
                            @foreach ($details as $detail)
                            <td>
                                <input step="any" min="-1" style="max-width: 25%!important;" type="number" name="detail0[]" value="{{$detail[0]}}" required>
                            </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td>
                                Number of transactions in each portfolio
                            </td>
                            @foreach ($details as $detail)
                            <td>
                                <input step="any" min="-1" style="max-width: 25%!important;" type="number" name="detail1[]" value="{{$detail[1]}}" required>
                            </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td>
                                Feature A
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
                        </tr>
                        <tr>
                            <td>
                                Feature C
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