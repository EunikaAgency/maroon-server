<?php if (!isset($page)) show_error('<b>Missing parameter:</b> $page is required but was not provided.', 500); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->view('template-parts/head'); ?>
</head>

<body class="plain-template">
    <?php $this->view($page, ['css' => ['asd']]); ?>

    <?php $this->view('template-parts/footer'); ?>
</body>

</html>