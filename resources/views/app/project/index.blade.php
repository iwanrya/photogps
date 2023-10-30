@extends('app/common/layout')

@section('content')
<section>
    <div class="row">
        <div class="col-12">
            <div class="card card-white mt-2">
                <div class="card-header">
                    <h3 class="card-title with-left-border text-bold">{{ __('project.title')}}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool btn-show-hide" data-card-widget="collapse">
                            <i class="fa fa-minus"> <span class="sh-text">{{ __('button.hidden')}}</span></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ url('project') }}" method="GET">
                        <!-- 1 -->
                        <div class="form-group row">
                            <label class="col-form-label col-12 col-sm-2 text-right xs-text-left">{{ __('project.company')}}</label>
                            <div class="col-12 col-sm-3 col-md-3 col-lg-3">
                                <select id="company" name="company[]" class="form-control" multiple="multiple">
                                    @foreach ($companies as $company)
                                    <option value="{{$company->code}}" {{ (request()->get('company') != null && in_array($company->code, request()->get('company')) ? 'selected' : '') }}>{{$company->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- 2 -->
                        <div class="form-group row">
                            <label class="col-form-label col-12 col-sm-2 text-right xs-text-left">{{ __('project.name')}}</label>
                            <div class="col-12 col-sm-7">
                                <input type="text" class="form-control" id="name" name="name" value="{{ request()->get('name') }}">
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
    <div class="row">
        <div class="col-12">
            <div class="card card-white mt-2">
                <div class="card-header">
                    <h3 class="card-title with-left-border text-bold">{{ __('project.title')}}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool btn-show-hide" data-card-widget="collapse">
                            <i class="fa fa-minus"> <span class="sh-text">{{ __('button.hidden')}}</span></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <a href="{{ URL::to('project/create') }}">{{ __('project.create_link')}}</a>

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <td class="w-5 text-center">{{ __('project.id')}}</td>
                                <td>{{ __('project.content')}}</td>
                                <td class="w-20">{{ __('project.dates')}}</td>
                                <td class="w-20">{{ __('project.actions')}}</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projects as $key => $project)
                            <tr>
                                <td class="text-center">{{ $project->id }}</td>
                                <td>
                                    <div class='row mb-1'>
                                        <div class='col-4'>
                                            <strong>{{ __('project.name')}}</strong>
                                        </div>
                                        <div class='col-8'>
                                            {{ $project->name }}
                                        </div>
                                    </div>

                                    <div class='row mb-1'>
                                        <div class='col-4'>
                                            <strong>{{ __('project.company')}}</strong>
                                        </div>
                                        <div class='col-8'>
                                            {{ $project->company ? $project->company->name : "-" }}
                                        </div>
                                    </div>
                                </td>
                                <td>{{ __(('table.create_date_symbol'))}}: {{ $project->created_at_formatted }}
                                    <br>
                                    {{ __(('table.update_date_symbol'))}}: {{ $project->updated_at_formatted }}
                                </td>

                                <td>
                                    <a class="btn btn-sm btn-success" href="{{ URL::to('project/' . $project->id) }}">{{ __('button.detail')}}</a>
                                    <a class="btn btn-sm btn-info" href="{{ URL::to('project/' . $project->id . '/edit') }}">{{ __('button.edit')}}</a>
                                    <a class="btn btn-sm btn-danger" href="{{ route('project.delete', $project->id) }}">{{ __('button.delete')}}</i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-2">
                        {!! $posts->render("pagination::custom-jpns") !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('js')
<script src="{{asset('assets/js/projects/index.js')}}"></script>
@endpush