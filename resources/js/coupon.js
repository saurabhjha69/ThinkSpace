window.alertCouponWindow = function () {
    let coupon_code = prompt("Enter coupon code");

    if (coupon_code == "" || coupon_code ==" ") {
        alert("Coupon code is empty");
        return;
    }

    // Redirect with the coupon code appended to the URL as a query parameter
    alert("Coupon applied");
    setTimeout(function () {
        window.location.href = "?coupon=" + encodeURIComponent(coupon_code);
    }, 500);
};
