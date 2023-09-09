@extends('layouts.layout')

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
    </style>

    <div class="container mt-4 mb-5">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"><span style="color:gold">Plan</span></li>
            </ol>
        </nav>

        <h3>Subsciption plan & pricing</h3>

        <div class="overflow-x-auto">
            <table class="table table-dark text-center fs-5">
                <thead class="align-middle">
                    <tr>
                        <th>Plans</th>
                        @foreach ($data as $plan)
                        <th>
                            <h5>{{$plan->type}}</h5>
                            <h5><span class="gold">${{$plan->price}}</span> <span class="text-muted">/month</span></h5>
                            @if($planSubscribed && $planSubscribed->id == $plan->id)
                            <div class="bg-success">Subscribed</div>
                            @else
                            <form method="post" action="">
                                @csrf
                                <input type="hidden" name="planId" value="{{$plan->id}}" readonly>
                                <button type="submit" class="btn btn-primary">SELECT</button>
                            </form>
                            @endif
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="align-middle">
                    <tr>
                        <td>
                            {{__("Number of portfolio")}}
                        </td>
                        @foreach ($details as $detail)
                        <td>
                            {{$detail[0] == -1? "unlimited" : $detail[0]}}
                        </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>
                            {{__("Number of transactions")}}
                        </td>
                        @foreach ($details as $detail)
                        <td>
                            {{$detail[1] == -1? "unlimited" : $detail[1]}}
                        </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>
                            {{__("Number of transactions per portfolio")}}
                        </td>
                        @foreach ($details as $detail)
                        <td>
                            {{$detail[2] == -1? "unlimited" : $detail[2]}}
                        </td>
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
    </div>

    <script>
        //    $(document).ready(function() {
        //         $('input[type=checkbox]').change(function() {
        //             changeBtnState();
        //         });
        //     });
    </script>
</body>
@endsection