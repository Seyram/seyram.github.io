<?php
/**
 * Created by PhpStorm.
 * User: Seyram
 * Date: 10/14/2017
 * Time: 3:24 AM
 */
//upload folder
$folder_path ='uploads/';
$watermark_image = 'img/gng1.png';
$watermark_image_two = 'img/gng2.png';
$watermark_image_three ='img/gng3.png';
if(isset($_POST['submit'])) {
    if(isset($_POST['image'])) {
        $set_water_mark = $_POST['image'];
        $img_name = $_FILES['choosen']['name'];
        $img_source = $_FILES['choosen']['tmp_name'];
        $img_type = strtolower($_FILES['choosen']['type']);
        if ($img_name != '') {
            // check for image tpye
            switch ($img_type) {
                //create new image file
                case 'image/png':
                    $image_src = imagecreatefrompng($img_source);
                    break;
                case 'image/jpeg':
                    $image_src = imagecreatefromjpeg($img_source);
                    break;
                default;
                    $image_src = false;
            }

            if ($image_src) {

                $watermark_src = imagecreatefrompng( $set_water_mark);
                $destination_image = $folder_path . $img_name;
                // var_dump($destination_image);

                //position  watermark
                $right_margin = 70;
                $bottom_margin = 70;
                $watermark_width = imagesx($watermark_src);
                $watermark_height = imagesy($watermark_src);
                // merge watermark image with uploaded
                imagecopy($image_src, $watermark_src, imagesx($image_src) - $watermark_width - $right_margin,
                    imagesy($image_src)
                    - $watermark_height - $bottom_margin, 0, 0, $watermark_width, $watermark_height);

                //save image to folder
                imagejpeg($image_src, $destination_image, 90);
                // release memory
                imagedestroy($image_src);
                imagedestroy($watermark_src);


            } else {
                $msg = 'Invalid image type! Only JPEG and PNG files allowed';
            }
        }
    }
}
else{
    $msg = 'Please select and image';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GNGWPBL</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<div class="">
    <div  class="row sticky-top navbar-light  bg-dark">
        <div  class="col-3 nav justify-content-center">
            <nav class="navbar">
            </nav>
        </div>
    </div>
</div>
<div class="">
    <div class="container">
        <div class="row">
            <div class="col-12">
            </div>

        </div>
        <div class="row">
            <div class="col-6">
                <span class=""><h3>Please select a button and upload an image</h3></span>
                <form method="post" action="index.php" enctype="multipart/form-data">
                    <div class="row">
                        <div class="mradio col-2">

                            <input type="radio" name="image" value="<?php echo $watermark_image  ?>">

                        </div>

                        <div class="  col-4">
                            <img class="card"  src="img/gng1.png" width="130px" height="130px" alt="First Image">
                        </div>
                    </div>

                    <div class="row">
                        <div class="mradio col-2">
                            <input type="radio" name="image" value="<?php echo $watermark_image_two  ?>">

                        </div>
                        <div class="  col-4">
                            <img class="card"  src="img/gng2.png"  width="130px" height="130px"  alt="First Image">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mradio col-2">
                            <input type="radio" name="image" value="<?php echo $watermark_image_three  ?>">

                        </div>
                        <div class=" col-4">
                            <img class="card"  src="img/gng3.png"  width="130px" height="130px"  alt="First Image">
                        </div>
                    </div>

                    <div class="row">
                        <div class="mradio col">
                            <input class="" type="file" name="choosen">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input class=" card btn btn-primary" type="submit" value="Upload" name="submit" >

                        </div>
                        <?php if(isset($msg)){ ?>
                        <div class="alert alert-danger text-center"> <?php echo $msg; ?>
                        </div>
                        <?php } ?>
                    </div>
                </form>
            </div>
            <div style="float: right" class="col-6">

                <div class="row">

                    <?php if(isset($destination_image)){ ?>

                        <div class="" style="background: none;">
                            <img class="card" src="<?php echo $destination_image; ?>" width="100%" alt="UPLOAD">
                        </div>
                        <div class="row">
                                <a class=" card btn btn-primary" href="<?php echo $destination_image; ?>" download=""> Download </a>

                            <a class=" card btn btn-warning" href="index.php" > Change</a>
                        </div>
                    <?php } ?>
                </div>

            </div>
        </div>
    </div>
</div>

</body>
</html>
