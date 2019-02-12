<?php require_once('config.php') ?>
<?php require_once( ROOT_PATH . '/controllers/public_functions.php') ?>

<?php $bills = getCurrentDayBills(); ?>

<?php include_once('resources/views/header.php') ?>
    <title>Ebilling</title>
</head>
<body class="bg-grey-lighter flex flex-col min-h-screen">
    <?php include_once('resources/views/navbar.php') ?>
    <main class="flex flex-1 flex-col m-5">
        <h2 class="font-monospace text-orange-dark w-3/4 mx-auto my-5" id = "heading">Current Day Bills</h2>
        <div class="content flex">
            <div class="main-content flex-1 w-3/4 mx-1">
                <div class="flex w-3/4 m-auto justify-between px-5">
                    <div class="search-bar">
                        <input type="text" id="name" class="p-2 rounded" placeholder="client name..."><button class="p-2 rounded mx-2 border border-orange-dark hover:bg-orange-dark hover:text-white" onclick = "search()">search</button>
                    </div>
                    <div>
                        <p class="inline-flex">Filter-by:</p>
                        <select name="filter" onchange = "filter()" id="select" class="p-1">
                            <option value="1">Current Day Bills</option>
                            <option value="2">Past Week Bills</option>
                            <option value="3">Past Month Bills</option>
                            <option value="4">All Bills</option>
                        </select>
                    </div>
                </div>
                <div id = 'bills'>
                </div>
                <div class="flex justify-center">
                    <div class="w-32 flex justify-between" id = "pages">
                    </div>                    
                </div>
            </div>
        </div>
    </main>

    <?php include_once('resources/views/footer.php') ?>
</body>
<script>
    bills = <?php echo json_encode($bills); ?>;
    pagesDiv = document.getElementById('pages');

    function search(){
        name = document.getElementById('name').value;
        if(name){ 
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    bills = JSON.parse(this.responseText);
                    paginate(1);
                }
            };
            xhttp.open("GET", "filter.php?name="+name , true);
            xhttp.send();
        }
    }

    function filter(){
        select = document.getElementById('select').value;
        header = document.getElementById('heading');
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                bills = JSON.parse(this.responseText);
                paginate(1);
                switch(select){
                    case '1':
                        header.innerHTML = 'Current Day Bills';
                        break;
                    case '2':
                        header.innerHTML = 'Past Week Bills';
                        break;
                    case '3':
                        header.innerHTML = 'Past Month Bills';
                        break;
                    case '4':
                        header.innerHTML = 'All Bills';
                        break;
                }
            }
        };
        xhttp.open("GET", "filter.php?filter_bills="+select, true);
        xhttp.send();
    }

    function paginate(page){
        start = 15*(page-1);
        end = start + 14;
        s = ''
        for(var i = start; i <= end; i++){
            if(i < bills.length){
                bills[i]['created_at'] = bills[i]['created_at'].split(" ");
                s += `<div class="card min-h-20 my-5 w-3/4 mx-auto bg-white rounded flex flex-1 flex-col p-4 shadow">
                        <div class="card-header ">
                        <h2 class="text-black py-2">Invoice<small class="text-grey-darkest font-light text-base float-right">Issued by: ` + bills[i]['user']['username'] + `</small></h2>
                        </div>
                        <div class="flex px-4">
                            <div class="w-1/2 border-r-4 border-dashed">
                                <h4 class="text-grey-darkest py-2">Customer-name :<span class="font-normal">`+bills[i]['client_name']+`</span></h3>
                                <h4 class="text-grey-darkest py-2">Total-products: <span class="font-normal">`+bills[i]['products'].length+`</span></h3>
                                <h4 class="text-grey-darkest py-2">Date: <span class="font-normal">` + bills[i]['created_at'][0] + `</span></h3>
                                <h4 class="text-grey-darkest py-2">Time: <span class="font-normal">` + bills[i]['created_at'][1] + `</span></h3>
                            </div>
                            <div class="w-1/2 flex flex-col mx-10">
                                <h3 class="text-grey-darkest text-center">purchased-products</h3>
                                <div class="card-content flex my-2 justify-around">
                                        <ul class="list-reset flex flex-col ">
                                                `; 
                                            for(var j = 0; j < bills[i]['products'].length; j++){
                                                s += '<li class="py-2">' + bills[i]['products'][j]['name'] + '</li>';
                                            }
                                            
                                        s += `</ul>
                                            <ul class="list-reset flex flex-col ">`;
                                        
                                            for(var j = 0; j < bills[i]['products'].length; j++){
                                                s += '<li class="py-2">' + bills[i]['products'][j]['price'] + '</li>';
                                            }

                                        s +=   `
                                        </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer flex my-2 justify-between">
                            <div>
                                <a href=invoice.php?bill_id=` + bills[i]['id'] + ` class="p-1 rounded border border-orange-dark hover:bg-orange-dark hover:text-white">view bill</a>
                            </div>
                            <h5 class="text-grey-darkest">Total-Price <small class=" text-xs text-grey-dark">` + bills[i]['amount'] + `</small> </h5>
                        </div>
                    </div>`;
            }
        }
        billsDiv = document.getElementById('bills');
        billsDiv.innerHTML = s;
    }

    pages = Math.floor((bills.length)/15) + 1;

    if(pages > 1){
        for(var i = 1; i <= pages; i++){
            pagesDiv.innerHTML += '<button class="text-orange-dark hover:bg-orange-dark hover:text-white p-2 rounded" onclick = ' + paginate(i) + '>' + i + '</button>'
        }
    }

    paginate(1);

</script>
</html>