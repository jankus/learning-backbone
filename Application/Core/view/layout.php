<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User management</title>
    <link href="<?php echo appUrl('assets/css/application.css'); ?>" rel="stylesheet" type="text/css" />
</head>
<body>

    <div class="container">
        <div class="page-header">
            <h1>User Management <small><?php echo $title; ?></small></h1>
        </div>
        <ul class="nav nav-tabs" role="tablist">
            <li class="active"><a href="#">Users</a></li>
            <li><a href="#">Groups</a></li>
        </ul>
        <?php echo $content; ?>
    </div>

    <script src="<?php echo appUrl('assets/js/jquery.js'); ?>"></script>
    <script src="<?php echo appUrl('assets/js/underscore.js'); ?>"></script>
    <script src="<?php echo appUrl('assets/js/backbone.js'); ?>"></script>
    <script src="<?php echo appUrl('assets/js/bootstrap.js'); ?>"></script>
    <script src="<?php echo appUrl('assets/js/users.js'); ?>"></script>
    <script>
        appUrl = '<?php echo appUrl(); ?>';
    </script>
</body>
</html>
