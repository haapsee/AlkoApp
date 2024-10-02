

<html>
    <head>
        <title>Alko App</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/2.1.7/css/dataTables.bootstrap5.css" crossorigin="anonymous"></script>
    </head>


    <body>
        <div>
            <h1>Alko App</h1>
        </div>
        <div>
            <button class="btn btn-success" onclick="showTable()">List</button>
            <button class="btn btn-danger" onclick="hideTable()">Empty</button>
            <button id="btn1" class="btn btn-outline-primary" onclick="prev()">Previous</button>
            <button id="btn2" class="btn btn-outline-primary" onclick="next()">Next</button>
            <button id="btn3" class="btn btn-outline-primary" onclick="getall()">All</button>
        </div>
        <div>
            <table id="datatable_for_items" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Number</th>
                        <th>Name</th>
                        <th>Bottle size</th>
                        <th>Price</th>
                        <th>Price GBP</th>
                        <th>Last time retrieved</th>
                        <th>Quantity</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody id="datatable_body">
                </tbody>
            </table>
        </div>


        <script>
            var start = 0;
            var amount = 20;
            var isLast = false;

            function hideTable() {
                document.getElementById("datatable_for_items").style.display = "none";
                document.getElementById("btn1").style.display = "none";
                document.getElementById("btn2").style.display = "none";
                document.getElementById("btn3").style.display = "none";
            }

            function showTable() {
                document.getElementById("datatable_for_items").style.display = "table"; 
                document.getElementById("btn1").style.display = "inline-block";
                document.getElementById("btn2").style.display = "inline-block";
                document.getElementById("btn3").style.display = "inline-block";
            }

            function updateDataTable(jsonData) {

                var newTable = "";

                jsonData.forEach(item => {
                    var str = "<tr>"
                    str += `<td>${item.number}</td>`;
                    str += `<td>${item.name}</td>`;
                    str += `<td>${item.bottlesize}</td>`;
                    str += `<td>${item.price}</td>`;
                    str += `<td>${item.pricegbp}</td>`;
                    str += `<td>${item.retrieved}</td>`;
                    str += `<td id="${item.number}_amount">${item.orderamount}</td>`;
                    str += `<td><button class="btn btn-success" onclick="additem(${item.number})">Add</button>`;
                    str += `<button class="btn btn-danger" onclick="clearitem(${item.number})">Clear</button></td>`;
                    newTable += str + "</tr>"
                });

                document.getElementById("datatable_body").innerHTML = newTable;
            }

            function updateDataTableData() {
                const xhr = new XMLHttpRequest();
                xhr.open("GET", `/api.php?amount=${amount+1}&from=${start}`)

                xhr.onload = () => {
                    if (xhr.status == 200) {
                        const data = JSON.parse(xhr.responseText);

                        if (data.length <= amount) {
                            isLast = true;
                        }
                        updateDataTable(data);
                    } else {
                        console.error("Request failed with status: ", xhr.status)
                    }
                }
                xhr.send();
            }

            function additem(num) {
                const xhr = new XMLHttpRequest();
                xhr.open("POST", `/api.php`, true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");


                var item = document.getElementById(`${num}_amount`);
                var newAmount = parseFloat(item.innerText.trim()) + 1;

                xhr.onload = () => {
                    if (xhr.status == 200) {
                        document.getElementById(`${num}_amount`).innerText = newAmount;
                    } else {
                        console.error("Request failed with status: ", xhr.status)
                    }
                }
                xhr.send(`func=Add&number=${num}&quantity=${newAmount}`);
            }

            function clearitem(num) {
                const xhr = new XMLHttpRequest();
                xhr.open("POST", `/api.php`, true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                xhr.onload = () => {
                    if (xhr.status == 200) {
                        var item = document.getElementById(`${num}_amount`);
                        item.innerText = "0";
                    } else {
                        console.error("Request failed with status: ", xhr.status)
                    }
                }
                xhr.send(`func=Clear&number=${num}`);
            }

            function next() {
                if (isLast) {
                    alert("Last page");
                    return;
                }
                start += amount;
                updateDataTableData()
            }

            function prev() {
                if (start == 0) {
                    alert("First page");
                    return;
                }
                isLast = false;
                start -= amount;
                updateDataTableData()
            }

            function getall() {
                const xhr = new XMLHttpRequest();
                xhr.open("GET", `/api.php?amount=${1000000}&from=0`);

                xhr.onload = () => {
                    if (xhr.status == 200) {
                        const data = JSON.parse(xhr.responseText);
                        updateDataTable(data);
                    } else {
                        console.error("Request failed with status: ", xhr.status)
                    }
                }
                xhr.send();
            }

            // hideTable();
            updateDataTableData();
        </script>
    </body>

</html>
