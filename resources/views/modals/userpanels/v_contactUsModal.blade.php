 <div class="modal fade text-left modal-success" id="contactUsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel113" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel113">ContactUS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div style="text-align: justify;">
                    {{ $company_addr->text_setting }}
                </div>
                <br>
                <div class="d-flex align-items-center justify-content-start">
                    <h5 class="me-0 mb-0">Phone:</h5>
                    <span class="ml-1">{{ $company_phone->text_setting }}</span>
                </div>
                <div class="d-flex align-items-center justify-content-start">
                    <h5 class="me-0 mb-0">Email:</h5>
                    <span class="ml-1">{{ $company_email->text_setting }}</span>
                </div>
            </div>
            <div class="modal-footer d-none">
                <button type="button" class="btn btn-success" data-dismiss="modal">Okay</button>
            </div>
        </div>
    </div>
</div>
