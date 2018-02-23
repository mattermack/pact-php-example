<?php
error_log(print_r($_REQUEST, true));

if (file_exists("../dashboard/index.php.bak")) {
    unlink("../dashboard/index.php");
    $result = rename("../dashboard/index.php.bak", "../dashboard/index.php");
    echo "File write " . (!$result ? "failed" : "successful");
    error_log("Resetting state");
}
else {
    copy("../dashboard/index.php", "../dashboard/index.php.bak");

    $str = <<<STR
    <?php
    
    header('Content-Type: application/json');
    
    ?>
    {
        "stats":
        {
            "city_top_groups": 100,
            "global_top_groups": 100,
            "upcoming_events": 14,
            "memberships": 7,
            "nearby_events": 2444
        }
    }
STR;

    $result = file_put_contents("../dashboard/index.php", $str);

    echo "File write " . (!$result ? "failed" : "successful");
    error_log("Setting state");
}
