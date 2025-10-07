<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Otsuka HCP <?php echo isset($title) ? ' | ' . $title : ' | Otsucard' ?></title>

<link rel="shortcut icon" href="<?php echo base_url('src/images/otsuka-logo.png') ?>" type="image/x-icon">

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

<script src="<?php echo base_url('src/plugins/jquery/jquery.min.js') ?>"></script>

<link rel="stylesheet" href="<?php echo base_url('src/plugins/fontawesome-free/css/all.min.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('src/dist/css/adminlte.min.css') ?>">

<link rel="stylesheet" href="<?php echo base_url('src/plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('src/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

<link rel="stylesheet" href="<?php echo base_url('src/plugins/toastr/toastr.css') ?>">

<!-- DataTables -->
<link rel="stylesheet" href="<?php echo base_url('src/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('src/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('src/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') ?>">

<?php

if (isset($css)) {
    
    if (!is_array($css)) {
        show_error('<b>Invalid parameter:</b> $css must be an array of stylesheet filenames.', 500);
    }

    foreach ($css as $css_filename) {
        $file_url = base_url("src/css/{$css_filename}.css");
        $file_path = FCPATH . "src/css/{$css_filename}.css";

        if (file_exists($file_path)) {
            $file_version = filemtime($file_path);
            echo "<link rel='stylesheet' href='$file_url?ver=$file_version'></link>";
        }
    }
}
?>




<script>
    const base_url = '<?php echo base_url() ?>';
</script>