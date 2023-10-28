<div class="modal fade" id="popup_photo_mobile_image_info" style="padding-right: 17px;">
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
                                <div class="text-center ">
                                    <div id="ppmii_image">
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div id="ppmii_no_gps_info" class="no-gps-info">{{ __('photogps.no_gps_info_1')}}<br>{{ __('photogps.no_gps_info_2')}}</div>
                                <div id="ppmii_maps"></div>
                                <a id='ppmii_image_original' class="btn btn-primary button-small-font w-100 mt-2" download>{{ __('photogps.download_original_image')}}</a>
                                <a id='ppmii_image_no_exif' class="btn btn-primary button-small-font w-100 mt-2" download>{{ __('photogps.download_noexif_image')}}</a>
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
<script src="{{asset('assets/js/posts/popup/posts_image_info.js')}}"></script>
@endpush