@if (isset($_COOKIE['debugger']))
    <div class="d-none d-md-flex justify-content-center" style="user-select: none; font-size: 10px">

        <div style="width: 100px; border-radius: 100% !important; aspect-ratio: 1/1"
            class="bg-light d-flex flex-column align-items-center justify-content-center p-2 border border-electric_pink card-shadow m2- mx-4">
            <img src="{{ wp_get_attachment_url(13566) }}" class="aspect-square" style="width: 30px">
            <p class="text-xs font-weight-bold text-center m-0 mt-2">Engineer Certified</p>
        </div>


        <div style="width: 100px; border-radius: 100% !important; aspect-ratio: 1/1"
            class="bg-light d-flex flex-column align-items-center justify-content-center p-2 border border-electric_pink card-shadow m2- mx-4">
            <img src="{{ wp_get_attachment_url(13565) }}" class="aspect-square" style="width: 30px">
            <p class="text-xs font-weight-bold text-center m-0 mt-2">Weather Resistant</p>
        </div>


        <div style="width: 100px; border-radius: 100% !important; aspect-ratio: 1/1"
            class="bg-light d-flex flex-column align-items-center justify-content-center p-2 border border-electric_pink card-shadow m2- mx-4">
            <img src="{{ wp_get_attachment_url(13567) }}" class="aspect-square" style="width: 30px">
            <p class="text-xs font-weight-bold text-center m-0 mt-2">Strong & Durable</p>
        </div>


        <div style="width: 100px; border-radius: 100% !important; aspect-ratio: 1/1"
            class="bg-light d-flex flex-column align-items-center justify-content-center p-2 border border-electric_pink card-shadow m2- mx-4">
            <img src="{{ wp_get_attachment_url(13568) }}" class="aspect-square" style="width: 30px">
            <p class="text-xs font-weight-bold text-center m-0 mt-2">Termite Resistant</p>
        </div>

    </div>
@endif
{{-- <div class="d-none d-md-block container-fluid">
        <div class="row py-3">

            <div class="col-3">
                <div class="bg-light d-flex align-items-center justify-content-center aspect-square p-2 rounded">
                    <img src="{{ wp_get_attachment_url(13566) }}">
                </div>
            </div>


            <div class="col-3">
                <div class="bg-light d-flex align-items-center justify-content-center aspect-square p-2 rounded">
                    <img src="{{ wp_get_attachment_url(13565) }}">
                </div>
            </div>


            <div class="col-3">
                <div class="bg-light d-flex align-items-center justify-content-center aspect-square p-2 rounded">
                    <img src="{{ wp_get_attachment_url(13567) }}">
                </div>
            </div>


            <div class="col-3">
                <div class="bg-light d-flex align-items-center justify-content-center aspect-square p-2 rounded">
                    <img src="{{ wp_get_attachment_url(13568) }}">
                </div>
            </div>

        </div>
    </div> --}}
