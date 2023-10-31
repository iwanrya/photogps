@extends('app/common/layout')

@section('content')
<section>
    <div class="row">
        <div class="col-12">
            <div class="card card-white mt-2">
                <div class="card-header">
                    <h3 class="card-title with-left-border text-bold">{{ __('user.title')}}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool btn-show-hide" data-card-widget="collapse">
                            <i class="fa fa-minus"> <span class="sh-text">{{ __('button.hidden')}}</span></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <a href="{{ URL::to('user/create') }}">{{ __('user.create_link')}}</a>

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <td class="w-5 text-center">{{ __('user.no')}}</td>
                                <td>{{ __('user.name')}}</td>
                                <td class="w-30">{{ __('user.details')}}</td>
                                <td class="w-20">{{ __('user.dates')}}</td>
                                <td class="w-20">{{ __('user.actions')}}</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $key => $value)
                            <tr>
                                <td class="text-center">{{ $users->firstItem() + $key }}</td>
                                <td>{{ $value->name }}</td>
                                <td>{{ __('user.email')}}: {{ $value->email }}
                                    <br />
                                    {{ __('user.company')}}: {{ !empty($value->companyUser) ? $value->companyUser->company->name : "-" }}
                                    <br />
                                    {{ __('user.role')}}: {{ !empty($value->companyUser) ? $value->companyUser->userAuth->name : "-" }}
                                </td>
                                <td>{{ __(('table.create_date_symbol'))}}: {{ $value->created_at_formatted }}
                                    <br>
                                    {{ __(('table.update_date_symbol'))}}: {{ $value->updated_at_formatted }}
                                </td>

                                <td>
                                    <a class="btn btn-sm btn-success" href="{{ URL::to('user/' . $value->id) }}">{{ __('button.detail')}}</a>
                                    <a class="btn btn-sm btn-info" href="{{ URL::to('user/' . $value->id . '/edit') }}">{{ __('button.edit')}}</a>
                                    <a class="btn btn-sm btn-danger" href="{{ route('user.delete', $value->id) }}">{{ __('button.delete')}}</i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-2">
                        {!! $users->render("pagination::custom-jpns") !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection