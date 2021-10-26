<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Preview</title>
    <?php wp_head(); ?>
</head>

<body>
    <?php
    if (isset($preview_id)) {
        $shortcode = '[dynamicform id="' . $preview_id . '"]';
        echo do_shortcode($shortcode);
    }
    ?>
    <?php wp_footer(); ?>
</body>

</html>