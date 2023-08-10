@extends('app/common/layout')

@section('content')
<section>
    <div class="row">
        <div class="col-12">
            <div class="card card-white mt-2">
                <div class="card-header">
                    <h3 class="card-title with-left-border text-bold">{{ __('customer.title')}}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool btn-show-hide" data-card-widget="collapse">
                            <i class="fa fa-minus"> <span class="sh-text">{{ __('button.hidden')}}</span></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="nav navbar-nav">
                        <li><a href="{{ URL::to('customer') }}">{{ __('customer.view_link')}}</a></li>
                        <li><a href="{{ URL::to('customer/create') }}">{{ __('customer.create_link')}}</a></li>
                    </ul>

                    <form action="{{ route('customer.update', $customer->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label class="col-form-label col-12 col-sm-2 text-right xs-text-left">{{ __('customer.name')}}</label>
                            <div class="col-12 col-sm-2">
                                <input type="text" class="form-control" name="name" value="{{ $customer->name }}">
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