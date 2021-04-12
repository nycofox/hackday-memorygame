<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
@foreach ($images as $image)
    { image: '{{ $image }}', flipped: false, cleared: false },
@endforeach
</body>
</html>
