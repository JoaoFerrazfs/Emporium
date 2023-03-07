@extends('layouts.managerMain')
@section('title','Emporium')
@section('content')

<div style="margin-top: 50px;" class="container">
    <h1 class="badge bg-secondary ">Seu carrinho de Compras</h1>
    <th>
        <form method="POST" action="/carrinho/excluir/carrinho" enctype="multipart/form-data">@csrf
            <button type="submit" class="btn btn-outline-light">Excluir carrinho</button>
        </form>
    </th>


    <table class=" table table-hover table-dark table-borderless ">
        <thead>
            <tr>
                <th scope="col">Quantidade</th>
                <th scope="col">Nome</th>
                <th scope="col">Preço</th>
                <th scope="col">Disponibilidade</th>
                <th scope="col">Foto</th>
                <th scope="col">Valor Total: R$</th>





@stop
