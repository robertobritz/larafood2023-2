<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Planos</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="{{ 'css/site.css' }}">
    <link rel="icon" href="{{ url('imgs/favicon.png')}}" type="image/png">
</head>
<body>

<div class="demo">
    <div class="container">
    	<div class="text-center">
    		<h1 class="title-plan">Escolha o plano</h1>
    	</div>
        <div class="row">
            @foreach ($plans as $plan)
                
            
            <div class="col-md-4 col-sm-6">
                <div class="pricingTable">
                    <div class="pricing-content">
                        <div class="pricingTable-header">
                            <h3 class="title">{{ $plan->name}}</h3>
                        </div>
                        <div class="inner-content">
                            <div class="price-value">
                                <span class="currency">R$</span>
                                <span class="amount">{{ number_format($plan->price, 2, ',', '.') }}</span>
                                <span class="duration">Por Mês</span>
                            </div>
                            <ul>
                            @foreach ($plan->details as $detail)
                                <li>{{ $detail->name }}</li>
                            @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="pricingTable-signup">
                        <a href="{{ route('plan.subscription', $plan->url) }}">Assinar</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

</body>
</html>