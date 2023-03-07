<script>
    function decreaseQuantity(button) {
        var input = button.parentNode.querySelector('#quantity');
        var value = parseInt(input.value);
        if (value > 1) {
            input.value = value - 1;
        }
    }

    function increaseQuantity(button) {
        var input = button.parentNode.querySelector('#quantity');
        var value = parseInt(input.value);
        input.value = value + 1;
    }

    // Encontre o botão de excluir pelo ID
    const deleteButton = document.getElementById('delete-button');

    // Adicione um manipulador de eventos de clique ao botão de excluir
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('[id^="delete-button-"]');
        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const productIdToDelete = parseInt(button.dataset.productId); // Substitua por um ID de produto real que você queira excluir
                const cookieJSON = document.cookie.match(/(^|;) ?cart=([^;]*)(;|$)/)[2];
                const products = JSON.parse(cookieJSON);
                const productIndexToDelete = products.findIndex(product => product.id === productIdToDelete);

                if (productIndexToDelete !== -1) {
                    products.splice(productIndexToDelete, 1);
                }

                const newCookieJSON = JSON.stringify(products);
                console.log(newCookieJSON);
                document.cookie = `cart=${newCookieJSON}; expires=${new Date(Date.now() + 86400000).toUTCString()}; path=/`;
                window.location.reload();
            });
        });
    });



</script>
