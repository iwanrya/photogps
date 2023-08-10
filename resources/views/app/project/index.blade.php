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
                    <a href="{{ URL::to('project/create') }}">{{ __('project.create_link')}}</a>

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <td class="w-5 text-center">{{ __('project.id')}}</td>
                                <td>{{ __('project.name')}}</td>
                                <td class="w-20">{{ __('project.dates')}}</td>
                                <td class="w-15">{{ __('project.actions')}}</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projects as $key => $value)
                            <tr>
                                <td class="text-center">{{ $value->id }}</td>
                                <td>{{ $value->name }}</td>
                                <td>{{ __(('table.create_date_symbol'))}}: {{ $value->created_at_formatted }}
                                    <br>
                                    {{ __(('table.update_date_symbol'))}}: {{ $value->updated_at_formatted }}
                                </td>

                                <!-- we will also add show, edit, and delete buttons -->
                                <td>
                                    <!-- delete the project (uses the destroy method DESTROY /project/{id} -->
                                    <!-- we will add this later since its a little more complicated than the other two buttons -->
                                    <a class="btn btn-sm btn-success" href="{{ URL::to('project/' . $value->id) }}">{{ __('button.detail')}}</a>
                                    <a class="btn btn-sm btn-info" href="{{ URL::to('project/' . $value->id . '/edit') }}">{{ __('button.edit')}}</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection