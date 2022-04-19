<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verify mail</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <h1>{{$details['title']}}</h1>
    <p>{{$details['body']}}</p>
    <h1><button type="button" class="btn btn-success"><a href="http://127.0.0.1:8000/api//verify/mail/{{$details['userId']}}">Verify</a></button></h1>
    <p>Thank you</p>
</body>
</html>