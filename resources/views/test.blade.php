<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="post" action="/api/exchange">
        @csrf
        <button name="type" class="text-white btn btn-primary" value="Other" type="submit">{{__('getTransaction Other')}}</button>
    </form>
</body>

</html>