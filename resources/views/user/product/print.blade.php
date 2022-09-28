<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Array Online Store</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css\bootstrap.min.css') }}">
</head>
<body>

        <div class="card" id="div_print">
            <div class="card-header bg-light">
                <center>
                    <h3>Array Online Store</h3>
                    <h4>Biratnagar</h4>
                    <h5>Ph no:</h5>
                </center>
            </div>
            <div class="card-body">
                <p class="sub-heading">Product Name: <strong>{{$product->name}}</strong></p>
                    <p class="sub-heading ">Product Id: <strong class="bg-secondary">{{$product->product_id}}</strong>  </p>
                    <p class="sub-heading">Quantity: <strong>{{$product->sell_quantity}} </strong> </p>
                    <p class="sub-heading">Rate: <strong>{{$product->selling_price}}</strong>  </p>
            </div>
        </div>
         <input name="b_print" type="button" class="ipt" onclick="printDiv()" value=" Print ">
        

     
    <script>
            function printDiv() {
                var divContents = document.getElementById("div_print").innerHTML;
                var a = window.open('', '', '');
                var path = '{{ asset('css/bootstrap.min.css') }}';
                a.document.write('<html>');
                a.document.write('<link rel="stylesheet" type="text/css" href="'+path+'">');
                a.document.write('<style type="text/css">.bg-red {background-color: red !important;} @media print { .bg-red {background-color: red !important;} }</style> ');
                a.document.write('<body > ');
                a.document.write(divContents);
                a.document.write('</body></html>');
                a.document.close();
                // a.print();
                setTimeout(() => {
                    a.print();
                }, 1000);
            }
        </script>
</body>
</html>