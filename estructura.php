<?php 
$variableHola = "hola mundo";
echo $variableHola;

echo '<p>';

$condicion = 3;

if ($condicion == 1){ //siempre las condicionales llevan doble igual 
    echo 'uno';
}else if ($condicion == 2){
    echo 'dos';
}else{
    echo 'otro';
}
echo '</p>';

echo '<p>Ciclo while<br>';

$i = 0;
while($i <= 10){
    echo $i;
    echo '<br>';
    $i++;  //inrementar el valor en uno
}

echo '<hr>Ciclo for<br>';
for ($i = 0; $i <= 10; $i++){
    echo $i;
    echo '<br>';
}

echo '</p>';

echo '<p>Array<br>';

$array = array();

array_push($array, "Guillermo");
array_push($array, "Elci");
array_push($array, "Alan");

print_r($array);

echo '</p>';
?>