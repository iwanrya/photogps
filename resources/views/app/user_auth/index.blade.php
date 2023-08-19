@extends('app/common/layout')

@section('content')
<section>
    <div class="row">
        <div class="col-12">
            <div class="card card-white mt-2">
                <div class="card-header">
                    <h3 class="card-title with-left-border text-bold">{{ __('user_auth.title')}}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool btn-show-hide" data-card-widget="collapse">
                            <i class="fa fa-minus"> <span class="sh-text">{{ __('button.hidden')}}</span></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <a href="{{ URL::to('user_auth/create') }}">{{ __('user_auth.create_link')}}</a>

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <td class="w-5 text-center">{{ __('user_auth.id')}}</td>
                                <td>{{ __('user_auth.name')}}</td>
                                <td class="w-10">{{ __('user_auth.system_owner')}}</td>
                                <td class="w-20">{{ __('user_auth.dates')}}</td>
                                <td class="w-15">{{ __('user_auth.actions')}}</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user_auths as $key => $value)
                            <tr>
                                <td class="text-center">{{ $value->id }}</td>
                                <td>{{ $value->name }}</td>
                                <td>{{ $value->is_system_owner ? __('app.yes') : __('app.no') }}</td>
                                <td>{{ __(('table.create_date_symbol'))}}: {{ $value->created_at_formatted }}
                                    <br>
                                    {{ __(('table.update_date_symbol'))}}: {{ $value->updated_at_formatted }}
                                </td>

                                <!-- we will also add show, edit, and delete buttons -->
                                <td>
                                    <!-- delete the user_auth (uses the destroy method DESTROY /user_auth/{id} -->
                                    <!-- we will add this later since its a little more complicated than the other two buttons -->
                                    <a class="btn btn-sm btn-success" href="{{ URL::to('user_auth/' . $value->id) }}">{{ __('button.detail')}}</a>
                                    <a class="btn btn-sm btn-info" href="{{ URL::to('user_auth/' . $value->id . '/edit') }}">{{ __('button.edit')}}</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-2">
                        {!! $user_auths->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection