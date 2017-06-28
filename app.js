// // importante verificar se o navegador suporta service workers.
// if ('serviceWorker' in navigator) {
//   navigator.serviceWorker
//             .register('/tcc/service-workers.js')
//               .then(function() { console.log('Service Worker registrado ! :)'); })
//               .catch(function(e) { console.error(e); });

//   navigator.serviceWorker.oncontrollerchange = function(controllerchangeevent) {
//     // aqui dentro podemos disparar algum evento em uma 
//     //  store por exemplo para o usuário saber que existe
//     //  novas funcionalidades esperando pelo seu refresh
//     alert("Atualize sua página para ter acesso a um conteúdo mais novo");  
//   }
// }


if (navigator.serviceWorker) {
  navigator.serviceWorker.register('./service-workers.js').then(function(registration) {
    console.log('ServiceWorker registration successful with scope:',  registration.scope);
  }).catch(function(error) {
    console.log('ServiceWorker registration failed:', error);
  });
}