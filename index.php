<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Photos of Ontario</title>
        <meta name="description" content="">
        <link rel="icon" type="image/png" href="images/icon.png"/>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <style>
        </style>    
    </head>
    <body style="background-color: #fff;">
        <h1 style="font-family: Noto Sans; text-align: center; color: #00000; margin-top: 2%;">
            Photos of Ontario
        </h1>
        <?php
        session_start();

        $connect = mysqli_connect("localhost", "user", "pass", "id"); 
        
        if (!$connect) echo "Failed to connect to MySQL".mysqli_connect_error()."";

        $sql = "CREATE TABLE Photograph (
            picture_number int AUTO_INCREMENT primary key NOT NULL UNIQUE,
            picture_subject varchar(255) NOT NULL UNIQUE,
            picture_location varchar(255) NOT NULL UNIQUE,
            date_taken date NOT NULL UNIQUE,
            picture_url varchar(1000) NOT NULL UNIQUE
        )";

        //process sql
        if (mysqli_query($connect, $sql)) {
            //
        } else {
            //
        }
        
        $sql = "INSERT INTO Photograph (picture_subject, picture_location, date_taken, picture_url) 
            VALUES ('The Bluffs', 'Ontario', '2020-08-28', 'https://utsc.utoronto.ca/news-events/sites/default/files/styles/large/public/image/article/Bluffs%202_0.jpg?itok=f_ECvKot'),
            ('Niagara Falls', 'Ontario', '2013-08-25', 'https://upload.wikimedia.org/wikipedia/commons/5/5e/Niagara_Falls_and_Niagara_River.jpg'),
            ('CN Tower', 'Ontario', '2020-06-21', 'https://upload.wikimedia.org/wikipedia/commons/6/65/Toronto_Skyline_Summer_2020.jpg'),
            ('Chinatown', 'Ontario', '2006-06-10', 'https://upload.wikimedia.org/wikipedia/commons/f/fe/Chinatown_Toronto.JPG'),
            ('Downtown Ottawa', 'Ontario', '2019-06-19', 'https://upload.wikimedia.org/wikipedia/commons/2/21/Ottawa_Downtown_2019.1.jpg'),
            ('Silicon Valley', 'California', '2014-06-01', 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/35/Aerial_view_of_Apple_Park.jpg/1920px-Aerial_view_of_Apple_Park.jpg'),
            ('Jerusalem', 'Palestine', '2020-04-11', 'https://cdnuploads.aa.com.tr/uploads/Contents/2020/11/04/thumbs_b_c_475c09370551493c1ecb40bb43e9df72.jpg?v=203025'),
            ('Kaaba', 'Mecca', '2018-12-01', 'https://upload.wikimedia.org/wikipedia/commons/6/67/Kaaba_Masjid_Haraam_Makkah.jpg')";

        if (mysqli_multi_query($connect, $sql)) {
        } else {
            echo "Error: ".mysqli_error($connect)."<br><br>";
        }
        
        echo '<h3 style="text-align: center; font-family: Noto Sans; font-style: italic">Random Image of Ontario!</h3>';
        
        $sql = "SELECT * FROM Photograph";
        $result = mysqli_query($connect, $sql);

        
        $sql = "SELECT * FROM Photograph WHERE picture_location = 'Ontario' ORDER BY RAND() LIMIT 1";
        $query = mysqli_query($connect, $sql);
        $row = mysqli_fetch_array($query);

        echo "<section>";
        echo '<header style="text-align: center; font-family: Noto Sans">Subject: '.$row['picture_subject']."<br>";
        echo 'Location: '.$row['picture_location']."<br>";
        echo 'Date: '.$row['date_taken']."<br>";
        echo "</header><br><br>";
        echo '<img src="'.$row['picture_url'].'"style="display: block; width: 40%; height: auto; margin: 0 auto;">';
        echo "</section>";

        $rowcount = mysqli_num_rows($result);
        echo "<br><br>";
        echo '<h3 style="text-align: center; font-family: Noto Sans; font-style: italic">Total number of images in the database: '. $rowcount. " images.</h3>";

        $pageRefreshed = $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0' && isset($_SERVER['HTTP_CACHE_CONTROL']);

        if ($pageRefreshed) {
            $sql = "TRUNCATE TABLE Photograph";
            mysqli_query($connect, $sql);
        }   
        ?>
    </body>
</html>
