// bird rings, I feel like I'm Tre.
// 17_March_19
// jedenfalls

$colours = array('r','y','b','s'); 

foreach($colours as $key1 => $value1){
  foreach($colours as $key2 => $value2){
    foreach($colours as $key3 => $value3){
      foreach($colours as $key4 => $value4){
        echo $value1.",".$value2.",".$value3.",".$value4;
        echo "\n";
      }
    }
  }
}


// now all I have to do is run this in pythons as a recursive loop (not that that is that necessary)
