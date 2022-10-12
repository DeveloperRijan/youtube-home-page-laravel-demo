<!-- Modal Upload-->
<?php
	$ts = time();
	$user_id = 5;
	$date = date("Y-m-d");
?>
<div class="modal fade" tabindex="-1" id="uploaderModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ __('Upload file') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <h5>{{ __('Drag and drop multipe files') }}</h5>
            </div>
            <div id="uploaderHolder">
                <form action="{{ route('file-upload') }}"
                    class="dropzone"
                    id="datanodeupload">

                    <input type="file" name="file"  style="display: none;">
                    <input type="hidden" name="dataTS" id="dataTS" value="{{ $ts }}">
                    <input type="hidden" name="dataDATE" id="dataDATE" value="{{ $date }}">
                    @csrf
                </form>
            </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onClick="window.location.reload();">{{ __('Done') }}</button>
        </div>
      </div>
    </div>
  </div>
