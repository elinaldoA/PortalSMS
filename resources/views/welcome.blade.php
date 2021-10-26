<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal de SMS</title>
    <!-- Styles -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS"
        crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="jumbotron">
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            Adicionar número de telefone
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>Digite o número do telefone</label>
                                    <input type="tel" class="form-control" name="phone_number" placeholder="Somente números...">
                                </div>
                                <button type="submit" class="btn btn-primary">Registrar usuário</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            Enviar mensagem
                        </div>
                        <div class="card-body">
                            <form method="POST" action="/custom">
                                @csrf
                                <div class="form-group">
                                    <label>Selecione os usuários para notificar</label>
                                    <select name="users[]" multiple class="form-control">
                                        @foreach ($users as $user)
                                        <option>{{$user->phone_number}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Mensagem de notificação</label>
                                    <textarea name="body" class="form-control" rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Enviar notificação</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
