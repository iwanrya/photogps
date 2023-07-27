@extends('app/common/layout')

@section('content')
<section>
    <div class="row">
        <div class="col-12">
            <div class="card card-white mt-2">
                <div class="card-header">
                    <h3 class="card-title with-left-border text-bold">{{ __('photogps.title')}}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool btn-show-hide" data-card-widget="collapse">
                            <i class="fa fa-minus"> <span class="sh-text">{{ __('button.hidden')}}</span></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form action="">
                        <!-- 1 -->
                        <div class="form-group row">
                            <label class="col-form-label col-12 col-sm-2 text-right xs-text-left">{{ __('photogps.photographer')}}</label>
                            <div class="col-12 col-sm-3 col-md-3 col-lg-3">
                                <select id="photographer" class="form-control" multiple="multiple">
                                    <?php
                                    for ($i = 0; $i < count($photographers); $i++) {
                                        $photographer = $photographers[$i];
                                        echo "<option value='" . $photographer->code . "'" . (isset($_GET['photographer']) && $_GET['photographer'] === $photographer->code ? 'selected' : '') . ">({$photographer->username}){$photographer->name}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- 2 -->
                        <div class="form-group row">
                            <label class="col-form-label col-12 col-sm-2 text-right xs-text-left">{{ __('photogps.shoot_datetime')}}</label>
                            <div class="col-12 col-sm-4 col-md-4 col-lg-4">
                                <div class="row">
                                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-inline xs-mt-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
                                                </div>
                                                <input id="shoot_date_start" type="text" data-date-start="1" class="form-control datepicker" placeholder="yyyy/mm/dd" value="<?= isset($_GET['shoot_date_start']) && $_GET['shoot_date_start'] !== '' ? $_GET['shoot_date_start'] : '' ?>" ?>
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">~</span>
                                                </div>
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
                                                </div>
                                                <input id="shoot_date_end" type="text" data-date-end="1" class="form-control datepicker" placeholder="yyyy/mm/dd" value="<?= isset($_GET['shoot_date_end']) && $_GET['shoot_date_end'] !== '' ? $_GET['shoot_date_end'] : '' ?>" ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-5 xs-mt-10 md-mt-10">
                                <div class="form-inline">
                                    <button data-btn-date="1" data-val="1" type="button" class="btn <?= isset($_GET['filter_date_toogle_1']) && $_GET['filter_date_toogle_1'] === '1' ? 'btn-success' : 'btn-default'; ?> btn-onoff ml-1" <?= isset($_GET['order_date_not_null']) && $_GET['order_date_not_null'] === 'true' ? 'disabled' : '' ?>>{{ __('button.today')}}</button>
                                    <button data-btn-date="1" data-val="2" type="button" class="btn <?= isset($_GET['filter_date_toogle_1']) && $_GET['filter_date_toogle_1'] === '2' ? 'btn-success' : 'btn-default'; ?> btn-onoff ml-1" <?= isset($_GET['order_date_not_null']) && $_GET['order_date_not_null'] === 'true' ? 'disabled' : '' ?>>{{ __('button.one_week_ago')}}</button>
                                    <button data-btn-date="1" data-val="3" type="button" class="btn <?= isset($_GET['filter_date_toogle_1']) && $_GET['filter_date_toogle_1'] === '3' ? 'btn-success' : 'btn-default'; ?> btn-onoff ml-1" <?= isset($_GET['order_date_not_null']) && $_GET['order_date_not_null'] === 'true' ? 'disabled' : '' ?>>{{ __('button.one_month_ago')}}</button>
                                    <button data-btn-date="1" data-val="4" type="button" class="btn <?= isset($_GET['filter_date_toogle_1']) && $_GET['filter_date_toogle_1'] === '4' ? 'btn-success' : 'btn-default'; ?> btn-onoff ml-1" <?= isset($_GET['order_date_not_null']) && $_GET['order_date_not_null'] === 'true' ? 'disabled' : '' ?>>{{ __('button.three_month_ago')}}</button>
                                </div>
                            </div>
                        </div>
                        <!-- 3 -->
                        <div class="form-group row">
                            <label class="col-form-label col-12 col-sm-2 text-right xs-text-left">コメント</label>
                            <div class="col-12 col-sm-7">
                                <input type="text" class="form-control" id="comment" value="<?= isset($_GET['comment']) && $_GET['comment'] !== '' ? $_GET['comment'] : '' ?>">
                            </div>
                        </div>
                        <!-- button -->
                        <div class="form-group row">
                            <label class="col-form-label col-12 col-sm-4 text-right xs-text-left"></label>
                            <div class="col-12 col-sm-4 col-md-4 col-lg-4">
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                        <button type="button" id="b_clear" class="btn btn-default btn-block xs-btn-block">{{ __('button.reset')}}</button>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                        <button type="button" id="b_search" class="btn btn-success btn-block xs-btn-block xs-mt-10">{{ __('button.search')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="card card-white" style="margin-bottom: 75px;">
        <div class="card-body">
            <div class="row mt-10">
                <div class="col-12">
                    <div class="table-responsive-wrapper">
                        <div id="dvSearchResult">
                            <table id="tblResult" class="table table-bordered table-soft-dark">
                                <thead>
                                    <tr>
                                        <th class="text-center"></th>
                                        <th class="text-center" width=70%>{{ __('photogps.content')}}</th>
                                        <th class="text-center">{{ __('photogps.photograph')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>
@endsection

@push('modals')
@include('app.photogps.popup.detail')
@endpush

@push('js')
<script src="{{asset('assets/js/app/url.js')}}"></script>
<script src="{{asset('assets/js/posts/index.js')}}"></script>
<script src="{{asset('assets/js/posts/datatable.js')}}"></script>
@endpush