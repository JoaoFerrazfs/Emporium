@component('mail::message')
# Seu numero de pedido é  -  Pedido numero {{$order->id}}

## Dados do pedido

> Nome do cliente: {{$order->user->name}}


## Entrega

> Cidade: {{$order->city}}
> Bairro: {{$order->neighborhood ?? ''}}
> Rua: {{$order->street}}
> Numero: {{$order->number}}


## Observação

> {{$order->observation}}

## Itens do Pedido

| ID  | Nome | Quantidade |
| ------------- |:-------------:|:-------------:|
@foreach(json_decode($order->cart()->get()[0]['products'], true) as $cart)
|{{ $cart['id'] }} | {{$cart['name']}}| {{$cart['quantity']}}|
@endforeach

@component('mail::button', ['url' => $paymentUrl])
Verificar pedido
@endcomponent

## Ainda não realizou o pagamento? Clique no link abaixo para finalizar:

@component('mail::button', ['url' => $paymentUrl])
Pagar Pedido
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent

