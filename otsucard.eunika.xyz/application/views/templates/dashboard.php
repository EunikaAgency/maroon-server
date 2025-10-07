<?php if (!isset($page)) show_error('<b>Missing parameter:</b> $page is required but was not provided.', 500); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->view('template-parts/head'); ?>
    <link rel="stylesheet" href="<?php echo base_url('src/css/dashboard.css?ver=' . time()) ?>">
</head>

<body class="dashboard-template hold-transition sidebar-mini">
    <div class="wrapper">

        <?php $this->view('template-parts/dashboard-header'); ?>

        <?php $this->view('template-parts/dashboard-sidebar'); ?>

        <div class="content-wrapper">
            <section class="content p-3">

                <div class="container-fluid">
                    <?php $this->view($page); ?>
                </div>

            </section>
        </div>

        <?php $this->view('template-parts/dashboard-footer'); ?>

        <?php $this->view('template-parts/footer'); ?>
</body>

</html>