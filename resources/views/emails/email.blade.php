@extends('layouts.email')
@section('title', 'Email-mk')
@section('content')
<img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/assets/images/mkd2.png'))) }}" alt="Mk Banner Neotel Logo" class="mk-banner-neotel-logo"> <br> <br>


<p>Почитувани, <br> <br> {{ $row[9] }}</p> <br><!-- Naslov na porakata -->

@if(!empty($row[10]))
<p> <b> Причина: </b> {{$row[10]}}</p>
@endif <br>


<p> <b> Афектирани сервиси: </b> </p>
<p>Корисник: {{ $row[1] }}</p> <!-- Korisnik ili Circuit ID -->



<div class="address-service-container">
    @foreach ($addresses as $index => $address)
        @if (!empty($address) && isset($services[$index])) <!-- Check if both address and service exist -->
            <p>Адреса: {{ $address }}</p>
            <p>Сервис: {{ $services[$index] }}</p>
        @endif
    @endforeach
</div> <br> 


<p> <b> Временска рамка: </b> </p>
<p>Почеток: {{ $row[3] }}</p> <!-- Pocetok -->
<p>Крај: {{ $row[4] }}</p> <!-- Kraj -->
<p>Очекувано времетраење на интервенцијата: {{ $row[5] }}</p> <br> <!-- Vremetraenje -->

<p> Се извинуваме поради непријатностите и однапред Ви благодариме за разбирањето. </p>
<p>Доколку не добиеме повратен одговор во следните 24 часа ќе сметаме дека планираната работа е прифатена.. </p> <br>

<div class="contact-info">
    <p>Поздрав,</p>
    <p>Кристијан Гошевски</p> 
    <p>Програмер</p>
    <p>Tel: + 389 70 233 959</p>
    <p>e-mail: <a href="mailto:your_email@yahoo.com">your_email@yahoo.com</a></p>
</div>
  
@endsection

