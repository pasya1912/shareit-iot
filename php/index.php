<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Project IOT SMAN 2 Klari</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.3.1/socket.io.js"></script>
</head>

<body>
    <header>
        <h1>Project IOT SMAN 2 Klari</h1>
    </header>
    <main>
        <section>
            <h2>Pengukur Jarak Keamanan</h2>
            <div class="fitur">
                <div class="produk">
                    <img src="jarak.png" alt="jarak">
                    <h3>Jarak Real Time </h3>
                    <p id="jarak"></p>
                </div>
                <div class="produk">
                    <img src="pesan.png" alt="pesan">
                    <h3>Pesan Keamanan</h3>
                    <p id="statusJarak">"Pergerakan Terdeteksi"</p>
                </div>
            </div>
            <div class="history">
                <h3>History Keamanan Ruangan</h3>
                <div id="listHistory">
                    <li>10.00 Aman Terkendali</li>
                    <li>10.15 Pergerakan Terdeteksi</li>
                    <li>10.30 Aman Terkendali</li>
                </div>
            </div>

        </section>
        <aside>
            <h2>Keterangan</h2>
            <p>1. Tempatkan project pada posisi dekat dengan pintu masuk ruangan</p>
            <p>2. Sambungkan pada sumber daya listrik yang ada</p>
            <p>3. Project akan mendeteksi apabila ada pergerakan benda pada jarak kurang dari 50cm</p>
            <p>4. Jika tidak ada pergerakan benda pada jarak kurang dari 50cm, maka dikatakan aman</p>
        </aside>
    </main>
    <footer>
        <p>Hak Cipta &copy; 2023 Pengukur Jarak Keamanan</p>
    </footer>
    <script>
        var socket = io.connect('http://' + window.location.hostname + ':3000');
        //listen on dataJarak 
        socket.on('dataJarak', function(data) {
            //set to id jarak
            document.getElementById("jarak").innerHTML = data + " cm";
            if (data > 50) {
                document.getElementById("statusJarak").innerHTML = "Aman Terkendali";

            } else {
                document.getElementById("statusJarak").innerHTML = "Pergerakan terdeteksi";
            }
        });
        //listen on dataHistory
        socket.on('dataHistory', function(data) {
            //set dataHistory to ''
            document.getElementById("listHistory").innerHTML = "";
            if (item.jarak > 50) {
                var status = "Aman terkendali";
            } else {
                var status = "Pergerakan Terdeteksi";
            }
            data.forEach(
                function(item) {
                    var node = document.createElement("li");
                    var textnode = document.createTextNode(item.waktu + " " + status);
                    node.appendChild(textnode);
                    document.getElementById("listHistory").appendChild(node);
                }
            );



        });
    </script>
</body>

</html>