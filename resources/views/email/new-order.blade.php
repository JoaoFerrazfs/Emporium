@component('mail::message')
# Novo pedido registrado  -  Pedido numero {{$order->id}}

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

| Código do Produto |     Nome      | Quantidade |
| :--------------: | :-----------: | :--------: |
@foreach($order->cart['products'] as $cart)
    |{{ $cart['id'] }} | {{$cart['name']}}| {{$cart['quantity']}}|
@endforeach


@component('mail::button', ['url' => route('admin.show.order',['id' => $order->id])])
 Verificar pedido
@endcomponent

Verifique o pedido no painel administrativo,<br>
{{ config('app.name') }}
@endcomponent
