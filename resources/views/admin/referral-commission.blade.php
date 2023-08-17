@extends('admin.layouts.app')

@section('title')
    @lang('Referral Commission')
@endsection


@section('content')
    <div class=" m-0 m-md-4 my-4 m-md-0">
        <div class="row justify-content-between ">
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary shadow">
                            <div class="card-body">
                                <form method="post" action="{{route('admin.referral-commission.action')}}" class="form-inline align-items-center justify-content-between">
                                    @csrf

                                    <div class="form-group col-md-6 mb-3">
                                        <label class="text-dark">@lang('Upline Deposit Bonus')</label>
                                        <div class="custom-switch-btn ">
                                            <input type='hidden' value='1' name='deposit_commission'>
                                            <input type="checkbox" name="deposit_commission"
                                                   class="custom-switch-checkbox "
                                                   id="deposit_commission"
                                                   value="0" <?php if ($control->deposit_commission == 0):echo 'checked'; endif ?> >
                                            <label class="custom-switch-checkbox-label" for="deposit_commission">
                                                <span class="custom-switch-checkbox-inner"></span>
                                                <span class="custom-switch-checkbox-switch"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6 mb-3">
                                        <label class="text-dark">@lang('Upline Bet Commission')</label>
                                        <div class="custom-switch-btn ">
                                            <input type='hidden' value='1' name='bet_commission'>
                                            <input type="checkbox" name="bet_commission"
                                                   class="custom-switch-checkbox "
                                                   id="bet_commission"
                                                   value="0" <?php if ($control->bet_commission == 0):echo 'checked'; endif ?> >
                                            <label class="custom-switch-checkbox-label" for="bet_commission">
                                                <span class="custom-switch-checkbox-inner"></span>
                                                <span class="custom-switch-checkbox-switch"></span>
                                            </label>
                                        </div>
                                    </div>



                                    <div class="form-group col-md-6 mb-3">
                                        <label class="text-dark">@lang('Upline Bet Win Commission')</label>
                                        <div class="custom-switch-btn ">
                                            <input type='hidden' value='1' name='bet_win_commission'>
                                            <input type="checkbox" name="bet_win_commission"
                                                   class="custom-switch-checkbox "
                                                   id="bet_win_commission"
                                                   value="0" <?php if ($control->bet_win_commission == 0):echo 'checked'; endif ?> >
                                            <label class="custom-switch-checkbox-label" for="bet_win_commission">
                                                <span class="custom-switch-checkbox-inner"></span>
                                                <span class="custom-switch-checkbox-switch"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6 mb-3">
                                        <button type="submit"
                                                class="btn  btn-rounded btn-primary mt-4 btn-block">
                                            <span>@lang('Save Changes')</span></button>
                                    </div>



                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">

                        <div class="card card-primary shadow">
                            <div class="card-body">


                                <h5 class="card-title">@lang('Deposit Bonus')</h5>
                                <div class="table-responsive">
                                    <table class="categories-show-table table table-hover table-striped table-bordered"
                                           id="zero_config">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">@lang('Level')</th>
                                            <th scope="col">@lang('Bonus')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($referrals->where('commission_type','deposit') as $item)
                                            <tr>
                                                <td data-label="Level">@lang('LEVEL')# {{ $item->level }}</td>
                                                <td data-label="@lang('Bonus')">
                                                    {{ $item->percent }} %
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="100%">@lang('No Data Found')</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

                        <div class="card card-primary shadow">
                            <div class="card-body">


                                <h5 class="card-title">@lang('Bet Invest Bonus')</h5>
                                <div class="table-responsive">
                                    <table class="categories-show-table table table-hover table-striped table-bordered"
                                           id="zero_config">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">@lang('Level')</th>
                                            <th scope="col">@lang('Bonus')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($referrals->where('commission_type','bet_invest') as $item)
                                            <tr>
                                                <td data-label="Level">@lang('LEVEL')# {{ $item->level }}</td>
                                                <td data-label="@lang('Bonus')">
                                                    {{ $item->percent }} %
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="100%">@lang('No Data Found')</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>


                        <div class="card card-primary shadow">
                            <div class="card-body">


                                <h5 class="card-title">@lang('Bet Win Bonus')</h5>
                                <div class="table-responsive">
                                    <table class="categories-show-table table table-hover table-striped table-bordered"
                                           id="zero_config">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">@lang('Level')</th>
                                            <th scope="col">@lang('Bonus')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($referrals->where('commission_type','bet_win') as $item)
                                            <tr>
                                                <td data-label="Level">@lang('LEVEL')# {{ $item->level }}</td>
                                                <td data-label="@lang('Bonus')">
                                                    {{ $item->percent }} %
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="100%">@lang('No Data Found')</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7">

                <div class="card card-primary shadow">

                    <div class="card-body">

                        <div class="row  formFiled justify-content-between ">
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label class="font-weight-bold">@lang('Select Type')</label>
                                    <select name="type" class="form-control  type">
                                        <option value="" disabled>@lang('Select Type')</option>
                                        <option value="deposit">@lang('Deposit Bonus')</option>
                                        <option value="bet_invest">@lang('Bet Invest Bonus')</option>
                                        <option value="bet_win">@lang('Bet Win Bonus')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">@lang('Set Level')</label>
                                    <input type="number" name="level" placeholder="@lang('Number Of Level')"
                                           class="form-control  numberOfLevel">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="button" class="btn btn-primary btn-block  makeForm ">
                                        <i class="fa fa-spinner"></i> @lang('GENERATE')
                                    </button>
                                </div>
                            </div>


                        </div>

                        <form action="" method="post" class="form-row">
                            @csrf

                            <input type="hidden" name="commission_type" value="">
                            <div class="col-md-12 newFormContainer">

                            </div>


                            <div class="col-md-12">
                                <button type="submit"
                                        class="btn btn-primary btn-block mt-3 submit-btn">@lang('Submit')</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>




@endsection

@push('style')
    <style>

        .table-responsive {
             min-height: initial;
        }
    </style>
@endpush
@push('js')

    @if ($errors->any())
        @php
            $collection = collect($errors->all());
            $errors = $collection->unique();
        @endphp
        <script>
            "use strict";
            @foreach ($errors as $error)
            Notiflix.Notify.Failure("{{trans($error)}}");
            @endforeach
        </script>
    @endif

    <script>
        "use strict";
        $(document).ready(function () {

            $('.submit-btn').addClass('d-none');

            $(".makeForm").on('click', function () {

                var levelGenerate = $(this).parents('.formFiled').find('.numberOfLevel').val();
                var selectType = $('.type :selected').val();
                if (selectType == '') {
                    Notiflix.Notify.Failure("{{trans('Please Select a type')}}");
                    return 0
                }

                $('input[name=commission_type]').val(selectType)
                var value = 1;
                var viewHtml = '';
                if (levelGenerate !== '' && levelGenerate > 0) {
                    for (var i = 0; i < parseInt(levelGenerate); i++) {
                        viewHtml += `<div class="input-group mt-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text no-right-border">LEVEL</span>
                            </div>
                            <input name="level[]" class="form-control" type="number" readonly value="${value++}" required placeholder="@lang('Level')">
                            <input name="percent[]" class="form-control" type="text" required placeholder="@lang("Level Bonus (%)")">
                            <span class="input-group-btn">
                            <button class="btn btn-danger removeForm" type="button"><i class='fa fa-trash'></i></button></span>
                            </div>`;
                    }

                    $('.newFormContainer').html(viewHtml);
                    $('.submit-btn').addClass('d-block');
                    $('.submit-btn').removeClass('d-none');

                } else {

                    $('.submit-btn').addClass('d-none');
                    $('.submit-btn').removeClass('d-block');
                    $('.newFormContainer').html(``);
                    Notiflix.Notify.Failure("{{trans('Please Set number of level')}}");
                }
            });

            $(document).on('click', '.removeForm', function () {
                $(this).closest('.input-group').remove();
            });


            $('select').select2({
                selectOnClose: true
            });

        });

    </script>
@endpush
