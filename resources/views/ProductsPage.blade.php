@if($databaseOrigin->isEmpty())
    <p>Nenhum produto encontrado.</p>
@else
    <ul>
    @foreach($databaseOrigin as $produto)
        <li>
                <strong>{{ $produto->name }}</strong> - R$ {{ $produto->price_per_hour }}
                <a href="?name={{ $produto->name }}">Reservar</a>
        </li>
    @endforeach
    </ul>
@endif
