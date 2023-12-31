@component('mail::message')
# Seu numero de pedido é  -   {{$order->id}}

## Dados do pedido

> Nome do cliente: {{$order->user['name']}}


## Entrega

> Cidade: {{$order->address['city']}}
> Bairro: {{$order->address['neighborhood'] ?? ''}}
> Rua: {{$order->address['street']}}
> Numero: {{$order->address['number']}}


## Observação

> {{$order->observation}}

## Itens do Pedido

| Código do Produto  | Nome | Quantidade |
| :-------------: |:-------------:|:-------------:|
@foreach($order->cart['products'] as $cart)
|{{ $cart['id'] }} | {{$cart['name']}}| {{$cart['quantity']}}|
@endforeach

@component('mail::button', ['url' => route('client.orders')])
Verificar pedido
@endcomponent

## Ainda não realizou o pagamento? Clique no link abaixo para finalizar:

@component('mail::button', ['url' => $paymentUrl])
Pagar Pedido
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent

