<?php
echo'
<a href = "ProjectOne/index.php"> ProjectOne </a> &nbsp
<a href = "ProjectOneV2/header.php"> ProjectOne V2 </a> &nbsp
';
 ?>
 <html lang = "en">
 <head>
   <meta charset="UTF-8">

   <!-- Latest compiled and minified CSS -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

   <!-- Optional theme -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
   <!-- Latest compiled and minified JavaScript -->
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

 </head>
 <body>

   <nav class="navbar navbar-inverse">
     <div class="container-fluid">
       <div class="navbar-header">
         <a class="navbar-brand" href="#">NYIT</a>
       </div>
       <ul class="nav navbar-nav">
         <li class="active"><a href="../index.php">Home</a></li>
         <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Campus<span class="caret"></span></a>
           <ul class="dropdown-menu">
             <li><a href="ProjectOneV2/Campus/InsertCampus.php">Insert Campus</a></li>
             <li><a href="ProjectOneV2/Campus/LookupCampus.php">Lookup Campus</a></li>
             <li><a href="ProjectOneV2/Campus/DeleteCampus.php">Delete Campus</a></li>
             <li><a href="ProjectOneV2/Campus/UpdateCampus.php">Update Campus</a></li>
           </ul>
         </li>
         <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Building<span class="caret"></span></a>
           <ul class="dropdown-menu">
             <li><a href="ProjectOneV2/Building/InsertBuilding.php">Insert Building</a></li>
             <li><a href="ProjectOneV2/Building/LookupBuilding.php">Lookup Building</a></li>
             <li><a href="ProjectOneV2/Building/DeleteBuilding.php">Delete Building</a></li>
             <li><a href="ProjectOneV2/Building/UpdateBuilding.php">Update Building</a></li>
           </ul>
         </li>
         <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Room<span class="caret"></span></a>
           <ul class="dropdown-menu">
             <li><a href="ProjectOneV2/Room/InsertRoom.php">Insert Room</a></li>
             <li><a href="ProjectOneV2/Room/LookupRoom.php">Lookup Room</a></li>
             <li><a href="ProjectOneV2/Room/DeleteRoom.php">Delete Room</a></li>
             <li><a href="ProjectOneV2/Room/UpdateRoom.php">Update Room</a></li>
           </ul>
         </li>
       </ul>
     </div>
   </nav>
 </body>
 </html>