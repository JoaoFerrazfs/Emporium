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

| Código do Produto |     Nome      | Quantidade |
| :--------------: | :-----------: | :--------: |
@foreach(json_decode($order->cart()->get()[0]['products'], true) as $cart)
    |   {{ $cart['id'] }}    | {{$cart['name']}} | {{$cart['quantity']}} |
@endforeach


@component('mail::button', ['url' => '#'])
 Verificar pedido
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
