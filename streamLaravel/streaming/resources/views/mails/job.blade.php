
<!DOCTYPE html>
<html>
<head>
    <title>Payment Details</title>
</head>
<body>
    <h1>{{ $subject }}</h1>
    <p>Name: {{ $detail['name'] }}</p>
    <p>Product: {{ $detail['product'] }}</p>
    <p>Price: {{ $detail['price'] }}</p>
    {{-- Uncomment the line below if 'random_text' is included --}}
    {{-- <p>Random Text: {{ $detail['random_text'] }}</p> --}}
</body>
</html>
