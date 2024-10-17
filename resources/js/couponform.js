window.updateCouponFields = function () {
    const couponType = document.getElementById('coupon_type').value;
    const percentageFields = document.getElementById('percentage_fields');
    const fixedFields = document.getElementById('fixed_fields');

    // Hide all fields initially
    percentageFields.classList.add('hidden');
    fixedFields.classList.add('hidden');

    // Show relevant fields based on selected coupon type
    if (couponType === 'percentage') {
        percentageFields.classList.remove('hidden');
    } else if (couponType === 'fixed') {
        fixedFields.classList.remove('hidden');
    }
}

// Initial call to set the fields based on default selected coupon type
