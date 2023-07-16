<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.3.1/socket.io.js"></script>
</head>

<body>
    <div class="header">
        <h1>Socket.io</h1>
    </div>
    <div class="body">
        <p>Jarak pintu sekarang: <span id="jarak"></span></p>
        <div id="history">
            <div>Perubahan jarak pada jam:</div>
            <ul id="listHistory"></ul>
        </div>
    </div>
    <script>
        //connect to socket http://localhost:3000/socket.io/socket.io.js
        var socket = io.connect('http://localhost:3000');
        //listen on dataJarak 
        socket.on('dataJarak', function(data) {
           //set to id jarak
            document.getElementById("jarak").innerHTML = data + " cm";
        });
        //listen on dataHistory
        socket.on('dataHistory', function(data) {
            //set dataHistory to ''
            document.getElementById("listHistory").innerHTML = "";
            data.forEach(
                function(item) {
                    var node = document.createElement("li");
                    var textnode = document.createTextNode(item.waktu + " (" + item.jarak + " cm)");
                    node.appendChild(textnode);
                    document.getElementById("listHistory").appendChild(node);
                }
            );


        
        });

    </script>
</body>

</html>