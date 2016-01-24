<!DOCTYPE html>
<html lang="en">
<head>
    <title>We compare your confusion</title>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no"/>
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/grid.css">
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link rel="stylesheet" href="css/camera.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/jquery.fancybox.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">

    <script src="js/jquery.js"></script>
    <script src="js/jquery-migrate-1.2.1.js"></script>

    <!--[if lt IE 9]>
    <html class="lt-ie9">
    <div style=' clear: both; text-align:center; position: relative;'>
        <a href="http://windows.microsoft.com/en-US/internet-explorer/..">
            <img src="images/ie8-panel/warning_bar_0000_us.jpg" border="0" height="42" width="820"
                 alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."/>
        </a> 
    </div>
    <script src="js/html5shiv.js"></script>
    <![endif]-->
 
    <script src='js/device.min.js'></script> 
    <style type="text/css">
     @import "compass/css3";

/***********************
 * Essential Structure *
 ***********************/
body{
  background-color:#E6E6E6;
}
.flexsearch--wrapper {
    height: auto;
    width: auto;
    max-width: 100%;
    overflow: hidden;
    background: transparent;
    margin: 0;
    position: static;
}
    
.flexsearch--form {
    overflow: hidden;
    position: relative;
}
    
.flexsearch--input-wrapper {
    padding: 0 66px 0 0; /* Right padding for submit button width */
    overflow: hidden;
}

.flexsearch--input {
  width: 100%;
}

/***********************
 * Configurable Styles *
 ***********************/
.flexsearch {
  padding: 0 450px 0 200px; /* Padding for other horizontal elements */
}

.flexsearch--input {
  -webkit-box-sizing: content-box;
    -moz-box-sizing: content-box;
    box-sizing: content-box;
    height: 60px;
  padding: 0 46px 0 10px;
    border-color: #888;
  border-radius: 35px; /* (height/2) + border-width */
  border-style: solid;
    border-width: 5px;
  margin-top: 15px;
  color: #333;
  font-family: 'Helvetica', sans-serif;
    font-size: 26px;
    -webkit-appearance: none;
    -moz-appearance: none;
}
    
.flexsearch--submit {
  position: absolute;
    right: 0;
    top: 0;
    display: block;
    width: 60px;
    height: 60px;
  padding: 0;
  border: none;
    margin-top: 20px; /* margin-top + border-width */
  margin-right: 5px; /* border-width */
    background: transparent;
  color: #888;
  font-family: 'Helvetica', sans-serif;
  font-size: 40px;
  line-height: 60px;
}

.flexsearch--input:focus {
  outline: none;
  border-color: #333;
}

.flexsearch--input:focus.flexsearch--submit {
    color: #333; 
}

.flexsearch--submit:hover {
  color: #333;
  cursor: pointer;
}

::-webkit-input-placeholder {
    color: #888;  
}

input:-moz-placeholder {
  color: #888
}


/****************
 * Pretify demo *
 ****************/
h1{
  float: left;
  margin: 25px;
  color: #333;
  font-family: 'Helvetica', sans-serif;
  font-size: 45px;
  font-weight: bold;
  line-height: 45px;
  text-align: center;
}

    </style>
</head>
<body>
<left>
 



  
    <!--========================================================
                              HEADER
    =========================================================-->
    


<?php 

  $search = $_POST["name"];
  $middle = explode(" ", $search);
  $replaced = join("+",$middle);

  $url = "http://www.amazon.in/s/ref=nb_sb_noss_2?url=search-alias%3Daps&field-keywords=".$replaced;
 

  $response = getPriceFromAmazon($url);  
  $initialPrice = $response[0];
  $initialtitle = $response[1];
  // echo json_encode($response2);
   
  /* Returns the response in JSON format */
 
    function getPriceFromAmazon($url) {
     
      $curl = curl_init($url);
      curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 10.10");
      curl_setopt($curl, CURLOPT_FAILONERROR, true);
      curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      $html = curl_exec($curl);
      curl_close($curl);
     
      $regex='/<span class="a-size-base a-color-price s-price a-text-bold"><span.*?><\/span>(.*?)/';
      preg_match_all($regex, $html, $price, PREG_SET_ORDER);
      
     
        $regex = '/<h2 class="a-size-medium a-color-null s-inline s-access-title a-text-normal"[^>]*>([^<]*)<\/h2>/';
        preg_match_all($regex, $html, $title, PREG_SET_ORDER);
     
       // $regex = '/data-src="([^"]*)"/i';
       // preg_match($regex, $html, $image);
     
       if ($price) {
          // $intialResponse = $price[0][0];
          // $middleResponse = intval(preg_replace('/[^0-9]+/', '', $intialResponse), 10);
          // $finalResponse = $middleResponse * 0.01;
          $response = array($price,$title);
          
       } else {
        $response = array("status" => "404", "error" => "We could not find the product details on Flipkart $url");
       }
      // return $response2;
       return $response;
      // return $response2;
  }

    $url2 = "http://www.snapdeal.com/search?keyword=".$replaced."&santizedKeyword=&catId=&categoryId=&suggested=false&vertical=&noOfResults=48&clickSrc=go_header&lastKeyword=&prodCatId=&changeBackToAll=false&foundInAll=false&categoryIdSearched=&cityPageUrl=&url=&utmContent=&dealDetail=&sort=rlvncy";
 

  $response2 = getPriceFromSnapdeal($url2);
  // echo json_encode($response);  
  // echo json_encode($responsejson_encode2);
   $initialPrice2 = $response2[0];
  $initialtitle2 = $response2[1];
  /* Returns the response in JSON format */
 
    function getPriceFromSnapdeal($url2) {
     
      $curl2 = curl_init($url2);
      curl_setopt($curl2, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 10.10");
      curl_setopt($curl2, CURLOPT_FAILONERROR, true);
      curl_setopt($curl2, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true);
      $html = curl_exec($curl2);
      curl_close($curl2);
     
      $regex='/<span class="product-price">(.*?)<\/span>/';
      preg_match_all($regex, $html, $price2, PREG_SET_ORDER);
      
     
        $regex = '/<p class="product-title"[^>]*>([^<]*)<\/p>/';                
        preg_match_all($regex, $html, $title2, PREG_SET_ORDER);
     
       // $regex = '/data-src="([^"]*)"/i';
       // preg_match($regex, $html, $image);
     
        if ($price2 ) {
      //  $finalResponse = $price[3][1];
      //    // $intialResponse = $price[0][0];
      //    // $middleResponse = intval(preg_replace('/[^0-9]+/', '', $intialResponse), 10);
      //    // $finalResponse = $middleResponse * 0.01;
      //  // $middleTitle = $title[3][1];
      //  // $finalTitle = substr($middleTitle,0,-1);
        $response2 = array($price2,$title2);
        //  $response = $price;
        } else {
          $response2 = array("status" => "404", "error" => "We could not find the product details on Flipkart $url");
        }
        // return $response;
      return $response2;
  }

  ?>
  

  <div class="main">
    <h3 class="text-left">
    Top results for <b><?php $search = $_POST["name"]; echo $search; ?></b>:
    </h3>
    <h5>Top 7 results will be displayed related to your search....so be particular</h5>
    <div class="main_box">
      <div class="row">
        <div class="col-sm-6">
          
          <div class="list">      
            <h2><?php
              
              $secondTitle = $initialtitle[0][0];
             echo $secondTitle;
              ?></h2> 
              <p style="margin-top:60px;"><img src="images/amazon.jpg"> Rs.<?php  
              $secondPrice = $initialPrice[0][0];
              // $middlePrice = intval(preg_replace('/[^0-9]+/', '', $intialResponse), 10);
              // $finalPrice = $middlePrice * 0.01;
              echo $secondPrice;
              ?></p>
          </div>
          <div class="list">      
            <h2><?php
              
              $secondTitle = $initialtitle[1][0];
             echo $secondTitle;
              ?></h2> 
              <p style="margin-top:60px;"><img src="images/amazon.jpg">Rs.<?php   
              $secondPrice = $initialPrice[1][0];
              // $middlePrice = intval(preg_replace('/[^0-9]+/', '', $intialResponse), 10);
              // $finalPrice = $middlePrice * 0.01;
              echo $secondPrice;
              ?></p>
          </div>
          <div class="list">      
            <h2><?php
              
              $secondTitle = $initialtitle[2][0];
             echo $secondTitle;
              ?></h2> 
              <p style="margin-top:60px;"><img src="images/amazon.jpg">Rs.<?php   
              $secondPrice = $initialPrice[2][0];
              // $middlePrice = intval(preg_replace('/[^0-9]+/', '', $intialResponse), 10);
              // $finalPrice = $middlePrice * 0.01;
              echo $secondPrice;
              ?></p>
          </div>
          <div class="list">      
          <h2><?php
            
            $secondTitle = $initialtitle[3][0];
           echo $secondTitle;
            ?></h2> 
            <p style="margin-top:60px;"><img src="images/amazon.jpg">Rs.<?php   
            $secondPrice = $initialPrice[3][0];
            // $middlePrice = intval(preg_replace('/[^0-9]+/', '', $intialResponse), 10);
            // $finalPrice = $middlePrice * 0.01;
            echo $secondPrice;
            ?></p>
          </div>
          <div class="list">      
          <h2><?php
            
            $secondTitle = $initialtitle[4][0];
           echo $secondTitle;
            ?></h2> 
            <p style="margin-top:60px;"><img src="images/amazon.jpg">Rs.<?php   
            $secondPrice = $initialPrice[4][0];
            // $middlePrice = intval(preg_replace('/[^0-9]+/', '', $intialResponse), 10);
            // $finalPrice = $middlePrice * 0.01;
            echo $secondPrice;
            ?></p>
          </div>
          <div class="list">      
          <h2><?php
            
            $secondTitle = $initialtitle[5][0];
           echo $secondTitle;
            ?></h2> 
            <p style="margin-top:60px;"><img src="images/amazon.jpg">Rs.<?php   
            $secondPrice = $initialPrice[5][0];
            // $middlePrice = intval(preg_replace('/[^0-9]+/', '', $intialResponse), 10);
            // $finalPrice = $middlePrice * 0.01;
            echo $secondPrice;
            ?></p>
          </div>
          <div class="list">      
          <h2><?php
            
            $secondTitle = $initialtitle[6][0];
           echo $secondTitle;
            ?></h2> 
            <p style="margin-top:60px;"><img src="images/amazon.jpg">Rs.<?php   
            $secondPrice = $initialPrice[6][0];
            // $middlePrice = intval(preg_replace('/[^0-9]+/', '', $intialResponse), 10);
            // $finalPrice = $middlePrice * 0.01;
            echo $secondPrice;
            ?></p>
          </div>
        </div>
        <div class="col-sm-6">
          
          <div class="list">
            <h2><?php
        
            $secondTitle2 = $initialtitle2[0][0];
           echo $secondTitle2;
              ?></h2> 
            <p style="margin-top:60px;"><img src="images/snapdeal.jpg"> <?php   
            $secondPrice2 = $initialPrice2[0][0];
            // $middlePrice = intval(preg_replace('/[^0-9]+/', '', $intialResponse), 10);
            // $finalPrice = $middlePrice * 0.01;
            echo $secondPrice2;
            ?></p>
          </div>
          <div class="list">
            <h2><?php
        
            $secondTitle2 = $initialtitle2[1][0];
           echo $secondTitle2;
              ?></h2> 
            <p style="margin-top:60px;"><img src="images/snapdeal.jpg"><?php  
            $secondPrice2 = $initialPrice2[1][0];
            // $middlePrice = intval(preg_replace('/[^0-9]+/', '', $intialResponse), 10);
            // $finalPrice = $middlePrice * 0.01;
            echo $secondPrice2;
            ?></p>
          </div>
          <div class="list">
            <h2><?php
        
            $secondTitle2 = $initialtitle2[2][0];
           echo $secondTitle2;
              ?></h2> 
            <p style="margin-top:60px;"><img src="images/snapdeal.jpg"><?php  
            $secondPrice2 = $initialPrice2[2][0];
            // $middlePrice = intval(preg_replace('/[^0-9]+/', '', $intialResponse), 10);
            // $finalPrice = $middlePrice * 0.01;
            echo $secondPrice2;
            ?></p>
          </div>
          <div class="list">
            <h2><?php
        
            $secondTitle2 = $initialtitle2[3][0];
           echo $secondTitle2;
              ?></h2> 
            <p style="margin-top:60px;"><img src="images/snapdeal.jpg"><?php  
            $secondPrice2 = $initialPrice2[3][0];
            // $middlePrice = intval(preg_replace('/[^0-9]+/', '', $intialResponse), 10);
            // $finalPrice = $middlePrice * 0.01;
            echo $secondPrice2;
            ?></p>
          </div>
          <div class="list">
            <h2><?php
        
            $secondTitle2 = $initialtitle2[4][0];
           echo $secondTitle2;
              ?></h2> 
            <p style="margin-top:60px;"><img src="images/snapdeal.jpg"><?php  
            $secondPrice2 = $initialPrice2[4][0];
            // $middlePrice = intval(preg_replace('/[^0-9]+/', '', $intialResponse), 10);
            // $finalPrice = $middlePrice * 0.01;
            echo $secondPrice2;
            ?></p>
          </div>
          <div class="list">
            <h2><?php
        
            $secondTitle2 = $initialtitle2[5][0];
           echo $secondTitle2;
              ?></h2> 
            <p style="margin-top:60px;"><img src="images/snapdeal.jpg"><?php  
            $secondPrice2 = $initialPrice2[5][0];
            // $middlePrice = intval(preg_replace('/[^0-9]+/', '', $intialResponse), 10);
            // $finalPrice = $middlePrice * 0.01;
            echo $secondPrice2;
            ?></p>
          </div>
          <div class="list">
            <h2><?php
        
            $secondTitle2 = $initialtitle2[6][0];
           echo $secondTitle2;
              ?></h2> 
            <p style="margin-top:60px;"><img src="images/snapdeal.jpg"><?php  
            $secondPrice2 = $initialPrice2[6][0];
            // $middlePrice = intval(preg_replace('/[^0-9]+/', '', $intialResponse), 10);
            // $finalPrice = $middlePrice * 0.01;
            echo $secondPrice2;
            ?></p>
          </div>
        </div>
      </div>  
    </div>
  </div>
<footer>
        <div class="container">
            <ul class="socials">
                <li><h4>facebook</h4><a href="https://www.facebook.com/search/top/?q=svanucet"class="fa fa-facebook">   </a></li>
                <li><h4>Gmail</h4><a href="#" class="fa fa-gmail"></a></li>
                <li><h4>Whatsapp</h4><a href="#" class="fa fa-whatsapp"></a></li>
            </ul>
            <div class="copyright">© <span id="copyright-year"></span> |
                <a href="#">Privacy Policy     svanucet</a>
            </div>
        </div>
    </footer>
    <script src="js/script.js"></script>

    </body>
    </style>