<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Checkers</title>
    @vite('resources/js/app.js')
</head>
<body>
    <h3>Email</h3>
    <input id="email" type="email" name="email" />
    <h3>Password</h3>
    <input id="password" type="password" name="password" />
    <h3>Name</h3>
    <input id="name" type="text" name="name" />
    <button id="create">Create</button>
</body>
</html>

<script>
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const name = document.getElementById("name");
    const button = document.getElementById("create");

    button.addEventListener('click', login);

    function login() {
        axios.post('/api/account/create', {
            email: email.value,
            password: password.value,
            name: name.value,
        })
        .then((res) => {
            window.location.href = "/account/login";
        })
        .catch((res) => {
            console.log(res.response.data);
        })
    }
</script>
