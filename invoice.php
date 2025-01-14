<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - BZ#0099</title>

    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="icon" href="resourses/logo.svg" />
</head>

<body>
    <!-- Invoice 1 - Bootstrap Brain Component -->
    <section class="py-3 py-md-5">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-9 col-xl-8 col-xxl-7">
                    <div class="row gy-3 mb-3 justify-content-between align-items-center">
                        <div class="col-5 col-lg-5">
                            <h2 class="text-uppercase text-endx m-0">Invoice</h2>
                            <div class="row">
                                <span class="col-6">Order ID</span>
                                <span class="col-6 text-sm-end">#9742</span>
                                <span class="col-6">Invoice Date</span>
                                <span class="col-6 text-sm-end">12/10/2025</span>
                                <span class="col-6">Payment</span>
                                <span class="col-6 text-sm-end">Card Payment</span>
                            </div>
                        </div>
                        <div class="col-5">
                            <a class="d-block text-end" href="#!">
                                <img src="resourses/logo.svg" class="img-fluid" alt="Book Zone Logo" width="135">
                            </a>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3 justify-content-between">
                        <div class="col-12 col-sm-6 col-md-9">
                            <h4>Bill To</h4>
                            <address>
                                <strong>Mason Carter</strong><br>
                                7657 NW Prairie View Rd<br>
                                Kansas City, 64151<br>
                                United States<br>
                                Phone: (816) 741-5790<br>
                                Email: email@client.com
                            </address>
                        </div>
                        <div class="col-12 col-sm-5 col-md-3 col-lg-3">
                            <h4>Ship To</h4>
                            <address>
                                <strong>Mason Carter</strong><br>
                                7657 NW Prairie View Rd<br>
                                Kansas City, 64151<br>
                                United States<br>
                                Phone: (816) 741-5790<br>
                                Email: email@client.com
                            </address>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-uppercase">Qty</th>
                                            <th scope="col" class="text-uppercase">Product</th>
                                            <th scope="col" class="text-uppercase text-end">Unit Price</th>
                                            <th scope="col" class="text-uppercase text-end">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider">
                                        <tr>
                                            <th scope="row">2</th>
                                            <td>Console - Bootstrap Admin Template</td>
                                            <td class="text-end">75</td>
                                            <td class="text-end">150</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>Planet - Bootstrap Blog Template</td>
                                            <td class="text-end">29</td>
                                            <td class="text-end">29</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">4</th>
                                            <td>Hello - Bootstrap Business Template</td>
                                            <td class="text-end">32</td>
                                            <td class="text-end">128</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>Palette - Bootstrap Startup Template</td>
                                            <td class="text-end">55</td>
                                            <td class="text-end">55</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end">Subtotal</td>
                                            <td class="text-end">362</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end">VAT (5%)</td>
                                            <td class="text-end">18.1</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end">Shipping</td>
                                            <td class="text-end">15</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" colspan="3" class="text-uppercase text-end">Total</th>
                                            <td class="text-end">$495.1</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary mb-3">Download Invoice</button>
                            <button type="submit" class="btn btn-danger mb-3">Submit Payment</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




    <script src="script.js"></script>
    <script src="bootstrap.bundle.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</body>

</html>