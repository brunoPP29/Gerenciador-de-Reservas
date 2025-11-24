@if($productInfo)
<form GIT method="POST">
    @csrf

    <!-- Tabelas dinâmicas -->
    <input type="hidden" name="where_to" value="{{ $tbReservation }}">
    <input type="hidden" name="Products" value="{{ $tbProducts }}">

    <!-- Produto selecionado -->
    <input type="hidden" name="product_id" value="{{ $productInfo->id }}">
    <input type="hidden" name="product" value="{{ $productInfo->name }}">

    <!-- Campos do produto como referência -->
    <p><strong>Nome do Produto:</strong> {{ $productInfo->name }}</p>
    @if(isset($productInfo->price))
        <p><strong>Preço por hora:</strong> {{ $productInfo->price }}</p>
    @endif
    @if(isset($productInfo->opens_at))
        <p><strong>Horário de abertura:</strong> {{ $productInfo->opens_at }}</p>
    @endif
    @if(isset($productInfo->closes_at))
        <p><strong>Horário de fechamento:</strong> {{ $productInfo->closes_at }}</p>
    @endif

    <!-- Datas e horários da reserva -->
    <label for="date">Data:</label>
    <input type="date" name="date" id="date" required>

    <label for="start_time">Hora de Início:</label>
    <input type="time" name="start_time" id="start_time" 
           min="{{ $productInfo->opens_at ?? '' }}" 
           max="{{ $productInfo->closes_at ?? '' }}" 
           required>

    <label for="end_time">Hora de Fim:</label>
    <input type="time" name="end_time" id="end_time" 
           min="{{ $productInfo->opens_at ?? '' }}" 
           max="{{ $productInfo->closes_at ?? '' }}" 
           required>
//AJUSTAR
           <label for="client_name">Nome do Cliente:</label>
           <input type="hidden" value="" name="client_name" id="client_name">
    <!-- Dados do cliente -->

    <label for="client_phone">Telefone do Cliente:</label>
    <input type="text" name="client_phone" id="client_phone">

    <!-- Status sempre confirmado -->
    <input type="hidden" name="status" value="confirmed">

    <button type="submit">Salvar Reserva</button>
</form>
@else
<p>Produto não encontrado. Não é possível reservar.</p>
@endif
