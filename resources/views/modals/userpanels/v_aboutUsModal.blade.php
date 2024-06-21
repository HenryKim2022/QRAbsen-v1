<div class="modal fade text-left modal-success" id="aboutUsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel112" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel112">AboutUS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p style="text-align: justify;">
                    {{ $aboutus_data->text_setting }}
                </p>
            </div>
            <div class="modal-footer d-none">
                <button type="button" class="btn btn-success" data-dismiss="modal">Okay</button>
            </div>
        </div>
    </div>
</div>
