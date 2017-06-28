<!-- 
https://developers.google.com/maps/documentation/javascript/examples/places-autocomplete-addressform?hl=pt-br
-->

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
      <h2>Cadastro de Estacionamento</h2>
    </div>
  </div>
</header>

  <form action="endereco.php" method="POST" role="form" >
    
      <div class="row"> <!-- Pesquisa Por Endereço ou CEP  -->
        <div class="form-group col-md-12">
          <label for="autocomplete" class="control-label">Endereço ou CEP </label>
          <input id="autocomplete" class="form-control" placeholder="Informe o endereço ou CEP" onFocus="geolocate()" type="text">
        </div>
      </div>

      <div class="row"> <!-- Endereço e Número -->
        <div class="form-group col-md-12">
          <label for="estacionamento" class="control-label">Nome do Estacionamento</label>
          <input type="text" class="form-control" id="estacionamento" name="estacionamento">
        </div>
      </div>

      <div class="row"> <!-- Endereço e Número -->
        <div class="form-group col-md-6">
          <label for="route" class="control-label">Endereço</label>
          <input type="text" class="form-control" id="route" name="route">
        </div>
        <div class="form-group col-md-2">
          <label for="street_number" class="control-label">Numero</label>
          <input type="text" class="form-control" id="street_number" name="street_number" >
        </div>
        <div class="form-group col-md-4">
          <label for="complemento" class="control-label">Complemento</label>
          <input type="text" class="form-control" id="complemento" name="complemento">
        </div>  
      </div>

      <div class="row"> <!-- Cidade e Bairro  -->
        <div class="form-group col-md-6">
          <label for="locality" class="control-label">Cidade</label>
          <input type="text" class="form-control" id="locality" name="locality" >
        </div>          
        <div class="form-group col-md-6">
          <label for="sublocality_level_1" class="control-label">Bairro</label>
          <input type="text" class="form-control" id="sublocality_level_1" name="sublocality_level_1" >
        </div>  
      </div>

      <div class="row"> <!-- Estado, CEP e Pais  -->
        <div class="form-group col-md-4">
          <label for="administrative_area_level_1" class="control-label">Estado</label>
          <input type="text" class="form-control" id="administrative_area_level_1" name="administrative_area_level_1">
        </div>   
        <div class="form-group col-md-4">
          <label for="postal_code" class="control-label">CEP</label>
          <input type="text" class="form-control" id="postal_code" name="postal_code" >
        </div>
        <div class="form-group col-md-4">
          <label for="country" class="control-label">País</label>
          <input type="text" class="form-control" id="country" name="country" >
        </div>   
      </div>

      <div class="row"> <!-- Estado, CEP e Pais  -->
        <div class="form-group col-md-6">
          <label for="estacionamento_coberto" class="control-label">Estacionamento Coberto</label>
          <select ng-model='discussionsSelect' class='form-control' id="estacionamento_coberto" name="estacionamento_coberto">
            <option value='0' selected>Selecione a opão</option>
            <option value='Sim'>Sim</option>
            <option value='Nao'>Não</option>
          </select>
        </div>   
        <div class="form-group col-md-6">
          <label for="horario_atendimento" class="control-label">Horário de Atendimento</label>
          <input type="text" class="form-control" id="horario_atendimento" name="horario_atendimento" >
        </div>
 
      </div>

      <div class="row"> <!-- Latitude e Longitude -->
        <div class="form-group col-md-6">
          <label for="latitude" class="control-label">Latitude</label>
          <input type="text" class="form-control" id="latitude" name="latitude" readonly>
        </div>  
        <div class="form-group col-md-6">
          <label for="longitude" class="control-label">Longitude</label>
          <input type="text" class="form-control" id="longitude" name="longitude" readonly>
        </div>  
      </div>

      <div class="row"> <!-- Botão Gravar-->
        <div class="col-md-12">
          <button type="submit" class="btn btn-primary">Gravar</button>
        </div>     
      </div>
  </form>

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