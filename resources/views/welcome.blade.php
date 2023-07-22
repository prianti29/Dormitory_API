<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{ asset('loginCSS/login.css') }}">
</head>

<body>
    <ul>
        <li><a href="">Home</a></li>
        <li><a href="">Member</a></li>
        <li><a href="">Meal</a></li>
        <li><a href="">Cost</a></li>
        <li><a href="">Acounts</a></li>
    </ul>
    <div class="buttons">
        <button onclick="document.getElementById('id01').style.display='block'"
            style="width:auto; margin-top: 20%; margin-left:40%">Sign in</button>
        <button onclick="document.getElementById('id02').style.display='block'"
            style="width:auto; margin-top: 20%; margin-right:30%">sign up</button>
    </div>

    {{-- login --}}
    <div id="id01" class="modal">
        <form class="modal-content animate" action="{{ route('auth.login') }}" method="POST">
            @csrf
            <div class="container">
                <label><b>Email</b></label>
                <input type="text" placeholder="Enter Email" name="email" required>
                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" required>
                <button type="submit">Login</button>
                <label>
                    <input type="checkbox" checked="checked" name="remember"> Remember me
                </label>
            </div>
            <div class="container" style="background-color:#f1f1f1">
                <button type="button" onclick="document.getElementById('id01').style.display='none'"
                    class="cancelbtn">Cancel</button>
                <span class="psw">Forgot <a href="#">password?</a></span>
            </div>
        </form>
    </div>

    {{-- registration --}}
    <div id="id02" class="modal">
        <form class="modal-content animate" action="{{ route('auth.register') }}" method="post">
            @csrf
            <div class="container">
                <label><b>Name</b></label>
                <input type="text" placeholder="Enter name" name="member_name" required>
                <label><b>Member Type</b></label>
                <input type="text" placeholder="Enter member type" name="member_type" required>
                <label><b>Phone</b></label>
                <input type="text" placeholder="Enter phone number" name="phone" required>
                <label><b>Email</b></label>
                <input type="text" placeholder="Enter email" name="email" required>
                <label><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" required>
                <div class="container" style="background-color:#f1f1f1">
                    <button type="submit">Register</button>
                    <button type="button" onclick="document.getElementById('id02').style.display='none'"
                        class="cancelbtn regcancelbtn">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</body>


<script>
    var modal = document.getElementById('id01');
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

</script>
<script>
    var modal = document.getElementById('id02');
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

</script>

</html>
