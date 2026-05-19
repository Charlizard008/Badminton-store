// DARK MODE

function toggleDarkMode() {

    document.body.classList.toggle("dark");

    if (document.body.classList.contains("dark")) {

        document.body.style.background = "#111";
        document.body.style.color = "white";

    } else {

        document.body.style.background = "#f4f7fb";
        document.body.style.color = "#222";

    }

}

// CART SYSTEM

let cart = JSON.parse(localStorage.getItem("cart")) || [];

updateCart();

function addToCart(product, price) {

    cart.push({ product, price });

    localStorage.setItem("cart", JSON.stringify(cart));

    updateCart();

    alert(product + " added to cart!");

}

function updateCart() {

    const cartItems =
        document.getElementById("cart-items");

    const totalText =
        document.getElementById("total");

    const cartCount =
        document.getElementById("cart-count");

    cartItems.innerHTML = "";

    let total = 0;

    cart.forEach((item, index) => {

        total += item.price;

        cartItems.innerHTML += `

            <div class="cart-item">

                <div>
                    <h4>${item.product}</h4>
                    <p>RM ${item.price}</p>
                </div>

                <button class="remove-btn"
                    onclick="removeItem(${index})">

                    Remove

                </button>

            </div>

        `;

    });

    totalText.innerText = total;
    cartCount.innerText = cart.length;

}

function removeItem(index) {

    cart.splice(index, 1);

    localStorage.setItem("cart", JSON.stringify(cart));

    updateCart();

}

function toggleCart() {

    document.getElementById("cartSidebar")
        .classList.toggle("active");

}

// CHECKOUT

function checkout() {

    if (cart.length === 0) {

        alert("Your cart is empty.");
        return;

    }

    alert(
        "Checkout successful! Thank you for shopping at SmashZone."
    );

    cart = [];

    localStorage.removeItem("cart");

    updateCart();

}

// ADMIN LOGIN

function openLogin() {

    document.getElementById("loginModal")
        .style.display = "flex";

}

function login() {

    const username =
        document.getElementById("username").value;

    const password =
        document.getElementById("password").value;

    if (username === "admin"
        && password === "1234") {

        alert("Admin Login Successful!");

        document.getElementById("loginModal")
            .style.display = "none";

    }
    else {

        alert("Wrong username or password.");

    }

}

// CLOSE MODAL

window.onclick = function (event) {

    const modal =
        document.getElementById("loginModal");

    if (event.target === modal) {

        modal.style.display = "none";

    }

}

// SEARCH

document.getElementById("searchInput")
    .addEventListener("keyup", function () {

        const value =
            this.value.toLowerCase();

        const products =
            document.querySelectorAll(".product-card");

        products.forEach(product => {

            const text =
                product.innerText.toLowerCase();

            if (text.includes(value)) {

                product.style.display = "block";

            } else {

                product.style.display = "none";

            }

        });

    });