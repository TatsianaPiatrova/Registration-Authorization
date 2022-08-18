<?php
    session_start();
    include_once 'header.php';
?>

<main role="main" class="container starter-template">
 
  <div class="row">
      <div class="col">
          <div id="response"></div>
          <div id="content"></div>
      </div>
  </div>

</main>

<script src="http://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script>

    jQuery(function ($) {

        $(document).on("click", "#sign_up", function () {

            var html = `
                <h2>Регистрация</h2>
                <form id="sign_up_form">
                    <div class="form-group">
                        <label for="login">Login</label>
                        <input type="text" class="form-control" name="login" id="login" required />
                    </div>
    
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" required />
                    </div>
    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" required />
                    </div>
    
                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <input type="password" class="form-control" name="password" id="password" required />
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Повторите пароль</label>
                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" required />
                    </div>
    
                    <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
                </form>
            `;

            clearResponse();
            $("#content").html(html);
        });

        $(document).on("submit", "#sign_up_form", function(){
            
            var login = $('#login').val();
            var name = $('#name').val();
            var email = $('#email').val();
            var password = $('#password').val();
            var confirmPassword = $('#confirm_password').val();
            var flag = true;

            console.log(flag);

            $(".error").remove();

            if(login.length < 6){
                $('#login').after('<span class="error">Логин должен содержать минимум 6 символов</span>');
                flag = false;
            } else {
                var regEx = /^[0-9a-zA-Z]/;
                var validLogin = regEx.test(login);
                if (!validLogin) {
                    $('#login').after('<span class="error">Введите правильный логин</span>');
                    flag = false;
                }
            }

            if(name.length < 2){
                $('#name').after('<span class="error">Имя должно содержать минимум 2 символа</span>');
                flag = false;
            } else {
                var regEx = /^[A-ZА-Я]/;
                var validName = regEx.test(name);
                if (!validName) {
                    $('#name').after('<span class="error">Введите правильное имя</span>');
                    flag = false;
                }
            }

            if (email.length < 1) {
                $('#email').after('<span class="error">Это поле должно быть заполнено</span>');
                flag = false;
            } else {
                var regEx = /^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/;
                var validEmail = regEx.test(email);
                if (!validEmail) {
                    $('#email').after('<span class="error">Введите правильный email</span>');
                    flag = false;
                }
            }

            if(password.length < 6){
                $('#password').after('<span class="error">Пароль должен содержать минимум 6 символов</span>');
                flag = false;
            }
            else {
                var regEx = /^[0-9a-zA-Z]{6}/;
                var validPassword = regEx.test(password);
                if (!validPassword) {
                    $('#password').after('<span class="error">Пароль должен содержать буквы и цифры</span>');
                    flag = false;
                }
            }

            if(confirmPassword !== password){
                $('#confirm_password').after('<span class="error">Пароли должны совпадать</span>');
                flag = false;
            }

            console.log(flag);

            if (flag){
                var sign_up_form=$(this);
                var form_data=JSON.stringify(sign_up_form.serializeObject());

                $.ajax({
                    url: "create_user.php",
                    type : "POST",
                    contentType : "application/json",
                    data : form_data,
                    success : function(result) {
                        $("#response").html('<div class="alert alert-success">Регистрация завершена успешно. Пожалуйста, войдите.</div>');
                        sign_up_form.find("input").val("");
                    },
                    error: function(xhr, resp, text){
                        $("#response").html('<div class="alert alert-danger">Невозможно зарегистрироваться. Пожалуйста, свяжитесь с администратором.</div>');
                    }
                });
            }
            return false;
        });

        $(document).on("click", "#form_login", function(){
            $.post("validate.php").done(function(result) {
                showHomePage();
            })
            .fail(function(result){
                showLoginPage();
            });
        });

        function showLoginPage(){
            var html = `
                <h2>Вход</h2>
                <form id="login_form">
                    <div class="form-group">
                        <label for="login">Login</label>
                        <input type="login" class="form-control" id="login" name="login" placeholder="Введите login">
                    </div>

                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Введите пароль">
                    </div>

                    <button type="submit" class="btn btn-primary">Войти</button>
                </form>
                `;            
            clearResponse();
            $("#content").html(html);
            showLoggedOutMenu();
        }

        $(document).on("submit", "#login_form", function(){

            var login_form=$(this);
            var form_data=JSON.stringify(login_form.serializeObject());

            $.ajax({
                url: "login.php",
                type : "POST",
                contentType : "application/json",
                data : form_data,
                success : function(result){
                    localStorage.setItem("name",result['name']);
                    $("#response").html('<div class="alert alert-success">Успешный вход в систему.</div>');
                    showHomePage();
                },
                error: function(xhr, resp, text){
                    $("#response").html('<div class="alert alert-danger">Ошибка входа. Login или пароль указан неверно.</div>');
                    login_form.find("input").val("");
                }
            });
            return false;
        });

        function clearResponse() {
            $("#response").html("");
        }  

        function showLoggedOutMenu(){
            $("#form_login, #sign_up").show();
            $("#logout").hide();
        }

        $(document).on("click", "#home", function(){
            showHomePage();
            clearResponse();
        });

        function showHomePage() {
            $.post("validate.php").done(function(result) {
                var html = `
                    <div class="card">
                        <div class="card-header">Добро пожаловать!</div>
                        <div class="card-body">
                            <h5 class="card-title">Вы вошли в систему.</h5>
                            <p class="card-text">Hello, ${localStorage.getItem("name")}!</p>                            
                        </div>
                    </div>
                `;

                $("#content").html(html);
                showLoggedInMenu();
            })
            .fail(function(result){
                showLoginPage();
                $("#response").html('<div class="alert alert-danger">Пожалуйста войдите, чтобы получить доступ к домашней станице</div>');
            });
        }

        function showLoggedInMenu(){
            $("#form_login, #sign_up").hide();
            $("#logout").show();
        }

        $(document).on("click", "#logout", function(){        
            $.post("logout.php").done(function(result) {
                showLoginPage();
                $("#response").html('<div class="alert alert-info">Вы вышли из системы.</div>');
            })
            .fail(function(result){
                $("#response").html('<div class="alert alert-danger">Ошибка выхода</div>');
            });            
        });

        $.fn.serializeObject = function(){
            var o = {};
            var a = this.serializeArray();
            $.each(a, function() {
                if (o[this.name] !== undefined) {
                    if (!o[this.name].push) {
                        o[this.name] = [o[this.name]];
                    }
                    o[this.name].push(this.value || "");
                } else {
                    o[this.name] = this.value || "";
                }
            });
            return o;
        };

        function validateForm(){

        }

    });
</script>

</body>
</html>