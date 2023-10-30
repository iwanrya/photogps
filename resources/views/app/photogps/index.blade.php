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
                    <form action="{{ url('photo') }}" method="GET">
                        <!-- 1 -->
                        <div class="form-group row">
                            <label class="col-form-label col-12 col-sm-2 text-right xs-text-left">{{ __('photogps.photographer')}}</label>
                            <div class="col-12 col-sm-3 col-md-3 col-lg-3">
                                <select id="photographer" name="photographer[]" class="form-control" multiple="multiple">
                                    @foreach ($photographers as $photographer)
                                    <option value="{{$photographer->code}}" {{ (request()->get('photographer') != null && in_array($photographer->code, request()->get('photographer')) ? 'selected' : '') }}>({{$photographer->username}}){{$photographer->name}}</option>
                                    @endforeach
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
                                                <input id="shoot_date_start" name="shoot_date_start" type="text" data-date-start="1" class="form-control datepicker" placeholder="yyyy/mm/dd" value="{{ request()->get('shoot_date_start') }}" />
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">~</span>
                                                </div>
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
                                                </div>
                                                <input id="shoot_date_end" name="shoot_date_end" type="text" data-date-end="1" class="form-control datepicker" placeholder="yyyy/mm/dd" value="{{ request()->get('shoot_date_end') }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-5 xs-mt-10 md-mt-10">
                                <div class="form-inline">
                                    <input type="checkbox" id="filter_date_toogle_opt_1" name="filter_date_toogle_1" value="1" data-btn-date="1" class="btn-check" {{ request()->get('filter_date_toogle_1') === '1' ? 'checked' : '' }} autocomplete="off">
                                    <label class="btn btn-outline-success ml-1" for="filter_date_toogle_opt_1">{{ __('button.today')}}</label>

                                    <input type="checkbox" id="filter_date_toogle_opt_2" name="filter_date_toogle_1" value="2" data-btn-date="1" class="btn-check" {{ request()->get('filter_date_toogle_1') === '2' ? 'checked' : '' }} autocomplete="off">
                                    <label class="btn btn-outline-success ml-1" for="filter_date_toogle_opt_2">{{ __('button.one_week_ago')}}</label>

                                    <input type="checkbox" id="filter_date_toogle_opt_3" name="filter_date_toogle_1" value="3" data-btn-date="1" class="btn-check" {{ request()->get('filter_date_toogle_1') === '3' ? 'checked' : '' }} autocomplete="off">
                                    <label class="btn btn-outline-success ml-1" for="filter_date_toogle_opt_3">{{ __('button.one_month_ago')}}</label>

                                    <input type="checkbox" id="filter_date_toogle_opt_4" name="filter_date_toogle_1" value="4" data-btn-date="1" class="btn-check" {{ request()->get('filter_date_toogle_1') === '4' ? 'checked' : '' }} autocomplete="off">
                                    <label class="btn btn-outline-success ml-1" for="filter_date_toogle_opt_4">{{ __('button.three_month_ago')}}</label>
                                </div>
                            </div>
                        </div>
                        <!-- 3 -->
                        <div class="form-group row">
                            @if (Auth::user()->isSystemOwner())
                            <label class="col-form-label col-12 col-sm-2 text-right xs-text-left">{{ __('photogps.customer')}}</label>
                            <div class="col-12 col-sm-3 col-md-3 col-lg-3">
                                <select id="company" name="company[]" class="form-control" multiple="multiple">
                                    @foreach ($companies as $company)
                                    <option value="{{$company->code}}" {{ (request()->get('company') != null && in_array($company->code, request()->get('company')) ? 'selected' : '') }}>{{$company->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            <label class="col-form-label col-12 col-sm-2 text-right xs-text-left">{{ __('photogps.project')}}</label>
                            <div class="col-12 col-sm-3 col-md-3 col-lg-3">
                                <select id="project" name="project[]" class="form-control" multiple="multiple">
                                    @foreach ($projects as $project)
                                    <option value="{{$project->code}}" {{ (request()->get('project') != null && in_array($project->code, request()->get('project')) ? 'selected' : '') }}>{{$project->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- 5 -->
                        <div class="form-group row">
                            <label class="col-form-label col-12 col-sm-2 text-right xs-text-left">{{ __('photogps.area')}}</label>
                            <div class="col-12 col-sm-3 col-md-3 col-lg-3">
                                <select id="area" name="area[]" class="form-control" multiple="multiple">
                                    @foreach ($areas as $area)
                                    <option value="{{$area->code}}" {{ (request()->get('area') != null && in_array($area->code, request()->get('area')) ? 'selected' : '') }}>{{$area->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="col-form-label col-12 col-sm-2 text-right xs-text-left">{{ __('photogps.status')}}</label>
                            <div class="col-12 col-sm-3 col-md-3 col-lg-3">
                                <select id="status" name="status[]" class="form-control" multiple="multiple">
                                    @foreach ($status as $item)
                                    <option value="{{$item->code}}" {{ (request()->get('status') != null && in_array($item->code, request()->get('status')) ? 'selected' : '') }}>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- 7 -->
                        <div class="form-group row">
                            <label class="col-form-label col-12 col-sm-2 text-right xs-text-left">{{ __('photogps.comment')}}</label>
                            <div class="col-12 col-sm-7">
                                <input type="text" class="form-control" id="comment" name="comment" value="{{ request()->get('comment') }}">
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
                                        <button type="submit" id="b_search" class="btn btn-success btn-block xs-btn-block xs-mt-10">{{ __('button.search')}}</button>
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
                                        <th class="text-center" width=40px>{{ __('photogps.no')}}</th>
                                        <th class="text-center" width=75%>{{ __('photogps.content')}}</th>
                                        <th class="text-center">{{ __('photogps.photograph')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($posts) === 0)
                                    <tr>
                                        <td class="text-center" colspan=3>{{ __('table.no_search_result')}}</td>
                                    </tr>
                                    @else
                                    @foreach ($posts as $key => $post)
                                    <tr>
                                        <td>{{ $posts->firstItem() + $key }}</td>
                                        <td>
                                            <div class='row mb-1'>
                                                <div class='col-4'>
                                                    <strong>{{ __('photogps.photographer')}}</strong>
                                                </div>
                                                <div class='col-8'>
                                                    {{ $post->photographer }}
                                                </div>
                                            </div>

                                            <div class='row mb-1'>
                                                <div class='col-4'>
                                                    <strong>{{ __('photogps.shoot_datetime')}}</strong>
                                                </div>
                                                <div class='col-8'>
                                                    {{ isset($post->postPhoto) && count($post->postPhoto) > 0 ? $post->postPhoto[0]->shoot_datetime_formatted : "-" }}
                                                </div>
                                            </div>

                                            <div class='row mb-1'>
                                                <div class='col-4'>
                                                    <strong>{{ __('photogps.location')}}</strong>
                                                </div>
                                                <div class='col-8'>
                                                    <strong>{{ __('photogps.latitude')}}</strong>: {{ isset($post->postPhoto) && count($post->postPhoto) > 0 ? $post->postPhoto[0]->latitude : "-" }}
                                                    <strong>{{ __('photogps.longitude')}}</strong>: {{ isset($post->postPhoto) && count($post->postPhoto) > 0 ? $post->postPhoto[0]->longitude : "-" }}
                                                </div>
                                            </div>

                                            <div class='row mb-1'>
                                                <div class='col-4'>
                                                    <strong>{{ __('photogps.company_name')}}</strong>
                                                </div>
                                                <div class='col-8'>
                                                    {{ $post->company ? $post->company->name : "-" }}
                                                </div>
                                            </div>

                                            <div class='row mb-1'>
                                                <div class='col-4'>
                                                    <strong>{{ __('photogps.project_name')}}</strong>
                                                </div>
                                                <div class='col-8'>
                                                    {{ $post->project ? $post->project->name : "-" }}
                                                </div>
                                            </div>

                                            <div class='row mb-1'>
                                                <div class='col-4'>
                                                    <strong>{{ __('photogps.status')}}</strong>
                                                </div>
                                                <div class='col-8'>
                                                    {{ $post->statusItem ? $post->statusItem->name : "-" }}
                                                </div>
                                            </div>

                                            <div class='row'>
                                                <div class='col-12 text-right'>
                                                    <a href="{{ $post->report }}" class='btn btn-success'><i class="fa fa-file-excel-o" aria-hidden="true"></i> {{ __('photogps.download_report')}}</a>
                                                    <button data-bs-toggle='modal' data-id='{{ $post->id }}' data-bs-target='#popup_photo_mobile_detail' class='btn btn-primary'>{{ __('photogps.detail')}}</button>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="align-content: center; align-items: center; text-align: center; vertical-align: middle;"><img src='{{ count($post->postPhoto) > 0 ? $post->postPhoto[0]->thumbnail : "" }}' style='max-width: 120px; max-height: 120px;' /></td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>

                            <div class="mt-2">
                                {!! $posts->render("pagination::custom-jpns") !!}
                            </div>
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
@include('app.photogps.popup.image_info')
@endpush

@push('js')
<script src="{{asset('assets/js/posts/index.js')}}"></script>
@endpush