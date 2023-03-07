<script>

var product = {!!json_encode($product)!!};

document.getElementById("addToCart").addEventListener("click", function () {

    // verificar se o cookie já existe
    var cart = getCookie("cart");

    if (cart) {
        // se já existir, adicione o novo produto
        cart = JSON.parse(cart);
        cart.push(product);
        setCookie("cart", JSON.stringify(cart), 7);
    } else {
        // se não existir, crie um novo cookie com o produto
        setCookie("cart", JSON.stringify([product]), 7);
    }
});

document.getElementById("buy").addEventListener("click", function () {

    // verificar se o cookie já existe
    var cart = getCookie("cart");

    if (cart) {
        // se já existir, adicione o novo produto
        cart = JSON.parse(cart);
        cart.push(product);
        setCookie("cart", JSON.stringify(cart), 7);
    } else {
        // se não existir, crie um novo cookie com o produto
        setCookie("cart", JSON.stringify([product]), 7);
    }
});

// função para obter um cookie pelo nome
function getCookie(name) {
    var cookies = document.cookie.split("; ");
    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i].split("=");
        if (cookie[0] === name) {
            return cookie[1];
        }
    }
    return null;
}

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
