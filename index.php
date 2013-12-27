<?php
    if($_GET['url']=='picakla' && $_POST['message']!=''):
        try{
            $im = imagecreatefrompng('./img/bahattin.png');
            $imText = imagecreatetruecolor ( 255+205+12 , 500 );
            $tcolour = imagecolorallocate($imText,254,255,255);
            imagefilledrectangle($imText, 0, 0, 255+205+12, 500, $tcolour); // Or draw other background.
            imagecolortransparent($imText, $tcolour);
            
            $white = imagecolorallocate($im, 255, 255, 255);
            $black = imagecolorallocate($im, 0, 0, 0);
            $red = imagecolorallocate($im, 255, 0, 0);
            
            $p = array('x'=>255,'y'=>60,'x2'=>255+205+24,'y2'=>60+$_POST['height']+14);
            
            imagefilledrectangle($im, $p['x'], $p['y']-5, $p['x2'], $p['y2']+5, $white);
            imagefilledrectangle($im, $p['x']-5, $p['y'], $p['x2']+5, $p['y2'], $white);
            imagefilledellipse($im, $p['x'], $p['y'], 10, 10, $white);
            imagefilledellipse($im, $p['x2'], $p['y'], 10, 10, $white);
            imagefilledellipse($im, $p['x'], $p['y2'], 10, 10, $white);
            imagefilledellipse($im, $p['x2'], $p['y2'], 10, 10, $white);
            
            $tp = array('x'=>$p['x']-20,'y'=>$p['y']+40);
            imagefilledpolygon($im, array(
                                            $tp['x'],$tp['y'],
                                            $tp['x']+15,$tp['y']-5,
                                            $tp['x']+15,$tp['y']+5) , 3, $white);
            
            
            
            $text = $_POST['message'];
            $font = 'css/PatrickHand-Regular.ttf';
            // Add some shadow to the text
            $i = 0;
            foreach(explode(PHP_EOL, $text) as $txt):
                if($i<12):
                    $r = imagettftext($imText, 18, 0, 265, 85+($i*26), $black, $font, $txt);
                endif;
                $i++;
            endforeach;
            imagecopymerge($im, $imText, 0, 0, 0, 0, 255+205+12, 500, 100);
            $uid = uniqid();
            $fileName = 'tmp/'.$uid.'.jpg';
            imagejpeg($im, $fileName,100);
            imagedestroy($im);
            imagedestroy($imText);
            header('location: ?goster='.$uid);
        }  catch (Exception $e){
            echo 'pardon canım';
        }
    else:
?><!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>BahattinMatik</title>
        <link href="css/site.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
    </head>
    <body>

        <div id="container">
            <a href="?url=">yeni yap</a>
        <?php
            if($_GET['goster']):
                $fileName = 'tmp/'.$_GET['goster'].'.jpg';
            
                $url = "http" . ($_SERVER['HTTPS']=="on" ? 's' : '') . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
                echo '<img src="'.$fileName.'" alt="" />';
                $onClick = "http://www.facebook.com/sharer.php?u=".$url;
                //$onClick .= "p[title]=".urlencode("BahattinMatik") . "&";
                //$onClick .= "p[summary]=" . urlencode(substr($text, 0, 254)) + "...&";
                //$onClick .= "p[url]=" . $url . "&";
                //$onClick .= "p[images][0]=http://www.cocey.com/temp/bahattin/". $fileName;
                echo '<a href="'.$onClick.'" target="_blank">paylaş</a>';
            else:
        ?>
            <div class="bahattin">
                <div class="bubble">
                    <div class="content">
                        
                    </div>
                </div>
            </div>
            <form method="post" action="?url=picakla">
                <input type="hidden" name="height" value="70" />
                <label>sözünüz</label>
                <textarea name="message" onkeyup="setMessage($(this).val());"></textarea>
                <label></label>
                <button type="submit">pıçakla</button>
            </form>
        </div>
        <script>
            var setMessage = function(str){
                $('.content').html(str);
                $('input[name="height"]').val($('.content').height());
            };
        </script>
        <?php
            endif;
        ?>
    </body>
</html>
<?php
    endif;
?>
