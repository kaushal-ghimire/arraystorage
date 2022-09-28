<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Array Online Store</title>
    <style>
        body{
            background-color: #F6F6F6; 
            margin: 0;
            padding: 0;
        }
        h1,h2,h3,h4,h5,h6{
            margin: 0;
            padding: 0;
        }
        p{
            margin: 0;
            padding: 0;
        }
        .container{
            width: 30%;
            margin-right: auto;
            margin-left: auto;
        }
        .brand-section{
           background-color: #0d1033;
           padding: 10px 0px;
        }
        .logo{
            width: 50%;
        }

        .row{
            display: flex;
            flex-wrap: wrap;
        }
        .col-6{
            width: 50%;
            flex: 0 0 auto;
        }
        .text-white{
            color: #fff;
        }
        .company-details{
            float: right;
            text-align: end;
        }
        .body-section{
            padding: 16px;
            border: 1px solid gray;
        }
        .sub-heading{
            color: #262626;
            margin-bottom: 05px;
        }
        .text-right{
            text-align: end;
        }
        .w-20{
            width: 20%;
        }
        .float-right{
            float: right;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="brand-section">
            <div class="row">
                <div class="col-3">
                    <h1 class="text-white">Array Online Store</h1>
                
                        <p class="text-white"> Biratnagar</p>
                        <p class="text-white"> Ph no:</p>
                </div>
            </div>
        </div>

        <div class="body-section">
            <div class="row">
                <div class="col-3">
                    <p class="sub-heading">Product Name: <strong>{{$product->name}}</strong></p>
                    <p class="sub-heading">Product Id: <strong>{{$product->product_id}}</strong>  </p>
                    <p class="sub-heading">Quantity: <strong>{{$product->sell_quantity}} </strong> </p>
                    <p class="sub-heading">Rate: <strong>{{$product->selling_price}}</strong>  </p>
                </div>
            </div>

        </div>


        <!-- <div class="body-section">
            <h3 class="heading">Ordered Items</h3>
            <br>
            <table class="table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th class="w-20">Price</th>
                        <th class="w-20">Quantity</th>
                        <th class="w-20">Grandtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Product Name</td>
                        <td>10</td>
                        <td>1</td>
                        <td>10</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right">Sub Total</td>
                        <td> 10.XX</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right">Tax Total %1X</td>
                        <td> 2</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right">Grand Total</td>
                        <td> 12.XX</td>
                    </tr>
                </tbody>
            </table>
            <br>
            <h3 class="heading">Payment Status: Paid</h3>
            <h3 class="heading">Payment Mode: Cash on Delivery</h3>
        </div> -->

        <div class="body-section">
            <em>&copy; Copyright {{date('Y')}}
                <strong>All rights reserved.</strong> 
                <a href="https://www.arraystoreonline.com/" >www.arraystoreonline.com</a>
            </em>
        </div>
        <div class="text-right">
            <span>
                <style type="text/css">
                    @media print {
                        #printbtn {
                            display :  none;
                        }
                    }
                </style>
                <input id ="printbtn" type="button" value="Print" onclick="window.print();" >
            </span>
        </div>     
    </div>      

</body>
</html>