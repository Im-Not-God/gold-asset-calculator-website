@extends('layouts.layout')

@section('title', 'Home')

@section('content')
<style>
    .filter {
        background-color: rgba(0, 0, 0, 0.5);
        height: 100%;
        width: 100%;
        left: 0px;
        position: absolute;
    }
</style>
<div class="background-image">
    <div class="filter"></div>
    <div class="align-items-center container d-flex h-100" style="padding: 0 40px;">

        <div class="py-5" style="position: relative;">
            <div class="text-center">
                <h1 style="color:gold; font-weight:bold">Gold Calculator</h1><br><br>
                <p style="color:white" class="fs-4">Welcome to our Universal Gold Asset Calculator website. This is one of the most user-friendly gold asset calculator websites in Malaysia. This website is designed to help you calculate your gold assets accurately.</p>
            </div>
            <!-- <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Pricing</div>
                        <div class="card-body">
                            <p>Choose the plan that best suits your needs:</p>
                            <ul>
                                <li>Basic - $9.99/month</li>
                                <li>Premium - $19.99/month</li>
                                <li>Gold - $29.99/month</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mt-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">About</div>
                        <div class="card-body">
                            <p>We are a team of experienced professionals who specialize in gold asset management. Our goal is to help you make informed decisions and grow your wealth through smart investments.</p>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- <div class="row justify-content-center mt-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Contact</div>
                        <div class="card-body">
                            <p>For any inquiries, please contact us at:</p>
                            <ul>
                                <li>Email: info@goldassetmanagement.com</li>
                                <li>Phone: 1-800-GOLD-123</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="text-center mt-5">
                <button class="btn btn-warning" onclick="window.location.href='/register'">
                    Get Started
                </button>
            </div>
        </div>
    </div>

</div>
<div style="background-color: gold;" id="plan">
    <div class="container py-4 text-center">
        <h1 style="color:black; font-weight:bold">Subscription Plan</h1><br>
        <div class="row justify-content-center align-items-center">
            <div class="col-md-3 mb-1">
                <div class="card bg-dark">
                    <div class="card-body">
                        <h5 class="card-title">Basic</h5>
                        <h5 class="card-title">$0 <span class="text-muted">/month</span></h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-1">
                <div class="card bg-dark p-3">
                    <div class="card-body">
                        <h5 class="card-title fs-4">Standard</h5>
                        <h5 class="card-title fs-4">$9.99 <span class="text-muted">/month</span></h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-1">
                <div class="card bg-dark">
                    <div class="card-body">
                        <h5 class="card-title">Premium</h5>
                        <h5 class="card-title">$19.99 <span class="text-muted">/month</span></h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Begin Gold Price Script - GOLDPRICE.ORG -->
<div style="border: 1px solid #000000; width: 300px; height: auto; font-family: Arial; background-color: #FFFFFF; margin: auto;">
    <div style="margin: 0px auto; width: 100%; height: 24px; text-align: center; padding-top: 0px; font-size: 18px; font-weight: bold; background-color: #000000;"><a style="color: #FFFFFF; background-color: #000000; text-decoration: none;" href="http://goldprice.org" target="_blank"></a></div>
    <div id="gold-price" data-gold_price="USD-o-1d"></div>
    <script type="text/javascript" src="/js/charts-goldprice-org/gold-price.js"></script>
</div>
<!-- End Gold Price Script - GOLDPRICE.ORG -->

@endsection