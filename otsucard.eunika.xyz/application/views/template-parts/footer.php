<script src="<?php echo base_url('src/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?php echo base_url('src/dist/js/adminlte.min.js') ?>"></script>

<script src="<?php echo base_url('src/plugins/moment/moment-with-locales.min.js') ?>"></script>

<script src="<?php echo base_url('src/plugins/select2/js/select2.full.js') ?>"></script>

<script src="<?php echo base_url('src/plugins/toastr/toastr.min.js') ?>"></script>

<!-- DataTables  & Plugins -->
<script src="<?php echo base_url('src/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('src/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?php echo base_url('src/plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
<script src="<?php echo base_url('src/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>
<script src="<?php echo base_url('src/plugins/datatables-buttons/js/dataTables.buttons.min.js') ?>"></script>
<script src="<?php echo base_url('src/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') ?>"></script>
<script src="<?php echo base_url('src/plugins/jszip/jszip.min.js') ?>"></script>
<script src="<?php echo base_url('src/plugins/pdfmake/pdfmake.min.js') ?>"></script>
<script src="<?php echo base_url('src/plugins/pdfmake/vfs_fonts.js') ?>"></script>
<script src="<?php echo base_url('src/plugins/datatables-buttons/js/buttons.html5.min.js') ?>"></script>
<script src="<?php echo base_url('src/plugins/datatables-buttons/js/buttons.print.min.js') ?>"></script>
<script src="<?php echo base_url('src/plugins/datatables-buttons/js/buttons.colVis.min.js') ?>"></script>

<script src="<?php echo base_url('src/plugins/bs-custom-file-input/bs-custom-file-input.min.js') ?>"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script src="<?php echo base_url('src/js/global.js') ?>"></script>


<?php
if (isset($js)) {

    if (!is_array($js)) {
        show_error('<b>Invalid parameter:</b> $js must be an array of JavaScript filenames.', 500);
    }

    foreach ($js as $js_filename) {
        $file_url  = base_url("src/js/{$js_filename}.js");
        $file_path = FCPATH . "src/js/{$js_filename}.js";

        if (file_exists($file_path)) {
            $file_version = filemtime($file_path);
            echo "<script src='{$file_url}?ver={$file_version}'></script>";
        }
    }
}
?>