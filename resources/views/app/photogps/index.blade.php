@extends('app/common/layout')

@section('content')
<section>
    <div class="row">
        <div class="col-12">
            <div class="card card-white">
                <div class="card-header">
                    <h3 class="card-title with-left-border text-bold">写真共有ツール</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool btn-show-hide" data-card-widget="collapse">
                            <i class="fa fa-minus"> <span class="sh-text">非表示</span></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form action="">
                        <!-- 1 -->
                        <div class="form-group row">
                            <label class="col-form-label col-12 col-sm-2 text-right xs-text-left">撮影者</label>
                            <div class="col-12 col-sm-3 col-md-3 col-lg-3">
                                <select id="photographer" class="form-control" multiple="multiple">
                                    <option value='aaaaa'>asfasodj</option>
                                    <?php
                                    for ($i = 0; $i < count($photographers); $i++) {
                                        $photographer = $photographers[$i];
                                        echo "<option value='" . $photographer->code . "'" . (isset($_GET['photographer']) && $_GET['photographer'] === $photographer->code ? 'selected' : '') . ">" . '(' . $photographer->code . ')' . $photographer->name . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- 2 -->
                        <div class="form-group row">
                            <label class="col-form-label col-12 col-sm-2 text-right xs-text-left">撮影日時</label>
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
                                    <button data-btn-date="1" data-val="1" type="button" class="btn <?= isset($_GET['filter_date_toogle_1']) && $_GET['filter_date_toogle_1'] === '1' ? 'btn-success' : 'btn-default'; ?> btn-onoff ml-1" <?= isset($_GET['order_date_not_null']) && $_GET['order_date_not_null'] === 'true' ? 'disabled' : '' ?>>本日</button>
                                    <button data-btn-date="1" data-val="2" type="button" class="btn <?= isset($_GET['filter_date_toogle_1']) && $_GET['filter_date_toogle_1'] === '2' ? 'btn-success' : 'btn-default'; ?> btn-onoff ml-1" <?= isset($_GET['order_date_not_null']) && $_GET['order_date_not_null'] === 'true' ? 'disabled' : '' ?>>1週間前</button>
                                    <button data-btn-date="1" data-val="3" type="button" class="btn <?= isset($_GET['filter_date_toogle_1']) && $_GET['filter_date_toogle_1'] === '3' ? 'btn-success' : 'btn-default'; ?> btn-onoff ml-1" <?= isset($_GET['order_date_not_null']) && $_GET['order_date_not_null'] === 'true' ? 'disabled' : '' ?>>1カ月前</button>
                                    <button data-btn-date="1" data-val="4" type="button" class="btn <?= isset($_GET['filter_date_toogle_1']) && $_GET['filter_date_toogle_1'] === '4' ? 'btn-success' : 'btn-default'; ?> btn-onoff ml-1" <?= isset($_GET['order_date_not_null']) && $_GET['order_date_not_null'] === 'true' ? 'disabled' : '' ?>>3カ月前</button>
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
                                        <button type="button" id="b_clear" class="btn btn-default btn-block xs-btn-block">クリア</button>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                        <button type="button" id="b_search" class="btn btn-success btn-block xs-btn-block xs-mt-10">検　索</button>
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
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">{{ __('message.content') }}</th>
                                        <th class="text-center">{{ __('message.photograph') }}</th>
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

@section('js')
<script src="{{asset('js/app/url.js')}}"></script>
<script src="{{asset('js/posts/index.js')}}"></script>
@endsection