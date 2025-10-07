<div class="card">
    <div class="card-body">
        <p class="h4 m-0 font-weight-bold"><?php echo $title ?></p>
        <p class="m-0 text-muted">Manage all professional identification cards and user access</p>
    </div>
</div>

<div class="card card-primary">
    <div class="card-header p-3">
        <p class="h4 m-0">
            <i class="fas fa-user mr-2"></i> Card Management Dashboard
        </p>
    </div>
    <div class="card-body container-fluid">

        <table id="cardsTable" class="table w-100">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Card Number</th>
                    <th>Card Status</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile Number</th>
                    <th>Role</th>
                    <th>Image</th>
                    <th>Date Generated</th>
                    <th>Options</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <p class="text-center h2 mb-3 font-weight-bold">Card Generator</p>

        <button id="generateNewCardBtn" class="btn btn-outline-primary rounded-pill d-block mx-auto">Generate new card</button>

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 p-2 d-flex align-items-center justify-content-center flex-column" style="gap: 1rem">
                    <p class="qr_label h5 font-weight-bold d-none">Profile Link</p>
                    <div class="card_qr_code_profile" role="button"></div>
                    <a class="card_qr_link_profile" role="button" style="word-break: break-all;"></a>
                </div>
                <div class="col-lg-6 p-2 d-flex align-items-center justify-content-center flex-column" style="gap: 1rem">
                    <p class="qr_label h5 font-weight-bold d-none">Registration Link</p>
                    <div class="card_qr_code_edit" role="button"></div>
                    <a class="card_qr_link_edit" role="button" style="word-break: break-all;"></a>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="cardTableModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <h4 class="text-center">Click QR Code to Download</h4>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 p-3">
                            <h5 class="text-center">Profile Link</h5>
                            <div class="modal_card_qr_code_profile d-flex align-items-center justify-content-center"></div>
                            <div class="modal_card_qr_link_profile text-center" style="word-wrap: break-word;"></div>
                        </div>

                        <div class="col-md-6 p-3">
                            <h5 class="text-center">Registration Link</h5>
                            <div class="modal_card_qr_code_edit d-flex align-items-center justify-content-center"></div>
                            <div class="modal_card_qr_link_edit text-center" style="word-wrap: break-word;"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>