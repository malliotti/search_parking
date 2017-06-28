<!-- 
https://developers.google.com/maps/documentation/javascript/examples/places-autocomplete-addressform?hl=pt-br
-->

<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);


include "recursos/conecao.php";

?>

<html lang="pt-br">
  <head>
    <title>Search Parking</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">

    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

    <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

</head>

<body>

<?php
include "header.php";
?>

<div class="container">

<header>
  <div class="row">
    <div class="col-sm-6">
      <h2>Estacionamento</h2>
    </div>
    <div class="col-sm-6 text-right h2">
        <a class="btn btn-primary" href="endereco_cadastro.php"><i class="fa fa-plus"></i> <span class="glyphicon glyphicon-file" aria-hidden="true"></span></a>
        <a class="btn btn-default" href="#"><i class="fa fa-refresh"></i> <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></a>
      </div>
  </div>
</header>

<hr>

<table class="table table-hover">
<thead>
  <tr>
    <th>Nome</th>
    <th>Cidade</th>
    <th>UF</th>
    <th>Opções</th>
  </tr>
</thead>
<tbody>
<?php 


// try {

//     // prepare sql and bind parameters
//     $stmt = $conn->prepare("INSERT INTO tbl_estacionamento (nome_estacionamento, cep, logradouro, numero,complemento,bairro,localidade,uf,estacionamento_coberto,horario_atendimento,latitude,longitude) VALUES (:1,:2,:3,:4,:5,:6,:7,:8,:9,:10,:11,:12)");
//     $stmt->bindParam(':1', $nome_estacionamento);
//     $stmt->bindParam(':2', $cep);
//     $stmt->bindParam(':3', $logradouro);
//     $stmt->bindParam(':4', $numero);
//     $stmt->bindParam(':5', $complemento);
//     $stmt->bindParam(':6', $bairro);
//     $stmt->bindParam(':7', $localidade);
//     $stmt->bindParam(':8', $uf);
//     $stmt->bindParam(':9', $estacionamento_coberto);
//     $stmt->bindParam(':10', $horario_atendimento);
//     $stmt->bindParam(':11', $latitude);
//     $stmt->bindParam(':12', $longitude);
//     $stmt->execute();


//     echo "estacionamento cadastrado";
//     }
// catch(PDOException $e)
//     {
//     echo "Error: " . $e->getMessage();
//     }
// $conn = null;

$consulta =  $conn->query("SELECT id_estacionamento, nome_estacionamento, localidade, uf FROM tbl_estacionamento;"); 
$result = $consulta->fetchAll();

if ($result) {
  foreach($result as $row){
?>
  <tr>
    <td><?php echo $row['nome_estacionamento']; ?></td>
    <td><?php echo $row['localidade']; ?></td>
    <td><?php echo $row['uf']; ?></td>
    <td class="actions text-left">
      <a href="view.php?id=<?php echo $row['id_estacionamento']; ?>" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> <span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
      <a href="edit.php?id=<?php echo $row['id_estacionamento']; ?>" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
      <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-modal" data-customer="<?php echo $row['id_estacionamento']; ?>"><i class="fa fa-trash"></i><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
    </td>
  </tr>
<?php 
} 
}else {
?>
  <tr>
    <td colspan="6">Nenhum registro encontrado.</td>
  </tr>
<?php
}
?>
</tbody>
</table>

</div>

<script>
    var placeSearch, autocomplete;
    var componentForm = {
      street_number: 'short_name',
      route: 'long_name',
      locality: 'long_name',
      administrative_area_level_1: 'short_name',
      country: 'long_name',
      postal_code: 'short_name',
      sublocality_level_1: 'long_name'
    };

    function initAutocomplete() {
      // Create the autocomplete object, restricting the search to geographical
      // location types.
      autocomplete = new google.maps.places.Autocomplete(
        /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
        {types: ['geocode']});

      // When the user selects an address from the dropdown, populate the address
      // fields in the form.
      autocomplete.addListener('place_changed', fillInAddress);
    }//function initAutocomplete()

    function fillInAddress() {
      // Get the place details from the autocomplete object.
      var place = autocomplete.getPlace();
      for (var component in componentForm) {
        document.getElementById(component).value = '';
        document.getElementById(component).disabled = false;
      }

      // Get each component of the address from the place details
      // and fill the corresponding field on the form.
      for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        if (componentForm[addressType]) {
          var val = place.address_components[i][componentForm[addressType]];
          document.getElementById(addressType).value = val;
        }
      }
      document.getElementById('latitude').value = place.geometry.location.lat();
      document.getElementById('longitude').value = place.geometry.location.lng();
    }//function fillInAddress()

    // Bias the autocomplete object to the user's geographical location,
    // as supplied by the browser's 'navigator.geolocation' object.
    function geolocate() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
          var geolocation = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
          };
          var circle = new google.maps.Circle({
            center: geolocation,
            radius: position.coords.accuracy
          });
          autocomplete.setBounds(circle.getBounds());
        });
      }
    }//function geolocate()

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBBhEbgb2XS80KdDP2vli4sY3kQGFZpYiQ&libraries=places&callback=initAutocomplete" async defer></script>

  </body>
</html>