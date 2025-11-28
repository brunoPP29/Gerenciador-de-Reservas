<form method="post">
    @csrf
            <input type="hidden" name="where_to" value="{{ $req->where_to ?? '' }}">
            <input type="hidden" name="Products" value="{{ $req->Products ?? '' }}">
            <input type="hidden" name="product_id" value="{{ $req->product_id ?? '' }}">
            <input type="hidden" name="product" value="{{ $req->product ?? '' }}">
            <input type="hidden" name="date" value="{{ $req->date ?? '' }}">
            <input type="hidden" name="status" value="confirmed">
            <input type="hidden" value="{{ session('userName') }}" name="client_name" id="client_name">
<label for="hora">Escolha o horário:</label>
<select name="hora" id="hora">
    @if(count($horariosDisponiveis) > 0)
        @foreach($horariosDisponiveis as $time)
            <option value="{{ $time['start'] }}">
                {{ $time['start'] }} - {{ $time['end'] }}
            </option>
        @endforeach
    @else
        <option disabled>Não há horários disponíveis</option>
    @endif
</select>

<input type="number" name="client_phone" required>

<input type="submit" value="Reservar!">
</form>
