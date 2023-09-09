@extends('layouts.layout')

@section('title', __('Transaction'))

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
    </style>

    <div class="container mt-4 mb-5">

        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">{{__("Home")}}</a></li>
                <li class="breadcrumb-item active" aria-current="page"><span style="color:gold"> {{__('Transaction')}}</span></li>
            </ol>
        </nav>

        <h3>{{__('Transaction List')}}</h3>
        <form method="post" action="/transaction/report" id="transactionList" onsubmit="return beforeCalculate()">
            @csrf

            <button type="button" class="btn btn-secondary" id="clearBtn">{{__('Clear selection')}}</button>
            <button type="button" class="btn btn-warning" id="addBtn" data-bs-toggle="modal" data-bs-target="#addModal">{{__('Add')}}</button>
            <button disabled type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" id="deleteSelectedBtn">{{__('Delete')}}</button>
            <button disabled class="text-white btn btn-primary ms-3" type="submit" id="Calculate">{{__('Calculate')}}</button>

            <div class="border-img">
                <div class="overflow-auto mb-2" style="max-height: 280px;">
                    <table class="table table-dark table-hover mb-0">
                        <thead>
                            <tr>
                                @if(sizeof($data)>0)
                                <th><input type="checkbox" id="checkAll" name="all_transactions" value='0'></th>
                                @endif
                                <th>{{__('ID')}}</th>
                                <th>{{__('Date')}}</th>
                                <th>{{__('Type')}}</th>
                                <th>{{__('Gold Price (USD/g)')}}</th>
                                <th>{{__('Downpayment (USD)')}}</th>
                                <th>{{__('Gold Price Gap(USD/g)')}}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(sizeof($data)>0)
                            @foreach ($data as $transaction)
                            <tr class='clickable'>
                                <td><input type="checkbox" class="checkBox" id="" name="transactions[]" value="{{$transaction->id}}"></td>
                                <td class="data">{{$transaction->id}}</td>
                                <td class="data">{{$transaction->created_at}}</td>
                                <td class="data">{{$transaction->type}}</td>
                                <td class="data">{{$transaction->gold_price}}</td>
                                <td class="data">{{$transaction->downpayment}}</td>
                                @php
                                $goldPriceGap = $currentGoldPrice - $transaction->gold_price;
                                $goldPriceGap = number_format($goldPriceGap, 2, '.', '');
                                @endphp
                                @if ($goldPriceGap > 0)
                                <td style="color: lime">{{$goldPriceGap}} ↑</td>
                                @elseif ($goldPriceGap == 0)
                                <td>{{$goldPriceGap}}</td>
                                @else
                                <td style="color: red">{{$goldPriceGap}} ↓</td>
                                @endif
                                <td>
                                    <button type="button" class="btn edit-btn" title="{{__('edit')}}" data-bs-toggle="modal" data-bs-target="#editModal" data-bs-id="{{$transaction->id}}" data-bs-date="{{$transaction->created_at}}" data-bs-type="{{$transaction->type}}" data-convertPercent="{{$transaction->convert_percent}}" data-managementFeePercent="{{$transaction->management_fee_percent}}" data-bs-gold="{{$transaction->gold_price}}" data-bs-downpayment="{{$transaction->downpayment}}">
                                        <span class="material-symbols-outlined">
                                            edit
                                        </span>
                                    </button>

                                    <button type="button" class="btn delete-btn" title="{{__('delete')}}" data-bs-toggle="modal" data-bs-target="#deleteModal">
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
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">{{__('Add transaction')}}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="/transaction/add">
                    @csrf
                    <div class="modal-body">
                        @if(!$transactionsLimit)
                        <div class="mb-3">
                            <label for="date" class="col-form-label">{{__('Date')}}:</label>
                            <input type="date" class="form-control @error('buyDate') is-invalid @enderror" id="date" name="buyDate" required>

                            @error('buyDate')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3 row">
                            <div class="col">
                                <label for="date" class="col-form-label">{{__('Currency')}}:</label>
                                <select class="form-select currencySelection" name="currency">
                                    <option value="USD">USD</option>
                                    <option value="MYR">MYR</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="date" class="col-form-label">{{__('Type')}}:</label>
                                <select class="form-select typeSelection" name="type">
                                    <option value="QM">QM</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="percent" hidden>
                            <div class="mb-3 row">
                                <div class="col">
                                    <label for="convertPercent" class="col-form-label">{{__('Convert Rate(%)')}}:</label>
                                    <input type="number" step="any" min="0" class="form-control @error('convertPercent') is-invalid @enderror" id="convertPercent" name="convertPercent" value="0" required>
                                    @error('convertPercent')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="managementFeePercent" class="col-form-label">{{__('Annual Management Fee(%)')}}:</label>
                                    <input type="number" step="any" min="0" class="form-control @error('managementFeePercent') is-invalid @enderror" id="managementFeePercent" name="managementFeePercent" value="0" required>
                                    @error('managementFeePercent')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="gold_price" class="col-form-label">{{__('Gold Price')}}(<span class="label_currency">USD</span>/g):</label>
                            <input type="number" step="any" min="0" oninput="check(this)" class="form-control @error('goldPrice') is-invalid @enderror" id="gold_price" name="goldPrice" required>

                            @error('goldPrice')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="downpayment" class="col-form-label">{{__('Downpayment')}}(<span class="label_currency">USD</span>):</label>
                            <input type="number" step="any" min="0" oninput="check(this)" class="form-control @error('downpayment') is-invalid @enderror" id="downpayment" name="downpayment" required>

                            @error('downpayment')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        @else
                        <div class="alert alert-warning d-flex align-items-center" role="alert">
                            <span class="material-symbols-outlined">
                                warning
                            </span>
                            <div class="ms-1">
                                {{__('Exceeded the limit')}}
                            </div>
                        </div>
                        <p>{{__('If you wish to continue, please consider upgrading your subscription plan or deleting unnecessary data.')}}</p>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("Close")}}</button>
                        @if(!$transactionsLimit)
                        <button type="submit" class="btn btn-warning">{{__("Add")}}</button>
                        @else
                        <a href="/plan" class="btn btn-warning">{{__("Upgrade")}}</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- editModal -->
    <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">{{__('Edit transaction ID')}}: <span></span></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="/transaction/update" style="display: contents;">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id">
                        <div class="mb-3">
                            <label for="date_" class="col-form-label">{{__('Date')}}:</label>
                            <input type="date" class="form-control @error('buyDate') is-invalid @enderror" id="date_" name="buyDate" required>
                            @error('buyDate')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3 row">
                            <div class="col">
                                <label for="date" class="col-form-label">{{__('Currency')}}:</label>
                                <select class="form-select currencySelection" name="currency">
                                    <option value="USD">USD</option>
                                    <option value="MYR">MYR</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="date" class="col-form-label">{{__('Type')}}:</label>
                                <select class="form-select typeSelection" name="type">
                                    <option value="QM">QM</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="percent" hidden>
                            <div class="mb-3 row">
                                <div class="col">
                                    <label for="convertPercent" class="col-form-label">{{__('Convert Rate(%)')}}:</label>
                                    <input type="number" step="any" min="0" class="form-control @error('convertPercent') is-invalid @enderror" id="convertPercent" name="convertPercent" value="0" required>
                                    @error('convertPercent')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="managementFeePercent" class="col-form-label">{{__('Annual Management Fee(%)')}}:</label>
                                    <input type="number" step="any" min="0" class="form-control @error('managementFeePercent') is-invalid @enderror" id="managementFeePercent" name="managementFeePercent" value="0" required>
                                    @error('managementFeePercent')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="gold_price_" class="col-form-label">{{__('Gold Price')}}(<span class="label_currency">USD</span>/g):</label>
                            <input type="number" step="any" min="0" oninput="check(this)" class="form-control @error('goldPrice') is-invalid @enderror" id="gold_price_" name="goldPrice" required>
                            @error('goldPrice')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="downpayment_" class="col-form-label">{{__('Downpayment')}}(<span class="label_currency">USD</span>):</label>
                            <input type="number" step="any" min="0" oninput="check(this)" class="form-control  @error('downpayment') is-invalid @enderror" id="downpayment_" name="downpayment" required>
                            @error('downpayment')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
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
    <div class="modal fade" id="deleteModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
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

        $(".edit-btn").on("click", function() {
            let data = $(this).parent().parent().find(".data");
            let id = data[0].textContent;
            let date = data[1].textContent;
            let gold = data[2].textContent;
            let downpayment = data[3].textContent;

            let content = `<input type="hidden" id="id" name="transactions[]" value=${id}><p id="id">ID: ${id}</p><p id="date">Date: ${date}</p><p id="gold_price">Gold Price(USD/g): ${gold}</p><p id="downpayment">Downpayment(USD): ${downpayment}</p>`

            $("#deleteModal .modal-body").html(content);
        })

        $(".delete-btn").on("click", function() {
            let data = $(this).parent().parent().find(".data");
            let id = data[0].textContent;
            let date = data[1].textContent;
            let gold = data[2].textContent;
            let downpayment = data[3].textContent;

            let content = `<input type="hidden" id="id" name="transactions[]" value=${id}><p id="id">ID: ${id}</p><p id="date">Date: ${date}</p><p id="gold_price">Gold Price(USD/g): ${gold}</p><p id="downpayment">Downpayment(USD): ${downpayment}</p>`

            $("#deleteModal .modal-body").html(content);
        })

        $("#deleteSelectedBtn").click(function() {
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

                content += `<input type="hidden" id="id" name="transactions[]" value=${id}><p id="id">ID: ${id}</p><p id="date">Date: ${date}</p><p id="gold_price">Gold Price(USD/g): ${gold}</p><p id="downpayment">Downpayment(USD): ${downpayment}</p>`
            })
            $("#deleteModal .modal-body").html(content);
        })

        $(document).ready(function() {
            changeBtnState()
        });

        $('input[type=checkbox]').change(function() {
            changeBtnState();
            var options = saveCheckBoxOptionHandler();
            console.log("save: " + JSON.stringify(options));
        });

        function changeBtnState() {
            if ($('input[type=checkbox]:checked').length > 0) {
                $('#Calculate').prop('disabled', false)
                $('#deleteSelectedBtn').prop('disabled', false)
            } else {
                $('#Calculate').prop('disabled', true)
                $('#deleteSelectedBtn').prop('disabled', true)
            }
        }

        $(".clickable").click(function(e) {
            var checkbox = $(this).children().find(".checkBox");
            if (e.target != checkbox[0] && !$(e.target).hasClass("material-symbols-outlined")) {
                checkbox.prop('checked', !checkbox.prop('checked'));
                changeBtnState();
            }
            if ($('.checkBox:checked').length < $('.checkBox').length) {
                $("#checkAll").prop('checked', false);
            } else
                $("#checkAll").prop('checked', true);
        });

        if (@json($validationFail) == 'true') {
            $('#addBtn').trigger('click');
        }

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

        $('[type="date"]').prop('max', new Date().toLocaleDateString('fr-ca'));

        // $(".label_currency").text($('.currencySelection option:selected').val());
        $(".currencySelection").on("change", function() {
            $(".modal.show .label_currency").text($(this).val());
        })

        $(".typeSelection").on("change", function() {
            if ($(this).val() == "Other") {
                $(".modal.show .percent").removeAttr("hidden");
                $(".modal.show .percent input").attr("min", 0);
                $(".modal.show .percent input").attr("required");
            } else {
                $(".modal.show .percent").attr("hidden", true);
                $(".modal.show .percent input").removeAttr("min");
                $(".modal.show .percent input").removeAttr("required", true);
            }
        })

        // 存储选项到LocalStorage
        function saveOptionsToStorage(options) {
            localStorage.setItem("transaction_page<?php echo $data->currentPage() ?>", JSON.stringify(options));
        }

        // 获取选项从LocalStorage
        function getOptionsFromStorage() {
            var options = localStorage.getItem("transaction_page<?php echo $data->currentPage() ?>");
            if (options)
                return JSON.parse(options);
            else
                return false;
        }

        let optionsData = getOptionsFromStorage();

        if (!optionsData) {
            var options = saveCheckBoxOptionHandler();
            console.log("new: " + JSON.stringify(options));
        } else {
            console.log("read: " + JSON.stringify(optionsData));
            $("input[type='checkbox']").each(function(index) {
                $(this).prop('checked', optionsData[$(this).val()]);
            });
        }

        // 当用户进行选择时保存选项
        function saveCheckBoxOptionHandler() {
            var options = {};
            $("input[type='checkbox']:checked").each(function() {
                options[$(this).val()] = $(this).is(':checked');
            })
            saveOptionsToStorage(options);
            return options;
        }

        let totalPage = <?php echo $data->lastPage() ?>

        $("#clearBtn").on("click", function() {
            $("input[type='checkbox']").prop('checked', false);
            for (var i = 1; i <= totalPage; i++) {
                localStorage.removeItem(`transaction_page${i}`);
            }
        });

        //待解决
        function beforeCalculate() {
            // let myForm = document.getElementById('transactionList');
            // let formData = new FormData(myForm);
            // let selectedTransactionIDs = [];

            // for (var i = 1; i <= totalPage; i++) {
            //     var data = JSON.parse(localStorage.getItem(`transaction_page${i}`));
            //     Object.keys(data).forEach(function(key) {
            //         if (data[key] && key != 0) {
            //             selectedTransactionIDs.push(key);
            //         }
            //     })
            // }


            // $("input[name='transactions[]']").each(function(index) {
            //     $(this).val(selectedTransactionIDs[index]);
            // });
            // formData.append("transactionIDs", selectedTransactionIDs);

            return true
        }
    </script>
</body>

</html>

@endsection