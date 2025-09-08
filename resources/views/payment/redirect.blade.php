<form action="{{ env('PAYU_ACTION_URL') }}" method="post" id="payuForm">
    @foreach($payuData as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endforeach
</form>

<script>
    document.getElementById('payuForm').submit();
</script>
