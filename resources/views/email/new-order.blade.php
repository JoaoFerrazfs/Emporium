@component('mail::message')
# Novo pedido registrado  -  Pedido numero {{$order->id}}

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
@foreach(json_decode($order->cart->products_id) as $cart)
|{{ $cart }}     | right foo     | right foo     |
@endforeach

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
