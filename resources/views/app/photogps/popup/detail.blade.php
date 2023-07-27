<div class="modal fade" id="popup_photo_mobile_detail" style="padding-right: 17px;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary-soft">
                <div>
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">{{ __('button.close')}}</button>
                </div>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <div>
                        <div class="form-group row">
                            <div class="col-8">
                                <div id="dv_pmd_comment" style="max-height: 250px; overflow-y: auto; overflow-x: hidden;">
                                </div>
                                <textarea class="form-control mb-1 mt-2" id="pmd_new_comment" rows="3"></textarea>
                                <div class="text-right">
                                    <button id="ppmd_add_comment" class="btn btn-primary button-small-font">{{ __('photogps.submit_comment')}}</button>
                                </div>
                            </div>
                            <div class="col-4">
                                <div id="pmd_no_gps_info" class="no-gps-info">{{ __('photogps.no_gps_info_1')}}<br>{{ __('photogps.no_gps_info_2')}}</div>
                                <div id="pmd_maps"></div>
                                <div id="pmd_image" class="text-center mt-2 mb-2">
                                    <img />
                                </div>
                                <a id='pmd_image_original' class="btn btn-primary button-small-font w-100 mb-2" download>{{ __('photogps.download_original_image')}}</a>
                                <a id='pmd_image_no_exif' class="btn btn-primary button-small-font w-100 mb-2" download>{{ __('photogps.download_noexif_image')}}</a>
                                <button id="ppmd_delete" class="btn btn-danger text-white button-small-font w-100"><i class="fa fa-trash"></i> {{ __('photogps.delete')}}</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@push('js')
<script src="{{asset('assets/js/posts/popup/posts_detail.js')}}"></script>
@endpush