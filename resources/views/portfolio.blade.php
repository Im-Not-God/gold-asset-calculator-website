@extends('layouts.layout')

@section('title', __('Portfolio'))

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

        th,
        td,
        h3 {
            text-align: center;
        }

        .material-symbols-outlined {
            font-variation-settings:
                'FILL' 0,
                'wght' 400,
                'GRAD' 0,
                'opsz' 48
        }

        .edit-btn {
            /* text-decoration: none; */
            padding: 0;
            height: 24px;
            width: 24px;
            border: none;
            color: #0d6efd;
        }

        .edit-btn:hover {
            color: #0b5ed7;
        }

        .delete-btn {
            padding: 0;
            height: 24px;
            width: 24px;
            border: none;
            color: red;
        }

        .delete-btn:hover {
            color: #bb2d3b;
        }

        .pagination {
            --bs-pagination-color: #ffc107;
            --bs-pagination-hover-color: #ffd34f;
            --bs-pagination-focus-color: #ffd34f;
            --bs-pagination-active-color: #000;
            --bs-pagination-active-bg: #ffc107;
            --bs-pagination-active-border-color: #ffc107;
        }

        #miniLoader {
            background: #373b3ebd center center;
            position: absolute;
            top: 0px;
            height: 100%;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
    </style>

    <div class="container mt-4 mb-5">

        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">{{__("Home")}}</a></li>
                <li class="breadcrumb-item active" aria-current="page"><span style="color:gold"> {{__('Portfolio')}}</span></li>
            </ol>
        </nav>

        <h3>{{__('Portfolio List')}}</h3>
        <form method="post" action="/report">
            @csrf

            <button type="button" class="btn btn-warning" id="addBtn" data-bs-toggle="modal" data-bs-target="#addModal">{{__('Add')}}</button>
            <button disabled type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteSelectedModal" id="deleteSelected">{{__('Delete')}}</button>
            <button disabled class="text-white btn btn-primary" type="submit" id="Calculate">{{__('Calculate report test')}}</button>

            <div class="border-img">
                <div class="overflow-auto mb-2" style="max-height: 280px;">
                    <table class="table table-dark table-hover mb-0">
                        <thead>
                            <tr>
                                @if(sizeof($data)>0)
                                <th><input type="checkbox" id="checkAll" name="all_transactions" value='1'></th>
                                @endif
                                <th>{{__('ID')}}</th>
                                <th>{{__('Date')}}</th>
                                <th>{{__('Type')}}</th>
                                <th>{{__('Num of transactions')}}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(sizeof($data)>0)
                            @foreach ($data as $portfolio)
                            <tr class='clickable'>
                                <td><input type="checkbox" class="checkBox" name="transactions[]" value="{{$portfolio->id}}"></td>
                                <td class="data">{{$portfolio->id}}</td>
                                <td class="data">{{$portfolio->created_at}}</td>
                                <td class="data">{{$portfolio->type}}</td>
                                <td class="data">{{$portfolio->num_of_transactions}}</td>


                                <td>
                                    <button type="button" class="btn edit-btn" title="{{__('edit')}}" data-bs-toggle="modal" data-bs-target="#editModal" data-bs-id="{{$portfolio->id}}" data-bs-type="{{$portfolio->type}}">
                                        <span class="material-symbols-outlined">
                                            edit
                                        </span>
                                    </button>

                                    <button type="button" class="btn delete-btn" title="{{__('delete')}}" data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-id="{{$portfolio->id}}" data-bs-date="{{$portfolio->created_at}}" data-bs-type="{{$portfolio->type}}">
                                        <span class="material-symbols-outlined">
                                            delete
                                        </span>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr class=''>
                                <td colspan="7">
                                    <p>No data</p>
                                </td>
                            </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
                @if(sizeof($data)>0)
                <div class="d-flex justify-content-between">
                    <p>{{__('Showing')}} {{$data->firstItem()? $data->firstItem() : 0}} {{__('to')}} {{$data->lastItem()? $data->lastItem() : 0}} {{__('of')}} {{$data->total()}} {{__('results')}}</p>
                    <p class="text-end">{{__('Total')}} {{$data->lastPage()}} {{__('pages')}}</p>
                </div>
                <nav aria-label="Page navigation example" class="d-flex justify-content-end">
                    <ul class="pagination text-end">
                        @if ($data->hasPages())
                        @if ($data->onFirstPage())
                        <li class="page-item disabled">
                            <a class="page-link">{{ __('Previous') }}</a>
                        </li>
                        @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $data->previousPageUrl() }}">{{ __('Previous') }}</a>
                        </li>
                        @endif

                        @for ($i=1 ; $i<=$data->lastPage(); $i++)
                            @if($i == $data->currentPage())
                            <li class="page-item active"><a class="page-link">{{$i}}</a></li>
                            @else
                            <li class="page-item"><a class="page-link" href="{{$data->url($i)}}">{{$i}}</a></li>
                            @endif
                            @endfor

                            @if ($data->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $data->nextPageUrl() }}">{{ __('Next') }}</a>
                            </li>
                            @else
                            <li class="page-item disabled"><a class="page-link">{{ __('Next') }}</a></li>
                            @endif
                            @else
                            <li class="page-item active" aria-current="page">
                                <a class="page-link" href="#">1</a>
                            </li>
                            @endif
                    </ul>
                </nav>
                @endif
            </div>

        </form>
    </div>

    <!-- addModal -->
    <div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">{{__('Add transaction')}}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="/transaction/add">
                    @csrf
                    <div class="modal-body">

                        <div class="mb-3 row">
                            <div class="col">
                                <label for="date" class="col-form-label">{{__('Type')}}:</label>
                                <select class="form-select typeSelection" name="type">
                                    <option value="QM">QM</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 overflow-auto" id="transactionsTableDiv" style="position: relative; max-height: 58vh;">

                            <table class="table table-dark transactionsTable table-hover">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="checkAll2" name="all_transactions" value='1'></th>
                                        <th>{{__('ID')}}</th>
                                        <th>{{__('Date')}}</th>
                                        <th>{{__('Type')}}</th>
                                        <th>{{__('Gold Price (USD/g)')}}</th>
                                        <th>{{__('Downpayment (USD)')}}</th>
                                        <th>{{__('Gold Price Gap(USD/g)')}}</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>

                            <div id='miniLoader' style="display: none;">
                                <img src="/images/logo-loading.svg" alt="Loading" width="50">
                                <p class="text-warning mt-2 mb-0">Loading ...</p>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("Close")}}</button>
                        <button type="submit" class="btn btn-warning">{{__("Add")}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- editModal -->
    <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">{{__('Edit portfolio ID')}}: <span></span></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="#" style="display: contents;">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id">
                        <div class="mb-3 row">
                            <div class="col">
                                <label for="date" class="col-form-label">{{__('Type')}}:</label>
                                <select class="form-select typeSelection" name="type">
                                    <option value="QM">QM</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("Close")}}</button>
                        <button type="submit" class="btn btn-warning">{{__("Update")}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- deleteModal -->
    <div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">{{__('Are you sure to delete')}}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="#" style="display: contents;">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="id" name="transactions[]">
                        <p id="id">{{__('ID')}}: <span></span></p>
                        <p id="date">{{__('Date')}}: <span></span></p>
                        <p id="type">{{__('Type')}}: <span></span></p>
                        <p id="gold_price">{{__('Gold Price')}}(USD/g): <span></span></p>
                        <p id="downpayment">{{__('Downpayment')}}(USD): <span></span></p>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("Close")}}</button>
                        <button type="submit" class="btn btn-danger">{{__("Delete")}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- deleteSelectedModal -->
    <div class="modal fade" id="deleteSelectedModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">{{__('Are you sure to delete')}}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="post" action="/transaction/delete" style="display: contents;">
                    @csrf
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("Close")}}</button>
                        <button type="submit" class="btn btn-danger">{{__("Delete")}}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        $("#checkAll").click(function() {
            $(".checkBox").prop('checked', $(this).prop('checked'));
        });

        $("#checkAll2").click(function() {
            $(".checkBox2").prop('checked', $(this).prop('checked'));
        });

        const editModal = document.getElementById('editModal');
        if (editModal) {
            editModal.addEventListener('show.bs.modal', event => {
                // Button that triggered the modal
                const button = event.relatedTarget;
                // Extract info from data-bs-* attributes
                const id = button.getAttribute('data-bs-id');
                const date = button.getAttribute('data-bs-date');
                const type = button.getAttribute('data-bs-type');
                const convertPercent = button.getAttribute('data-convertPercent');
                const managementFeePercent = button.getAttribute('data-managementFeePercent');
                const gold = button.getAttribute('data-bs-gold');
                const downpayment = button.getAttribute('data-bs-downpayment');
                // If necessary, you could initiate an Ajax request here
                // and then do the updating in a callback.

                // Update the modal's content.
                editModal.querySelector('.modal-title span').textContent = id;
                editModal.querySelector('.modal-body input[id="id"]').value = id;
                editModal.querySelector('.modal-body input[id="date_"]').value = date;
                editModal.querySelector('.modal-body .typeSelection').value = type;
                editModal.querySelector('.modal-body input[id="gold_price_"]').value = gold;
                editModal.querySelector('.modal-body input[id="downpayment_"]').value = downpayment;

                editModal.querySelector('.modal-body .currencySelection').value = "USD";
                editModal.querySelector('.modal-body .label_currency').textContent = "USD";

                if (type == "Other") {
                    editModal.querySelector('.modal-body .percent').removeAttribute("hidden");
                    editModal.querySelector('.modal-body .percent input').setAttribute("min", 0);
                    editModal.querySelector('.modal-body .percent input[name="convertPercent"]').value = convertPercent;
                    editModal.querySelector('.modal-body .percent input[name="managementFeePercent"]').value = managementFeePercent;
                } else {
                    editModal.querySelector('.modal-body .percent').setAttribute("hidden", true);
                    editModal.querySelector('.modal-body .percent input').removeAttribute("min");
                    editModal.querySelector('.modal-body .percent input').removeAttribute("required", false);
                }
            })
        }

        const deleteModal = document.getElementById('deleteModal');
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', event => {
                // Button that triggered the modal
                const button = event.relatedTarget;
                // Extract info from data-bs-* attributes
                const id = button.getAttribute('data-bs-id');
                const date = button.getAttribute('data-bs-date');
                const type = button.getAttribute('data-bs-type');
                const gold = button.getAttribute('data-bs-gold');
                const downpayment = button.getAttribute('data-bs-downpayment');
                // If necessary, you could initiate an Ajax request here
                // and then do the updating in a callback.

                // Update the modal's content.
                deleteModal.querySelector('.modal-body input[id="id"]').value = id;
                deleteModal.querySelector('.modal-body p[id="id"] span').textContent = id;
                deleteModal.querySelector('.modal-body p[id="date"] span').textContent = date;
                deleteModal.querySelector('.modal-body p[id="type"] span').textContent = type;
                deleteModal.querySelector('.modal-body p[id="gold_price"] span').textContent = gold;
                deleteModal.querySelector('.modal-body p[id="downpayment"] span').textContent = downpayment;
            })
        }

        $("#deleteSelected").click(function() {
            let content = "";
            let count = 0;
            $('.checkBox:checked').each(function() {
                if (count) {
                    content += "<hr>"
                }
                count++;
                const data = $(this).parent().parent().find(".data");
                const id = data[0].textContent;
                const date = data[1].textContent;
                const gold = data[2].textContent;
                const downpayment = data[3].textContent;

                content += '<input type="hidden" id="id" name="transactions[]" value=' + id + '><p id="id">ID: ' + id + '</p><p id="date">Date: ' + date + '</p><p id="gold_price">Gold Price(USD/g): ' + gold + '</p><p id="downpayment">Downpayment(USD): ' + downpayment + '</p>'
            })
            $("#deleteSelectedModal .modal-body").html(content);
        })

        $('.checkBox').change(function() {
            if ($('.checkBox:checked').length < $('.checkBox').length) {
                $("#checkAll").prop('checked', false);
            } else
                $("#checkAll").prop('checked', true);
        });

        $('.checkBox2').change(function() {
            console.log("aa");
            if ($('.checkBox2:checked').length < $('.checkBox2').length) {
                $("#checkAll2").prop('checked', false);
            } else
                $("#checkAll2").prop('checked', true);
        });

        $(document).ready(function() {
            $('input[type=checkbox]').change(function() {
                changeBtnState();
            });
        });

        function changeBtnState() {
            if ($('input[type=checkbox]:checked').length > 0) {
                $('#Calculate').prop('disabled', false)
                $('#deleteSelected').prop('disabled', false)
            } else {
                $('#Calculate').prop('disabled', true)
                $('#deleteSelected').prop('disabled', true)
            }
        }

        $(".clickable").click(function(e) {
            var checkbox = $(this).children().find(".checkBox");
            if (e.target != checkbox[0] && !$(e.target).hasClass("material-symbols-outlined")) {
                checkbox.prop('checked', !checkbox.prop('checked'));
                changeBtnState();
                if ($('.checkBox:checked').length < $('.checkBox').length) {
                    $("#checkAll").prop('checked', false);
                } else
                    $("#checkAll").prop('checked', true);
            }
        });

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

        $("#addBtn").click(function() {
            getTransactionData($(".typeSelection").val());
        })


        $(".typeSelection").on("change", function() {
            getTransactionData($(this).val());
        })

        function getTransactionData(type) {
            showLoading();
            $.post("/portfolio/getTransactions", {
                    type: type,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                function(data, status) {
                    hideLoading();
                    if (status == "success") {
                        if (data["transactionsData"]) {
                            let currentGoldPrice = data["currentGoldPrice"];

                            $(".transactionsTable tbody").html(``);
                            data["transactionsData"].forEach(function(transaction, index) {

                                let goldPriceGap = currentGoldPrice - transaction.gold_price;
                                goldPriceGap = goldPriceGap.toFixed(2);
                                let goldPriceGapHtml = "";
                                if (goldPriceGap > 0) {
                                    goldPriceGapHtml = `<td style="color: lime">${goldPriceGap} ↑</td>`;
                                } else if (goldPriceGap < 0) {
                                    goldPriceGapHtml = `<td style="color: red">${goldPriceGap} ↓</td>`;
                                } else {
                                    goldPriceGapHtml = `<td>${goldPriceGap}</td>`;
                                }

                                $(".transactionsTable tbody").append(`
                                <tr class='clickable2'>
                                    <td><input type="checkbox" class="checkBox2" name="transactions[]" value="${transaction.id}"></td>
                                    <td>${transaction.id}</td>
                                    <td>${transaction.created_at}</td>
                                    <td >${transaction.type}</td>
                                    <td>${transaction.gold_price}</td>
                                    <td >${transaction.downpayment}</td>
                                    ${goldPriceGapHtml}
                                </tr>
                                `);
                            })

                        } else {
                            $(".transactionsTable tbody").html(`
                            <tr class=''>
                                <td colspan="7">
                                    <p>No data</p>
                                </td>
                            </tr>
                            `);
                        }

                    } else {
                        console.log("error: not found");
                    }
                });
        }

        function showLoading() {
            $("#miniLoader").fadeIn();
            $("#transactionsTableDiv").addClass("overflow-hidden");
        }

        function hideLoading() {
            $("#miniLoader").fadeOut();
            $("#transactionsTableDiv").removeClass("overflow-hidden");
        }
    </script>
</body>

</html>

@endsection