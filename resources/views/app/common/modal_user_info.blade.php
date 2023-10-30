<div id="modal_user_info" class="modal modal-additional-bg" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <table id="tbl_user_info">
                    <tr>
                        <td class="first_column">{{ __('userinfo.userid')}}</td>
                        <td class="second_column">:</td>
                        <td class="third_column">{{ auth()->user()->username }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('userinfo.name')}}</td>
                        <td>:</td>
                        <td>{{ auth()->user()->name }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('userinfo.company_name')}}</td>
                        <td>:</td>
                        <td>{{ auth()->user()->companyUser->company->name }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('userinfo.permissions')}}</td>
                        <td>:</td>
                        <td>{{ auth()->user()->companyUser->userAuth->name }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('userinfo.last_login')}}</td>
                        <td>:</td>
                        <td>{{ auth()->user()->lastLogin }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <a href="{{route('changepassword')}}" type="button" class="btn btn-primary">{{ __('menu.change_password') }}</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('button.close')}}</button>
            </div>
        </div>
    </div>
</div>