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

        .expand-btn {
            padding: 0;
            height: 24px;
            width: 24px;
            border: none;
            color: #9aa0a6;
        }

        .expand-btn:hover {
            color: #e8eaed;
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
        <form method="post" action="/portfolio/report">
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
                                <th><input type="checkbox" id="checkAll" name="all_portfolios" value='1'></th>
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
                                <td><input type="checkbox" class="checkBox" name="portfolios[]" value="{{$portfolio->id}}"></td>
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">{{__('Add portfolio')}}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="/portfolio/add" id="addModalForm">
                    @csrf
                    <div class="modal-body">
                        @if(!$portfoliosLimit)
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
                        @if(!$portfoliosLimit)
                        <button type="button" class="btn btn-warning " id="addModal-AddBtn" disabled>{{__("Add")}}</button>
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">{{__('Edit portfolio ID')}}: <span></span></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="/portfolio/update" style="display: contents;">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" readonly>
                        <input type="hidden" name="type" value="" readonly>

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

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("Close")}}</button>
                        <button type="button" class="btn btn-warning" id="updateBtn">{{__("Update")}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- deleteModal -->
    <div class="modal fade" id="deleteModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">{{__('Are you sure to delete')}}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="post" action="/portfolio/delete" style="display: contents;">
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

    <!-- warningModal -->
    <div class="modal fade" id="warningModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">{{__('Warning')}}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <span class="material-symbols-outlined">
                            warning
                        </span>
                        <div class="ms-1">
                            {{__('Exceeded the limit')}}
                        </div>
                    </div>
                    <p>{{__('If you wish to continue, please consider upgrading your subscription plan or deleting unnecessary data.')}}</p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("Close")}}</button>
                    <a href="/plan" class="btn btn-warning">{{__("Upgrade")}}</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        $("#checkAll").click(function() {
            $(".checkBox").prop('checked', $(this).prop('checked'));
            changeBtnState();
        });

        $("#checkAll2").click(function() {
            $(".checkBox2").prop('checked', $(this).prop('checked'));
            $('#addModal-AddBtn').prop('disabled', !$(this).prop('checked'));
        });

        $(document).ready(function() {
            changeBtnState();

            $('.modal').on('hidden.bs.modal', function(event) {
        $(this).removeClass( 'fv-modal-stack' );
        $('body').data( 'fv_open_modals', $('body').data( 'fv_open_modals' ) - 1 );
    });

    $('.modal').on('shown.bs.modal', function (event) {
        // keep track of the number of open modals
        if ( typeof( $('body').data( 'fv_open_modals' ) ) == 'undefined' ) {
            $('body').data( 'fv_open_modals', 0 );
        }

        // if the z-index of this modal has been set, ignore.
        if ($(this).hasClass('fv-modal-stack')) {
            return;
        }

        $(this).addClass('fv-modal-stack');
        $('body').data('fv_open_modals', $('body').data('fv_open_modals' ) + 1 );
        $(this).css('z-index', 1040 + (10 * $('body').data('fv_open_modals' )));
        $('.modal-backdrop').not('.fv-modal-stack').css('z-index', 1039 + (10 * $('body').data('fv_open_modals')));
        $('.modal-backdrop').not('fv-modal-stack').addClass('fv-modal-stack'); 

    });        
        });

        function changeBtnState() {
            if ($('input[type=checkbox]:checked').length > 0) {
                $('#Calculate').prop('disabled', false);
                $('#deleteSelectedBtn').prop('disabled', false)
            } else {
                $('#Calculate').prop('disabled', true)
                $('#deleteSelectedBtn').prop('disabled', true)
            }
            if ($('input[type=checkbox]:checked').length > 1) {
                $('#Calculate').prop('disabled', true);
            }
        }

        //checkbox control 
        $(".clickable").on("click", function(e) {
            var checkbox = $(this).children().find(".checkBox");
            if (e.target != checkbox[0] && !$(e.target).hasClass("material-symbols-outlined")) {
                checkbox.prop('checked', !checkbox.prop('checked'));
            }
            changeBtnState();

            if ($('.checkBox:checked').length < $('.checkBox').length) {
                $("#checkAll").prop('checked', false);
            } else
                $("#checkAll").prop('checked', true);

            var options = saveCheckBoxOptionHandler();
            console.log("save: " + JSON.stringify(options));

        });

        //transactionsTable checkbox control 
        $(".transactionsTable").on("click", ".clickable2", function(e) {
            var checkbox = $(this).children().find(".checkBox2");
            if (e.target != checkbox[0]) {
                checkbox.prop('checked', !checkbox.prop('checked'));
            }
            if ($('.checkBox2:checked').length > 0) {
                $('#addModal-AddBtn').prop('disabled', false);
            } else {
                $('#addModal-AddBtn').prop('disabled', true);
            }

            if ($('.checkBox2:checked').length < $('.checkBox2').length) {
                $("#checkAll2").prop('checked', false);
            } else {
                $("#checkAll2").prop('checked', true);
            }
        });

        $(".delete-btn").on("click", function() {
            $("#deleteModal .modal-body").html("");
            let data = $(this).parent().parent().find(".data");
            let id = data[0].textContent;
            let date = data[1].textContent;
            let type = data[2].textContent;
            let num = data[3].textContent;

            $("#deleteModal .modal-body").append(`
                    <input type="hidden" id="id" name="portfolios[]" value=${id} readonly>
                    <p id="id">ID: ${id}</p>
                    <p id="date">Date: ${date}</p>
                    <p id="type">Type: ${type}</p>
                    <div class="d-flex">
                        <p id="numOfTransactions" class="clickableP">Num of transactions: ${num}</p>&nbsp;
                        <button type="button" class="btn expand-btn" title="{{__('expand more')}}">
                            <span class="material-symbols-outlined">
                                expand_more
                            </span>
                        </button>
                    </div>

                    <div class="mb-3 overflow-auto" id="transactionsTableDiv" style="position: relative; max-height: 58vh;" hidden>

                        <table class="table table-dark transactionsTable table-hover">
                            <thead>
                                <tr>
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

                    </div>
            `);
            getTransactionDataUnderPortfolioDelete($("#deleteModal"), type, id);
        })

        $("#deleteSelectedBtn").on("click", function() {
            let count = 0;
            $("#deleteModal .modal-body").html("");
            $('.checkBox:checked').each(function() {
                if (count) {
                    $("#deleteModal .modal-body").append("<hr>");
                }
                count++;
                const data = $(this).parent().parent().find(".data");
                const id = data[0].textContent;
                const date = data[1].textContent;
                const type = data[2].textContent;
                const num = data[3].textContent;

                $("#deleteModal .modal-body").append(`
                    <input type="hidden" id="id" name="portfolios[]" value=${id} readonly>
                    <p id="id">ID: ${id}</p>
                    <p id="date">Date: ${date}</p>
                    <p id="type">Type: ${type}</p>
                    <div id="${id}">
                        <div class="d-flex">
                            <p id="numOfTransactions" class="clickableP">Num of transactions: ${num}</p>&nbsp;
                            <button type="button" class="btn expand-btn" title="{{__('expand more')}}">
                                <span class="material-symbols-outlined">
                                    expand_more
                                </span>
                            </button>
                        </div>

                        <div class="mb-3 overflow-auto" id="transactionsTableDiv" style="position: relative; max-height: 58vh;" hidden>

                            <table class="table table-dark transactionsTable table-hover">
                                <thead>
                                    <tr>
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

                        </div>
                    </div>
                `);
                getTransactionDataUnderPortfolioDelete($(`div#${id}`), type, id);
            });
        });

        $("#deleteModal .modal-body").on("click", ".clickableP, .expand-btn", function() {
            //expand more
            var expandBtn = null;
            if ($(this).hasClass("clickableP")) {
                expandBtn = $(this).parent().find(".expand-btn");
            } else {
                expandBtn = $(this);
            }
            if (expandBtn.children().html() !== "expand_less") {
                console.log("more");
                expandBtn.children().html("expand_less");
                expandBtn.attr("title", "{{__('expand less')}}");
                expandBtn.parent().parent().find("#transactionsTableDiv").attr("hidden", false);
            }
            //expand less
            else {
                console.log("less");
                expandBtn.children().html("expand_more");
                expandBtn.attr("title", "{{__('expand more')}}");
                expandBtn.parent().parent().find("#transactionsTableDiv").attr("hidden", true);
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

        $('.edit-btn').on("click", function() {
            let id = $(this).attr("data-bs-id");
            let type = $(this).attr("data-bs-type");
            $('#editModal').find("input[name='id']").val(id);
            $('#editModal').find("input[name='type']").val(type);
            $('#editModal').find(".modal-title span").text(id);
        });

        $('#editModal').on("shown.bs.modal", function() {
            $(this).find(".transactionsTable").after(`
                <div id='miniLoader' style="display: none;">
                    <img src="/images/logo-loading.svg" alt="Loading" width="50">
                    <p class="text-warning mt-2 mb-0">Loading ...</p>
                </div>
            `);
            getTransactionData($(this), $('#editModal').find("input[name='type']").val());

            let id = $(this).find(".modal-title span").text();
            getTransactionDataUnderPortfolioEdit($(this), id)
        });

        $('#addModal').on('shown.bs.modal', function(e) {
            @if(!$portfoliosLimit)
            $(this).find(".transactionsTable").after(`
                <div id='miniLoader' style="display: none;">
                    <img src="/images/logo-loading.svg" alt="Loading" width="50">
                    <p class="text-warning mt-2 mb-0">Loading ...</p>
                </div>
            `);
            getTransactionData($(this), $(".typeSelection").val());
            @endif
        })


        $('#addModal, #editModal').on('hidden.bs.modal', function(e) {
            $("#miniLoader").remove();
            $(".transactionsTable tbody").html(``);
        })


        $(".typeSelection").on("change", function() {
            getTransactionData($(this).parents('#addModal'), $(this).val());
        })

        function getTransactionData(modal, type) {
            showLoading();
            $.post("/portfolio/getTransactions", {
                    type: type,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                function(data, status) {
                    hideLoading();
                    if (status == "success") {
                        if (data["transactionsData"].length) {

                            modal.find(".transactionsTable tbody").html(``);

                            let currentGoldPrice = data["currentGoldPrice"];

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

                                modal.find(".transactionsTable tbody").append(`
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
                            });
                        } else {
                            modal.find(".transactionsTable tbody").html(`
                            <tr class=''>
                                <td colspan="7">
                                    <p>No data</p>
                                    <a class="btn btn-outline-warning" href="/transaction">Add transaction</a>
                                </td>
                            </tr>
                            `);
                        }

                    } else {
                        console.log("error: not found");
                    }
                });
        }

        function getTransactionDataUnderPortfolioDelete(modal, type, portfolioID) {
            showLoading();
            $.post("/portfolio/delete/showtransactions", {
                    type: type,
                    portfolioID: portfolioID,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                function(data, status) {
                    hideLoading();
                    if (status == "success") {
                        if (data["transactionsData"].length) {

                            let currentGoldPrice = data["currentGoldPrice"];

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

                                modal.find(".transactionsTable tbody").append(`
                                    <tr class=''>
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
                            modal.find(".transactionsTable tbody").html(`
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

        function getTransactionDataUnderPortfolioEdit(modal, portfolioID) {
            showLoading();
            $.post("/portfolio/edit/showtransactions", {
                    portfolioID: portfolioID,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                function(data, status) {
                    hideLoading();
                    if (status == "success") {
                        if (data["transactionsData"].length) {

                            data["transactionsData"].forEach(function(transactionId, index) {
                                modal.find(".transactionsTable .checkBox2:not(:checked)").each(function() {
                                    console.log($(this).val());
                                    if ($(this).val() == transactionId) {
                                        $(this).prop('checked', true);
                                        return false;
                                    }
                                })
                            })
                        }
                    } else {
                        console.log("error: not found");
                    }
                });
        }

        function showLoading() {
            $("#miniLoader").fadeIn();
            $("#transactionsTableDiv").scrollTop(0);
            $("#transactionsTableDiv").addClass("overflow-hidden");
        }

        function hideLoading() {
            $("#miniLoader").fadeOut();
            $("#transactionsTableDiv").removeClass("overflow-hidden");
        }

        // 存储选项到LocalStorage
        function saveOptionsToStorage(options) {
            localStorage.setItem("portfolio_page<?php echo $data->currentPage() ?>", JSON.stringify(options));
        }

        // 获取选项从LocalStorage
        function getOptionsFromStorage() {
            var options = localStorage.getItem("portfolio_page<?php echo $data->currentPage() ?>");
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
                localStorage.removeItem(`portfolio_page${i}`);
            }
        });

        $('#addModal-AddBtn, #updateBtn').on('click', function() {
            checkTransactionLimit($(this));
        });

        function checkTransactionLimit(btn) {
            $('#addModal-AddBtn').attr("disable", true);
            $.post("/portfolio/checkLimit", {
                    numOfTransactions: $(".checkBox2:checked").length,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                function(data, status) {
                    if (status == "success") {
                        if (data) {
                            // alert("Exceed the limit");
                            $("#warningModal").modal('show'); 
                           
                            return false;
                        } else {
                            $('#addModal-AddBtn').attr("disable", false);
                            btn.parents("form").submit();
                        }

                    } else {
                        console.log("error: not found");
                    }
                    $('#addModal-AddBtn').attr("disable", false);
                    btn.parents("form").submit();
                }
            );
        }
    </script>
</body>

</html>

@endsection