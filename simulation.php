<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Simulation</title>
</head>
<body>

<!-- import Bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<!-- import Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<!-- import FontAwesome Font -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
<!-- import Costumized CSS -->
<link rel="stylesheet" href="css/main.css">

<?php
    /** defines nodes parameter */
    if(isset($_POST['nodes'])){
        $num = $_POST['nodes']; 
    } else if(isset($_GET['nodes'])){
        $num = $_GET['nodes'];
    } else {
        $x = 250; /** default nodes value when not set */
    }

    /** defines col parameter */
    if(isset($_POST['collums'])){
        $col = $_POST['collums'];
    } else if(isset($_GET['collums'])){
        $col = $_GET['collums'];
    } else {
        $col = 7; /** default col value when not set */
    }

  echo '<style>.collum{width: calc(96%/'.$col.')</style>';

  class Node{
  public $uid;
  public $next;
}

/*first Node points to himself*/
$node_0 = new Node();
$node_0->uid = 0;
$node_0->next = 0;
$node_0->level = 0;
$nodes[0] = $node_0; 

for($i=1;$i<$num;$i++){
    ${'node_' . $i} = new Node();
    /** random generate one number between the interval before this */
    $next_id = rand(0 , $i-1);
    /** the uid is an incremental order number */
    ${'node_' . $i}->uid = $i;
    /** this node points to the next one generated before */
    ${'node_' . $i}->next = $next_id;
    /** this node is pushd into an array of nodes */
    array_push($nodes, ${'node_' . $i});
}

/** Generate nodes */

for($j=0;$j<$col;$j++){
    echo '<div class="collum">';
    for($i=0;$i<$num/$col;$i++){
        $m = ($j*($num/$col))+$i;
        echo '<span id="'.$i.'" class="label label-primary"> node_' . $nodes[$m]->uid . '</span> <i class="fas fa-arrow-right"></i> ';
        echo '<a href="#'. $nodes[$m]->next.'"><span class="label label-info">node_' . $nodes[$m]->next.'</span></a><br>';
    }
    echo '</div>';
}

echo '<nav class="navbar navbar-inverse navbar-fixed-bottom">';
  echo '<div class="details">';
  $a = rand(0 , $i-1);
  $b = rand(0 , $i-1);
  /** prevent from node_a and node_b beeing the same */
  while($a == $b){
      $b = rand(0 , $i);
  }
  echo '<a class="nolink">Sorted Nodes: </a>';
  echo '<span class="label label-primary"> node_' . $a . '</span> <i class="fas fa-ellipsis-h light"></i> '; 
        echo '<a href="#'. $b .'"><span class="label label-info">node_' . $b .'</span></a>';

 // echo "node_a is node_".$a." and node_b is node_".$b;
  
  $path_a = array($a);
  $path_b = array($b);
  $next_a = ${'node_'.$a}->next;
  $next_b = ${'node_'.$b}->next;
  
  do {
      array_push($path_a, $next_a);
      array_push($path_b, $next_b);
      $next_a = ${'node_'.$next_a}->next;
      $next_b = ${'node_'.$next_b}->next;
  }while ($next_a != $next_b);
  
  $_path = array();

  array_push($path_a, $next_a);
  array_push($path_b, $next_b);
  
  $inter_ab = array_intersect($path_a, $path_b);
  $inter_ab = array_values($inter_ab);
  
  $path_a = array_diff($path_a, $inter_ab);
  $path_b = array_diff($path_b, $inter_ab);
  
  
  //echo "<br> path_a: ";
  for($i=0; $i<count($path_a); $i++){
      //echo $path_a[$i] . " ";
      array_push($_path, $path_a[$i]);
  }
  
  if(count($inter_ab) > 0) {
      //echo "<br> vertice is: ";
      //echo count($inter_ab);
      //echo $inter_ab[0] . " ";
      array_push($_path, $inter_ab[0]);
  }
  
  if(count($path_b)>0){
      //echo "<br> rev path_b: ";
  }
  for($i=count($path_b)-1; $i>=0; $i--){
      //echo $path_b[$i] . " ";
      array_push($_path, $path_b[$i]);
  }
  
  echo '<a class="nolink">full path: </a>';
  for($i=0; $i<count($_path); $i++){
      if($i==0){
          $tag = "primary";
      }else if($i < count($_path)-1){
          $tag = "default";
      }else if($i == count($_path)-1){
          $tag = "info";
      }
    echo '  <span class="label label-'.$tag.'"> node_' . $_path[$i] . '</span>';
    if($i < count($_path)-1){ /** if has next print the arrow */
        echo '<i class="fas fa-arrow-right light"></i>';
    }
}

    echo '<a href="https://www.linkedin.com/in/arcadio-macedo/"><span class="author light">Arcadio Macedo<i class="fab fa-linkedin"></i></span></a>';
  echo '</div>';
echo '</nav>';

?>
    
</body>
</html>