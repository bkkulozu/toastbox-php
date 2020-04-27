<?php

/*

    index: 0
    addPage: 1
    resultPage: 2


*/


$index = 0; // 

$titleMessage = ""; // 
$urlMessage = "";
$title = "";
$url = "";
$shareChecked = false; 


if (isset($_GET['action'])) { 
    if ($_GET['action'] == "add") {
        $index = 1;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") { 

    $index = 1; 

    $title = $_POST['title']; 
    $url = $_POST['url'];
    if (isset($_POST['share'])) {
        $shareChecked = true;
    } else {
        $shareChecked = false;
    }


    $validated = true; 

    if (empty($title)) { 
        $validated = false;
        $titleMessage = "Title can not be empty!";
    }

    if (empty($url)) {
        $validated = false;
        $urlMessage = "URL can not be empty!";
    } else { // If the url isn't empty we check if the url is valid.

        preg_match("@https?://([a-z]{2,}\.){1,4}([a-z]{2,}){1}@", $url, $matches);

       

            
        
        $temp = array_shift($matches); 

        if ($temp != $url) {
            $validated = false;
            $urlMessage = "The entered text is not a valid URL.";
        }
    }



    if ($validated == true) {


        if (substr($url, 0, 7) == "http://") { 
            $protocol = "http";
            $domain = substr($url, 7, strlen($url));
        } else {
            $protocol = "https";
            $domain = substr($url, 8, strlen($url));
        }

        $index = 2;
    }
}


?>

<!DOCTYPE html>
<html>

<head>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <style>
        .toastDefault {
            text-align: center;
            background-color: blue;
            color: white;
            margin-top:350px;
            margin-right: 550px;
        }
    </style>
</head>

<body>

    <div class="container">

        <nav>
            <div class="nav-wrapper">
                <a href="index.php" class="brand-logo"><i class="material-icons">home</i>BMS</a>
                <ul class="right hide-on-med-and-down">
                    <li><a href="#"><i class="large material-icons">person</i></a></li>
                    <li style="margin-right: 10px">  Beste </li>

                </ul>
            </div>
        </nav>

        <?php if ($index == 0) { ?>

            <h4 style="text-align: center">Welcome to Bookmark Management System <a href="index.php?action=add" style="margin-left: 50px" class="btn-floating btn-large red pulse"><i class="material-icons">add</i></a></h4>
        <?php } ?>

        <?php if ($index == 1) { ?>

            <h4 style="text-align: center">New Bookmark</h4>

            <div>
                <form action="index.php" method="post" class="col s6">
                    <div class="row">
                        <div class="input-field">
                            <i class="material-icons prefix">create</i>
                            <input id="icon_prefix" value="<?php echo $title; ?>" type="text" name="title">
                            <label for="icon_prefix">Title</label>
                            <?php
                            if ($titleMessage != "") {
                                echo "<span class='helper-text' style = 'color:red'>{$titleMessage}</span>";
                            }

                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field">
                            <i class="material-icons prefix">link</i>
                            <input id="link" value="<?php echo $url; ?>" type="text" name="url">
                            <label for="link">URL</label>
                            <?php
                            if ($urlMessage != "") { 
                                echo "<span class='helper-text' style = 'color:red'>{$urlMessage}</span>";
                            }

                            ?>
                        </div>
                    </div>

                    <div class="col s4">
                        <div class="row">
                            <div class="col s6">
                                Share
                            </div>
                            <div class="switch">
                                <label>

                                    <input name="share" type="checkbox" value="true" <?php echo $shareChecked ? 'checked="checked"' : ''; 
                                                                                        ?>>
                                    <span class="lever"></span>

                                </label>
                            </div>
                        </div>
                    </div>

                    <button class="btn waves-effect waves-light" type="submit" name="action">Submit
                        <i class="material-icons right">send</i>
                    </button>
                </form>
            </div>

        <?php } ?>

        <?php if ($index == 2) { ?>

            <table>


                <tbody>
                    <tr>
                        <td>Title</td>
                        <td><?php echo $title ?></td>
                    </tr>
                    <tr>
                        <td>URL</td>
                        <td><?php echo $url ?></td>
                    </tr>
                    <tr>
                        <td>Protocol</td>
                        <td><?php echo $protocol ?></td>
                    </tr>
                    <tr>
                        <td>Domain</td>
                        <td><?php echo $domain ?></td>
                    </tr>
                    <tr>
                        <td>Share</td>
                        <td>
                            <?php
                            if ($shareChecked) {
                                echo "<i class='small material-icons'>check</i>";
                            } else {
                                echo "<i class='small material-icons'>close</i>";
                            }

                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>

            <script>
                M.toast({
                    html: 'Bookmark added!',
                    classes: 'rounded toastDefault'
                }); //toastbox
            </script>

        <?php } ?>


    </div>




</body>

</html>