<script>

    var preparedOrder = {!!json_encode($preparedOrder)!!};

    document.getElementById("orderConfirmation").addEventListener("click", function () {
        setCookie("order", JSON.stringify([preparedOrder]), 7);
    });


    // função para definir um novo cookie
    function setCookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + value + expires + "; path=/";
    }
</script>
