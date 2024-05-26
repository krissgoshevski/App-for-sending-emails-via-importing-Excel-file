@extends('layouts.email')
@section('title', 'Email-en')
@section('content')

<img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/assets/images/en2.png'))) }}" alt="English Banner Neotel Logo" class="english-banner-neotel-logo"> <br> <br> 



         <p>Dear Customer, <br> <br> {{ $row[9] }}</p> <br> <!-- Naslov na porakata -->

        @if(!empty($row[10]))
        <p> <b> Reason: </b> {{$row[10]}}</p>
        @endif 
     
        <br>  <p> <b> Affected Services: </b> </p>

    @foreach ($circuit_ids as $circuit_id)
        <p>Customer name: {{ $circuit_id }}</p>
    @endforeach 

    <div class="address-service-container">
        @foreach ($addresses as $index => $address)
            @if (!empty($address))
                <p>Circuit ID: {{ $address }}</p>
            @endif
            @if ($index < count($services))
                        @if (!empty($services[$index]))
                            <p>Circuit ID: {{ $services[$index] }}</p>
                        @endif
            @endif
        @endforeach
    </div>
   
    <br>  <p> <b> Maintenance window: </b> </h4>
        <p>Start date and time:  {{ $row[3] }}</p>
        <p>Start end and time:  {{ $row[4] }}</p>
        <p>Expected Duration of Intervention:  {{ $row[5] }}</p> <br>

        <p>We would like to apologize for any inconvenience caused. </p>
        <p>If no reply is received in 24h, we will consider the date as accepted and proceed with the work. </p> <br>
        
        <div class="contact-info">
            <p> Regards, </p>   
            <p> Kristijan Goshevski </p>  
            <p>Programmer</p>
            <p>Tel: + 390 70 233 959</p>
            <p>e-mail: <a href="mailto:your_email@yahoo.com">your_email@yahoo.com</a></p>
        </div>
@endsection

