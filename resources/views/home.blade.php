<!DOCTYPE html>
<html lang=&quoten&quot>
<head>
    <meta charset=&quotUTF-8&quot>
    <meta name=&quotviewport&quot content=&quotwidth=device-width, initial-scale=1.0&quot>
    <meta http-equiv=&quotX-UA-Compatible&quot content=&quotie=edge&quot>
    <title>Document</title>
</head>
<body>
    
        navigator.serviceWorker.register('sw.js');
async function subscribe() {
    let sw = await navigator.serviceWorker.ready;
    let push = await sw.pushManager.subscribe({
        userVisibleOnly:true,
        applicationServerKey:&quotBJjPvcv9QQu3SVxvjP_WpQNeuyhWKpGozAXkab2rl6VTaMv18R4avQy5dKcudeEbCbRNMR_kRkbPxV957fxXbP8&quot
    });
      let xhr = new XMLHttpRequest()
 
xhr.open('POST', '/api/admin/savepush', true)
xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8')
xhr.send(JSON.stringify({&quotpush&quot:JSON.stringify(push)}));
}
        function enableNotif() {
            Notification.requestPermission().then(function (permission) {
               if (Notification.permission === 'granted') {
 subscribe()
}
            });
        }
    
    <button =&quotenableNotif();&quot style=&quotfont-size: 5rem&quot>enableNotif</button>
</body>
</html>