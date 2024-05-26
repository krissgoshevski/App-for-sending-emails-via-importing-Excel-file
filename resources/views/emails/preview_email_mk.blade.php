@extends('layouts.email')
@section('title', 'Email-mk')
@section('content')

<p>Почитувани, <br> <br> {{ $rows[8] }}</p> <!-- Naslov na porakata -->


<h4>Афектирани сервиси:</h4>
<p>Корисник: {{ $rows[1] }}</p> <!-- Korisnik ili Circuit ID -->



<div class="address-service-container">
    @foreach ($addresses as $index => $address)
        @if (!empty($address) && isset($services[$index])) <!-- Check if both address and service exist -->
            <p>Адреса: {{ $address }}</p>
            <p>Сервис: {{ $services[$index] }}</p>
        @endif
    @endforeach
</div>





<h4>Временска рамка:</h4>
<p>Почеток: {{ $rows[3] }}</p> <!-- Pocetok -->
<p>Крај: {{ $rows[4] }}</p> <!-- Kraj -->
<p>Очекувано времетраење на интервенцијата: {{ $rows[5] }}</p> <br> <!-- Vremetraenje -->

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
