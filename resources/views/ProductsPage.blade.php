@if($databaseOrigin->isEmpty())
    <p>Nenhum produto encontrado.</p>
@else
    <ul>
        Produtos da empresa {{ $dadosEmpresa->name }}
    @foreach($databaseOrigin as $produto)
        <li>
                <strong>{{ $produto->name }}</strong> - R$ {{ $produto->price_per_hour }}
                <a href="/reservas/public/loja/{{ $empresa }}/{{ $produto->name }}">Reservar</a>
        </li>
    @endforeach
    </ul>
@endif
