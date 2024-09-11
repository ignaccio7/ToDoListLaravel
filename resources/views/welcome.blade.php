<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>login</title>
    <style>
        html {
  height: 100%;
}

.login-box {
  position: absolute;
  top: 50%;
  left: 50%;
  width: 400px;
  padding: 40px;
  transform: translate(-50%, -50%);
  background: rgba(0,0,0,.5);
  box-sizing: border-box;
  box-shadow: 0 15px 25px rgba(0,0,0,.6);
  border-radius: 10px;
}

.login-box h2 {
  margin: 0 0 30px;
  padding: 0;
  color: #fff;
  text-align: center;
}

.login-box .user-box {
  position: relative;
}

.login-box .user-box input {
  width: 100%;
  padding: 10px 0;
  font-size: 16px;
  color: #fff;
  margin-bottom: 30px;
  border: none;
  border-bottom: 1px solid #fff;
  outline: none;
  background: transparent;
}
.login-box .user-box label {
  position: absolute;
  top:0;
  left: 0;
  padding: 10px 0;
  font-size: 16px;
  color: #fff;
  pointer-events: none;
  transition: .5s;
}

.login-box .user-box input:focus ~ label,
.login-box .user-box input:valid ~ label {
  top: -20px;
  left: 0;
  color: #03e9f4;
  font-size: 12px;
}

.login-box form a {
  position: relative;
  display: inline-block;
  padding: 10px 20px;
  color: #03e9f4;
  font-size: 16px;
  text-decoration: none;
  text-transform: uppercase;
  overflow: hidden;
  transition: .5s;
  margin-top: 40px;
  letter-spacing: 4px
}

button{
    width: 100%;
    padding: 10px;
    text-align: center;
    background-color: #09f;
    border: none;
    rounded:1rem;
    color: white;
    font-weight: bold;
    cursor: pointer;

    &.register{
        background-color: rgb(24, 158, 29);
    }
}

    </style>
</head>
<body>
    <div class="login-box">
        <h2>Login</h2>
        <form>
          <div class="user-box">
            <input type="text" name="email" required="" value="test@example.com">
            <label>Username</label>
          </div>
          <div class="user-box">
            <input type="password" name="password" required="" value="secret">
            <label>Password</label>
          </div>
          <button>Login</button>
        </form>
        <br>
        <button class="register">Registrar Nuevo Usuario</button>
      </div>

    <script>
        const apiUrl = 'http://localhost/laravel/todolist-one/public/api/auth/';
        const form = document.querySelector('form');
        form.addEventListener('submit', e => {
          e.preventDefault();

          fetch(`${apiUrl}login`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({              
              email: form.email.value,
              password: form.password.value
            })
          }).then(res => {
            if(!res.ok){                
                throw new Error('Fallo al enviar el formulario');
            }
            return res.json();
          })
            .then(data => {
                console.log(data);
                localStorage.setItem('token', data.access_token);
                window.location.href = `http://localhost/laravel/todolist-one/public/tasks`;
            })
            .catch(err => {
                console.log('err');
                console.log(err);
            });
        });

        const $register = document.querySelector('.register');
        $register.addEventListener('click', e => {
          e.preventDefault();
          window.location.href = `http://localhost/laravel/todolist-one/public/register`;
        });
        
    </script>
</body>
</html>