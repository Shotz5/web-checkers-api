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
    <h3>Remember Me</h3>
    <input id="remember" type="checkbox" name="remember" />
    <button id="login">Login</button>
    <br>
    <br>
    <button id="logout">Logout</button>
</body>
</html>

<script>
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const remember = document.getElementById("remember");
    const button = document.getElementById("login");
    const logoutButton = document.getElementById("logout");

    button.addEventListener('click', login);
    logoutButton.addEventListener('click', logout);

    function login() {
        axios.get('/sanctum/csrf-cookie').then(response => {
            axios.post('/api/account/login', {
                email: email.value,
                password: password.value,
                remember: remember.checked,
            })
            .then((res) => {
                console.log(res.data);
            })
            .catch((res) => {
                console.log(res.response.data);
            })
        })
        .catch((res) => {
            console.log('Unable to create CSRF token');
        });
    }

    function logout() {
        axios.get('/api/account/logout')
        .then((res) => {
            console.log(res.data);
        })
        .catch((res) => {
            console.log(res.response.data);
        });
    }
</script>
