<form action="" method="POST">
    @csrf

    <input type="hidden" value="{{ $tbReservation }}" name="where_to">
    <input type="hidden" value="{{ $name }}" name="product">
    <input type="hidden" value="{{ $tbProducts }}" name="Products">
    <input type="hidden" value="{{ $idProduct }}" name="product_id">

    <label for="date">Data:</label>
    <input type="date" name="date" id="date" required>

    <label for="start_time">Hora de Início:</label>
    <input type="time" name="start_time" id="start_time" required>

    <label for="end_time">Hora de Fim:</label>
    <input type="time" name="end_time" id="end_time" required>

    <label for="client_name">Nome do Cliente:</label>
    <input type="text" name="client_name" id="client_name">

    <label for="client_phone">Telefone do Cliente:</label>
    <input type="text" name="client_phone" id="client_phone">

    <!-- Status sempre confirmado -->
    <input type="hidden" name="status" value="confirmed">

    <button type="submit">Salvar Reserva</button>
</form>
