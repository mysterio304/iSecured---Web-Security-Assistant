<div class="topnav" id="myTopnav">
    <a href="/" class="active">Home</a>
    <a href="/password_generator">Password Generator</a>
    <a href="/phishing_email_detector">Phishing Email Detector</a>
    <a href="/scam_detector">AI Scam Detector</a>
    <a href="/about">About</a>
    <a href="/logout">Logout</a>
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
        <i class="fa fa-bars"></i>
    </a>
</div>

<script>
    function myFunction() {
        var x = document.getElementById("myTopnav");
        if (x.className === "topnav") {
            x.className += " responsive";
        } else {
            x.className = "topnav";
        }
    }
</script>