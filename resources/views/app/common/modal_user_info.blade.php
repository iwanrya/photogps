<div id="modal_user_info" class="modal modal-additional-bg" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <table id="tbl_user_info">
                    <tr>
                        <td class="first_column">{{ __('message.userid')}}</td>
                        <td class="second_column">:</td>
                        <td class="third_column">{{ auth()->user()->username }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('message.name')}}</td>
                        <td>:</td>
                        <td>{{ Str::title(auth()->user()->name) }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('message.company_name')}}</td>
                        <td>:</td>
                        <td>{{ Str::title(auth()->user()->company_name) }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('message.permissions')}}</td>
                        <td>:</td>
                        <td>{{ auth()->user()->permissions }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('message.last_login')}}</td>
                        <td>:</td>
                        <td>{{ auth()->user()->last_login }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">{{ __('menu.change_password') }}</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('button.close')}}</button>
            </div>
        </div>
    </div>
</div>