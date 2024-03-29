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
                    <ul class="nav navbar-nav">
                        <li><a href="{{ URL::to('project') }}">{{ __('project.view_link')}}</a></li>
                        <li><a href="{{ URL::to('project/create') }}">{{ __('project.create_link')}}</a></li>
                    </ul>

                    <form action="{{ route('project.update', $project->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label class="col-form-label col-12 col-sm-2 text-right xs-text-left">{{ __('project.company')}}</label>
                            <div class="col-12 col-sm-3 col-md-3 col-lg-3">
                                <select id="company" name="company" class="form-control">
                                    <option hidden></option>
                                    @foreach ($companies as $company) 
                                        <option value="{{$company->code}}" {{ ($company->code == (old() ? old('company') : $project->company_id) ? 'selected' : '') }}>{{$company->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('company'))
                                <div>
                                    <small class="text-danger text-left">{{ $errors->first('company') }}</small>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-12 col-sm-4 col-md-3 col-lg-2 text-right xs-text-left">{{ __('project.name')}}</label>
                            <div class="col-12 col-sm-5 col-md-3">
                                <input type="text" class="form-control" name="name" value="{{ old() ? old('name') : $project->name }}">
                                @if ($errors->has('name'))
                                <div>
                                    <small class="text-danger text-left">{{ $errors->first('name') }}</small>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">{{ __('button.submit')}}</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('js')
<script src="{{asset('assets/js/projects/edit.js')}}"></script>
@endpush