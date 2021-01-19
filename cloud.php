<!DOCTYPE html>
  <html>

    <head>

      <meta charset="utf-8">
      <title>Cloud Systeme</title>

      <link rel="stylesheet" type="text/css" href="css/main.css">

    </head>
  
  <body>

  <!-- Section : upload files -->
  <fieldset>

    <legend>Upload files</legend>

    <form method="POST" action="" enctype="multipart/form-data">

    <input type="file"  name="fichier"><br><br>

    <input type="submit">
     
    </form>

    <!-- PHP Systeme -->

  <?php

  try{

     $database = new PDO('mysql:host=localhost:3306;dbname=cloud;charset=utf8', 'root', '');
    
    } catch(PDOException $e){

    die('Erreur : '.$e-> getmessage());
    
  }

    if(!empty($_FILES)){


      $file_name = $_FILES['fichier']['name'];
      $file_extension = strrchr($file_name, ".");
      
      $file_tmp_name = $_FILES['fichier']['tmp_name'];
      $file_dest = 'data/'.$file_name;
      $req = $database->query('SELECT name, file_url FROM files');


      $extensions_auto = array('.mp4', '.mp3', '.avi', '.png' , '.mkv' , '.php' , '.html' , '.js' , '.mkv' , '.jpg' , '.jpeg', '.bmp', '.gif' , '.docx' , '.odt' , '.flv' , '.exe' , '.MP4', '.MP3', '.AVI', '.PNG' , '.JPG' , '.JPEG', '.BMP', '.GIF' , '.DOCX' , '.ODT' , '.EXE' , '.FLV' , '.MKV'); 
      
    if(in_array($file_extension, $extensions_auto)){
      if(move_uploaded_file($file_tmp_name, $file_dest)){
        $req = $database->prepare('INSERT INTO files(name, file_url) VALUES(?,?)');
        $req-> execute(array($file_name, $file_dest));
          echo 'The file has been upload';
        } else {
          echo 'Error while uploading file!';
             }
      } else {
        echo 'Format is not allowed!';
      }
      
    }
?> 

  </fieldset>

  <!-- Section : list of upload files -->

  <fieldset>

    <legend>Files</legend>

    <?php

      $req = $database->query('SELECT name, file_url FROM files ORDER BY `files`.`name` ASC');

      while ($data = $req->fetch()) {

      echo $data['name'].' : '.'<a class="download" download="'.$data['name'].'"  href="'.$data['file_url'].'">Download</a> <a class="read" target="_blank" href="'.$data['file_url'].'">View</a><br>';
                                   }
    ?>
  </fieldset>
</body>
</html>